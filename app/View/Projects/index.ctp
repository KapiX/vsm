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
                <a href="#"><?php echo __('Open') ?></a>
                <?php echo $this->Html->link(__('Settings'), array('action' => 'settings')); ?>
            </div>
        </div>
    </div>
<?php if(!$newline): ?></div><?php endif ?>
<?php $newline = !$newline ?>
<?php endforeach ?>