<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..',
	'name' => 'Admin panel',
	'defaultController' => 'admin',
	'controllerPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../controllers',
	'viewPath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '../views',
	'sourceLanguage' => 'ru',

	// preloading 'log' component
	'preload' => array('log'),

	// autoloading model and component classes
	'import' => array(
		'application.admin.models.*',
		'application.admin.components.*',
		'application.components.ActiveDataProvider',
		'application.components.ActiveRecord',
		'application.admin.components.widgets.*',
		'application.admin.controllers.*',
	),

	// application components
	'components' => array(
		'user' => array(
			'class' => 'AdminWebUser',
			'allowAutoLogin' => true,
			'loginUrl' => '/admin/login',
		),
		'urlManager' => array(
			'urlFormat' => 'path',
			'showScriptName' => false,
			'rules' => require('rules.php'),
		),

		'db' => require('db.php'),
		'errorHandler' => array(
			// use 'site/error' action to display errors
			'errorAction' => '/admin/error',
		),
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'session' => array(
			'class' => 'CDbHttpSession',
			'sessionTableName' => 'AdminUserSession',
			'timeout' => 24 * 60 * 60,
			'connectionID' => 'db'
		),

		//		'cache' => array('class' => 'CApcCache')
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params' => array(
		// this is used in contact page
		'adminEmail' => 'arossokha@takeforce.com',
		'provides' => "© " . date('Y') . " Powered by Artem Rossokha. All right reserved.<br>tel. +3(096)7254106",
		'layout' => array(
			'panelSettings' => array(
				array(
					'name' => 'Настройки',
					'path' => 'settings',
					'returnUrl' => '/admin/settings',
					'class' => 'ModelWidget',
					'importPath' => 'application.admin.models.*',
					'model' => array('class' => 'Settings')
				),
				
				array(
					'name' => 'FAQ',
					'path' => 'faq',
					'class' => 'ModelManagerWidget',
					'importPath' => 'application.models.*',
					'model' => 'Faq',
				),
				array(
					'name' => 'Города',
					'path' => 'city',
					'class' => 'ModelManagerLimiterWidget',
					'importPath' => 'application.models.*',
					'model' => 'City',
				),
				
								array(
									'name' => 'Администраторы',
									'path' => 'user',
									'class' => 'ModelManagerWidget',
									'importPath' => 'application.admin.models.*',
									'model' => 'AdminUser',
								),
								array(
									'name' => 'Страницы',
									'class' => 'ModelManagerWidget',
									'path' => 'pages',
									'importPath' => 'application.models.*',
									'model' => 'Page'
								),
			),
		)
	),
);