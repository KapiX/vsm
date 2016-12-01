<?php

App::uses('AppModel', 'Model');
App::uses('SprintsUser', 'Model');

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

    public function addUserToProjectNotification($project_id, $user_id, $creator_name) {
        $this->addNotification("project/$project_id", "$creator_name added you to project.", $user_id, "Project");
    }

    public function addNewSprintNotification($project_id, $sprint_id, $creator_name) {
        $SprintsUser = new SprintsUser();
        $sprint_users = $SprintsUser->find('all', array(
            'conditions' => array('SprintsUser.sprint_id' => $sprint_id)
        ));
        foreach ($sprint_users as $sprint_user) {
            $this->addNotification("project/$project_id", "$creator_name added new sprint.", $sprint_user['SprintsUser']['user_id'], "New Sprint");
        }
    }
}
