<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class SettingsController extends AppController {

    var $uses = array('User', 'Project', 'ProjectsUsers', 'ProjectVsmSettings');

    public function account() {

    }

    public function projects() {
        $projects = $this->Project->find('all', array('recursive' => -1, 'fields' => 'project.id, project.short_name'));
        $editableProjects = array_filter($projects, function($project) { return $this->Project->userCanEdit($project['Project']['id'], $this->Auth->user('id')); });
        $this->set('editableProjects', $editableProjects);
    }

    public function changePassword() {
      if ($this->request->is('post')) {
          $user_id = $this->Auth->user('id');
          $reponse = '';
          $new_password = $this->request->data['new_password'];
          $confirm_new_password = $this->request->data['confirm_new_password'];
          if ($new_password != $confirm_new_password) {
              $response = 'The new password and confirmation password must be the same.';
          } else {
              $data = array('id' =>$user_id, 'password' => $new_password);
              if ($this->User->save($data)) {
                  $response = 'Your password has been changed.';
              } else {
                $response = 'The password could not be changed. Please, try again.';
              }
          }
          $this->Session->setFlash(__($response));
          return $this->redirect($this->referer());
      }
    }

    public function edit($projectID) {
        if (!$this->Project->userCanEdit($projectID, $this->Auth->user('id'))) {
            return $this->redirect($this->referer());
        }
        $this->set('projectID', $projectID);
        Configure::load('misc');
        $users = $this->User->find( 'all', array(
            'fields' => 'user.id, user.short_name'
        ));
        $availableUsers =  array_filter($users, function($user) use ($projectID){ return !$this->ProjectsUsers->userInProject($user['User']['id'], $projectID); });
        $userIds = array_column(array_column($availableUsers, 'User'), 'id');
        $userNicknames = array_column(array_column($availableUsers, 'User'), 'short_name');
        $usersNameID = array_combine ( $userIds, $userNicknames);
        $this->set('availableUsers', $usersNameID);

        $projectUsers = array_filter($users, function($user) use ($projectID){ return $this->ProjectsUsers->userInProject($user['User']['id'], $projectID); });
        $projectUserIds = array_column(array_column($projectUsers, 'User'), 'id');
        $projectUserNicknames = array_column(array_column($projectUsers, 'User'), 'short_name');
        $projectUsersNameID = array_combine ( $projectUserIds, $projectUserNicknames);
        $this->set('projectUsers', $projectUsersNameID);
        
        $vsm_settings = $this->ProjectVsmSettings->find('first', array('recursive' => -1, 'conditions' => array('ProjectVsmSettings.project_id' => $projectID)));
        if (!empty($vsm_settings)) {
            $this->request->data['ProjectVsmSettings'] = $this->ProjectVsmSettings->read(null, $vsm_settings['ProjectVsmSettings']['id'])['ProjectVsmSettings'];
        }
    }   

    public function remove_user_from_project() {
        if(!array_key_exists('Settings', $this->request->data) ||
           !array_key_exists('projectId', $this->request->data['Settings']) ||
           !array_key_exists('userId', $this->request->data['Settings'])) {
            return $this->redirect($this->referer());
        }
        $projectId = $this->request->data['Settings']['projectId'];
        $userId = $this->request->data['Settings']['userId'];
        if (!$this->Project->userCanEdit($projectId, $this->Auth->user('id'))) {
            return $this->redirect($this->referer());
        }
        $this->ProjectsUsers->deleteAll(array('ProjectsUsers.user_id' => $userId, 'ProjectsUsers.project_id' => $projectId), false);
        return $this->redirect($this->referer());
    }

    public function add_user_from_project() {
        if(!array_key_exists('Settings', $this->request->data) ||
           !array_key_exists('projectId', $this->request->data['Settings']) ||
           !array_key_exists('userId', $this->request->data['Settings'])) {
            return $this->redirect($this->referer());
        }
        $projectId = $this->request->data['Settings']['projectId'];
        $userId = $this->request->data['Settings']['userId'];
        if (!$this->Project->userCanEdit($projectId, $this->Auth->user('id'))) {
            return $this->redirect($this->referer());
        }
        $this->ProjectsUsers->create();
        $data = array(
                'ProjectsUsers' => array(
                    'project_id'=>$projectId,
                    'user_id'=>$userId
                )
        );
        $this->ProjectsUsers->save($data);
        return $this->redirect($this->referer());
    }
}
