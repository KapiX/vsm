<?php

App::uses('AppModel', 'Model');

class UserUserScrumReport extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'UserScrumReport' => array(
            'className' => 'UserScrumReport',
            'foreignKey' => 'user_scrum_report_id'
        ),
    );
}
