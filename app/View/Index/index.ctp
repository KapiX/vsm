<?php
$lastPrintedDay = 0;
$urlPrev = $this->Html->url('/' . implode('/', array(
    'calendar', $this->Time->format("$current - 1 month", '%Y/%m'),
)));
$urlNext = $this->Html->url('/' . implode('/', array(
    'calendar', $this->Time->format("$current + 1 month", '%Y/%m')
)));
?>
<?php if(count($newNotifications) > 0): ?>
<div class="row">
    <ul class="collection with-header">
        <li class="collection-header"><strong>Recent Activities</strong></li>
        <div class="dashboard-notifications">
            <?php foreach($newNotifications as $notification): ?>
                <?php $link = $this->Html->url(array('controller' => 'notifications', 'action' => 'read', 'id' => $notification['Notification']['id'])); ?>
                <li class="collection-item">
                    <a href="<?php echo $link ?>"><?php echo $notification['Notification']['text'] ?></a>
                    <span class="time-text right"><?php echo $this->Time->timeAgoInWords($notification['Notification']['created_time']) ?></span>
                </li>
            <?php endforeach ?>
        </div>
    </ul>
</div>
<?php endif ?>
<h3 class="header"><i class="material-icons" style="font-size:2rem;">view_headline</i><?php echo __('Upcoming reports') ?></h3>
<?php foreach($upComingReports as $projectReports): ?>
  <h5><?php echo $projectReports['Project']['name'] ?></h5>
  <ul class="collection" id="upcoming-reports">
  <?php if(empty($projectReports['reports'])): ?>
      <li class="collection-item"><div><?php echo __("No upcoming reports for this project") ?>
  <?php else: ?>
      <?php foreach($projectReports['reports'] as $report): ?>
          <?php $url = $this->Html->url(array('controller' => 'sprints', 'action' => 'index', 'id' => $report['Sprint']['id']));?>
          <?php $deadline = $report['ScrumReport']['deadline_date'] ?>
          <a href="<?php echo $url ?>"><li class="collapsible-header missing-report-item <?php if(CakeTime::isPast($deadline)) echo "report-deadline-reached"; else if(CakeTime::isTomorrow($deadline)) echo "report-deadline-today" ?>">
                  <i class="material-icons"><?php echo CakeTime::isPast($deadline) || CakeTime::isTomorrow($deadline)? 'announcement' : 'playlist_add' ?></i>
                  <?php echo $report['Sprint']['name'] ?>
                  <span class="report-time"><?php echo $deadline ?></span>
          </li></a>
      <?php endforeach ?>
  <?php endif ?>
  </ul>

<?php endforeach ?>
