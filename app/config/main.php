<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.contacts.models.*',
		'application.modules.contacts.components.*',
		'application.modules.contacts.components.behaviors.*',
		'application.modules.contacts.components.enums.*',
		'application.modules.contacts.components.interfaces.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			'ipFilters' => array(),
			// 'ipFilters'=>array('127.0.0.1','::51'),
		),
		'contacts',
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(	
			'urlFormat'=>'path',
			'rules'=>array(
			w	'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db' => array(
			'enableProfiling' => true,
			'enableParamLogging' => true,

            'connectionString' => 'pgsql:host=localhost;dbname=yii-contacts;port=5432',
            'emulatePrepare' => false,
            'username' => 'postgres',
            'password' => 'postgres',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CWebLogRoute',
					'levels'=>'error',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);