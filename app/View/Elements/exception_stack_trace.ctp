<?php App::uses('Debugger', 'Utility'); ?>
<h3 class="header">Stack trace</h3>
<ul class="collapsible" data-collapsible="expandable">
<?php 
foreach($error->getTrace() as $i => $stack) {
    $excerpt = $arguments = '';
    $params = array();
    echo '<li><div class="collapsible-header">';
    if(isset($stack['file']) && isset($stack['line'])) {
        echo Debugger::trimPath($stack['file']) . ':' . $stack['line'];
        $excerpt = '<pre>';
        $excerpt .= "\n" . implode("\n", Debugger::excerpt($stack['file'], $stack['line'] - 1, 2));
        $excerpt .= '</pre>';
    } else {
        echo '[internal function]';
    }
    echo ' &rarr; ';
    if($stack['function']) {
        $args = array();
        if(!empty($stack['args'])) {
            foreach((array) $stack['args'] as $arg) {
                $args[] = Debugger::getType($arg);
                $params[] = Debugger::exportVar($arg, 2);
            }
        }
        $called = isset($stack['class']) ?
            $stack['class'] . $stack['type'] . $stack['function'] :
            $stack['function'];
        echo $called . '(' . implode(', ', $args) . ')';
        $arguments = '<pre>';
        $arguments .= implode("\n", $params);
        $arguments .= '</pre>';
    }
    echo '</div><div class="collapsible-body">';
    echo $excerpt;
    echo $arguments;
    echo '</div></li>';
}
?>
</ul>