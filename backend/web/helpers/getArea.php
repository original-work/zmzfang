<?php
header("Content-type:text/json;charset=utf-8");
require_once(__DIR__ . '/../../../common/helpers/Area.php');
print_r($area =  \common\helpers\Area::$area );
