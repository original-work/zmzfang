<body>  
<?php 
$interfaces=[
	[
		'name'=>'需求异地 新增/修改(传requirementid)',
		'url'=>'requirement/yd-set',
		'params'=>'id,publishuserid,publishusertype,region,budget,housetype,storey,buildingtype,detail,subject'
	],
	[
		'name'=>'需求异地 列表(修改时间排序)',
		'url'=>'requirement/yd-get',
		'params'=>'region,limit,offset'
	],
	[
		'name'=>'需求异地 详情',
		'url'=>'requirement/yd-detail',
		'params'=>'id'
	],
	[
		'name'=>'房源异地 新增/修改(houseid)',
		'url'=>'supplyment/yd-set',
		'params'=>'houseid,userid,region,districtname,housenumber,roomnumber,buildingarea,expectsaleprice,storey,totalstorey,roomcnt,hallcnt,bathroomcnt,houseage,buildingtype,decorationtype,orientation,detail,schooldistrictflag,metroflag,owneronlyflag,overfiveonlyflag'
	],
	[
		'name'=>'房源异地 列表(发布时间排序)',
		'url'=>'supplyment/yd-get',
		'params'=>'region,limit,offset'
	],
	[
		'name'=>'房源异地 详情',
		'url'=>'supplyment/yd-detail',
		'params'=>'houseid'
	],
];
						
foreach($interfaces as $interface){
?>
<a href = "interfaces/simpleinterface.php?name=<?=$interface['name']?>&url=<?=$interface['url']?>&params=<?=$interface['params']?>" target = "frame2"><?=$interface['name']?></a><br/>
<?php 
}
?>

</body>  
