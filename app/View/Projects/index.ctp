<script type="text/javascript">
 $(document).ready(function(){
    $('.modal').modal();
 });
</script>

<?php $newline = true ?>
<?php foreach($projects as $project): ?>
<?php if($newline): ?><div class="row"><?php endif ?>
    <div class="col m6 s12">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="card-title">[<?php echo $project['short_name'] ?>] <?php echo $project['name'] ?></div>
                <p></p>
            </div>
            <div class="card-action">
                <?php echo $this->Html->link(__('Open'), array('controller' => 'projects', 'action' => 'view', 'id' => $project['id'])); ?>
                <?php if($project['userCanEdit']) echo $this->Html->link(__('Settings'), array('controller' => 'projects', 'action' => 'settings', 'id' => $project['id'])) ?>
            </div>
        </div>
    </div>
<?php if(!$newline): ?></div><?php endif ?>
<?php $newline = !$newline ?>
<?php endforeach ?>

<div class="fixed-action-btn">
<a class="btn-floating btn-large red" href="#add-project">
    <i class="large material-icons">add</i>
</a>
</div>

<div id="add-project" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><?php echo __('Add project') ?></h4>
        <div class="row">
            <div class="col s12">
                <?php echo $this->Form->create('Project', array('url' => array('action' => 'add'))); ?>
                <div class="row">
                    <?php echo $this->Form->input('name', ['div' => 'col s12']) ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->input('short_name', ['div' => 'col s12']) ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->end(array('label' => 'add', 'class' => 'col s12 btn large')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo __('Close') ?></a>
    </div>
</div>