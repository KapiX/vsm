<?php

App::uses('AppController', 'Controller');

class SprintsController extends AppController {

    var $uses = array('UserUserScrumReport', 'UserScrumReport', 'ScrumReport', 'Sprint');

    public function index() {
        $sprint_id = $this->request->params['id'];
        if(!empty($sprint_id)) {
            $sprint = $this->Sprint->findById($sprint_id);
            if(!empty($sprint)) {
                $this->set('title_for_layout', $sprint['Sprint']['name']);
                $this->loadModel('SprintsUsers');
                $user_id = $this->Auth->User('id');
                if($this->SprintsUsers->userInSprint($user_id, $sprint_id)) {
                    $userCompletedReports = $this->UserScrumReport->find('all', array(
                        'conditions' => array('user_id' => $user_id, 'sprint_id' => $sprint_id)
                    ));
                    $completedReportsIds = array();
                    if($userCompletedReports != null)
                        foreach ($userCompletedReports as $value) {
                            array_push($completedReportsIds, $value['UserScrumReport']['scrum_report_id']);
                        }
                    $missingUserScrumReports = $this->ScrumReport->find('all', array(
                        'conditions' => array('sprint_id' => $sprint_id, 'NOT' => array( 'ScrumReport.id' => $completedReportsIds ))
                    ));
                    $allUserScrumReports = $this->UserScrumReport->find('all', array('order' => array('UserScrumReport.id' => 'desc'), 'conditions' => array('sprint_id' => $sprint_id)));
                    $dateMap = array();
                    $lastUserScrumReport = $this->UserScrumReport->find('first', array('order' => array('UserScrumReport.id' => 'desc'), 'conditions' => array('sprint_id' => $sprint_id, 'user_id' => $user_id)));
                    for ($i = 0; $i < count($allUserScrumReports); $i++) {
                        $dateMap[$allUserScrumReports[$i]['ScrumReport']['deadline_date']][] = $i;
                        if($allUserScrumReports[$i]['UserScrumReport']['user_id'] != $user_id) {
                            $completedReport = $this->UserUserScrumReport->find('first', array(
                                'conditions' => array(
                                    'UserUserScrumReport.user_id' => $user_id,
                                    'UserUserScrumReport.user_scrum_report_id' => $allUserScrumReports[$i]['UserScrumReport']['id'],
                                    'not' => array('report_seen_date' => null)
                                )
                            ));
                            if(!$completedReport) {
                                $allUserScrumReports[$i]['UserScrumReport']['readed'] = false;
                            } else {
                                $allUserScrumReports[$i]['UserScrumReport']['readed'] = true;
                            }
                        } else {
                            $allUserScrumReports[$i]['UserScrumReport']['readed'] = true;
                        }
                    }
                    // sortuj według dat
                    uksort($dateMap, function($a, $b) { $ad = new DateTime($a); $bd = new DateTime($b); if($ad == $bd) return 0; return ($ad < $bd) ? -1 : 1; });
                    $this->set('lastUserScrumReport', $lastUserScrumReport);
                    $this->set('missingUserScrumReports', $missingUserScrumReports);
                    $this->set('allUserScrumReports', $allUserScrumReports);
                    $this->set('sprint', $sprint);
                    $this->set('dateMap', $dateMap);
                } else {
                    $this->Session->setFlash(__('You are not assigned to this sprint.'), 'error');
                    $this->redirect($this->referer());
                }
            } else {
                $this->Session->setFlash(__('Sprint does not exists.'), 'error');
                $this->redirect($this->referer());
            }
        } else {
            $this->redirect($this->referer());
        }
    }

    public function add_report() {
        $sprint_id = $this->request->params['id'];
        if($this->request->is('post') && !empty($sprint_id)) {
            $created = date('Y-m-d H:i:s');
            $user_id = $this->Auth->User('id');
            $data = array (
              'q1_ans' => $this->request->data['q1_ans'],
              'q2_ans' => $this->request->data['q2_ans'],
              'q3_ans' => $this->request->data['q3_ans'],
              'scrum_report_id' => $this->request->data['scrum_report_id'],
              'user_id' => $user_id,
              'created' => $created,
              'modified' => $created
            );
            $this->loadModel('UserScrumReport');
            $dataSource = $this->UserScrumReport->getDataSource();
            $dataSource->begin();
            if($this->UserScrumReport->save($data)) {
                $this->loadModel('SprintsUsers');
                $this->loadModel('UserUserScrumReport');
                $sprintUsers = $this->SprintsUsers->find('all', array(
                    'conditions' => array(
                        'sprint_id' => $sprint_id,
                        'NOT' => array( 'user_id' => $user_id)
                    )
                ));
                foreach ($sprintUsers as $sprintUser) {
                    $this->UserUserScrumReport->create();
                    $this->UserUserScrumReport->save(array(
                        'user_scrum_report_id' => $this->UserScrumReport->id,
                        'user_id' => $sprintUser['SprintsUsers']['user_id']
                    ));
                    $this->loadModel('Notification');
                    $this->Notification->newReportNotification($sprint_id, $sprintUser['SprintsUsers']['user_id'], $this->Auth->User('first_name'));
                }
                $dataSource->commit();
                $this->Session->setFlash(__('Report added.'), 'success');
            } else {
                $dataSource->rollback();
                $this->Session->setFlash(__('Could not save.'), 'error');
            }
        }
        $this->redirect($this->referer());
    }

    public function read_report() {
        if($this->RequestHandler->isAjax()) {
            $id = $this->request->data['id'];
            if(!empty($id)) {
                $user_id = $this->Auth->User('id');
                $fields = array('UserUserScrumReport.report_seen_date' => 'NOW()');
                $conditions = array('UserUserScrumReport.user_id' => $user_id, 'UserUserScrumReport.user_scrum_report_id' => $id);
                if($this->UserUserScrumReport->updateAll($fields, $conditions)) {
                    return new CakeResponse(array('body'=> json_encode('Report has been read'),'status'=>200));
                } else {
                    return new CakeResponse(array('body'=> json_encode('Could not read report'),'status'=>500));
                }
            } else {
                return new CakeResponse(array('body'=> json_encode('Missing id param'),'status'=>500));
            }
        } else {
            $this->redirect($this->referer());
        }
    }
}
