<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your email and password'); ?>
        </legend>
        <?php echo $this->Form->input('email');
        echo $this->Form->input('password');
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>   
    <?php 
    echo $this->Html->link( 'Register',
    array(
        'controller' => 'users',
        'action' => 'add',
    )); ?>
</div>