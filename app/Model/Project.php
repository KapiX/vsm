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
    public $hasOne = 'ProjectVsmSettings';
    public $hasMany = 'ScrumReport';
    
    public function userCanEdit($projectId, $userId) {
        $thisProject = $this->find('first', 
                array('recursive' => -1, 'fields' => 'Project.owner_id', 'conditions' => array('Project.id' => $projectId)));
        return $userId === $thisProject['Project']['owner_id'];
    }
    
}
