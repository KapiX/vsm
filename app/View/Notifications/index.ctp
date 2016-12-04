<div>
    <h3>Notifications</h3>
    <ul class="collection">
        <?php foreach($myNotifications as $notification): ?>
          <?php $link = $this->Html->url(array('controller' => 'notifications', 'action' => 'read', 'id' => $notification['Notification']['id'])); ?>
          <a href="<?php echo $link ?>" class="collection-item avatar <?php if(!$notification['Notification']['read']) echo "dropdown-element-new" ?>">
              <i class="material-icons circle">add_alert</i>
              <span class="title"><?php echo $notification['Notification']['title'] ?></span>
              <p><?php echo $notification['Notification']['text'] ?></p>
              <p class="time-text"><?php echo $notification['Notification']['created_time'] ?></p>
          </a>
        <?php endforeach ?>
    </ul>
</div>
