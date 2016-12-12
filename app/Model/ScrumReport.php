<?php

App::uses('AppModel', 'Model');

class ScrumReport extends AppModel {

    public $belongsTo = array(
        'Sprint' => array(
            'className' => 'Sprint',
            'foreignKey' => 'sprint_id'
        )
    );

    public $hasMany = array(
        'UserScrumReport' => array(
            'className' => 'UserScrumReport',
            'foreignKey' => 'scrum_report_id',
            'dependent' => true
        )
    );

    // przyjmuje start_date i end_date jako string
    public function addReportsForDays($sprint_id, $days, $start_date, $end_date) {
        $dataSource = $this->getDataSource();
        $dataSource->begin();
        $start_date = CakeTime::format($start_date, '%Y-%m-%d');
        $end_date = CakeTime::format($end_date, '%Y-%m-%d');
        $start_cmp = new DateTime($start_date);
        $end_cmp = new DateTime($end_date);
        while($start_cmp <= $end_cmp) {
            if(!in_array(CakeTime::format($start_date, '%u'), $days)) {
                $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
                $start_cmp = new DateTime($start_date);
                continue;
            }
            $this->create();
            $this->save(array('sprint_id' => $sprint_id, 'deadline_date' => $start_date));
            $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
            $start_cmp = new DateTime($start_date);
        }
        $dataSource->commit();
    }

    public function whoHasRead($user_report_id) {
        $report = $this->UserScrumReport->find('first', array(
            'conditions' => array(
                'UserScrumReport.id' => $user_report_id
            ),
            'recursive' => 1,
        ));
        if(!$report) {
            return false;
        }
        $has_seen = array();
        foreach($report['UserUserScrumReport'] as $seen) {
            if($seen['report_seen_date'] !== null) {
                $has_seen[$seen['user_id']] = true;
            } else {
                $has_seen[$seen['user_id']] = false;
            }
        }
        return $has_seen;
    }

}
