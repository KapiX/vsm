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
                    echo $lastPrintedDay;
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
                    echo $lastPrintedDay;
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
                    echo ++$lastPrintedDay;
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
