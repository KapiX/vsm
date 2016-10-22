<?php
App::uses('FormHelper', 'View/Helper');

class MaterializeFormHelper extends FormHelper {
    protected function _divOptions($options) {
        $classes = 'input-field';
        if(isset($options['div']))
            $options['div'] .= ' ' . $classes;
        else
            $options['div'] = $classes;

        return parent::_divOptions($options);
    }

    public function input($fieldName, $options = array()) {
        $labelText = isset($options['label']) ? $options['label'] : null; 
        $after = parent::label($fieldName, $labelText);
        $defaults = array_merge($options, array('label' => false, 'after' => $after));
        echo parent::input($fieldName, $defaults);
    }
}