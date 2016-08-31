<?php

App::uses('AppController', 'Controller');

class SettingsController extends AppController {

    var $uses = array('User');

    public function account() {

    }

    public function projects() {

    }

    public function changePassword() {
      if ($this->request->is('post')) {
          $user_id = $this->Auth->user('id');
          $data = array('id' =>$user_id, 'password' => $this->request->data['new_password']);
          if ($this->User->save($data)) {
              $this->Session->setFlash(__('The password has been changed'));
              return $this->redirect($this->referer());
          }
          $this->Session->setFlash(
              __(serialize($this->request->data))
          );
      }
    }

    public function testt() {}
}
