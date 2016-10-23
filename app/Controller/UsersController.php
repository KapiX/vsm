<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow('register');
    }

    public function login() {
        if($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Session->setFlash(__('Invalid username or password, try again.'), 'error');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function register() {
        if($this->Auth->loggedIn()) {
            $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Account has been successfully created. You can log in now.'), 'success');
                return $this->redirect(array('action' => 'login'));
            }
            $this->Session->setFlash(
                __('Account could not be created. Please, try again.'), 'error'
            );
        }
    }
}
