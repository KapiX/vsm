<?php

App::uses('AppController', 'Controller');

class NotificationsController extends AppController {

    public $uses = array('Notification');

    public function beforeFilter() {
        parent::beforeFilter();
    }
    public function read() {
        $user_id = $this->Auth->User('id');
        $notificationId = $this->request->params['id'];
        $notification = $this->Notification->find('first', array('conditions' => array('Notification.user_id' => $user_id, 'Notification.id' => $notificationId)))['Notification'];
        $dataSource = $this->Notification->getDataSource();
        $dataSource->begin();
        if($notification != null) {
            $notification['read'] = 1;
            if($this->Notification->save($notification)) {
                $dataSource->commit();
                $this->redirect(Router::url('/', true).$notification['href']);
            }
        }
        $dataSource->rollback();
        return $this->redirect($this->referer());
    }

    public function readAll() {
        $user_id = $this->Auth->User('id');
        $dataSource = $this->Notification->getDataSource();
        $dataSource->begin();
        $fields = array('Notification.read' => 1);
        $conditions = array('Notification.user_id' => $user_id, 'Notification.read' => 0);
        if($this->Notification->updateAll($fields, $conditions)) {
            $dataSource->commit();
        } else {
            $dataSource->rollback();
        }
        return $this->redirect($this->referer());
    }

    public function index() {
        $this->Notification->recursive = 0;
        $this->paginate = array('order' => array('Notification.created_time' => 'desc'), 'limit' => 5, 'conditions' => array('Notification.user_id' => $this->Auth->User('id')) );
        $this->set('paginatedNotifications', $this->paginate());
    }
}
