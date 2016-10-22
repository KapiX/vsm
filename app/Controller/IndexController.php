<?php
App::uses('AppController', 'Controller');

App::uses('CakeTime', 'Utility');

class IndexController extends AppController {
    public function index() {
        $month = $this->request->params['month'];
        $year = $this->request->params['year'];
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

        $this->set('weekdays', $localizedWeekdays);
        $this->set('firstWeekDay', $firstWeekDayOfMonth);
        $this->set('lastDay', $lastDayOfMonth);
        $this->set('header', $monthHeader);
        $this->set('current', $date);
    }
}