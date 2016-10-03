<?php

App::uses('AppModel', 'Model');

class UserUserScrumReport extends AppModel {
    public $belongsTo = array('User', 'UserScrumReport');
    public $hasMany = 'UserScrumReport';    
}
