<div id="overviewMyProjects">
    <ul>
        <legend>My projects: </legend>
        <?php
            foreach ($myProjects as $project) {
                    echo '<li>' .
                        $this->Html->link( $project['short_name'],
                            array(
                                'controller' => 'ScrumReports',
                                'action' => 'index',
                                $project['id']
                            ))
                    . '</li>';
            }
        ?>
    </ul>
</div>
