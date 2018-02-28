<!DOCTYPE html>
<html>
<head>
	<title>芝麻找房</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="baidu-site-verification" content="PmgvCPXs84" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<link href="<?=FRONTEND?>/assets/frontend/css/bootstrap.css" rel='stylesheet' type='text/css'/>
	<link href="<?=FRONTEND?>/assets/frontend/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<style type="text/css">
		.rslides li p{color:#fff;}
	</style>
	<script src="<?=FRONTEND?>/weixin/js/jquery.min.js"></script>
	<!---- start-smoth-scrolling---->
	<script type="text/javascript" src="<?=FRONTEND?>/assets/frontend/js/move-top.js"></script>
	<script type="text/javascript" src="<?=FRONTEND?>/assets/frontend/js/easing.js"></script>
	<!---End-smoth-scrolling---->
	<script src="<?=FRONTEND?>/assets/frontend/js/responsiveslides.min.js"></script>
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
	<div class="content">
		
		<div class="container">
		<p><a class="btn btn-default" href="./?r=login/activity-submit">发布新活动</a></p>
			<ul>
				<?php if($list){
					foreach ($list as $value) {
						echo "<li>$value[activitysubject]<a style='float:right' href='./?r=login/activity-modify&id=$value[activityid]'>修改</a></li>";
					}
				}
				?>
			</ul>
		</div>
	</div>
	<div class="footer-section">
		<div class="container">
			<div class="footer-top">
				<p>Copyright &copy; 2015.芝麻找房 All rights reserved. - <a href="http://www.miitbeian.gov.cn/" target="_blank">沪ICP备14020180</a></p>
			</div>
			<!-- 返回顶部 -->
			<a href="#" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
		</div>
	</div>
	<script type="text/javascript">
		var _hmt = _hmt || [];
		$(document).ready(function() {
			// 统计
			var hm = document.createElement("script");
			hm.src = "//hm.baidu.com/hm.js?2ed92d6dbf14abc53e22f0de42a77551";
			var s = document.getElementsByTagName("script")[0]; 
			s.parentNode.insertBefore(hm, s);
			// 菜单
			// $(".scroll").click(function(event){
			// 	event.preventDefault();
			// 	$('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
			// });
			// $("span.menu").click(function(){
			// 	$(".top-menu ul").slideToggle("slow" , function(){});
			// });
			// 返回顶部
			$().UItoTop({ easingType: 'easeOutQuart' });
			// 轮播
			// $("#slider").responsiveSlides({auto: true,nav: true,speed: 500,namespace: "callbacks",pager: true,});

		});
	</script>
	</body>
</html>