<?php

App::uses('AppModel', 'Model');

class AccountToken extends AppModel {
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
            $token = Security::hash(date($format) . $password, 'sha256', true);
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
