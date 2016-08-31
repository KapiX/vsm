<?php
    $css = array('menu');
    echo $this->Html->css($css);
?>

<div id ="leftMenu">
    <nav role="navigation">
        <div class="list-group">
            <a data-toggle="collapse" data-target="#projectsBox"><span class="glyphicon glyphicon-list"></span> Projects</a>
            <?php
            echo $this->Html->link( '+',
                    array(
                        'controller' => 'Projects',
                        'action' => 'add',
                    ));
            ?> <br>
            <div id="projectsBox" class="collapse">
                <ul>
                    <?php
                        foreach ($projects as $project) {
                                echo '<li>' .
                                    $this->Html->link( $project['Project']['short_name'],
                                        array(
                                            'controller' => 'ScrumReports',
                                            'action' => 'index',
                                            $project['Project']['id']
                                        ))
                                . '</li>';
                        }
                    ?>
                </ul>
            </div>
            <a data-toggle="collapse" data-target="#settingsBox"><span class="glyphicon glyphicon-wrench"></span> Settings</a>
            <div id="settingsBox" class="collapse">
                <ul>
                    <li>
                        <?php
                            echo $this->Html->link( 'My account',
                                    array(
                                        'controller' => 'Settings',
                                        'action' => 'account'
                                    ))
                        ?>
                    </li>
                    <li>
                        <?php
                            echo $this->Html->link( 'Projects',
                                    array(
                                        'controller' => 'Settings',
                                        'action' => 'projects'
                                    ))
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
