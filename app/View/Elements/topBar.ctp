<?php
$linkProjects = $this->html->link(__('Projects'), ['controller' => 'projects', 'action' => 'index']);
$linkLogout = $this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout']);

$urlHomepage = $this->Html->url('/');

$activeProjects = ($this->name == 'Projects') ? ' class="active"' : '';
?>

<nav>
    <div class="nav-wrapper">
        <a href="<?php echo $urlHomepage ?>" class="brand-logo">Virtual Scrum Meetings</a> 
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="#"><?php echo $username ?></a></li>
            <li<?php echo $activeProjects ?>><a href="#"><?php echo $linkProjects ?></a></li>
            <li><?php echo $linkLogout ?></li>
        </ul>
    </div>
</nav>