<?php

App::uses('AppController', 'Controller');

class ScrumReportsController extends AppController {

    public function index($projectID = null) {
        
        if (!empty($projectID)) {
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
        
    }

}
