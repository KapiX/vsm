<?php

App::uses('AppModel', 'Model');

class Notification extends AppModel {
    public $primaryKey = 'id';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

    public function addNotification($href, $text, $user_id, $title) {
        if($user_id != false) {
            $format = 'Y-m-d H:i:s';
            $this->create();
            return $this->save(array(
                'href' => $href,
                'text' => $text,
                'user_id' => $user_id,
                'title' => $title,
                'created_time' => date($format)
            ));
        }
        return false;
    }
}
