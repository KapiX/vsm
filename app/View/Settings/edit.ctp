<div id='projectVsmSettings'>
    <h1>Project settings</h1>
    <li>
      <h3>Remove users from project</h3>
      <?php
          foreach ($projectUsers as $id => $nickname) {
            echo $this->Form->create('Settings', array('action' => "remove_user_from_project", 'class' => 'form-horizontal'));
            echo "<span>$nickname</span>";
            echo $this->Form->hidden('projectId',array('value'=> $projectID));
            echo $this->Form->hidden('userId',array('value'=> $id));
            echo $this->Form->end(__('-'));
          }
      ?>
    <h3>Add users to project</h3>
    <?php
        foreach ($availableUsers as $id => $nickname) {
          echo $this->Form->create('Settings', array('action' => "add_user_from_project", 'class' => 'form-horizontal'));
          echo "<span>$nickname</span>";
          echo $this->Form->hidden('projectId',array('value'=> $projectID));
          echo $this->Form->hidden('userId',array('value'=> $id));
          echo $this->Form->end(__('+'));
        }
    ?>
    </li>
    <?php echo $this->Form->create('settings', array('action' => 'project_vsm_settings_edit', 'class' => 'form-horizontal')); ?>
    <?php echo $this->Form->input('report_weekdays', array('empty' => '', 'options' => Configure::read('misc.weekdays'),
                        'label' => 'Report weekdays<br /><small>(hold Ctrl to select multiple)', 'multiple' => true, 'style' => 'width: 100px; height: 120px;')); ?>
    <?php echo $this->Form->input('report_overdue_notification_text', array('type' => 'textbox')); ?>
    <?php echo $this->Form->input('report_overdue_frequency_hours', array('type' => 'number', 'min' => '1', 'max' => '48')); ?>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
