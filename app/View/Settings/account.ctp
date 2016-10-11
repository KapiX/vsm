<div class="changePassword form">
<?php echo $this->Form->create('User', array(
    'url' => array('controller' => 'Settings', 'action' => 'account')
));
?>
    <fieldset>
        <legend><?php echo __('Change password'); ?></legend>
        <?php
            echo $this->Form->input('current_password', array('type' => 'password'));
            echo $this->Form->input('new_password', array('type' => 'password'));
            echo $this->Form->input('confirm_new_password', array('type' => 'password'));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
