<?php

App::uses('AppModel', 'Model');

class PasswordToken extends AppModel {
    public $primaryKey = 'token';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

    public function createToken($user_email) {
        $user_id = $this->User->field('id', array('email' => $user_email));
        if($user_id != false) {
            $format = 'Y-m-d H:i:s';
            $this->User->id = $user_id;
            $password = $this->User->field('password'); // TODO: use salt instead?
            $token = hash('sha256', date($format) . $password);
            // delete all existing tokens for this user
            $this->deleteAll(array('user_id' => $user_id));
            $this->create();
            return $this->save(array(
                'token' => $token,
                'user_id' => $user_id,
                'expires' => date($format, strtotime('+1 day'))
            ));
        }
        return false;
    }

    public function deleteExpiredTokens() {
        $this->deleteAll(array('expires <' => date('Y-m-d H:i:s')));
    }
}
