<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/',
		array('controller' => 'Index', 'action' => 'index')
	);
	Router::connect('/calendar/:year/:month',
		array('controller' => 'Index', 'action' => 'index'),
		array(
			'year' => '[12][0-9]{3}',
			'month' => '0[1-9]|1[012]'
		)
	);
	Router::connect('/users/reset/:token',
		array('controller' => 'Users', 'action' => 'reset'),
		array('token' => '[0-9a-z]{64}')
	);
	Router::connect('/project/:id',
		array('controller' => 'projects', 'action' => 'view'),
		array('id' => '[0-9]+')
	);
	Router::connect('/project/:id/:year/:month',
		array('controller' => 'projects', 'action' => 'view'),
		array(
			'id' => '[0-9]+',
			'year' => '[12][0-9]{3}',
			'month' => '0[1-9]|1[012]'
		)
	);
	Router::connect('/project/:id/settings',
		array('controller' => 'projects', 'action' => 'settings'),
		array('id' => '[0-9]+')
	);
	Router::connect('/project/:id/add_user',
		array('controller' => 'projects', 'action' => 'add_user'),
		array('id' => '[0-9]+',
			  'user_id' => '[0-9]+')
	);
	Router::connect('/project/:id/remove_user/:user_id',
		array('controller' => 'projects', 'action' => 'remove_user'),
		array('id' => '[0-9]+',
			  'user_id' => '[0-9]+')
	);
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
