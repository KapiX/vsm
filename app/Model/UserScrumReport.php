<?php

App::uses('AppModel', 'Model');

class UserScrumReport extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'ScrumReport' => array(
            'className' => 'ScrumReport',
            'foreignKey' => 'scrum_report_id'
        )
    );

    public $hasMany = array(
        'UserUserScrumReport' => array(
            'className' => 'UserUserScrumReport',
            'foreignKey' => 'user_scrum_report_id',
            'dependent' => true
        )
    );
}
