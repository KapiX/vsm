<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {
    var $uses = array('AppSettings', 'PasswordToken');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('register', 'forgot_password', 'reset');
    }

    public function login() {
        if($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        $app_settings = $this->AppSettings->find('first', array('recursive' => -1, 'conditions' => array('name' => 'allow_registration')));
        $this->set('allow_registration', $app_settings['AppSettings']['value'] == 'True');
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Session->setFlash(
                    __('Logged in successfully.'), 'success'
                );
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash(
                __('Invalid username or password, try again.'), 'error'
            );
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function register() {
        if($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        $app_settings = $this->AppSettings->find('first', array('recursive' => -1, 'conditions' => array('name' => 'allow_registration')));
        if ($app_settings['AppSettings']['value'] != 'True') {
            $this->Session->setFlash(
                __('Registration is currently disabled. Please contact administrator')
            );
            return $this->redirect(array('action' => 'login'));
        }
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(
                    __('Account has been successfully created. You can log in now.'), 'success'
                );
                return $this->redirect(array('action' => 'login'));
            }
            $this->Session->setFlash(
                __('Account could not be created. Please, try again.'), 'error'
            );
        }
    }

    public function forgot_password() {
        if($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        Configure::load('misc');
        $data = $this->request->data['User'];
        if($this->request->is('post') && array_key_exists('email', $data)) {
            $token = $this->PasswordToken->createToken($data['email']);
            if($token != false) {
                $email = new CakeEmail(Configure::read('mail.transport'));
                $emailValues = array('token' => $token['PasswordToken']['token']);
                $email->template('password_reset')
                    ->emailFormat('html')
                    ->subject(__('Password reset link'))
                    ->to($data['email'])
                    ->from(Configure::read('mail.from'))
                    ->viewVars($emailValues)
                    ->send();
                $this->Session->setFlash(__('Reset link has been sent. Check your e-mail.'), 'success');
                return $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('An error has occurred.'), 'error');
                return $this->redirect(array('action' => 'forgot_password'));
            }
        }
    }

    public function reset() {
        $token = $this->PasswordToken->read(array(), $this->request->params['token'])['PasswordToken'];
        if(strtotime($token['expires']) >= time()) {
            if($this->request->is('post')) {
                $data = $this->request->data;
                $data['User']['id'] = $token['user_id'];
                $data['User']['modified'] = date('Y-m-d H:i:s');
                $data['User']['password'] = $data['User']['new_password'];
                if($this->User->save($data)) {
                    $this->PasswordToken->delete($token['token']);
                    $this->Session->setFlash(__('Password has been changed.'), 'success');
                    $this->redirect(array('action' => 'login'));
                } else {
                    $errors = '';
                    foreach($this->User->validationErrors as $validationError) {
                        $errors .= '<p>' . $validationError[0] . '</p>';
                    }
                    $this->set('errors', $errors);
                }
            }
            $user = $this->User->read(array(), $token['user_id'])['User'];
            $this->set('account', $user['first_name'] . ' ' . $user['last_name']);
        } else {
            $this->Session->setFlash(__('This token has expired.'), 'error');
            $this->redirect(array('action' => 'login'));
        }
        $this->PasswordToken->deleteExpiredTokens();
    }
}
