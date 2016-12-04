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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $this->Html->meta('icon');
                echo $this->Html->css('material-icons');
                echo $this->Html->css('materialize.min', ['media' => 'screen,projection']);
                echo $this->Html->css('style');
                echo $this->Html->meta('viewport', 'width=device-width, initial-scale=1.0');
                echo $this->Html->script('jquery-2.1.1.min');
                echo $this->Html->script('materialize.min');
	?>
</head>
<body>
        <?php echo $this->Session->flash(); ?>
        <?php echo $this->element('nav_bar'); ?>
	<div class="container">
                <?php echo $this->fetch('content'); ?>
	</div>
</body>
</html>
