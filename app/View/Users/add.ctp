<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Add User'); ?></legend>
        <?php 
            echo $this->Form->input('email');
            echo $this->Form->input('password');
            echo $this->Form->input('confirm_new_password', array('type' => 'password'));
            echo $this->Form->input('name');
            echo $this->Form->input('last_name');
            echo $this->Form->input('short_name');
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
