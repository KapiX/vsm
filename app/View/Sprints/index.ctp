<script type="text/javascript">
$(document).ready(function(){
    $('.modal').modal();
});
</script>

<h4 class="header"><?php echo __('Add reports') ?></h4>
<ul class="collection">
    <?php foreach($missingUserScrumReports as $missingReport): ?>
        <li class="collapsible-header missing-report-item" >
            <a href="#<?php echo $missingReport['ScrumReport']['id']?>"><div><i class="material-icons">playlist_add</i><?php echo $missingReport['ScrumReport']['deadline_date'] ?></div></a>
        </li>
        <div id="<?php echo $missingReport['ScrumReport']['id']?>" class="modal modal-fixed-footer">
          <div class="modal-content">
            <h4><?php echo __('Add report') ?></h4>
            <?php echo $this->Form->create(false, array('url' => array('action' => 'add_report', 'id' => $missingReport['ScrumReport']['sprint_id']))); ?>
            <?php echo $this->Form->hidden('scrum_report_id', array('value'=> $missingReport['ScrumReport']['id'])); ?>
            <div class="row">
                <?php echo $this->Form->input('q1_ans', ['div' => 'col s12', 'label' => __('What did I accomplish since last report?')]) ?>
            </div>
            <div class="row">
                <?php echo $this->Form->input('q2_ans', ['div' => 'col s12', 'label' => __('What will I do today?')]) ?>
            </div>
            <div class="row">
                <?php echo $this->Form->input('q3_ans', ['div' => 'col s12', 'label' =>  __('What obstacles are impeding my progress?')]) ?>
            </div>
          </div>
          <div class="modal-footer">
              <?php echo $this->Form->end(array('label' => 'add', 'class' => 'col s12 btn large')); ?>
          </div>
        </div>
    <?php endforeach ?>
</ul>
<h4 class="header"><?php echo __('Read reports') ?></h4>
<ul class="collapsible" data-collapsible="accordion">
    <?php foreach($allUserScrumReport as $report): ?>
        <li class="report-item">
            <div class="collapsible-header"><i class="material-icons">announcement</i><?php echo $report['User']['first_name']." ".$report['User']['last_name'] ?> <span class="report-time"><?php echo $this->Time->timeAgoInWords($report['UserScrumReport']['created']) ?></span></div>
            <div class="collapsible-body">
                <p><strong><?php echo __('What did I accomplish since last report?') ?></strong><br /><?php echo $report['UserScrumReport']['q1_ans'] ?></p>
                <p><strong><?php echo __('What will I do today?') ?></strong><br /><?php echo $report['UserScrumReport']['q2_ans'] ?></p>
                <p><strong><?php echo __('What obstacles are impeding my progress?') ?></strong><br /><?php echo $report['UserScrumReport']['q3_ans'] ?></p>
            </div>
        </li>
    <?php endforeach ?>
</ul>
