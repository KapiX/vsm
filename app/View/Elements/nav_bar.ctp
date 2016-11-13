<?php
$linkProjects = $this->html->link(__('Projects'), ['controller' => 'projects', 'action' => 'index']);
$linkLogout = $this->Html->link(__('Logout'), ['controller' => 'users', 'action' => 'logout']);

$urlHomepage = $this->Html->url('/');

$activeProjects = ($this->name == 'Projects') ? ' class="active"' : '';
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.button-collapse').sideNav();
    });
</script>
<nav>
    <div class="nav-wrapper">
        <a href="<?php echo $urlHomepage ?>" class="brand-logo">Virtual Scrum Meetings</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a> 
        <ul class="right hide-on-med-and-down">
        <?php if(isset($user)): ?>
            <li><a href="#"><?php echo $username ?></a></li>
            <li<?php echo $activeProjects ?>><?php echo $linkProjects ?></li>
            <li><?php echo $linkLogout ?></li>
        <?php endif ?>
        </ul>
        <ul id="mobile-demo" class="side-nav">
        <?php if(isset($user)): ?>
            <li><a href="#"><?php echo $username ?></a></li>
            <li<?php echo $activeProjects ?>><?php echo $linkProjects ?></li>
            <li><?php echo $linkLogout ?></li>
        <?php endif ?>
        </ul>
    </div>
</nav>