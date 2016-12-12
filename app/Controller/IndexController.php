<?php
App::uses('AppController', 'Controller');

App::uses('CakeTime', 'Utility');

class IndexController extends AppController {
    public function index() {
        //$month = $this->request->params['month']; TO DO
        //$year = $this->request->params['year']; TO DO
        if(empty($month)) $month = CakeTime::format('now', '%m');
        if(empty($year)) $year = CakeTime::format('now', '%Y');

        $localizedWeekdays = array();
        for($i = 0; $i < 7; $i++) {
            $localizedWeekdays[] = CakeTime::format("next Monday + $i days", '%A');
        }
        $date = "01.$month.$year";
        $firstWeekDayOfMonth = CakeTime::format("first day of $date", '%u') - 1;
        $lastDayOfMonth = CakeTime::format("last day of $date", '%d');
        $monthHeader = CakeTime::format($date, '%B %Y');

        $this->loadModel('UserScrumReport');
        $this->loadModel('ScrumReport');
        $this->loadModel('ProjectsUsers');
        $this->loadModel('SprintsUsers');
        $user_id = $this->Auth->User('id');
        $userCompletedReports = $this->UserScrumReport->find('all', array(
            'conditions' => array('user_id' => $user_id)
        ));
        $completedReportsIds = array();
        if($userCompletedReports != null)
            foreach ($userCompletedReports as $value) {
                array_push($completedReportsIds, $value['UserScrumReport']['scrum_report_id']);
            }
        $missingUserScrumReports = $this->ScrumReport->find('all', array(
            'order' => array('ScrumReport.deadline_date' => 'asc'),
            'conditions' => array('NOT' => array( 'ScrumReport.id' => $completedReportsIds )), 'group' => array('ScrumReport.sprint_id')
        ));
        $projectMap = array();
        for($i = 0; $i < count($missingUserScrumReports); $i++) {
            if($this->SprintsUsers->userInSprint($user_id, $missingUserScrumReports[$i]['Sprint']['id']))
                $projectMap[$missingUserScrumReports[$i]['Sprint']['project_id']]['reports'][] = $missingUserScrumReports[$i];
        }
        $projects = $this->ProjectsUsers->find('all', array('conditions' => array('ProjectsUsers.user_id' => $user_id)));
        for($i = 0; $i < count($projects); $i++) {
            $projectMap[$projects[$i]['Project']['id']]['Project'] = $projects[$i]['Project'];
        }

        $this->set('upComingReports', $projectMap);
        $this->loadModel('Notification');
        $this->set('newNotifications', $this->Notification->find('all', array('order' => array('Notification.created_time' => 'desc'), 'conditions' => array('Notification.user_id' => $this->Auth->user('id'), 'Notification.read' => 0))));
        $this->set('weekdays', $localizedWeekdays);
        $this->set('firstWeekDay', $firstWeekDayOfMonth);
        $this->set('lastDay', $lastDayOfMonth);
        $this->set('header', $monthHeader);
        $this->set('current', $date);
    }
}
