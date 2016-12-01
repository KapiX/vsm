<?php

App::uses('AppController', 'Controller');

class SprintsController extends AppController {

    var $uses = array('UserScrumReport', 'ScrumReport');

    public function index() {
        $user_id = $this->Auth->User('id');
        $sprint_id = $this->request->params['id'];
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
        $this->set('missingUserScrumReports', $missingUserScrumReports);
        $this->set('allUserScrumReport', $this->UserScrumReport->find('all', array('order' => array('UserScrumReport.id' => 'desc'), 'conditions' => array('sprint_id' => $sprint_id))));
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
            if($this->UserScrumReport->save($data)) {
                $this->loadModel('SprintsUser');
                $this->loadModel('UserUserScrumReport');
                $sprintUsers = $this->SprintsUser->find('all', array(
                    'conditions' => array(
                        'sprint_id' => $sprint_id,
                        'NOT' => array( 'user_id' => $user_id)
                    )
                ));
                foreach ($sprintUsers as $sprintUser) {
                    $this->UserUserScrumReport->create();
                    $this->UserUserScrumReport->save(array(
                        'user_scrum_report_id' => $this->UserScrumReport->id,
                        'user_id' => $sprintUser['SprintsUser']['user_id']
                    ));
                    $this->loadModel('Notification');
                    $this->Notification->newReportNotification($sprint_id, $sprintUser['SprintsUser']['user_id'], $this->Auth->User('first_name'));
                }
                $this->Session->setFlash(__('Report added.'), 'success');
            } else {
                $this->Session->setFlash(__('Could not save.'), 'error');
            }
        }
        $this->redirect($this->referer());
    }
}
