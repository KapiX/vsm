<script>

$(document).ready(function(){
   $('ul.tabs').tabs();
 });

</script>
<div class="row">
  <div class="col s12 m12">
    <div class="card">
      <ul class="tabs">
        <li class="tab col s6"><a class="active"  href="#">My Profile</a></li>
        <li class="tab col s6"><a target="_self" href="change_password">Change Password</a></li>
      </ul>
      <div class="col s12">
        <?php echo $this->Form->create('User', array('action' => 'profile')); ?>
        <div class="row">
        <?php echo $this->Form->input('email', ['label' => 'E-mail', 'class' => 'validate', 'div' => 'col s12', 'value' => $email]); ?>
        </div>
        <div class="row">
        <?php echo $this->Form->input('first_name', ['div' => 'col s12', 'value' => $first_name]); ?>
        </div>
        <div class="row">
        <?php echo $this->Form->input('last_name', ['div' => 'col s12', 'value' => $last_name]); ?>
        </div>
        <div class="row">
        <?php echo $this->Form->input('initials', ['div' => 'col s12', 'value' => $initials]); ?>
        </div>
        <div class="row">
        <?php echo $this->Form->end(['label' => __('Update'), 'class' => 'btn-large col s12', 'div' => false]); ?>
        </div>
      </div>
    </div>
  </div>
</div>
