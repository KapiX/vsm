<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ProjectsController extends AppController {

    public function index() {
        $projects = $this->User->find('first', array(
            'contain' => 'Project',
            'conditions' => ['User.id' => $this->Auth->user('id')],
            'recursive' => 1))['Project'];
        $this->set('projects', $projects);
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
        $row = $this->Project->find('first', array(
            'contain' => 'User',
            'recursive' => 1,
            'conditions' => array('Project.id' => $id),
        ));
        $this->set('project', $row['Project']);
        $this->set('users', $row['User']);
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
                    $this->ProjectsUsers->create();
                    $data = array(
                        'project_id' => $project_id,
                        'user_id' => $user['id']
                    );
                    if($this->ProjectsUsers->save($data)) {
                        $this->Session->setFlash(__('User added to project.'), 'success');
                    } else {
                        $this->Session->setFlash(__('Could not save.'), 'error');
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
                                         'password' => $new_user_password);
                    $Email->config(Configure::read('mail.transport'))
                       ->template('invitation')
                       ->emailFormat('html')
                       ->to($new_user_email)
                       ->from(Configure::read('mail.from'))
                       ->viewVars($emailValues)
                       ->send();
                    $this->Session->setFlash(__('Invitation has been sent.'), 'success');
                } else {
                    $this->Session->setFlash(__('Account could not be created. Please, try again.'), 'error');
                }
            } else {
                $this->Session->setFlash(__('You are now allowed to invite new users.'), 'error');
            }
        }
        return $this->redirect($this->referer());
    }
}
