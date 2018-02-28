<?php
define('YII_DEBUG', true);
//$_SERVER['HTTP_HOST']
defined('FRONTEND') or define('FRONTEND', 'http://www.zmzfang.com');
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
//define('CITY','_0021');//上海的表默认无后缀
define('CITY','_0020');//广州
define('PREFIX','0020');

header('Access-Control-Allow-Origin:*'); //兼容微信客户端
header('Access-Control-Allow-Headers:x-requested-with'); //兼容微信客户端
header("Content-type:json/application;charset=utf-8");
error_reporting(E_ALL ^ E_NOTICE);

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();