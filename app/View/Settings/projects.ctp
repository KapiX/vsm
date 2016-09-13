<div>
<h3>
<?php
echo $this->Html->link( 'Add new project',
        array(
            'controller' => 'Projects',
            'action' => 'add',
        ));
?>
</h3>
</div>
<div>
<h3>Edit my projects</h3>
<?php
    foreach ($editableProjects as $project) {
            echo '<li>' .
                $this->Html->link( $project['Project']['short_name'],
                    array(
                        'controller' => 'Settings',
                        'action' => 'edit',
                        $project['Project']['id']
                    ))
            . '</li>';
    }
?>
<div>
