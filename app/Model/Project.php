<?php

App::uses('AppModel', 'Model');

class Project extends AppModel {
    public $hasAndBelongsToMany = array (
        'User' => array (
            'className'             => 'User',
            'joinTable'             => 'projects_users',
            'foreignKey'            => 'project_id',
            'associationForeignKey' => 'user_id',
            'unique'                => false
        )
    );
    
    public function userCanEdit($projectId, $userId) {
        $thisProject = $this->find('first', 
                array('recursive' => -1, 'fields' => 'Project.owner_id', 'conditions' => array('Project.id' => $projectId)));
        return $userId === $thisProject['Project']['owner_id'];
    }
    
    public function userIsMember($projectId, $userId) {
        $projectUsers = $this->find('first', array('contain' => 'User', 'conditions' => array('Project.id' => $projectId)))['User'];
        $userIds = array_column($projectUsers, 'id');
        return in_array($userId, $userIds);
    }
}
