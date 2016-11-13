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
    public $hasMany = array(
        'Sprint' => array(
            'className'             => 'Sprint',
            'foreignKey'            => 'project_id',
            'associationForeignKey' => 'id',
            'order'                 => array('start_date ASC, end_date ASC'),
            'unique'                => false
        )
    );
    public $hasOne = 'ProjectVsmSettings';
    
    public function userCanEdit($projectId, $userId) {
        $thisProject = $this->find('first',
                array('recursive' => -1, 'fields' => 'Project.owner_id', 'conditions' => array('Project.id' => $projectId)));
        return $userId === $thisProject['Project']['owner_id'];
    }

    public function userCanBeRemoved($projectId, $userId) {
        $thisProject = $this->find('first',
                array('recursive' => -1, 'fields' => 'Project.owner_id', 'conditions' => array('Project.id' => $projectId)));
        return $userId !== $thisProject['Project']['owner_id'];
    }
    
}
