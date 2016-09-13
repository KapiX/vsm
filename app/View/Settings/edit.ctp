<div id='projectVsmSettings'>
    <h1>Project settings</h1>
    <?php echo $this->Form->create('settings', array('action' => 'project_vsm_settings_edit', 'class' => 'form-horizontal')); ?>
    <li>
      <h3>Edit project users</h3>
      <span>TO DO<span>
        <ul>
            <?php
            foreach ($projectUsers as $id => $nickname) {
                echo $id . ' ' . $nickname . '<br>';
            }
            ?>
        </ul>
    </li>
    <?php
    foreach ($availableUsers as $id => $nickname) {
        echo $id . ' ' . $nickname . '<br>';
    }
    ?>
     
     <?php echo $this->Form->input('report_weekdays', array('empty' => '', 'options' => Configure::read('misc.weekdays'), 
                        'label' => 'Report weekdays<br /><small>(hold Ctrl to select multiple)', 'multiple' => true, 'style' => 'width: 100px; height: 120px;')); ?>
    <?php echo $this->Form->input('report_overdue_notification_text', array('type' => 'textbox')); ?>
    <?php echo $this->Form->input('report_overdue_frequency_hours', array('type' => 'number', 'min' => '1', 'max' => '48')); ?> 
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
