<?php
$params = file_get_contents("http://www.zmzfang.com/weixin/js/params.js");
return (json_decode(substr($params,7,strlen($params)-7),true));