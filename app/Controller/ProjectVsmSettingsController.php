<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP ProjectVsmSettingsController
 * @author Milan
 */
class ProjectVsmSettingsController extends AppController {
    var $uses = array('User', 'Project', 'ProjectsUsers', 'ProjectVsmSettings');
    
    public function edit() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->autoRender = false;
            $projectId = $this->request->data['ProjectVsmSettings']['project_id'];
            $vsm_settings = $this->ProjectVsmSettings->find('first', array('recursive' => -1, 'conditions' => array('ProjectVsmSettings.project_id' => $projectId)));
            if (empty($vsm_settings)) {
                $this->ProjectVsmSettings->create();
            } else {
                $this->ProjectVsmSettings->id = $vsm_settings['ProjectVsmSettings']['id'];
            }
            $this->ProjectVsmSettings->save($this->request->data['ProjectVsmSettings']);

            return $this->redirect($this->referer()); 
        }
    }

}
