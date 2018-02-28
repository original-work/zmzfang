<?php
	$arr = ['rent'=>'求租','agent'=>'经纪人'];

	$admin_menu = "insert into admin_menu (`code`,menu_name,module_id,display_label,des,display_order,entry_right_name,entry_url,action,controller,has_lef,create_user,create_date,update_user,update_date)values";
	$admin_menu_i = 12;
	$admin_menu_each = '';

	$admin_right = "insert into admin_right (menu_id,right_name,display_label,des,display_order,has_lef,create_user,create_date,update_user,update_date)values";
	$admin_right_i = 17;
	$admin_right_j = 12;
	$admin_right_each = '';

	$admin_right_url = "insert into admin_right_url (right_id,url,para_name,para_value,create_user,create_date,update_user,update_date)values";
	$admin_right_url_i = 34;
	$admin_right_url_each ='';

	foreach ($arr as $k => $v) {
		$admin_menu_i++;
		@$admin_menu_each .="('$k','{$v}管理','3','{$v}管理','{$v}管理','$admin_menu_i','{$v}管理','$k/index','index','backend\\\\contrllers\\\\".ucfirst($k)."Controller','n','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),";

		$admin_right_i++;
		$admin_right_j++;
		@$admin_right_each .="('$admin_right_i','{$v}管理','{$v}管理','{$v}管理','$admin_right_j','n','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),";

		$admin_right_url_i++;
		@$admin_right_url_each .="('$admin_right_url_i','{$k}/index','$k','index','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),('$admin_right_url_i','{$k}/view','$k','view','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),('$admin_right_url_i','{$k}/create','$k','create','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),('$admin_right_url_i','{$k}/update','$k','update','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),('$admin_right_url_i','{$k}/delete','$k','delete','admin','".date('Y-m-d H:i:s',time())."','admin','".date('Y-m-d H:i:s',time())."'),";
	}
	echo $admin_menu.$admin_menu_each;
	echo '<br /><br />';
	echo $admin_right.$admin_right_each;
	echo '<br /><br />';
	echo $admin_right_url.$admin_right_url_each;