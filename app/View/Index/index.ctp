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
                    <span class="time-text right"><?php echo $notification['Notification']['created_time'] ?></span>
                </li>
            <?php endforeach ?>
        </div>
    </ul>
</div>
<?php endif ?>
<div class="card-panel valign-wrapper">
    <a href="<?php echo $urlPrev ?>" class="btn-flat"><i class="material-icons valign">chevron_left</i></a>
    <h5 class="header valign center-align" id="month-year"><?php echo $header ?></h5>
    <a href="<?php echo $urlNext ?>" class="btn-flat"><i class="material-icons valign">chevron_right</i></a>
</div>
<div class="row">
<div class="col s12">
    <table id="calendar">
        <thead class="hide-on-med-and-down">
            <tr><?php foreach($weekdays as $day) echo "<th>$day</th>" ?></tr>
        </thead>
        <thead class="hide-on-large-only">
            <tr><?php foreach($weekdays as $day) echo "<th>".substr($day, 0, 3)."</th>" ?></tr>
        </thead>
        <tbody>
            <?php
            // pierwszy tydzień
            echo '<tr>';
            for($i = 0; $i < 7; ++$i) {
                echo '<td>';
                $lastPrintedDay = $i - $firstWeekDay + 1;
                if($i >= $firstWeekDay)
                    echo $lastPrintedDay;
                echo '</td>';
            }
            echo '</tr>';
            // tygodnie środkowe
            while($lastDay - $lastPrintedDay > 7) {
                echo '<tr>';
                for($i = 0; $i < 7; ++$i) {
                    echo '<td>';
                    echo ++$lastPrintedDay;
                    echo '</td>';
                }
                echo '</tr>';
            }
            // ostatni tydzień
            echo '<tr>';
            for($i = 0; $i < 7; ++$i) {
                echo '<td>';
                if($lastPrintedDay < $lastDay)
                    echo ++$lastPrintedDay;
                echo '</td>';
            }
            echo '</tr>';
            ?>
        </tbody>
    </table>
</div>
</div>
