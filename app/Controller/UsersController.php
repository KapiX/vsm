<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    var $uses = array('AppSettings');

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('register');
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
}
