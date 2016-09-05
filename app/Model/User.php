<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    
    public $hasAndBelongsToMany = array (
        'Project' => array (
            'className'             => 'Project',
            'joinTable'             => 'projects_users',
            'foreignKey'            => 'user_id',
            'associationForeignKey' => 'project_id',
            'unique'                => false
        )
    );

    public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => 'email',
                'message' => 'A vaild email is required'
            ),
            'unique' => array(
                'rule'    => 'isUnique',
                'message' => 'This email is already in use.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('minLength', '8'),
                'message' => 'Min. 8 characters long password is required'
            )
        ),
        'short_name' => array(
            'required' => array(
                'rule' => array('minLength', '1'),
                'message' => 'An username is required'
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}
