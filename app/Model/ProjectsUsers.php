<?php

App::uses('AppModel', 'Model');

class ProjectsUsers extends AppModel {

  public function userInProject($userId, $projectId) {
      $userInProject = $this->find('first',
              array('recursive' => -1, 'conditions' => array('ProjectsUsers.project_id' => $projectId, 'ProjectsUsers.user_id' => $userId)));
      return !empty($userInProject);
  }

}
