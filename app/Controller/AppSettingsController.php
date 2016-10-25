<?php

App::uses('AppController', 'Controller');

class AppSettingsController extends AppController {

    var $uses = array('AppSettings');

    public function index() {
      $app_settings = $this->AppSettings->find('first', array('recursive' => -1));
      $this->set('allow_registration', $app_settings['AppSettings']['allow_registration']);
    }

    public function change_app_settings() {
      $app_settings = $this->AppSettings->find('first', array('recursive' => -1));
      if ($this->request->data['AppSettings']['allow_registration'])
          $this->AppSettings->save(array(id => 1, "allow_registration" => true));
      else
          $this->AppSettings->save(array(id => 1, "allow_registration" => false));
      $this->Session->setFlash(__("Changes saved."), 'success');
      return $this->redirect($this->referer());
    }
}
