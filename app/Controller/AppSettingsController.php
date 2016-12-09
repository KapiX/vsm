<?php

App::uses('AppController', 'Controller');

class AppSettingsController extends AppController {

    var $uses = array('AppSettings');

    public function index() {
        $app_settings = $this->AppSettings->find('first', array('recursive' => -1, 'conditions' => array('name' => 'allow_registration')));
        $this->set('allow_registration', $app_settings['AppSettings']['value'] == 'True');
        if($this->request->is('post')) {
            $allow_registration = $this->request->data['AppSettings']['allow_registration'] ? 'True' : 'False';
            $data = array('name' => 'allow_registration', 'value' => $allow_registration);
            if($this->AppSettings->save($data)) {
                $this->Session->setFlash(__('Changes saved.'), 'success');
            } else {
                $this->Session->setFlash(__('Changes count not be saved. Try again later.'), 'error');
            }
            return $this->redirect($this->referer());
        }
    }
}
