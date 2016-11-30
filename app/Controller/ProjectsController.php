<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::uses('CakeTime', 'Utility');

class ProjectsController extends AppController {

    public function index() {
        $projects = $this->User->find('first', array(
            'contain' => 'Project',
            'conditions' => ['User.id' => $this->Auth->user('id')],
            'recursive' => 1))['Project'];

        foreach ($projects as $key => $project) {
            $projects[$key]['userCanEdit'] = $this->Project->userCanEdit($project['id'], $this->Auth->user('id'));
        }
        $this->set('projects', $projects);
    }

    public function view() {
        $id = $this->request->params['id'];
        if(empty($id))
            $this->redirect($this->referer());
        if(array_key_exists('month', $this->request->params)) $month = $this->request->params['month'];
        if(array_key_exists('year', $this->request->params)) $year = $this->request->params['year'];
        if(empty($month)) $month = CakeTime::format('now', '%m');
        if(empty($year)) $year = CakeTime::format('now', '%Y');

        $localizedWeekdays = array();
        for($i = 0; $i < 7; $i++) {
            $localizedWeekdays[] = CakeTime::format("next Monday + $i days", '%A');
        }
        $date = "01.$month.$year";
        $firstWeekDayOfMonth = CakeTime::format("first day of $date", '%u') - 1;
        $lastDayOfMonth = CakeTime::format("last day of $date", '%d');
        $monthHeader = CakeTime::format($date, '%B %Y');

        $this->set('weekdays', $localizedWeekdays);
        $this->set('firstWeekDay', $firstWeekDayOfMonth);
        $this->set('lastDay', $lastDayOfMonth);
        $this->set('header', $monthHeader);
        $this->set('current', $date);
        $this->set('id', $id);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->loadModel('ProjectsUsers');
            $this->Project->create();
            $this->Project->set('owner_id', $this->Auth->user('id'));

            $dataSource = $this->Project->getDataSource();
            $dataSource->begin();
            if ($this->Project->save($this->request->data)) {
                $this->ProjectsUsers->create();
                $this->ProjectsUsers->set('project_id', $this->Project->id);
                $this->ProjectsUsers->set('user_id', $this->Auth->user('id'));
                if($this->ProjectsUsers->save())
                {
                    $dataSource->commit();
                    $this->Session->setFlash(__('The project  has been created'));
                    return $this->redirect($this->referer());
                }
            }
            $dataSource->rollback();
            $this->Session->setFlash(
                __('The project could not be created. Please, try again.')
            );
        }
    }

    public function settings() {
        $id = $this->request->params['id'];
        if(empty($id)) {
            $this->redirect(array('action' => 'index'));
        }
        if($this->Project->userCanEdit($id, $this->Auth->user('id'))) {
            $row = $this->Project->find('first', array(
                'contain' => array('User', 'Sprint'),
                'recursive' => 1,
                'conditions' => array('Project.id' => $id),
            ));
            $this->set('project', $row['Project']);
            $this->set('users', $row['User']);
            $this->set('sprints', array_reverse($row['Sprint']));
        } else {
            $this->redirect($this->referer());
        }
    }

    public function add_user() {
        $project_id = $this->request->params['id'];
        if($this->request->is('post') && !empty($project_id)) {
            $email = $this->request->data['search'];
            $this->loadModel('User');
            $this->loadModel('ProjectsUsers');
            if($this->Project->userCanEdit($project_id, $this->Auth->user('id'))) {
                $user = $this->User->find('first', array(
                    'conditions' => array('email' => $email),
                    'recursive' => -1
                ))['User'];
                if($user) {
                    if(!$this->ProjectsUsers->userInProject($user['id'], $project_id)) {
                        $this->ProjectsUsers->create();
                        $data = array(
                            'project_id' => $project_id,
                            'user_id' => $user['id']
                        );
                        if($this->ProjectsUsers->save($data)) {
                            $this->addUserToProjectNotification($project_id, $user['id']);
                            $this->Session->setFlash(__('User added to project.'), 'success');
                        } else {
                            $this->Session->setFlash(__('Could not save.'), 'error');
                        }
                    } else {
                        $this->Session->setFlash(__('User is already assigned to project.'), 'error');
                    }
                } else {
                    $this->Session->setFlash(__('User not found.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Insufficient permissions.'), 'error');
            }
            $this->redirect(array('action' => 'settings', 'id' => $project_id));
        }
        $this->redirect($this->referer());
    }

    public function remove_user() {
        $project_id = $this->request->params['id'];
        $user_id = $this->request->params['user_id'];
        if(!(empty($project_id) && empty($user_id))) {
            if($this->Project->userCanEdit($project_id, $this->Auth->user('id'))) {
                if($this->Project->userCanBeRemoved($project_id, $user_id)) {
                    $this->loadModel('ProjectsUsers');
                    $data = array(
                        'project_id' => $project_id,
                        'user_id' => $user_id
                    );
                    $this->ProjectsUsers->deleteAll($data);
                    $this->Session->setFlash(__('User removed from the project.'), 'success');
                } else {
                    $this->Session->setFlash(__('Project owner cannot be removed.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Insufficient permissions.'), 'error');
            }
            $this->redirect(array('action' => 'settings', 'id' => $project_id));
        }
        $this->redirect($this->referer());
    }

    public function invite_to_project()
    {
        if (array_key_exists('email', $this->request->data) &&
            array_key_exists('project_id', $this->request->data)) {
            $this->loadModel('User');
            $this->loadModel('ProjectsUsers');
            $this->loadModel('AccountToken');
            $projectId = $this->request->data['project_id'];
            if ($this->Project->userCanEdit($projectId, $this->Auth->user('id'))) {
                $new_user_password = $this->random_password();
                $new_user_email = $this->request->data['email'];
                $new_user_name = ucfirst(split("@", $new_user_email)[0]);
                $this->User->create();
                $user_data = array(
                    'first_name' => $new_user_name,
                    'email' => $new_user_email,
                    'password' => $new_user_password
                );
                if ($this->User->save($user_data)) {
                    Configure::load('misc');
                    $token = $this->AccountToken->createToken($new_user_email);
                    if ($token != false) {
                        $userId = $this->User->id;
                        $this->ProjectsUsers->create();
                        $data = array(
                                'ProjectsUsers' => array(
                                    'project_id' => $projectId,
                                    'user_id' => $userId
                                )
                        );
                        $this->ProjectsUsers->save($data);
                        $Email = new CakeEmail();
                        $emailValues = array('new_user_email' => $new_user_email,
                                             'inviter_email' => $this->Auth->user('email'),
                                             'password' => $new_user_password,
                                             'token' => $token['AccountToken']['token']);
                        $Email->config(Configure::read('mail.transport'))
                           ->template('invitation')
                           ->emailFormat('html')
                           ->to($new_user_email)
                           ->from(Configure::read('mail.from'))
                           ->viewVars($emailValues)
                           ->send();
                        $this->Session->setFlash(__('Invitation has been sent.'), 'success');
                    } else {
                        $this->Session->setFlash(__('An error has occurred.'), 'error');
                    }
                } else {
                    $this->Session->setFlash(__('Account could not be created. Please, try again.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('You are now allowed to invite new users.'), 'error');
            }
        }
        return $this->redirect($this->referer());
    }

    public function add_sprint() {
        $project_id = $this->request->params['id'];
        if($this->request->is('post') && !empty($project_id)) {
            $this->loadModel('Sprints');
            if($this->Project->userCanEdit($project_id, $this->Auth->user('id'))) {
                $this->Sprints->create();
                $start_date = CakeTime::format($this->request->data['Sprint']['start_date'], '%Y-%m-%d');
                $end_date = CakeTime::format($this->request->data['Sprint']['end_date'], '%Y-%m-%d');
                if($start_date < $end_date) {
                    $data = array(
                        'project_id' => $project_id,
                        'name' => $this->request->data['Sprint']['name'],
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'report_weekdays' => ''
                    );
                    if($this->Sprints->save($data)) {
                        $this->loadModel('ProjectsUsers');
                        $this->loadModel('SprintsUser');
                        $projects_users = $this->ProjectsUsers->find('all', array(
                            'conditions' => array('ProjectsUsers.project_id' => $project_id)
                        ));
                        foreach ($projects_users as $project_user) {
                            $this->SprintsUser->create();
                            $this->SprintsUser->save(array('sprint_id' => $this->Sprints->id, 'user_id' => $project_user['ProjectsUsers']['user_id']));
                        }
                        $this->loadModel('ScrumReport');
                        while($start_date <= $end_date) {
                            $this->ScrumReport->create();
                            $this->ScrumReport->save(array('sprint_id' => $this->Sprints->id, 'deadline_date' => $start_date));
                            $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
                        }
                        $this->addNewSprintNotification($project_id, $this->Sprints->id);
                        $this->Session->setFlash(__('Sprint added to project.'), 'success');
                    } else {
                        $this->Session->setFlash(__('Could not save.'), 'error');
                    }
                } else {
                    $this->Session->setFlash(__('Invalid sprint date.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Insufficient permissions.'), 'error');
            }
            $this->redirect(array('action' => 'settings', 'id' => $project_id));
        }
        $this->redirect($this->referer());
    }

    public function change_owner() {
        $project_id = $this->request->params['id'];
        if($this->request->is('post') && !empty($project_id)) {
            $new_owner_id = $this->request->data['new_owner'];
            $this->loadModel('Project');
            if($this->Project->userCanEdit($project_id, $this->Auth->user('id'))) {
                $data = array('id' => $project_id, 'owner_id' => $new_owner_id);
                if($this->Project->save($data)) {
                    $this->Session->setFlash(__('The owner has been changed.'), 'success');
                } else {
                    $this->Session->setFlash(__('Could not change.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('Insufficient permissions.'), 'error');
            }
        }
        $this->redirect($this->referer());
    }

    private function addNewSprintNotification($project_id, $sprint_id) {
        $this->loadModel('SprintsUser');
        $this->loadModel('Notification');
        $sprint_users = $this->SprintsUser->find('all', array(
            'conditions' => array('SprintsUser.sprint_id' => $sprint_id)
        ));
        $username = $this->Auth->user('first_name');
        foreach ($sprint_users as $sprint_user) {
            $this->Notification->addNotification("project/$project_id", "$username added new sprint.", $sprint_user['SprintsUser']['user_id'], "New Sprint");
        }
    }

    private function addUserToProjectNotification($project_id, $user_id) {
        $this->loadModel('Notification');
        $username = $this->Auth->user('first_name');
        $this->Notification->addNotification("project/$project_id", "$username added you to project.", $user_id, "Project");
    }
}
