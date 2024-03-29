<script type="text/javascript">
$(document).ready(function(){
    $('.modal').modal();
});
</script>
<?php
$lastPrintedDay = 0;
$urlPrev = $this->Html->url('/' . implode('/', array(
    'project', $id, $this->Time->format("$current - 1 month", '%Y/%m'),
)));
$urlNext = $this->Html->url('/' . implode('/', array(
    'project', $id, $this->Time->format("$current + 1 month", '%Y/%m')
)));

$sprint_color = array();
$day_sprint = array();
$i = 0;
for($day = 0; $day <= $lastDay; ++$day)
    $day_sprint[$day] = array();
foreach($sprints as $sprint) {
    $sprint_color[$sprint['id']] = $i;
    $i++;

    $start_date = new DateTime($sprint['start_date']);
    $end_date = new DateTime($sprint['end_date']);
    $first_date = new DateTime($current);
    $last_date = DateTime::createFromFormat('d F Y', "$lastDay $header");
    if($start_date > $last_date || $end_date < $first_date) continue;
    $start = (int) $start_date->format('d');
    $end = (int) $end_date->format('d');
    if($start_date < $first_date) {
        $start = 1;
    }
    if($end_date > $last_date) {
        $end = $lastDay;
    }
    for(;$start <= $end; $start++) {
        $day_sprint[$start][] = $sprint['id'];
    }
}
?>
<h3 class="header center-align"><?php echo $project['name'] ?></h3>
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
                $lastPrintedDay = $i - $firstWeekDay + 1;
                echo '<td>';
                if($i >= $firstWeekDay) {
                    echo '<div class="day-wrapper">';
                    if(!empty($readReports[$lastPrintedDay])) {
                        echo '<a href="#day-' . $lastPrintedDay . '">';
                        echo $lastPrintedDay;
                        echo '</a>';
                    } else {
                        echo $lastPrintedDay;
                    }
                    echo '<div class="sprint-marks">';
                    foreach($day_sprint[$lastPrintedDay] as $id) {
                        echo '<div class="sprint-mark ' . $colors[$sprint_color[$id]] . '"></div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                echo '</td>';
            }
            echo '</tr>';
            // tygodnie środkowe
            while($lastDay - $lastPrintedDay > 7) {
                echo '<tr>';
                for($i = 0; $i < 7; ++$i) {
                    $lastPrintedDay++;
                    echo '<td>';
                    echo '<div class="day-wrapper">';
                    if(!empty($readReports[$lastPrintedDay])) {
                        echo '<a href="#day-' . $lastPrintedDay . '">';
                        echo $lastPrintedDay;
                        echo '</a>';
                    } else {
                        echo $lastPrintedDay;
                    }
                    echo '<div class="sprint-marks">';
                    foreach($day_sprint[$lastPrintedDay] as $id) {
                        echo '<div class="sprint-mark ' . $colors[$sprint_color[$id]] . '"></div>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</td>';
                }
                echo '</tr>';
            }
            // ostatni tydzień
            echo '<tr>';
            for($i = 0; $i < 7; ++$i) {
                echo '<td>';
                if($lastPrintedDay < $lastDay) {
                    echo '<div class="day-wrapper">';
                    ++$lastPrintedDay;
                    if(!empty($readReports[$lastPrintedDay])) {
                        echo '<a href="#day-' . $lastPrintedDay . '">';
                        echo $lastPrintedDay;
                        echo '</a>';
                    } else {
                        echo $lastPrintedDay;
                    }
                    echo '<div class="sprint-marks">';
                    foreach($day_sprint[$lastPrintedDay] as $id) {
                        echo '<div class="sprint-mark ' . $colors[$sprint_color[$id]] . '"></div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                echo '</td>';
            }
            echo '</tr>';
            ?>
        </tbody>
    </table>
</div>
</div>

<?php
foreach($sprints as $sprint) {
    $start_date = new DateTime($sprint['start_date']);
    $end_date = new DateTime($sprint['end_date']);
    $first_date = new DateTime($current);
    $last_date = DateTime::createFromFormat('d F Y', "$lastDay $header");
    if($start_date > $last_date || $end_date < $first_date) continue;
    echo '<div class="chip ' . $colors[$sprint_color[$sprint['id']]] . '">';
    echo '<a class="sprint-link" href="'.$this->Html->url(array('controller' => 'sprint', 'action' => $sprint['id'])).'">';
    echo $sprint['name'] ? $sprint['name'] : '&nbsp;';
    echo '</a>';
    echo '</div>';
}
?>

<?php foreach($readReports as $day => $reports): ?>
<?php if(!empty($reports)): ?>
<div id="day-<?php echo $day ?>" class="modal modal-fixed-footer">
    <div class="modal-content">
      <h4><?php echo $day ?></h4>
      <?php foreach($reports as $sprint => $users): ?>
        <h5><?php echo $sprint ?></h5>
        <?php $order = array(); ?>
        <table class="highlight">
            <thead><tr>
                <th></th>
                <?php foreach($users as $user => $seen): ?>
                    <th class="center"><?php echo $usersMap[$user]['initials'] ?></th>
                    <?php $order[] = $user; ?>
                <?php endforeach ?>
            </tr></thead>
            <tbody>
                <?php foreach($users as $user => $seen): ?>
                    <tr>
                        <td><?php echo $usersMap[$user]['first_name']." ".$usersMap[$user]['last_name'] ?></td>
                        <?php if($seen === null): ?>
                            <td class="center red accent-4" colspan="<?php echo count($users) ?>"><?php echo __('Did not send report yet.') ?></td>
                        <?php else: ?>
                            <?php foreach($order as $user): ?>
                                <?php if(in_array($user, array_keys($seen))): ?>
                                    <td class="center <?php echo ($seen[$user] ? 'light-green accent-3' : 'red accent-4')?>">
                                      <i class="material-icons valign"><?php echo ($seen[$user] ? 'done' : 'close') ?></i>
                                    </td>
                                <?php else: ?>
                                    <td class="center light-green accent-3">N/A</td>
                                <?php endif ?>
                            <?php endforeach ?>
                            <td></td>
                            <td></td>
                        <?php endif ?>
                    <tr>
                <?php endforeach ?>
            </tbody>
        </table>
      <?php endforeach ?>
    </div>
    <div class="modal-footer">
      <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo __('Close') ?></a>
    </div>
</div>
<?php endif ?>
<?php endforeach ?>
