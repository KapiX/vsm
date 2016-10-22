<div class="row">
<div class="col s6 offset-s3">
<h3 class="header center-align"><?php echo __('Log in') ?></h3>
<?php
echo $this->Form->create('User');
echo $this->Form->input('email', ['label' => 'E-mail', 'class' => 'validate', 'div' => 'col s12']);
echo $this->Form->input('password', ['div' => 'col s12']);
echo $this->Form->end(['label' => __('Log in'), 'class' => 'btn-large col s12', 'div' => 'row']);
?>
<div class="row">
<?php
echo $this->Html->link(__('Register'),
    array('controller' => 'users', 'action' => 'add'),
    array('class' => 'btn col s12'));
?>
</div>
</div>