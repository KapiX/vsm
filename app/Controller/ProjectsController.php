<?php

App::uses('AppController', 'Controller');

class ProjectsController extends AppController {

    public function index($id) {
        
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Project->create();
            if ($this->Project->save($this->request->data)) {
                $this->Session->setFlash(__('The project  has been created'));
                return $this->redirect($this->referer());
            }
            $this->Session->setFlash(
                __('The project could not be created. Please, try again.')
            );
        }
    }

}
