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
}
