<div class="projects form">
<?php echo $this->Form->create('Project'); ?>
    <fieldset>
        <legend><?php echo __('Create Project'); ?></legend>
        <?php 
            echo $this->Form->input('name');
            echo $this->Form->input('short_name');
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
