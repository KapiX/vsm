<h3><?php echo __('Update profile') ?></h3>
<div class="row">
    <div class="col s12">
        <?php echo $this->Form->create('User', array('action' => 'profile')); ?>
        <?php echo $this->Form->hidden('action', array('value' => 'update_profile')); ?>
        <div class="row">
            <?php echo $this->Form->input('email', ['label' => 'E-mail', 'class' => 'validate', 'div' => 'col s12', 'value' => $email]); ?>
        </div>
        <div class="row">
            <?php echo $this->Form->input('first_name', ['div' => 'col m5 s12', 'value' => $first_name]); ?>
            <?php echo $this->Form->input('last_name', ['div' => 'col m5 s12', 'value' => $last_name]); ?>
            <?php echo $this->Form->input('initials', ['div' => 'col m2 s12', 'value' => $initials]); ?>
        </div>
        <div class="row">
            <?php echo $this->Form->end(['label' => __('Update'), 'class' => 'btn col s12', 'div' => false]); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <?php echo $this->Form->create('User', array('action' => 'profile')); ?>
        <?php echo $this->Form->hidden('action', array('value' => 'change_password')); ?>
        <div class="row">
            <?php echo $this->Form->input('current_password', ['type' => 'password', 'div' => 'col s12']); ?>
        </div>
        <div class="row">
            <?php echo $this->Form->input('new_password', ['type' => 'password', 'div' => 'col s12']); ?>
        </div>
        <div class="row">
            <?php echo $this->Form->input('confirm_new_password', ['type' => 'password', 'div' => 'col s12']); ?>
        </div>
        <div class="row">
            <?php echo $this->Form->end(['label' => __('Change'), 'class' => 'btn col s12', 'div' => false]); ?>
        </div>
    </div>
</div>
