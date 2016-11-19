<?php
$linkProjects = $this->html->link(__('Projects'), ['controller' => 'projects', 'action' => 'index']);
$linkLogout = $this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout']);
if(isset($user)) $linkUserProfile = $this->Html->link(__($username), ['controller' => 'users', 'action' => 'profile']);

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
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
        <?php if(isset($user)): ?>
            <li><?php echo $linkUserProfile ?></li>
            <li><a class='dropdown-button' href='#' data-activates='notification-dropdown' data-alignment="right" data-beloworigin="true" data-constrainwidth="false">Notifications<span class="nav-badge">2</span></a></li>
            <li<?php echo $activeProjects ?>><?php echo $linkProjects ?></li>
            <li><?php echo $linkLogout ?></li>
        <?php endif ?>
        </ul>
        <ul id="mobile-demo" class="side-nav">
        <?php if(isset($user)): ?>
            <li><?php echo $linkUserProfile ?></li>
            <li<?php echo $activeProjects ?>><?php echo $linkProjects ?></li>
            <li><?php echo $linkLogout ?></li>
        <?php endif ?>
        </ul>
    </div>
</nav>
<div id="notification-dropdown" class="dropdown-content">
    <h5>Notifications<span class="new badge gray">2</span></h5>
    <ul class="dropdown-list collection">
        <a href="#" class="collection-item avatar dropdown-element-new">
            <i class="material-icons circle">add_alert</i>
            <span class="title">New report</span>
            <p>John added new report to Project 2</p>
            <p class="time-text">10 minutes ago</p>
        </a>
        <a href="#" class="collection-item avatar">
            <i class="material-icons circle">add_alert</i>
            <span class="title">New report</span>
            <p>John added new report to Project 2</p>
            <p class="time-text">10 minutes ago</p>
        </a>
        <a href="#" class="collection-item avatar dropdown-element-new">
            <i class="material-icons circle">add_alert</i>
            <span class="title">New report</span>
            <p>John added new report to Project 2</p>
            <p class="time-text">10 minutes ago</p>
        </a>
        <a href="#" class="collection-item avatar">
            <i class="material-icons circle">add_alert</i>
            <span class="title">New report</span>
            <p>John added new report to Project 2</p>
            <p class="time-text">10 minutes ago</p>
        </a>
        <a href="#" class="collection-item avatar">
            <i class="material-icons circle">add_alert</i>
            <span class="title">New report</span>
            <p>John added new report to Project 2</p>
            <p class="time-text">10 minutes ago</p>
        </a>
    </ul>
</div>
