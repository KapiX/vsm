<?php 
    $css = array('menu');         
    echo $this->Html->css($css);   
?>

<div id =" topBar">
    <nav class="navbar navbar-fixed-top navbar-inverse" id ="topBar" role="navigation">
            <div >
                <h>VIRTUAL SCRUM MEETINGS</h>
            </div> 
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <p><?php echo $username ?></p>
                </li>
                <li>                  
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span><span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><?php 
                                echo $this->Html->link( 'Logout',
                                array(
                                    'controller' => 'users',
                                    'action' => 'logout',
                                )); ?>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>	  
    </nav>
</div>
