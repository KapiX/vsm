<?php
$linkProjects = $this->html->link(__('<i class="hide-on-large-only material-icons">toc</i>Projects'), ['controller' => 'projects', 'action' => 'index'], array('escape' => false));
$linkLogout = $this->Html->link(__('<i class="hide-on-large-only material-icons">power_settings_new</i>Logout'), ['controller' => 'users', 'action' => 'logout'], array('escape' => false));
if(isset($user)) $linkUser = $this->Html->link(__($username), ['controller' => 'users', 'action' => 'profile']);
$linkProfile = $this->Html->link(__('<i class="hide-on-large-only material-icons">supervisor_account</i>Update Profile'), ['controller' => 'users', 'action' => 'profile'], array('escape' => false));
$linkChangePassword = $this->Html->link(__('<i class="hide-on-large-only material-icons">vpn_key</i>Change Password'), ['controller' => 'users', 'action' => 'change_password'], array('escape' => false));
$allNotificationsUrl = $this->Html->url(array('controller' => 'notifications', 'action' => 'index', ));

$urlHomepage = $this->Html->url('/');

$activeProjects = ($this->name == 'Projects') ? ' class="active"' : '';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.button-collapse').sideNav();
        $('.tooltipped').tooltip({delay: 50});
    });
</script>
<nav>
    <div class="nav-wrapper">
        <a href="<?php echo $urlHomepage ?>" class="brand-logo">Virtual Scrum Meetings</a>
        <?php if(isset($user)): ?>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <?php endif ?>
        <ul class="right hide-on-med-and-down">
        <?php if(isset($user)): ?>
            <li><?php echo $linkUser ?></li>
            <li><a class='dropdown-button' href='#' data-activates='notification-dropdown' data-alignment="right" data-beloworigin="true" data-constrainwidth="false"><?php echo __('Notifications') ?><span class="nav-badge"><?php echo $newNotificationsCount ? $newNotificationsCount : 0 ?></span></a></li>
            <li<?php echo $activeProjects ?>><?php echo $linkProjects ?></li>
            <li><?php echo $linkLogout ?></li>
        <?php endif ?>
        </ul>
        <ul id="mobile-demo" class="side-nav">
        <?php if(isset($user)): ?>
            <li<?php echo $activeProjects ?>><?php echo $linkProjects ?></li>
            <li><a href="<?php echo $allNotificationsUrl ?>" ><i class="material-icons">announcement</i><?php echo __('Notifications') ?><span class="nav-badge"><?php echo $newNotificationsCount ? $newNotificationsCount : 0 ?></span></a></li>
            <li><?php echo $linkProfile ?></li>
            <li><?php echo $linkChangePassword ?></li>
            <li><?php echo $linkLogout ?></li>
        <?php endif ?>
        </ul>
    </div>
</nav>
<div id="notification-dropdown" class="dropdown-content">
    <h5>Notifications</h5><a href="<?php echo $allNotificationsUrl ?>" ><?php echo __('View all reports') ?></a>
    <ul class="dropdown-list collection">
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
