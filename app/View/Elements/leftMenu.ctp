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
            
            <a><span class="glyphicon glyphicon-wrench"></span>                                     
                <?php 
                    echo $this->Html->link( 'Settings',
                            array(
                                'controller' => 'Settings',
                                'action' => 'index'
                            )) 
                ?>  <br>
            </a>
        </div> 
    </nav>
</div>
