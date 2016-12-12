<?php

App::uses('AppModel', 'Model');

class Sprint extends AppModel {
    public $belongsTo = array(
        'Project' => array(
            'className' => 'Project',
            'foreignKey' => 'project_id',
        )
    );
    public $hasAndBelongsToMany = array(
        'User' => array(
            'className'             => 'User',
            'joinTable'             => 'sprints_users',
            'foreignKey'            => 'sprint_id',
            'associationForeignKey' => 'user_id',
            'unique'                => false
        )
    );

    public $hasMany = array(
        'SprintsUsers' => array(
            'className' => 'SprintsUsers',
            'foreignKey' => 'sprint_id',
            'dependent' => true
        ),
        'ScrumReport' => array(
            'className' => 'ScrumReport',
            'foreignKey' => 'sprint_id',
            'dependent' => true
        )
    );

    function beforeSave($options = array()) {
        $data = $this->data['Sprint'];
        if (is_array( $data['report_weekdays']) && count($data['report_weekdays']) > 0 ) {
            $this->data['Sprint']['report_weekdays'] = implode(",", $data['report_weekdays']);
        }
        $this->data['Sprint']['start_date'] = CakeTime::format($data['start_date'], '%Y-%m-%d');
        $this->data['Sprint']['end_date'] = CakeTime::format($data['end_date'], '%Y-%m-%d');

        return true;
    }

    public function afterFind($results, $primary = false) {
        foreach ($results as $k => &$v) {
            if (!empty($v['Sprint']['report_weekdays'])) {
                $v['Sprint']['report_weekdays'] = (strlen($v['Sprint']['report_weekdays']) > 0) ?
                    (explode(",", $v['Sprint']['report_weekdays'])) : array();
            }
        }

        return $results;
    }

    public function setMembers($sprint_id, $user_ids) {
        $this->SprintsUsers->deleteAll(array('sprint_id' => $sprint_id));
        foreach($user_ids as $id) {
            $this->SprintsUsers->create();
            if(!$this->SprintsUsers->save(array('sprint_id' => $sprint_id, 'user_id' => $id))) {
                return false;
            }
        }
        return true;
    }

    public function setWorkDays($sprint_id, $workdays) {
        $dataSource = $this->getDataSource();
        $dataSource->begin();
        $sprint = $this->find('first', array('conditions' => array('id' => $sprint_id), 'recursive' => -1))['Sprint'];
        if(!$sprint) {
            $dataSource->rollback();
            return false;
        }
        $subQuery = $dataSource->buildStatement(array(
            'fields' => array('reports.scrum_report_id'),
            'table'  => 'user_scrum_reports',
            'alias'  => 'reports',
        ), $this->Sprint);
        $subQuery = ' ScrumReport.id NOT IN (' . $subQuery . ') ';
        $subQueryExpression = $dataSource->expression($subQuery);
        $this->ScrumReport->deleteAll(array('sprint_id' => $sprint_id, $subQueryExpression));
        $last_date = $this->ScrumReport->find('first', array(
            'conditions' => array(
                'sprint_id' => $sprint_id
            ),
            'order' => array(
                'deadline_date DESC'
            ),
            'fields' => array('deadline_date'),
            'recursive' => -1
        ))['ScrumReport'];
        if($last_date) {
            $last_date = date('Y-m-d', strtotime($last_date['deadline_date'] . ' +1 day'));
            $this->ScrumReport->addReportsForDays($sprint_id, $workdays, $last_date, $sprint['end_date']);
        } else {
            $this->ScrumReport->addReportsForDays($sprint_id, $workdays, $sprint['start_date'], $sprint['end_date']);
        }
        $dataSource->commit();
        return true;
    }
}
