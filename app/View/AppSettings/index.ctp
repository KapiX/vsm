<script type="text/javascript">
$(document).ready(function(){
    $('.modal').modal();
    $('select').material_select();
});
</script>
<?php $roles = array(__('User'), __('Project manager'), __('Administrator')) ?>
<h3><?php echo __('App settings') ?></h3>
<?php echo $this->Form->create('AppSettings') ?>
<div class="row">
    <?php echo $this->Form->input('allow_registration', array('type' => 'checkbox', 'div' => 'col s9', 'checked' => $allow_registration)) ?>
</div>
<div class="row">
    <?php echo $this->Form->end(['label' => __('Save'), 'class' => 'col s3 btn']) ?>
</div>
<h3><?php echo __('Users') ?></h3>
<ul class="collection">
<?php foreach($paginatedUsers as $user): ?>
    <?php $u = $user['User'] ?>
    <li class="collection-item avatar">
        <i class="material-icons circle">person</i>
        <span class="title"><?php echo '[' . $u['initials'] . '] ' . $u['first_name'] . ' ' . $u['last_name'] ?></span>
        <p><?php echo $roles[$u['level']] ?><br>
           <?php echo $u['email'] ?></p>
        <a href="#user-<?php echo $u['id'] ?>" class="secondary-content"><i class="material-icons">mode_edit</i></a>
    </li>
<?php endforeach ?>
</ul>
<ul class="pagination center">
    <?php echo $this->Paginator->prev('<i class="material-icons">chevron_left</i>', array('escape' => false, 'tag' => 'li'), null, null);?>
    <?php echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1)) ?>
    <?php echo $this->Paginator->next('<i class="material-icons">chevron_right</i>', array('escape' => false, 'tag' => 'li'), null, null);?>
</ul>

<?php foreach($paginatedUsers as $user): ?>
<?php $u = $user['User'] ?>
<div id="user-<?php echo $u['id'] ?>" class="modal">
    <div class="modal-content">
        <h4><?php echo __('Change permissions') ?></h4>
        <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'edit', 'id' => $u['id']))); ?>
        <div class="row">
            <?php
            echo $this->Form->input('level', array(
                'options' => $roles,
                'div' => 'col s12',
                'default' => $u['level']
            ));
            ?>
        </div>
    </div>
    <div class="modal-footer">
        <?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn large')); ?> <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo __('Close') ?></a>
    </div>
</div>
<?php endforeach ?>
