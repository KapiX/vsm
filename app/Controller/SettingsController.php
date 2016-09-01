<?php

App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class SettingsController extends AppController {

    var $uses = array('User');

    public function account() {

    }

    public function projects() {

    }

    public function changePassword() {
      if ($this->request->is('post')) {
          $user_id = $this->Auth->user('id');
          $reponse = '';
          $new_password = $this->request->data['new_password'];
          $confirm_new_password = $this->request->data['confirm_new_password'];
          if ($new_password != $confirm_new_password) {
              $response = 'The new password and confirmation password must be the same.';
          } else {
              $data = array('id' =>$user_id, 'password' => $new_password);
              if ($this->User->save($data)) {
                  $response = 'Your password has been changed.';
              } else {
                $response = 'The password could not be changed. Please, try again.';
              }
          }
          $this->Session->setFlash(__($response));
          return $this->redirect($this->referer());
      }
    }

    public function edit() {

      
    }
}
