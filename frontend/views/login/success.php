<!DOCTYPE html>
<html>
<head>
	<title>芝麻找房</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="baidu-site-verification" content="PmgvCPXs84" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />

	<link href="<?=FRONTEND?>/assets/frontend/css/bootstrap.css" rel='stylesheet' type='text/css'/>
	<link href="<?=FRONTEND?>/assets/frontend/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="./weixin/js/jq.qrcode.js"></script>
	<script src="./weixin/js/qrcode.js" type="text/javascript"></script>

</head>
<body>
	<div class="header">
		<div class="header-top">
			<div class="container">
				<div class="logo">
					<a href="<?=FRONTEND?>/"><img src="<?=FRONTEND?>/assets/frontend/images/logo.jpg" height=64 width=200 ></a>
				</div>
				<!-- <div class="top-menu">
					<span class="menu"> </span> 
					<ul>
						<li><a href="#about" class="scroll">我们</a></li>
						<li><a href="#services" class="scroll">服务</a></li>
					</ul>
				</div> -->
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<div class="content" style="text-align: center;">
		<p>操作成功，微信扫描穿越到微信上查看</p>
		<div style="margin-top:20px" id="qrcode"></div>
	</div>
<script type="text/javascript">
	$('#qrcode').qrcode({width: 400,height: 400,text: "http://www.zmzfang.com/weixin/Activity/ActivityDetail.html?activityId=<?=$_GET[id]?>&publishuserid=<?=$_GET[userid]?>"});
</script>
</body>
</html>