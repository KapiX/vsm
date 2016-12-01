<?php

App::uses('AppModel', 'Model');

class ScrumReport extends AppModel {
    public $hasMany = 'UserScrumReport';

}
