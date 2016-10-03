<?php

App::uses('AppController', 'Controller');

class ScrumReportsController extends AppController {
    
    public $uses = array('ScrumReport', 'Project', 'ProjectsUsers', 'UserScrumReport');

    public function index($projectID = null) {
       
        if (!empty($projectID)) {
            
            if (!$this->ProjectsUsers->userInProject($this->Auth->user('id'), $projectID)) {
                return $this->redirect($this->referer());
            }
            
            $lastReport = $this->ScrumReport->find('first', array(
                'fields' => ('ScrumReport.id'),
                'conditions' => array('ScrumReport.project_id' => $projectID),
                'order' => array('ScrumReport.deadline_date' => 'desc')
            ));
            if (!empty($lastReport)) {
                $this->redirect(array('controller' => 'ScrumReports', 'action' => 'view', $projectID, $lastReport['ScrumReport']['id']));
            }      
        }
    }
    
    public function view($projectID, $reportID) {
        if (!$this->ProjectsUsers->userInProject($this->Auth->user('id'), $projectID)) {
            return $this->redirect($this->referer());
        }
        
        $report = $this->ScrumReport->find('first', array(
                'recursive' => 2,
                'conditions' => array('ScrumReport.id' => $reportID),
        ));  
        $this->set('userReports', $report['UserScrumReport']);
    }
    
    public function overview() {
        
    }

}
