var orderId;
var loginUser;
var questionId;
var appointmentType;
var answerFile;
var expertId;
var fee;
var playFlag = false;
var media;

var byId = function(id) {
	return document.getElementById(id);
};
	
(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui.ready(function() {
		//检查本页面是否初次打开,初始化导航
		initNavUi();
		//$('#mineLink').addClass('mui-active');
		loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
		if(!loginUser)
		{
			console.log('用户未登陆');
		}
		media = document.getElementById("musicBox");
		//订单详情
		initAppointmentDetail();
		//状态信息
		initAppointmentStatus();
		//问题答复信息
		//initQuestionAnserInfo();
		
	});
}(mui, document));

//增加用户头像的点击事件
document.querySelector('#expertPicBrief').addEventListener('tap', function() {
	console.log('expertPicBrief click');
	var expertId = this.getAttribute('expert-id');
	console.log('userId:'+userId);
	var dstUrl = '../List/ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
}, false);

//增加收听按钮事件
document.querySelector('#listenRecord').addEventListener('tap', function() {
	console.log('listenRecord click');
	if(playFlag)
	{
		//stop
		stop();
		return;
	}
	else {
		play();
		return;
	}
	
}, false);

//增加点评按钮事件
document.querySelector('#comment').addEventListener('tap', function() {
	console.log('comment click');
	var dstUrl = '../User/CommentExpert.html?expertId=';
	dstUrl += $("#expertPicBrief").attr('expert-id');
	mui.openWindow({
		url: dstUrl
	});
}, false);

//增加付费事件
document.querySelector('#pay').addEventListener('tap', function() {
	console.log('pay click');
	localStorage.setItem('zmzfangPayInfo',null);
	
	var dstUrl = '../Mine/MyPay.html';
	
	var payInfo = new Object();
	var subject = '芝麻找房商品';
	payInfo.orderid = orderId;
	payInfo.subject = subject;
	payInfo.fee = fee;
	payInfo.expertId = expertId;
	
	payInfo.ordertype = "1";//线上提问
	localStorage.setItem('zmzfangPayInfo',JSON.stringify(payInfo));
	
	mui.openWindow({
		url: dstUrl,
		id: 'MyPay.html'
	});
}, false);

//增加删除事件
document.querySelector('#delete').addEventListener('tap', function() {
	
	var options = new Object();
	options.userid = loginUser.id;
	options.orderid = orderId;
	ajax_to_server(deleteAppointmentUrl,options,deleteAppointmentSuc,deleteAppointmentFailed);
	
}, false);

function initAppointmentDetail()
{
	console.log("initAppointmentDetail");
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	orderId = getQueryStrFromUrl('orderId');
	console.log('orderId:'+orderId);
		
	var options = new Object();
	options.orderid = orderId;
	//获取我的约见 记录
	ajax_get_appointment_detail(options,getAppointmentDetailSuc,getAppointmentDetailFailed);
}

function initAppointmentStatus()
{
	console.log("initAppointmentStatus");
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	if(!loginUser)
	{
		console.log("initAppointmentStatus user not login");
		return;
	}
	var options = new Object();
	options.userid = loginUser.id;
	options.orderid = orderId;
	//获取我的约见 记录
	ajax_get_appointment_status(options,getAppointmentStatusSuc,getAppointmentStatusFailed);
}

function initQuestionAnserInfo()
{
	console.log("initQuestionAnserInfo");
	if(!loginUser)
	{
		console.log("initQuestionAnserInfo user not login");
		return;
	}
	
	var options = new Object();
	options.userid = loginUser.id;
	options.questionid = questionId;
	//获取我的约见 记录
	ajax_get_question_by_id(options,getQuestionByIdSuc,getQuestionByIdFailed);
}

function getAppointmentDetailSuc(data)
{
	console.log("getAppointmentDetailSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		return;
	}
	expertId = data.expertid;
	fee = data.fee;
	byId('question').innerText = data.subject;
	fillMyAppointment(data);
	if(data.appointmenttype == "1")
	{
		questionId = data.questionid;
		initQuestionAnserInfo();
	}
}

function getAppointmentDetailFailed(data)
{
	console.log("getAppointmentDetailFailed data:"+JSON.stringify(data));
}

function fillMyAppointment(data)
{
	console.log('fillMyAppointment data:'+JSON.stringify(data));
	$("#expertPicBrief").attr('expert-id',data.expertid);
	byId("expertName").innerText = data.expertname;
	byId("headPic").src = data.expertpicture;
	//byId("domain").innerHTML = getDomainBadge(data.domain);
	byId('organization').innerText = data.expertorganization;
	
	byId("appointmentType").innerText = getAppointmentTypeStr(data.appointmenttype);
	appointmentType = data.appointmenttype;
	byId("fee").innerText = data.fee;
	
	byId("status").innerText = getAppointmentStatusStr(data.appointmenttype,data.status);
	
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	byId("createTime").innerText = getTimeAgo(time);
	
	//如果专家已答复，则显示收听按钮，点评按钮
	if(data.appointmenttype == '1')
	{
		//线上约见，并且已经答复，显示问题相关信息和点评按钮
		if(data.status == '0')
		{
			$('#payDiv').removeClass('mui-hidden');
		}
		
		if(data.status == '2')
		{
			$('#anserInfo').removeClass('mui-hidden');
			$('#commentDiv').removeClass('mui-hidden');	
		}
	}
	
}

function getAppointmentStatusSuc(data)
{
	console.log("getAppointmentStatusSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		return;
	}
	
	var statusUl = document.getElementById('statusUl');
	var firstFrag = document.createDocumentFragment();
	for(var i in data)
	{
		firstFrag.appendChild(fillStatusLi(data[i]));
	}
	statusUl.appendChild(firstFrag);
}

function getAppointmentStatusFailed(data)
{
	console.log("getAppointmentStatusFailed data:"+JSON.stringify(data));
}

function fillStatusLi(data)
{
	//{"id":"1","orderid":"12","orderstatus":"0","statustime":"2016-09-01 14:02:36","operator":"a"}
	console.log(JSON.stringify(data));
	
	var statusStr;
	if(appointmentType == '1')
	{
		statusStr = getOnlineStatus(data.orderstatus);
	}
	else
	{
		statusStr = getOfflineStatus(data.orderstatus);
	}
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	liContent += '<div id="eventName" class="col-xs-3 mui-text-right">';
	liContent += 	'<h5>'+statusStr+'</h5>';
	liContent += '</div>';
	liContent += '<div id="statuTime" class="col-xs-6">';
	liContent += 	'<h5>'+data.statustime+'</h5>';
	liContent += '</div>';
	liContent += '<div id="dealName" class="col-xs-3">';
	liContent += 	'<h5>'+data.operator+'</h5>';
	liContent += '</div>';
	
	ele.innerHTML = liContent;
	return ele;
}

function getQuestionByIdSuc(data)
{
	console.log("getQuestionByIdSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	//填充 收听次数
	byId('question').innerText = data.questiondetail;
	byId('listenedCnt').innerText = data.listenedcnt;
	
	answerFile = data.answer;
	//data.answer;
	//media.src = answerFile;
	byId('duration').innerText = data.duration;
}

function getQuestionByIdFailed(data)
{
	console.log("getQuestionByIdFailed data:"+JSON.stringify(data));
}

function modifyOrderStatus(status)
{
	var options = new Object();
	options.expertid = expertId;
	options.orderid = orderId;
	options.status = status;
	//alert("modifyOrderStatus options:"+JSON.stringify(options));
	ajax_modify_order_status(options,modifyOrderStatusSuc,modifyOrderStatusFailed);
}

function modifyOrderStatusSuc(data)
{
	console.log("modifyOrderStatusSuc data:"+JSON.stringify(data));
	//alert("modifyOrderStatusSuc data:"+JSON.stringify(data));
	if(data && data.rscode == '0')
	{
		console.log("modifyOrderStatusSuc");
		mui.toast("已处理成功");
		//mui.reload();
		location.reload();
	}
	else
	{
		console.log("modifyOrderStatusSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，状态修改失败");
	}
}

function modifyOrderStatusFailed(data)
{
	console.log("modifyOrderStatusFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，修改状态失败");
}

function play()
{
	$('#listenRecord').css('background-image',"url(../../img/stop.png)");
	if (!media.src) {
	    media.src = answerFile;
	}
	media.play();
	
	playFlag = true;
	media.onended = function() {
	    //alert("音频播放完成");
	    $('#listenRecord').css('background-image',"url(../../img/play.png)");
	    playFlag = false;
	};
}

function stop()
{
	console.log('stop');
	//media = $(selectedMusicBox)[0];
	//media = document.getElementById("musicBox");
	$('#listenRecord').css('background-image',"url(../../img/play.png)");
	media.pause();
	//media.stop();
	playFlag = false;
}

function deleteAppointmentSuc(data)
{
	console.log("deleteAppointmentSuc data:"+JSON.stringify(data));
	//alert("modifyOrderStatusSuc data:"+JSON.stringify(data));
	if(data && data.rscode == '0')
	{
		console.log("modifyOrderStatusSuc");
		mui.toast("已处理成功");
		mui.back();
	}
	else
	{
		console.log("deleteAppointmentSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，删除订单失败");
	}
}

function deleteAppointmentFailed(data)
{
	console.log("deleteAppointmentFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，删除订单失败");	
}
