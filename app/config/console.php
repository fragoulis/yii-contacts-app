<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db' => array(
            'connectionString' => 'pgsql:host=localhost;dbname=yii-contacts;port=5432',
            'emulatePrepare' => false,
            'username' => 'postgres',
            'password' => 'postgres',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);