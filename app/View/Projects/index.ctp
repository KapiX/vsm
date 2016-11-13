<?php $newline = true ?>
<?php foreach($projects as $project): ?>
<?php if($newline): ?><div class="row"><?php endif ?>
    <div class="col s6">
        <div class="card blue-grey darken-1">
            <div class="card-content white-text">
                <div class="card-title">[<?php echo $project['short_name'] ?>] <?php echo $project['name'] ?></div>
                <p></p>
            </div>
            <div class="card-action">
                <?php echo $this->Html->link(__('Open'), array('controller' => 'projects', 'action' => 'view', 'id' => $project['id'])); ?>
                <?php echo $this->Html->link(__('Settings'), array('controller' => 'projects', 'action' => 'settings', 'id' => $project['id'])); ?>
            </div>
        </div>
    </div>
<?php if(!$newline): ?></div><?php endif ?>
<?php $newline = !$newline ?>
<?php endforeach ?>