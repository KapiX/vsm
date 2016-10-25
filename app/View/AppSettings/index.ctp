<div class="admin form">
  <h1>App settings</h1>
<?php
  echo $this->Form->create('AppSettings', array('action' => "change_app_settings"));
  echo $this->Form->input('allow_registration', array('type' => 'checkbox', 'checked' => $allow_registration));
  echo $this->Form->end(__('Save'));
?>
</div>
