<script type="text/javascript">
 $(document).ready(function(){
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal-trigger').leanModal();
  });
</script>

<h3 class="header"><i class="material-icons" style="font-size:2rem;">directions_run</i><?php echo __('Sprints') ?></h3>

<ul class="collapsible" data-collapsible="accordion">
<li>
    <div class="collapsible-header">Second<a href="#!" class="red-text secondary-content"><i class="material-icons">delete</i></a></div>
    <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
</li>
<li>
    <div class="collapsible-header">Second<a href="#!" class="red-text secondary-content"><i class="material-icons">delete</i></a></div>
    <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
</li>
<li>
    <div class="collapsible-header">Second<a href="#!" class="red-text secondary-content"><i class="material-icons">delete</i></a></div>
    <div class="collapsible-body"><p>Lorem ipsum dolor sit amet.</p></div>
</li>
</ul>

<h3 class="header"><i class="material-icons" style="font-size:2rem;">person</i><?php echo __('Users') ?></h3>
<ul class="collection">
    <li class="collection-item"><div>Alvin<a href="#!" class="red-text secondary-content"><i class="material-icons">remove_circle_outline</i></a></div></li>
    <li class="collection-item"><div>Alvin<a href="#!" class="red-text secondary-content"><i class="material-icons">remove_circle_outline</i></a></div></li>
    <li class="collection-item"><div>Alvin<a href="#!" class="red-text secondary-content"><i class="material-icons">remove_circle_outline</i></a></div></li>
    <li class="collection-item"><div>Alvin<a href="#!" class="red-text secondary-content"><i class="material-icons">remove_circle_outline</i></a></div></li>
</ul>

<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
<a class="btn-floating btn-large red">
    <i class="large material-icons">add</i>
</a>
<ul>
    <li><a class="btn-floating btn modal-trigger" href="#add-sprint"><i class="material-icons">directions_run</i></a></li>
    <li><a class="btn-floating modal-trigger" href="#add-user"><i class="material-icons">person</i></a></li>
</ul>
</div>

<div id="add-user" class="modal bottom-sheet">
    <div class="modal-content">
        <h4><?php echo __('Add user') ?></h4>
        <div class="row">
            <div class="col s12">
                <?php echo $this->Form->create(false, array('action' => 'invite_to_project')); ?>
                <?php echo $this->Form->hidden('project_id', array('value'=> 1)); ?>
                <div class="row">
                    <?php /*echo $this->Form->input('search', ['div' => 'col s6', 'before' => '<i class="material-icons prefix">search</i>'])*/ ?>
                    <?php echo $this->Form->input('email', ['div' => 'col s6', 'before' => '<i class="material-icons prefix">mail</i>']) ?>
                </div>
                <div class="row">
                    <!--input type="submit" value="send" class="col s6 btn large"-->
                    <!--<input type="submit" value="invite" class="col s6 btn large">-->
                    <?php echo $this->Form->end(array('label' => 'invite', 'class' => 'col s6 btn large')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
</div>
