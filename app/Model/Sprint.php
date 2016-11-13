<?php

App::uses('AppModel', 'Model');

class Sprint extends AppModel {
    public $hasOne = 'Project';
    
}
