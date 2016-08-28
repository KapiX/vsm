<?php 
    $css = array('menu');         
    echo $this->Html->css($css);   
?>

<div id ="leftMenu">
    <nav role="navigation">
        <div class="list-group">
            <a data-toggle="collapse" data-target="#projectsBox"><span class="glyphicon glyphicon-list"></span> Projects<br></a>
            <div id="projectsBox" class="collapse">
                <p>xxx</p>
                <p>aaa</p>
            </div>
            
            <a><span class="glyphicon glyphicon-wrench"></span> Settings<br></a>
        </div> 
    </nav>
</div>
