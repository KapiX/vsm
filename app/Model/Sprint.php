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

    public $hasMany = array('SprintsUsers');

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
}
