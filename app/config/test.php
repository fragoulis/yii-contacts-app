<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db' => array(
	            'connectionString' => 'pgsql:host=localhost;dbname=yii-contacts;port=5432',
	            'emulatePrepare' => false,
	            'username' => 'postgres',
	            'password' => 'postgres',
	            'charset' => 'utf8',
	            'tablePrefix' => '',
	        ),
		),
	)
);
