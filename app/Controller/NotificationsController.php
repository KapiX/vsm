<?php

App::uses('AppController', 'Controller');

class NotificationsController extends AppController {

    public $uses = array('Notification');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('read');
    }
    public function read() {
        $user_id = $this->Auth->user('id');
        $notificationId = $this->request->params['id'];
        $notification = $this->Notification->find('first', array('conditions' => array('Notification.user_id' => $user_id)))['Notification'];
        if($notification != null) {
            $notification['read'] = 1;
            $this->Notification->save($notification);
            $this->redirect(Router::url('/', true).$notification['href']);
        }
        return $this->redirect($this->referer());
    }
}
