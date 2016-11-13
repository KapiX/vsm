<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class SettingsController extends AppController {

    var $uses = array('User', 'Project', 'ProjectsUsers', 'ProjectVsmSettings');

    public function account() {
        if ($this->request->is('post')) {
            $response = '';
            $user_id = $this->Auth->user('id');
            $new_password = $this->request->data['User']['new_password'];
            $confirm_new_password = $this->request->data['User']['confirm_new_password'];
            $current_password = $this->request->data['User']['current_password'];
            $data = array('id' => $user_id, 'password' => $new_password, 'current_password' => $current_password, 'new_password' => $new_password, 'confirm_new_password' => $confirm_new_password);

            if($this->User->save($data)) {
                $response = 'Your password has been changed';
            } else {
                foreach ($this->User->validationErrors as $validationError) {
                    $response = $response . $validationError[0] . '<br>';
                }
            }
            $this->Session->setFlash(__($response));
        }
    }

    public function projects() {
        $projects = $this->Project->find('all', array('recursive' => -1, 'fields' => 'id, short_name'));
        $editableProjects = array_filter($projects, function($project) { return $this->Project->userCanEdit($project['Project']['id'], $this->Auth->user('id')); });
        $this->set('editableProjects', $editableProjects);
    }

    public function edit($projectID) {
        if (!$this->Project->userCanEdit($projectID, $this->Auth->user('id'))) {
            return $this->redirect($this->referer());
        }
        $this->set('projectID', $projectID);
        Configure::load('misc');
        $users = $this->User->find( 'all', array(
            'fields' => 'User.id, User.email'
        ));
        $availableUsers =  array_filter($users, function($user) use ($projectID){ return !$this->ProjectsUsers->userInProject($user['User']['id'], $projectID); });
        $userIds = array_column(array_column($availableUsers, 'User'), 'id');
        $userNicknames = array_column(array_column($availableUsers, 'User'), 'email');
        $usersNameID = array_combine ( $userIds, $userNicknames);
        $this->set('availableUsers', $usersNameID);

        $projectUsers = array_filter($users, function($user) use ($projectID){ return $this->ProjectsUsers->userInProject($user['User']['id'], $projectID); });
        $projectUserIds = array_column(array_column($projectUsers, 'User'), 'id');
        $projectUserNicknames = array_column(array_column($projectUsers, 'User'), 'email');
        $projectUsersNameID = array_combine ( $projectUserIds, $projectUserNicknames);
        $this->set('projectUsers', $projectUsersNameID);

        $vsm_settings = $this->ProjectVsmSettings->find('first', array('recursive' => -1, 'conditions' => array('ProjectVsmSettings.project_id' => $projectID)));
        if (!empty($vsm_settings)) {
            $this->request->data['ProjectVsmSettings'] = $this->ProjectVsmSettings->read(null, $vsm_settings['ProjectVsmSettings']['id'])['ProjectVsmSettings'];
        }
    }
}
