<?php
header("Content-type:text/html;charset=utf-8");
$sn = 5756;
$nickname=file_get_contents($sn.'.txt');
$nickname_exp = explode("\n", $nickname);
$sql = "insert into t_user (`id`,`nickname`,`sex`,`picture`,`agentflag`,`city`) values ";
foreach ($nickname_exp as $key=>$value) {
	$expRes = explode("#", $value);
	// echo "insert into t_user (`id`,`nickname`,`sex`,`picture`,`agentflag`) values ( '".(5201+$key)."','".trim($expRes[0])."','".trim($expRes[1])."','http://www.zmzfang.com/weixin/img/headpic/".(5201+$key).".jpg',0);<br />";
	$sql .= "( '".($sn+$key)."','".trim($expRes[0])."','1','http://www.zmzfang.com/weixin/img/headpic/".($sn+$key).".jpg',0,'上海市'),";

}
echo $sql;