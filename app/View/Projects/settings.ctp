<script type="text/javascript">
 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();

    $.ajax({
        url: "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'get_users')) ?>",
        cache: false,
        type: 'GET',
        dataType: 'json',
        success: function (usersData) {
            $('input#search').autocomplete({
                data: usersData
            });
        }
    });

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 15
    })
  });
</script>
<h3>[<?php echo $project['short_name'] ?>] <?php echo $project['name'] ?> settings</h3>
<h4 class="header"><i class="material-icons" style="font-size:1.5rem;">directions_run</i><?php echo __('Sprints') ?></h4>

<ul class="collapsible" data-collapsible="accordion">
<?php foreach($sprints as $sprint): ?>
<li>
    <?php $past = $this->Time->isPast($sprint['end_date']) ?>
    <div class="collapsible-header <?php echo ($isPast ? 'grey lighten-2' : '') ?>"><?php echo $sprint['name'] ?>
        <a href="#!" class="red-text secondary-content"><i class="material-icons">delete</i></a>
        <a href="#!" class="grey-text secondary-content text-darken-1"><?php echo $this->Time->format($sprint['start_date'], '%d %b') ?>-<?php echo $this->Time->format($sprint['end_date'], '%d %b') ?></a>
    </div>
    <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
</li>
<?php endforeach ?>
</ul>

<h4 class="header"><i class="material-icons" style="font-size:1.5rem;">person</i><?php echo __('Users') ?></h4>
<ul class="collection">
<?php foreach($users as $user): ?>
    <li class="collection-item"><div><?php echo $user['first_name'] . ' ' . $user['last_name'] ?>
    <?php if($user['id'] != $project['owner_id']): ?>
        <?php $url = $this->Html->url(array('controller' => 'projects', 'action' => 'remove_user', 'id' => $project['id'], 'user_id' => $user['id'])); ?>
        <a href="<?php echo $url ?>" class="red-text secondary-content"><i class="material-icons">remove_circle_outline</i></a>
    <?php else: ?>
        <a href="#!" class="yellow-text secondary-content text-darken-2" title="<?php echo __('Owner') ?>"><i class="material-icons">grade</i></a>
    <?php endif ?>
    </div></li>
<?php endforeach ?>
</ul>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
<a class="btn-floating btn-large red">
    <i class="large material-icons">add</i>
</a>
<ul>
    <li><a class="btn-floating modal-trigger" href="#add-sprint"><i class="material-icons">directions_run</i></a></li>
    <li><a class="btn-floating modal-trigger" href="#add-user"><i class="material-icons">person</i></a></li>
</ul>
</div>

<div id="add-user" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><?php echo __('Add user') ?></h4>
        <div class="row">
            <div class="col s12">
                <?php echo $this->Form->create(false, array('url' => array('action' => 'add_user', 'id' => $project['id']))); ?>
                <div class="row">
                    <?php echo $this->Form->input('search', ['div' => 'col s12', 'before' => '<i class="material-icons prefix">search</i>']) ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->end(array('label' => 'add', 'class' => 'col s12 btn large')); ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <?php echo $this->Form->create(false, array('action' => 'invite_to_project')); ?>
                <?php echo $this->Form->hidden('project_id', array('value'=> 1)); ?>
                <div class="row">
                    <?php echo $this->Form->input('email', ['div' => 'col s12', 'before' => '<i class="material-icons prefix">mail</i>']) ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->end(array('label' => 'invite', 'class' => 'col s12 btn large')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>

<div id="add-sprint" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><?php echo __('Add sprint') ?></h4>
        <?php echo $this->Form->create('Sprint', array('url' => array('controller' => 'projects', 'action' => 'add_sprint', 'id' => $project['id']))); ?>
        <div class="row">
            <?php echo $this->Form->input('name', ['div' => 'col s12']) ?>
        </div>
        <div class="row">
            <?php echo $this->Form->input('start_date', ['type' => 'date', 'class' => 'datepicker', 'div' => 'col s12']) ?>
        </div>
        <div class="row">
            <?php echo $this->Form->input('end_date', ['type' => 'date', 'class' => 'datepicker', 'div' => 'col s12']) ?>
        </div>
        <div class="row">
            <?php echo $this->Form->end(array('label' => 'add', 'class' => 'col s12 btn large')); ?>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
