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
        ),
        'Sprint' => array(
            'className'             => 'Sprint',
            'joinTable'             => 'sprints_users',
            'foreignKey'            => 'user_id',
            'associationForeignKey' => 'sprint_id',
            'unique'                => false
        )
    );
    public $hasMany = array(
        'UserScrumReport' => array (
            'className'             => 'UserScrumReport',
            'foreignKey'            => 'user_id',
            'dependent'             => true
        ),
        'UserUserScrumReport' => array (
            'className'             => 'UserUserScrumReport',
            'foreignKey'            => 'user_id',
            'dependent'             => true
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
        'new_password' => array(
            'required' => array(
                'rule' => array('minLength', '1'),
                'message' => 'No new password',
            )
        ),
        'confirm_new_password' => array(
            'rule' => 'passwordsMatch',
            'message' => 'Passwords must match',
        ),
        'current_password' => array(
            'rule' => 'checkCurrentPassword',
            'message' => 'Invalid current password',
        ),
        'short_name' => array(
            'required' => array(
                'rule' => array('minLength', '1'),
                'message' => 'An username is required'
            )
        ),
        'first_name' => array(
            'required' => array(
                'rule' => array('minLength', '1'),
                'message' => 'A first name is required'
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

    public function passwordsMatch($confirm_new_password) {
        return $confirm_new_password['confirm_new_password'] === $this->data[$this->alias]['password'];
    }

    public function checkCurrentPassword($current_password) {
        $this->id = AuthComponent::user('id');
        $passwordHasher = new BlowfishPasswordHasher();
        $password = $this->field('password');

        return $passwordHasher->check($current_password['current_password'], $password);
    }

    public function canSetPermissions($level) {
        if($level == 2)
            return true;
        return false;
    }

}
