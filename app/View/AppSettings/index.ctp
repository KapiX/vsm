<h3><?php echo __('App settings') ?></h3>
<?php echo $this->Form->create('AppSettings') ?>
<div class="row">
  <?php echo $this->Form->input('allow_registration', array('type' => 'checkbox', 'div' => 'col s9', 'checked' => $allow_registration)) ?>
</div>
<div class="row">
  <?php echo $this->Form->end(['label' => __('Save'), 'class' => 'col s3 btn']) ?>
</div>
