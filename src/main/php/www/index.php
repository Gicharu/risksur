<?php
// change the following paths if necessary
$yii    = dirname(__FILE__) . '/../framework/yii.php';
$config = dirname(__FILE__) . '/../protected/config/main.php';
//$yii=dirname(__FILE__).'/framework/yii.php';
//$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') || define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') || define('YII_TRACE_LEVEL', 0);

require_once($yii);

Yii::createWebApplication($config)->run();
//Yii::app()->run();
