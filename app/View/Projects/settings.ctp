<script type="text/javascript">
 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
    $('select').material_select();

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
        selectYears: 15,
        format: 'yyyy-mm-dd'
    });

    $('select').material_select();
  });
</script>
<h3>[<?php echo $project['short_name'] ?>] <?php echo $project['name'] . __(' settings')?></h3>
<h4 class="header"><i class="material-icons" style="font-size:1.5rem;">directions_run</i><?php echo __('Sprints') ?></h4>

<ul class="collapsible" data-collapsible="accordion">
<?php foreach($sprints as $sprint): ?>
<li>
    <?php $isPast = $this->Time->isPast($sprint['end_date']) ?>
    <div class="collapsible-header <?php echo ($isPast ? 'grey lighten-2' : '') ?>"><?php echo $sprint['name'] ?>
        <a href="#!" class="red-text secondary-content"><i class="material-icons">delete</i></a>
        <a href="#!" class="grey-text secondary-content text-darken-1"><?php echo $this->Time->format($sprint['start_date'], '%d %b') ?>-<?php echo $this->Time->format($sprint['end_date'], '%d %b') ?></a>
    </div>
    <div class="collapsible-body">
        <?php echo $this->Form->create('Sprint', array('url' => array('controller' => 'projects', 'action' => 'save_sprint', 'id' => $project['id'], 'sprint_id' => $sprint['id']))) ?>
        <div class="row">
            <?php echo $this->Form->input('start_date', ['type' => 'date', 'class' => 'datepicker', 'div' => 'col s6', 'default' => $sprint['start_date']]) ?>
            <?php echo $this->Form->input('end_date', ['type' => 'date', 'class' => 'datepicker', 'div' => 'col s6', 'default' => $sprint['end_date']]) ?>
        </div>
        <div class="row">
            <?php
            $weekdays = array_combine(range(1, 7), array_map(function($v) { return CakeTime::format("last sunday +$v day", '%A'); }, range(1, 7)));
            echo $this->Form->input('report_weekdays', array(
                'options' => $weekdays,
                'empty' => __('Select weekdays'),
                'multiple' => true,
                'disabled' => array(''),
                'div' => 'col s6',
                'default' => $sprint['report_weekdays']
            ));
            foreach($users as $user)
                $project_members[$user['id']] = $user['first_name'] . ' ' . $user['last_name'];
            $sprint_members = array();
            foreach($sprint['User'] as $member)
                $sprint_members[] = $member['id'];
            echo $this->Form->input('sprint_members', array(
                'options' => $project_members,
                'empty' => __('Select members'),
                'multiple' => true,
                'disabled' => array(''),
                'div' => 'col s6',
                'default' => $sprint_members,
            ));
            ?>
        </div>
        <?php echo $this->Form->end(['label' => __('Save'), 'class' => 'btn col s12', 'div' => 'row']); ?>
    </div>
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
        <a href="#change-owner" class="modal-trigger yellow-text secondary-content text-darken-2" title="<?php echo __('Change Project Owner') ?>"><i class="material-icons">grade</i></a>
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
                <?php echo $this->Form->hidden('project_id', array('value' => $project['id'])); ?>
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
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo __('Close') ?></a>
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
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo __('Close') ?></a>
    </div>
</div>

<div id="change-owner" class="modal modal-fixed-footer">
    <div class="modal-content">
        <h4><?php echo __('Change owner') ?></h4>
        <?php echo $this->Form->create(false, array('url' => array('controller' => 'projects', 'action' => 'change_owner', 'id' => $project['id']))); ?>
        <div class="row">
            <div class="input-field col s12">
                <select name="new_owner">
                    <?php foreach($users as $user): ?>
                        <?php if($user['id'] != $project['owner_id']): ?>
                            <option value="<?php echo $user['id'] ?>"><?php echo $user['first_name'] . ' ' . $user['last_name'] ?></option>
                        <?php else: ?>
                            <option selected value="<?php echo $user['id'] ?>"><?php echo $user['first_name'] . ' ' . $user['last_name'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
                <label><?php echo __('Choose new owner') ?></label>
            </div>
        </div>
        <div class="row">
            <?php echo $this->Form->end(array('label' => 'Save', 'class' => 'col s12 btn large')); ?>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo __('Close') ?></a>
    </div>
</div>
