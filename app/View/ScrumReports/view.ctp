<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapseMyReport">My report</a>
      </h4>
    </div>
    <div id="collapseMyReport" class="panel-collapse collapse">
        <div class="panel-body">
            <?php echo $this->Form->create('UserScrumReport'); ?>
            <?php echo $this->Form->input('q1_answer', array('label' => 'What did I accomplish yesterday?')); ?>
            <?php echo $this->Form->input('q2_answer', array('label' => 'What will I do today?')); ?>
            <?php echo $this->Form->input('q3_answer', array('label' => 'What obstacles are impending my progress?')); ?>
            <?php echo $this->Form->end(__('Save')); ?>
        </div>
    </div>
  </div>
</div>
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" href="#collapseOtherReports">Other reports</a>
      </h4>
    </div>
    <div id="collapseOtherReports" class="panel-collapse collapse">
      <div class="panel-body">
            <div class="panel-group">
                <?php foreach($userReports as $userReport): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <?php
                                $collapseId = 'collapse' . $userReport['id'];
                                echo '<a data-toggle="collapse" href="#' . $collapseId . '"> ' . $userReport['User']['email'] . ' </a>'; 
                            ?>
                          </h4>
                        </div>
                        <?php echo '<div id="' . $collapseId . '" class="panel-collapse collapse">'; ?>
                          <div class="panel-body">
                              <p>
                                <h3>What did I accomplish yesterday?</h3>
                                <?php echo $userReport['q1_ans']; ?>
                              </p>
                              <p>
                                <h3>What will I do today?</h3>
                                <?php echo $userReport['q2_ans']; ?>
                              </p>
                              <p>
                                <h3>What obstacles are impending my progress?</h3>
                                <?php echo $userReport['q3_ans']; ?>
                              </p>
                          </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
      </div>
    </div>
  </div>
</div>
