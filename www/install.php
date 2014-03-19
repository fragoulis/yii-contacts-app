<?php
/*
* Yeeki application installer
*/

$yii=dirname(__FILE__).'/../../yii/framework/yii.php';
$config=dirname(__FILE__).'/../app/config/main.php';

require_once($yii);
Yii::createWebApplication($config);
$installedFileName = Yii::app()->getRuntimePath().'/contacts_module_installed';

if(file_exists($installedFileName))
{
	echo 'Already installed.';
	die();
}

$runner=new CConsoleCommandRunner();
$runner->commands=array(
	'migrate' => array(
	'class' => 'system.cli.commands.MigrateCommand',
	'migrationPath' => 'application.modules.contacts.migrations',
	'migrationTable' => 'contacts_migration',
	'interactive' => false,
	),
);

ob_start();
$runner->run(array(
	'yiic',
	'migrate',
));
echo htmlentities(ob_get_clean(), null, Yii::app()->charset);

file_put_contents($installedFileName, 'remove if you need to run install.php again');