<script>

$(document).ready(function(){
   $('ul.tabs').tabs();
 });

</script>
<div class="row">
    <div class="col s12 m8 offset-m2">
        <div class="card">
            <ul class="tabs hide-on-med-and-down">
                <li class="tab col s6"><a target="_self" href="profile"><i class="material-icons" style="font-size:1.5rem;">supervisor_account</i><?php echo __(' My Profile') ?></a></li>
                <li class="tab col s6"><a class="active" href="#"><i class="material-icons" style="font-size:1.5rem;">vpn_key</i><?php echo __(' Change Password') ?></a></li>
            </ul>
            <div class="col s12">
                <?php echo $this->Form->create('User', array('action' => "change_password")); ?>
                <div class="row">
                    <?php echo $this->Form->input('current_password', ['type' => 'password', 'div' => 'col s12']); ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->input('new_password', ['type' => 'password', 'div' => 'col s12']); ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->input('confirm_new_password', ['type' => 'password', 'div' => 'col s12']); ?>
                </div>
                <div class="row">
                    <?php echo $this->Form->end(['label' => __('Change'), 'class' => 'btn-large col s12', 'div' => false]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
