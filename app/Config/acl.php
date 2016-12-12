<?php
/**
 * This is the PHP base ACL configuration file.
 *
 * Use it to configure access control of your CakePHP application.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 2.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * The role map defines how to resolve the user record from your application
 * to the roles you defined in the roles configuration.
 */
$config['map'] = array(
	'User' => 'User/email',
	'Role' => 'User/level',
);

/**
 * define aliases to map your model information to
 * the roles defined in your role configuration.
 */
$config['alias'] = array(
	'Role/2' => 'Role/admin',
	'Role/1' => 'Role/pm',
	'Role/0' => 'Role/user'
);

/**
 * role configuration
 */
$config['roles'] = array(
	'Role/admin' => 'Role/pm',
	'Role/pm' => 'Role/user',
	'Role/user' => null
);

/**
 * rule configuration
 */
$config['rules'] = array(
	'allow' => array(
		'controllers/*' => 'Role/admin',
		'controllers/projects/*' => 'Role/pm',
		'controllers/users/*' => 'Role/pm',
		'controllers/index/*' => 'Role/user',
		'controllers/projects/(index|view)' => 'Role/user',
		'controllers/notifications/*' => 'Role/user',
		'controllers/sprints/*' => 'Role/user',
		'controllers/users/(change_password|profile|logout)' => 'Role/user'
	),
	'deny' => array(),
);
