<?php

App::uses('AppModel', 'Model');

class ProjectVsmSettings extends AppModel {
    function beforeSave($options = array()) {
        if ( is_array( $this->data['ProjectVsmSettings']['report_weekdays']) && count($this->data['ProjectVsmSettings']['report_weekdays']) > 0 ) {
                $this->data['ProjectVsmSettings']['report_weekdays'] = ( implode(",", $this->data['ProjectVsmSettings']['report_weekdays']) );
        }
        
        return true;
    }
    
    public function afterFind($results, $primary = false) {
        foreach ($results as $k => &$v) {
            if (!empty($v['ProjectVsmSettings']['report_weekdays'])) {
                $v['ProjectVsmSettings']['report_weekdays'] = (strlen($v['ProjectVsmSettings']['report_weekdays']) > 0) ? 
                    (explode(",", $v['ProjectVsmSettings']['report_weekdays'])) : array();
            }
        }
        
        return $results;
    }
}
