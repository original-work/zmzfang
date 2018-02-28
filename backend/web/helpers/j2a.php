<?php
require_once("../../../common/helpers/Area.php");
 // $model = new Area();
 $model = new \common\helpers\Area();
 $area = $model::$area;
 $conf = $model::$area['children'];
 foreach ($conf as  $child) {
 		// echo $child['value'];
		echo "update `t_residential_district` set `region` = '";
		echo substr($child['value'],2,2);
		echo "' where `region` = '".$child['text']."';<br />";
			foreach ($child['children'] as $Grand) {
				echo "update `t_residential_district` set `plate` = '";
				echo substr($Grand['value'],4,2);
				echo "' where `plate` = '".$Grand['text']."';<br />";
			}

		}