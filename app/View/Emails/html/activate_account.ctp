<div>
		<p><?php echo __('Click the link below to activate your account.') ?></p>
		<?php echo $this->Html->link(__('Activate account'), array(
					    'controller' => 'users',
					    'action' => 'activate',
                        $token,
					    'full_base' => true
					));
		?>
</div>
