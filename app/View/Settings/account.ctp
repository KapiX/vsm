<div class="changePassword form">
<?php echo $this->Form->create(false, array(
    'url' => array('controller' => 'Settings', 'action' => 'changePassword')
));
?>
    <fieldset>
        <legend><?php echo __('Change password'); ?></legend>
        <?php
            echo $this->Form->input('new_password', array('type' => 'password'));
            echo $this->Form->input('confirm_new_password', array('type' => 'password'));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
