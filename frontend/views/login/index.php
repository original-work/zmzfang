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
				<div style="float:right;height: 74px;line-height: 74px;font-size: 2rem;">
					<a class="btn btn-default" href="./?r=login/qrcode">注册/登陆</a>
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
	<div class="banner">
		<div class="container">
			<div class="banner-grids">
				<div class="col-md-6 left-grid">
					<img src="<?=FRONTEND?>/assets/frontend/images/qrcode.jpg" class="img-responsive" alt="/">
				</div>
				<div class="col-md-6 right-grid slider">
					<div class="callbacks_container">
						<ul class="rslides" id="slider">
							<!-- <li>
								<p>买房卖房谁最明白，最<span>权威</span>的专家在这里</p>
								<a href="#" class="button  hvr-shutter-in-horizontal">more info</a>
							</li> -->
							<li>
								<p>买房找人比找房更重要，<span>靠谱</span>经纪人在这里</p>
								<!-- <a href="#" class="button  hvr-shutter-in-horizontal">more info</a> -->
							</li>
							<!-- <li>	          
								<p>房产交易流程复杂冗长，交给<span>专业</span>的人做专业的事</p>
								<a href="#" class="button hvr-shutter-in-horizontal">more info</a>			 	
							</li> -->
						</ul>
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<div class="content">
		<!-- <div class="service-section" id="services">
			<div class="container">
				<h3> our services</h3>
				<div class="service-grids">
					<div class="col-md-4 service-grid">
						<img src="<?=FRONTEND?>/assets/frontend/images/icon1.png">
						<h4>IOS</h4>
						<p>筹备中 </p>
						<a href="#" class="button hvr-shutter-in-horizontal">Download</a>
					</div>
					<div class="col-md-4 service-grid">
						<img src="<?=FRONTEND?>/assets/frontend/images/icon2.png">
						<h4>Android</h4>
						<p>筹备中 </p>
						<a href="#" class="button hvr-shutter-in-horizontal">Download</a>
					</div>
					<div class="col-md-4 service-grid">
						<img src="<?=FRONTEND?>/assets/frontend/images/icon3.png">
						<h4>Wechat</h4>
						<p>扫描上方二维码 </p>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div> -->
		<div class="about-section" id="about" >
			<div class="container">
				<h3>about</h3>
				<div class="about-grids">
					<div class="col-md-6 left-about">
						<div class="about-grid1">
							<h4>我们</h4>
							<p>芝麻找房是一家房产垂直领域共享平台 微信扫描上方二维码关注</p>
						</div>
					</div>
					<div class="col-md-6 right-about">
						<div class="contact">
							<p>&nbsp;</p>
							<p>合作电话：17765149732</p>
							<p>邮箱：2627864918@qq.com</p>
							<p>地址：上海市徐汇区田林路140号越界创意园16号东2楼</p>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
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
			$("#slider").responsiveSlides({auto: true,nav: true,speed: 500,namespace: "callbacks",pager: true,});
		});
	</script>
	</body>
</html>