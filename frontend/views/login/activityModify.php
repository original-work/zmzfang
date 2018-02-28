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
	<link href="<?=FRONTEND?>/assets/frontend/css/jedate.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?=FRONTEND?>/assets/wangEditor/wangEditor.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?=FRONTEND?>/weixin/css/mui.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?=FRONTEND?>/weixin/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<style type="text/css">
		.rslides li p{color:#fff;}
		.pick-button{width: 320px;height:200px;background-image:  url(./weixin/img/iconfont-tianjia.png);position:relative;display:block;background-size:320px 200px;}
		.pick-button label{padding:0;position:absolute;left:0;width: 320px;height: 200px;}
		#activitypic{position: absolute;clip: rect(1px 1px 1px 1px);}
		.phone{
			margin: 0 auto;
			position: relative;
			background: #111;
			border-radius: 55px;
			box-shadow: 0px 0px 0px 2px #aaa;
			width: 320px;
			height: 568px;
			padding: 105px 25px;
			-webkit-box-sizing: content-box;
			box-sizing: content-box;
			
		}
		.phoneContent{
			text-align: left;
			overflow-y: scroll;
			width: 320px;
			height: 558px;
			margin-bottom: 10px;
			background: #efeff4;
		}
		.phone:before {
			content: '';
			width: 60px;
			height: 10px;
			border-radius: 10px;
			position: absolute;
			left: 50%;
			margin-left: -30px;
			background: #333;
			top: 50px;
		}
		.phone:after {
			content: '';
			position: absolute;
			width: 60px;
			height: 60px;
			left: 50%;
			margin-left: -30px;
			bottom: 20px;
			border-radius: 100%;
			box-sizing: border-box;
			border: 5px solid #333;
		}
		#detail img{
			max-width:100%;
		}
	</style>
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
	<!---- start-smoth-scrolling---->
	<script type="text/javascript" src="<?=FRONTEND?>/assets/frontend/js/jquery.jedate.min.js"></script>
	<script type="text/javascript" src="<?=FRONTEND?>/assets/frontend/js/move-top.js"></script>
	<script type="text/javascript" src="<?=FRONTEND?>/assets/frontend/js/easing.js"></script>
	<script type="text/javascript" src="<?=FRONTEND?>/assets/frontend/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?=FRONTEND?>/weixin/js/city.data.js"></script>
	<script type="text/javascript" src="<?=FRONTEND?>/weixin/js/common.js"></script>
	<!---End-smoth-scrolling---->
	<script src="<?=FRONTEND?>/assets/frontend/js/responsiveslides.min.js"></script>
	<script src="<?=FRONTEND?>/assets/wangEditor/wangEditor.min.js"></script>
	<script src="<?=FRONTEND?>/weixin/js/PicUpload/dist/lrz.bundle.js"></script>
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
		<div class="col-md-7">
			<p></p>
			<p>您好,<?=$userInfo['nickname']?>。</p>

			<div id="zbfTable">
			<?php if ($info['organizationauth']==1):  ?>
				<table  class="table table-striped">
					<tr>
						<td><?=$org['organization']?></td><td><?=$org['organizationdetail']?></td><td><?=$org['organizationlocation']?></td><td><?=$org['contactname']?></td><td><?=$org['$contactphone']?></td><td><a  class="btn btn-primary" data-toggle="modal" data-target="#myModal">修改</a></td>
					</tr>
				</table>
			<?php endif; ?>
			</div>
			<form  id="activityForm" action="" method="POST">
				<input type="hidden" value="<?=$info['activityid']?>" name="activityid" />
				<input type="hidden" value="<?=$info['organizationauth']?>" name="organizationauth" />
				<input type="hidden" value="<?=$info['publishuserid']?>" name="publishuserid" />
				<input type="hidden" value="<?=$info['publishusername']?>" name="publishusername" />
				<div class="form-group">
					<label>活动类型</label>
					<select class="form-control" name="activitytype">
						<option value="培训" <?=$info['activitytype']=="培训"?"selected='selected'":""?>>培训</option>
						<option value="开盘" <?=$info['activitytype']=="开盘"?"selected='selected'":""?>>开盘</option>
						<option value="讲座" <?=$info['activitytype']=="讲座"?"selected='selected'":""?>>讲座</option>
						<option value="聚会" <?=$info['activitytype']=="聚会"?"selected='selected'":""?>>聚会</option>
						<option value="户外" <?=$info['activitytype']=="户外"?"selected='selected'":""?>>户外</option>
						<option value="派对" <?=$info['activitytype']=="派对"?"selected='selected'":""?>>派对</option>
						<option value="会议" <?=$info['activitytype']=="会议"?"selected='selected'":""?>>会议</option>
						<option value="沙龙" <?=$info['activitytype']=="沙龙"?"selected='selected'":""?>>沙龙</option>
						<option value="演出" <?=$info['activitytype']=="演出"?"selected='selected'":""?>>演出</option>
						<option value="比赛" <?=$info['activitytype']=="比赛"?"selected='selected'":""?>>比赛</option>
						<option value="导购" <?=$info['activitytype']=="导购"?"selected='selected'":""?>>导购</option>
						<option value="团购" <?=$info['activitytype']=="团购"?"selected='selected'":""?>>团购</option>
						<option value="展览" <?=$info['activitytype']=="展览"?"selected='selected'":""?>>展览</option>
						<option value="体验" <?=$info['activitytype']=="体验"?"selected='selected'":""?>>体验</option>
						<option value="招商" <?=$info['activitytype']=="招商"?"selected='selected'":""?>>招商</option>
						<option value="其他" <?=$info['activitytype']=="其他"?"selected='selected'":""?>>其他</option>
					</select>
				</div>
				<div class="form-group">
					<label for="activitysubject">活动主题</label>
					<input type="text" class="form-control" id="activitysubject" placeholder="请输入活动主题" name="activitysubject" value="<?=$info['activitysubject']?>" required>
				</div>
				<div class="form-group">
					<label>活动背景图</label>
					<div class="pick-button">
						<label for="activitypic">
							<img src="<?=$info['activitypic']?>" width="320" height="200">
						</label>
						<input type="file" id="activitypic" name="activitypic"  accept="image/*">
						<!-- <p class="help-block">Example block-level help text here.</p> -->
					</div>
				</div>
				<div class="form-group">
					<label for="startime">活动开始时间</label>
					<input type="text" class="form-control" id="startime" value="<?=$info['begintime']?>" name="begintime" readonly="readonly">
					
				</div>
				<div class="form-group">
					<label for="endtime">活动结束时间</label>
					<input type="text" class="form-control" value="<?=$info['endtime']?>" id="endtime" name="endtime"  readonly="readonly">
				</div>
				
				<div class="form-group">
					<label>活动城市</label>
					<input type="text" class="form-control" value="<?=$info['activitycity']?>" id="endtime" name="endtime"  readonly="readonly">
				</div>
				<div class="form-group">
					<label for="location">活动地点</label>
					<input type="text" class="form-control" value="<?=$info['location']?>" id="location" placeholder="请输入活动地点" name="location" required>
				</div>
				<div class="form-group">
					<label for="activitysubject">人数限制</label>
					<input type="number" class="form-control" value="<?=$info['personcount']?>" id="personcount" placeholder="请输入人数限制,填0则代表不限人数" name="personcount" required>
				</div>
				<div class="form-group">
					<label for="fee">报名费用</label>
					<input type="text" class="form-control"  value="<?=$info['fee']?>" id="fee" placeholder="请输入报名费用,填0则代表免费" name="fee" required>
				</div>
				<label>活动详情</label>
				<div id="activitydetail" style="text-align: left"></div>
				<button type="submit" class="btn btn-default" style="margin: 20px auto;display: block;">确定预览</button>
			</form>
		</div>
		<div class="col-md-5">
			<div class="phone">
			<img width=320 height=20 src="data:image/jpeg;base64,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b29sAAAAAABFbWxEYm9vbAAAAAAASW50cmJvb2wAAAAAAEJja2dPYmpjAAAAAQAAAAAAAFJHQkMAAAADAAAAAFJkICBkb3ViQG/gAAAAAAAAAAAAR3JuIGRvdWJAb+AAAAAAAAAAAABCbCAgZG91YkBv4AAAAAAAAAAAAEJyZFRVbnRGI1JsdAAAAAAAAAAAAAAAAEJsZCBVbnRGI1JsdAAAAAAAAAAAAAAAAFJzbHRVbnRGI1B4bEBSAAAAAAAAAAAACnZlY3RvckRhdGFib29sAQAAAABQZ1BzZW51bQAAAABQZ1BzAAAAAFBnUEMAAAAATGVmdFVudEYjUmx0AAAAAAAAAAAAAAAAVG9wIFVudEYjUmx0AAAAAAAAAAAAAAAAU2NsIFVudEYjUHJjQFkAAAAAAAAAAAAQY3JvcFdoZW5QcmludGluZ2Jvb2wAAAAADmNyb3BSZWN0Qm90dG9tbG9uZwAAAAAAAAAMY3JvcFJlY3RMZWZ0bG9uZwAAAAAAAAANY3JvcFJlY3RSaWdodGxvbmcAAAAAAAAAC2Nyb3BSZWN0VG9wbG9uZwAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAIASAAAAAEAAjhCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAHjhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAjhCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAyAAAAAQBaAAAABgAAAAAAAQA1AAAAAQAtAAAABgAAAAAAAThCSU0D+AAAAAAAcAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAAAAAAAAAIAADhCSU0EAgAAAAAABAAAAAA4QklNBDAAAAAAAAIBAThCSU0ELQAAAAAABgABAAAAAzhCSU0ECAAAAAAAEAAAAAEAAAJAAAACQAAAAAA4QklNBB4AAAAAAAQAAAAAOEJJTQQaAAAAAAM5AAAABgAAAAAA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IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE0IChNYWNpbnRvc2gpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAxNy0wNy0yNlQxNToyMDoyMSswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMTctMDctMjZUMTU6MzM6NDUrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMTctMDctMjZUMTU6MzM6NDUrMDg6MDAiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6YTE4Yzk4MTAtZDY0NS1mZjRlLWFkMGItY2VjNzhhNzFiOWM5IiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6YWZmOWNkMTgtNzFkNC0xMWU3LWI1YTMtYzExYjRmMTg2NjljIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6REEyN0EzRUY1QzM3MTFFNEE1ODA5RkNEOEU4MEU4ODYiIGRjOmZvcm1hdD0iaW1hZ2UvanBlZyIgcGhvdG9zaG9wOkNvbG9yTW9kZT0iMyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjJlYTBmZWRkLTlhYTEtODE0YS05NDZhLWJmYWU5YWY2MTUxOCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpEQTI3QTNFRjVDMzcxMUU0QTU4MDlGQ0Q4RTgwRTg4NiIgc3RSZWY6b3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOkRBMjdBM0VGNUMzNzExRTRBNTgwOUZDRDhFODBFODg2Ii8+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjJlYTBmZWRkLTlhYTEtODE0YS05NDZhLWJmYWU5YWY2MTUxOCIgc3RFdnQ6d2hlbj0iMjAxNy0wNy0yNlQxNTozMzo0NSswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUuNSAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNvbnZlcnRlZCIgc3RFdnQ6cGFyYW1ldGVycz0iZnJvbSBpbWFnZS9wbmcgdG8gaW1hZ2UvanBlZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iZGVyaXZlZCIgc3RFdnQ6cGFyYW1ldGVycz0iY29udmVydGVkIGZyb20gaW1hZ2UvcG5nIHRvIGltYWdlL2pwZWciLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmExOGM5ODEwLWQ2NDUtZmY0ZS1hZDBiLWNlYzc4YTcxYjljOSIgc3RFdnQ6d2hlbj0iMjAxNy0wNy0yNlQxNTozMzo0NSswODowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUuNSAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDxwaG90b3Nob3A6VGV4dExheWVycz4gPHJkZjpCYWc+IDxyZGY6bGkgcGhvdG9zaG9wOkxheWVyTmFtZT0iMDowMCIgcGhvdG9zaG9wOkxheWVyVGV4dD0iMDowMCIvPiA8L3JkZjpCYWc+IDwvcGhvdG9zaG9wOlRleHRMYXllcnM+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDw/eHBhY2tldCBlbmQ9InciPz7/7gAhQWRvYmUAZIAAAAABAwAQAwIDBgAAAAAAAAAAAAAAAP/bAIQADAgICAkIDAkJDBELCgsRFQ8MDA8VGBMTFRMTGBEM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">

			<div class="phoneContent">
				<div id="ActiviePic">
					<img id="background" src="http://www.zmzfang.com/weixin/img/activity/201707241423547209.jpg" style="width: 100%;max-height:200px;">
				</div>
				
				<div id="userInfo" class="card" user-id="15530">
					<div class="user-info" style="border-bottom:1px solid #ddd;margin-bottom:20px;">
						<div style="width:42px; height:42px;overflow:hidden;float:left;">
							<img id="userPic" class="circle-img" width="42" height="42px" data-lazyload-id="0" src="<?=$userInfo['picture']?>">
						</div>
						<div class="user-info-content" style="float:left;margin-left: 0px;padding-left: 10px;">
						<p class="mui-ellipsis requirement-user-nickname" style="font-size:1.2rem;margin-bottom:5px;"> 
								发布人：<span id="userName"><?=$userInfo['nickname']?></span>&nbsp;
						</p>
						<p>
							<span span="" id="organization"> <?=$plus['organization']?$plus['organization']:'-'?> </span> <span id="position"> <?=$plus['position']?$plus['position']:'-'?> </span>
							
						</p>
						
						</div>
						<div class="mui-clearfix"></div>
					</div>
					
					<div id="activityInfo" class="activity-info" activity-id="713">
						<ul class="row">
							<li class="col-xs-12">
								<p style="color:#000;font-size:1.1rem;"><span id="subject"> - </span></p>
							</li>
							
							<li class="col-xs-12">
								<p><span style="color:#999;">开始时间：</span><span id="start" style="color: #333;"> - </span></p>
							</li>
							<li class="col-xs-12">
								<p><span style="color:#999;">结束时间：</span><span id="endTime" style="color: #333;"> - </span></p>
							</li>
							<li class="col-xs-12">
								<p><span style="color:#999;">活动地点：</span><span id="plocation" style="color: #333;"> - </span></p>
							</li>
							<li class="col-xs-6">
								<p><span style="color:#999;">活动类型：</span><span id="type" style="color: #333;"> - </span></p>
							</li>	
						   <li class="col-xs-6">
								<p><span style="color:#999;">活动人数：</span><span id="personCnt" style="color: #333;"> - </span></p>
							</li>	
							<li class="col-xs-12">
								<p><span style="color:#999;">活动费用：</span><span id="pfee" style="color: #333;"> - </span></p>
							</li>
							<li class="col-xs-12">
								<div class="mui-input-row">
									<p><span style="color:#999;">活动详情：</span></p>
									<div>
										<p id="detail" style="text-indent: 1.5rem;font-size: 14px;color: #333;"> - 
									</div>
								</div>
							</li>
						</ul>
						<div class="mui-clearfix"></div>
					</div>
					<div>
				</div>
				</div>
			   
			   <div id="orgDiv" class="card">
					<p class="mui-ellipsis" style="padding-top: 3px;padding-left: 10px;font-size:1.1rem;color:#000;">
						主办方信息 
					</p>	
					<div id="orginfo">
						<ul class="row">
							<li class="col-xs-12">
								<p><span style="color:#999;">主办方：</span><span id="orgName" style="color: #333;"><?=$org['organization']?></span></p>
							</li>
							<li class="col-xs-12">
								<p><span style="color:#999;">联系人：</span><span id="contactName" style="color: #333;"><?=$org['contactname']?></span></p>
							</li>
							<li class="col-xs-12">
								<p><span style="color:#999;">联系方式：</span><span id="contactPhone" style="color: #333;"><?=$org['contactphone']?></span></p>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="card">
					<p class="mui-ellipsis" style="padding-top: 3px;padding-left: 10px;font-size:1.1rem;color:#000;">
						报名人数 <small>(<span id="bidCnt" style="color:#007D2C;">0</span>人)</small>
					</p>	
					<div id="bidlist">
						<ul class="head-row" id="bidUl"><li style="list-style:none;color:#aaa;font-size:.85rem;text-align:center;padding:10px 0;">暂无人响应</li></ul>
					</div>
				</div>
				
				<div class="card">
					<p class="mui-ellipsis" style="padding-top: 3px;padding-left: 10px;font-size:1.1rem;color:#000;">
						评论<small>(<span id="commentCnt" style="color:#007D2C;">0</span>人)</small>
					</p>	
					<div id="commentlist">
						<ul class="head-row" id="commentUl">
							<li style="text-align:center;list-style: none;"><li style="list-style:none;color:#aaa;font-size:.85rem;text-align:center;padding:10px 0;">暂无人评论</li></li>
						</ul>
					</div>
				</div>
				
			</div>
			</div>
			<div style="text-align: center;margin:20px 0">
			<button type="button" id="ok" class="btn btn-default" style="display: none;">确认发布</button>
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

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<form id="zbf">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">主办方管理</h4>
				</div>
				<div class="modal-body">
					
						<input type="hidden" value="<?=$org['organizationid']?>" name="organizationid" />
						<input type="hidden" value="<?=$userInfo['id']?>" name="userid" />
						<div class="form-group">
							<label for="organization">主办方名称</label>
							<input type="text" class="form-control" value="<?=$org['organization']?>" id="organization" placeholder="请输入主办方名称" name="organization" required>
						</div>
						<div class="form-group">
							<label for="organizationdetail">主办方描述</label>
							<input type="text" class="form-control" value="<?=$org['organizationdetail']?>" id="organization" placeholder="请输入主办方描述" name="organizationdetail">
						</div>
						<div class="form-group">
							<label for="organizationlocation">主办方地址</label>
							<input type="text" class="form-control" value="<?=$org['organizationlocation']?>" id="organization" placeholder="请输入主办方坐标" name="organizationlocation">
						</div>
						<div class="form-group">
							<label for="contactname">主办方联系人</label>
							<input type="text" class="form-control" value="<?=$org['contactname']?>" id="organization" placeholder="请输入主办方联系人" name="contactname" >
						</div>
						<div class="form-group">
							<label for="contactphone">主办方联系人手机</label>
							<input type="text" class="form-control" value="<?=$org['contactphone']?>" id="organization" placeholder="请输入主办方联系人手机" name="contactphone" >
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">保存修改</button>
				</div>
				</form>
			</div>
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
			// 选择日期
			//实现日期选择联动
			var start = {
				format: 'YYYY-MM-DD hh:mm',
				// minDate: $.nowDate({DD:0}), //设定最小日期为当前日期
				//festival:true,
				// maxDate: $.nowDate({DD:0}), //最大日期
				choosefun: function(elem,datas){
					end.minDate = $.nowDate({DD:0}); //开始日选好后，重置结束日的最小日期
					endDates();
				},
				okfun:function (elem,datas) {
					// alert(datas)
				}
			};
			var end = {
				format: 'YYYY-MM-DD hh:mm',
				// minDate: $.nowDate({DD:0}), //设定最小日期为当前日期
				//festival:true,
				maxDate: '2099-06-16 23:59:59', //最大日期
				choosefun: function(elem,datas){
					start.maxDate = datas; //将结束日的初始值设定为开始日的最大日期
				}
			};
			function endDates() {
				end.trigger = false;
				$("#endtime").jeDate(end);
			}
			$("#startime").jeDate(start);
			$("#endtime").jeDate(end);
			// 城市 区域联动
			// var cityOpt = '<option value="">-- 下拉选择城市 --</option>';
			// var regionArr = [];
			// for(i  in  cityData){
			// 	cityOpt += "<option value='"+cityData[i].value+"'>"+cityData[i].text+"</option>";
			// 	regionArr[cityData[i].value] = cityData[i].children;
			// }
			// // console.log(regionArr);
			// $('#city').html(cityOpt);
			// $('#city').change(function(){
			// 	region = regionArr[$(this).val()];
			// 	var regionOpt = '';
			// 	for(i  in  region){
			// 		regionOpt += "<option value='"+region[i].value+"'>"+region[i].text+"</option>";
			// 		$('#region').html(regionOpt);
			// 	}
			// })
			var E = window.wangEditor
			var editor = new E('#activitydetail')
			editor.customConfig.menus = [
				'head',  // 标题
				'bold',  // 粗体
				'italic',  // 斜体
				'underline',  // 下划线
				'strikeThrough',  // 删除线
				'foreColor',  // 文字颜色
				'backColor',  // 背景颜色
				'link',  // 插入链接
				'list',  // 列表
				'justify',  // 对齐方式
				'quote',  // 引用
				'image',  // 插入图片
				'table',  // 表格
				'video',  // 插入视频
				'undo',  // 撤销
				'redo'  // 重复
			]
			editor.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片
			// editor.customConfig.uploadImgServer = '/upload'  // 上传图片到服务器

			editor.create()
			editor.txt.html('<?=$info['activitydetail']?>')
			// 处理图片上传
			// 图片渲染
			var pic;
			var picname='';
			var result = true;
			$('#activitypic').on('change',function(){
				
				if (this.files.length === 0) return;
				$('.pick-button label').html('<div class="imgpath"><img src="./weixin/js/PicUpload/loading.gif" width="320" height="200" /><span></span></div>');
				lrz(this.files[0], {width: 640})
				.then(function (rst) {
					var img = new Image();
					img.src = rst.base64;
					img.onload = function () {
						$('.imgpath img').attr('src',rst.base64)
					};
					
					pic = rst.base64
				})

			})
			// 图片上传
			function uploadPic() {
				if(!pic){
					return;
				}
				$.ajax({
					url: './?r=activity/activity-pic-upload',
					data: {base64:pic},
					async: false,
					type: 'POST',
					dataType:"json",
					success: function (data) {
						if(data.status > 0){
							// $('.imgpath').removeClass('active');
							console.log('活动图片已上传');
							picname = "http://www.zmzfang.com/weixin/img/activity/"+data.picname;
						}else{
							alert('活动图片上传失败了！');
							result = false;
						}
						
					},error:function (){
						alert('活动图片上传失败了！');
						result = false;
					}
				});
			}


			// 提交活动新增处理
			$('#activityForm').on('submit',function(){
				var activitydetail = editor.txt.html();
				var activitycity = $('#city').find("option:selected").text()+' '+$('#region').find("option:selected").text()
				var serialize = $('#activityForm').serializeArray()
				var data = {};
				for (i in serialize){
					data[serialize[i].name] = serialize[i].value
				}
				data['activitydetail'] = activitydetail;
				data['activitycity'] = activitycity;
				data['publishusertype'] = <?=$userInfo['agentflag']?1:0?>;
				if(!$('#startime').val()){alert('请选择活动开始时间');return false;}
				if(!$('#endtime').val()){alert('请选择活动结束时间');return false;}
				// if(!$('#city').val()){alert('请选择活动城市');return false;}
				picname = '<?=$info['activitypic']?>'
				uploadPic();
				if(!picname){alert('请先上传活动图片！');return false;}
				if(!result){
					return false;
				}else{console.log(result)}
				data['activitypic'] = picname;
				var picture = picname;
				// console.log(data)

				preview(data);

				// $.ajax({
				// 	type: "POST",
				// 	dataType:"json",
				// 	url:'./?r=activity/pc-add',
				// 	data: JSON.stringify(data),
				// 	success: function(msg) {if(msg.rscode == 0){alert('发布成功')}}
				// });
				return false;
			})

			// 预览
			function preview(res){
				// console.log(res);
				$('#background').attr('src',res.activitypic);
				$('#subject').text(res.activitysubject)
				$('#start').text(res.begintime)
				$('#endTime').text(res.endtime)
				$('#plocation').text(res.location)
				$('#type').text(res.activitytype)
				if(parseInt(res.personcount) == 0){$('#personCnt').text('不限');}else{
					$('#personCnt').text(res.personcount+'人')
				}
				if(parseInt(res.fee) == 0){
					$('#pfee').text('免费')
				}else{
					$('#pfee').text(res.fee+'元/人')
				}
				$('#detail').html(res.activitydetail.replace(/\\/g, ""))

				$('#ok').show();
				$('#ok').off('click');
				$('#ok').on('click',function(){
					res.mid = getRandStr(20)
					$.ajax({
						type: "POST",
						dataType:"json",
						url:'./?r=activity/pc-modify',
						data: JSON.stringify(res),
						success: function(msg) {
							if(msg.rscode == 0){window.location.href="./?r=login/back2wechat&id="+msg.id+"&userid="+res.publishuserid}
							if(msg.rscode == 1){alert('出错了，请稍后再试')}
						}
					});
				})

			}
			// 提交主办方管理处理
			$('#zbf').on('submit',function(){
				var serialize = $('#zbf').serializeArray()
				var data = {};
				for (i in serialize){
					data[serialize[i].name] = serialize[i].value
				}
				$.ajax({
					type: "POST",
					dataType:"json",
					url:'./?r=activity/add-org',
					data: JSON.stringify(data),
					success: function(msg) {if(msg.rscode == 0){$('#organizationid').val(msg.organizationid);alert('修改成功');$('#zbfTable').html(
							'<table  class="table table-striped">'
								+'<tr>'
									+'<td>'+data.organization+'</td><td>'+data.organizationdetail+'</td><td>'+data.organizationlocation+'</td><td>'+data.contactname+'</td><td>'+data.contactphone+'</td><td><a  class="btn btn-primary" data-toggle="modal" data-target="#myModal">修改</a></td>'
								+'</tr>'
							+'</table>'
						);$('#myModal').modal('hide')}}
				});
				return false;
			})
		});
	</script>
	</body>
</html>