<?php

App::uses('AppModel', 'Model');

class UserScrumReport extends AppModel {
    public $belongsTo = array('User', 'ScrumReport');
    public $hasMany = 'UserUserScrumReport';
    
}
