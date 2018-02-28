var orderId;
var loginUser;
var appointmentType;
var expertId;
var expertName;
var fee;

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
		//订单详情
		initAppointmentDetail();
		//状态信息
		initAppointmentStatus();
		
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
	
	payInfo.ordertype = OrderType.getType('APPOINTMENT_OFFLINE');
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

//用户付完款后，线下沟通完成后，完成订单
document.querySelector('#closeOrder').addEventListener('tap', function() {
	console.log('closeOrder click');
	var status = OfflineStatus.getStatus('OFFLINE_USER_CLOSE');//专家已经确认
	//alert(status);
	modifyOrderStatus(status);
}, false);

//用户付完款后，线下沟通完成后，完成订单
document.querySelector('#chat').addEventListener('tap', function() {
	console.log('chat click');
	//弹出聊天界面
	localStorage.setItem("chatObjectId",expertId);
	//alert('chatObjectId:'+publishUser.id);
	localStorage.setItem("chatObjectNickName",expertName);
	//localStorage.setItem("chatObjectSubject",subject);
	//checkAndEnter('../Message/im-chat.html');
	var dstUrl = '../../Message/im-chat.html';
	mui.openWindow({
		url: dstUrl,
		id: '../Message/im-chat.html'
	});
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
	expertName = data.expertname;
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
	
	//
	if(data.appointmenttype == '2')
	{
		//线下约见，专家已经确认，待支付
		if(data.status == '1')
		{
			$('#payDiv').removeClass('mui-hidden');
		}
		else if(data.status == '2')
		{
			//已支付
			$('#chatDiv').removeClass('mui-hidden');
		}
		else if(data.status == '3')
		{
			//专家已确认流程结束
			$('#closeDiv').removeClass('mui-hidden');	
		}
		else if(data.status == '4')
		{
			//用户已确认流程结束
			$('#commentDiv').removeClass('mui-hidden');	
		}
		else if(data.status == '7')
		{
			//专家拒绝
			$('#expertAcceptLi').addClass('mui-hidden');	
			$('#userPayLi').addClass('mui-hidden');	
			$('#contactOfflineLi').addClass('mui-hidden');	
			$('#expertCloseLi').addClass('mui-hidden');	
			$('#userCloseLi').addClass('mui-hidden');	
			$('#systemPayLi').addClass('mui-hidden');	
			$('#expertRejectLi').removeClass('mui-hidden');	
			$('#overTimeLi').addClass('mui-hidden');	
			$('#completeLi').addClass('mui-hidden');	
		}
		else if(data.status == '8')
		{
			//超时结束
			$('#overTimeLi').removeClass('mui-hidden');	
			$('#completeLi').removeClass('mui-hidden');
			
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
	
	for(var i in data)
	{
		showAppointmentStatus(data[i]);
	}
	
}

function getAppointmentStatusFailed(data)
{
	console.log("getAppointmentStatusFailed data:"+JSON.stringify(data));
}

function showAppointmentStatus(data)
{
	//$flishFlag;
	//线下预约状态：0--已提交预约申请（等待专家确认），
//	1--专家确认（等待客户支付），
//	2--客户支付完成（线下沟通），
//	3--专家确认流程结束，
//	4--客户确认流程结束，
//	5--平台打款，
//	6--已完成，
//	7--专家拒绝，
//	8--超时未处理，
//	9--其他原因退款
	switch(data.orderstatus)
	{
		case '0':
			$('#userSubmitLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#userSubmitLi').find('#statusTime').text(data.statustime);
			break;
		case '1':
			$('#expertAcceptLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#expertAcceptLi').find('#statusTime').text(data.statustime);
			break;
		case '2':
			$('#userPayLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#userPayLi').find('#statusTime').text(data.statustime);
			$('#contactOfflineLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#contactOfflineLi').find('#statusTime').text(data.statustime);
			break;
		case '3':
			$('#expertCloseLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#expertCloseLi').find('#statusTime').text(data.statustime);
			break;
		case '4':
			$('#userCloseLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#userCloseLi').find('#statusTime').text(data.statustime);
			break;
		case '5':
			$('#systemPayLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#systemPayLi').find('#statusTime').text(data.statustime);
			break;
		case '6':
			$('#completeLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#completeLi').find('#statusTime').text(data.statustime);
			break;
		case '7':
			$('#expertRejectLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#expertRejectLi').find('#statusTime').text(data.statustime);
		case '8':
			$('#overTimeLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#overTimeLi').find('#statusTime').text(data.statustime);
			$('#completeLi').find('#flishFlag').removeClass('unfinish').addClass('finish');
			$('#completeLi').find('#statusTime').text(data.statustime);
			break;
		default:
			break;
	}
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
		//location.reload();
		hideDiv();
		initAppointmentDetail();
		initAppointmentStatus();
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

//重新拉取数据前，先隐藏部分div
function hideDiv()
{
	$('#payDiv').addClass('mui-hidden');
	$('#chatDiv').addClass('mui-hidden');
	$('#closeDiv').addClass('mui-hidden');
	$('#commentDiv').addClass('mui-hidden');
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
