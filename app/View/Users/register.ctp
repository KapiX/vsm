<h3 class="header center-align"><?php echo __('Register') ?></h3>
<?php echo $this->Form->create('User'); ?>
<div class="row">
    <?php
        echo $this->Form->input('email', ['label' => 'E-mail', 'class' => 'validate', 'div' => 'col s12']);
    ?>
</div>
<div class="row">
    <?php
        echo $this->Form->input('password', ['div' => 'col m6 s12']);
        echo $this->Form->input('confirm_new_password', ['type' => 'password', 'div' => 'col m6 s12']);
    ?>
</div>
<div class="row">
    <?php
        echo $this->Form->input('first_name', ['div' => 'col m5 s12']);
        echo $this->Form->input('last_name', ['div' => 'col m5 s12']);
        echo $this->Form->input('initials', ['div' => 'col m2 s12']);
    ?>
</div>
<?php
    echo $this->Form->end(['label' => __('Register'), 'class' => 'btn-large col s12', 'div' => 'row']);
?>
