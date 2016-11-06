<div class="row">
<div class="col s6 offset-s3">
<h3 class="header center-align"><?php echo __('Reset password') ?></h3>
<p class="center-align"><?php echo __('for account: ') . $account ?></p>
<?php if(isset($errors)): ?>
<div><?php echo $errors ?></div>
<?php endif ?>
<?php echo $this->Form->create('User'); ?>
<div class="row">
<?php echo $this->Form->input('new_password', ['type' => 'password', 'div' => 'col s12']); ?>
</div>
<div class="row">
<?php echo $this->Form->input('confirm_new_password', ['type' => 'password', 'div' => 'col s12']); ?>
</div>
<div class="row">
<?php echo $this->Form->end(['label' => __('Send'), 'class' => 'btn-large col s12', 'div' => false]); ?>
</div>
</div>
</div>
