<div class="row">
<div class="col s6 offset-s3">
<h3 class="header center-align"><?php echo __('Forgot password') ?></h3>
<p class="center-align"><?php echo __('Enter the e-mail you have used to log in on this site.') ?></p>
<p class="center-align"><?php echo __('You will receive a message with reset link.') ?></p>
<?php echo $this->Form->create('User'); ?>
<div class="row">
<?php echo $this->Form->input('email', ['label' => 'E-mail', 'class' => 'validate', 'div' => 'col s12']); ?>
</div>
<div class="row">
<?php echo $this->Form->end(['label' => __('Send'), 'class' => 'btn-large col s12', 'div' => false]); ?>
</div>
</div>
</div>