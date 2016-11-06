<div>
		<p><?php echo __('Click the link below to reset your password.') ?></p>
		<?php echo $this->Html->link(__('Reset password'), array(
					    'controller' => 'users',
					    'action' => 'reset',
                        $token,
					    'full_base' => true
					));
		?>
</div>
