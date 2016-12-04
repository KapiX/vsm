<div>
    <h3><?php echo __('Notifications') ?></h3>
    <ul class="collection">
        <?php foreach($paginatedNotifications as $notification): ?>
          <?php $link = $this->Html->url(array('controller' => 'notifications', 'action' => 'read', 'id' => $notification['Notification']['id'])); ?>
          <a href="<?php echo $link ?>" class="collection-item avatar <?php if(!$notification['Notification']['read']) echo "dropdown-element-new" ?>">
              <i class="material-icons circle">add_alert</i>
              <span class="title"><?php echo $notification['Notification']['title'] ?></span>
              <p><?php echo $notification['Notification']['text'] ?></p>
              <p class="time-text"><?php echo $notification['Notification']['created_time'] ?></p>
          </a>
        <?php endforeach ?>
    </ul>
    <ul class="pagination right">
        <?php echo $this->Paginator->prev('<i class="material-icons">chevron_left</i>', array('escape' => false, 'tag' => 'li'), null, null);?>
        <?php echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1)) ?>
        <?php echo $this->Paginator->next('<i class="material-icons">chevron_right</i>', array('escape' => false, 'tag' => 'li'), null, null);?>
    </ul>
</div>
