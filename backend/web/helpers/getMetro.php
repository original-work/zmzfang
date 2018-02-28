<?php
header("Content-type:text/json;charset=utf-8");
require_once(__DIR__ . '/../../../common/helpers/Area.php');
$metro =  \common\helpers\Area::$metro;
foreach ($metro['children'] as $k1 => $v1) {
	$sn = substr($v1['value'],2,2);
	foreach ($v1['children'] as $k2 => $v2) {
		// var_dump($v2);
		echo $sql = 'insert into `t_metro` (`metroline`,`text`,`value`,`longitude`,`latitude`) values("'.$sn.'","'.$v2['text'].'","'.$v2['value'].'","'.$v2['longitude'].'","'.$v2['latitude'].'");';
		echo "\n";
	}
}
