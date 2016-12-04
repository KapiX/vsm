<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('CakeTime', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => '/',
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'unauthorizedRedirect' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish',
                    'fields' => array('username' => 'email')
                )
            )
        ),
        'RequestHandler'
    );
    public $helpers = array(
        'Form' => array(
            'className' => 'MaterializeForm'
        )
    );
    public $uses = array('Project', 'User', 'Notification');

    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }

    public function beforeFilter() {
        parent::beforeFilter();
        if (!empty($this->Auth->user('id'))) {
            $this->set('user', $this->Auth->user());
            $this->set('username', $this->Auth->user('first_name'));
            $this->set('projects', $this->Project->find('all', array('recursive' => -1, 'fields' => 'id, short_name')));
            $this->set('myProjects', $this->User->find('first', array('contain' => 'Project', 'conditions' => array('User.id' => $this->Auth->user('id'))))['Project'] );
            $notifications = $this->Notification->find('all', array('order' => array('Notification.created_time' => 'desc'), 'limit' => 10, 'conditions' => array('Notification.user_id' => $this->Auth->user('id'))));
            foreach($notifications as $key => $notification) {
                $notifications[$key]['Notification']['created_time'] = CakeTime::timeAgoInWords($notification['Notification']['created_time']);
            }
            $this->set('myNotifications', $notifications);
            $this->set('newNotificationsCount', $this->Notification->find('count', array('conditions' => array('Notification.user_id' => $this->Auth->user('id'), 'Notification.read' => 0))));
        }
    }
}
