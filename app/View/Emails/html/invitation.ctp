<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div>
		<p>Hi <?php echo ucfirst(split("@", $new_user_email)[0]) ?>,</p>
		<p><?php echo $this->Html->link(ucfirst(split("@", $inviter_email)[0]) , 'mailto:'.$inviter_email, array('class' => 'button', 'target' => '_blank')); ?> has just setup an account for you on VSM.</p>
		<p>Your login details,
			<br />Email: <?php echo $new_user_email ?>
			<br />Password: <?php echo $password ?>
		</p>
		<p>Click the link below to activate your account.</p>
		<?php echo $this->Html->link('Activate account', array(
					    'controller' => 'users',
					    'action' => 'activate',
													$token,
					    'full_base' => true
					));
		?>
</div>
