<?php

App::uses('AppModel', 'Model');

class SprintsUsers extends AppModel {

    public $belongsTo = array(
        'Sprint' => array(
            'className' => 'Sprint',
            'foreignKey' => 'sprint_id'
        )
    );

    public function userInSprint($userId, $sprintId) {
        $userInSprint = $this->find('first',
                array('recursive' => -1, 'conditions' => array('SprintsUsers.sprint_id' => $sprintId, 'SprintsUsers.user_id' => $userId)));
        return !empty($userInSprint);
    }
}
