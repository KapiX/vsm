<?php

App::uses('AppModel', 'Model');

class ScrumReport extends AppModel {

    public $belongsTo = array(
        'Sprint' => array(
            'className' => 'Sprint',
            'foreignKey' => 'sprint_id'
        )
    );

    public $hasMany = array(
        'UserScrumReport' => array(
            'className' => 'UserScrumReport',
            'foreignKey' => 'scrum_report_id',
            'dependent' => true
        )
    );

}
