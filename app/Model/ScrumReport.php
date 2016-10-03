<?php

App::uses('AppModel', 'Model');

class ScrumReport extends AppModel {
    public $belongsTo = 'Project';
    public $hasMany = 'UserScrumReport';
    
}
