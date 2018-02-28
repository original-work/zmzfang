var orderId;
var loginUser;
var publishUserId;
var publishUserName;
var appointmentType;
var expertId;
var currentStatus;

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
		
		initAppointmentDetail();
		initAppointmentStatus();
		
	});
}(mui, document));


//增加用户头像的点击事件
document.querySelector('#userPicBrief').addEventListener('tap', function() {
	console.log('userPicBrief click');
	var userId = this.getAttribute('publishuser-id');
	console.log('userId:'+userId);
	var dstUrl = '../../Mine/User.html?userId='+userId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'User.html'
	});
}, false);

//用户刚提问时的确认操作
document.querySelector('#affirm').addEventListener('tap', function() {
	console.log('affirm click');
	var status = OfflineStatus.getStatus('OFFLINE_EXPERT_AFFIRM');//专家已经确认
	//alert(status);
	modifyOrderStatus(status);
}, false);

//用户刚提问时的拒绝操作
document.querySelector('#reject').addEventListener('tap', function() {
	console.log('reject click');
	var status = OfflineStatus.getStatus('OFFLINE_EXPERT_REJECT');//专家已经拒绝
	//alert(status);
	modifyOrderStatus(status);
}, false);

//用户付完款后，线下沟通完成后，专家完成订单
document.querySelector('#closeOrder').addEventListener('tap', function() {
	console.log('closeOrder click');
	var status = OfflineStatus.getStatus('OFFLINE_EXPERT_CLOSE');//专家确认流程结束
	//alert(status);
	modifyOrderStatus(status);
}, false);

//用户付完款后，线下沟通完成后，完成订单
document.querySelector('#chat').addEventListener('tap', function() {
	console.log('chat click');
	//弹出聊天界面
	localStorage.setItem("chatObjectId",publishUserId);
	localStorage.setItem("chatObjectNickName",publishUserName);
	var expertFlag = 1;
	var dstUrl = '../../Message/im-chat.html?id='+publishUserId+'&nickname='+publishUserName+'&expertflag='+expertFlag;
	mui.openWindow({
		url: dstUrl,
		id: '../Message/im-chat.html'
	});
}, false);

function initAppointmentDetail()
{
	console.log("initAppointmentDetail");
	orderId = getQueryStrFromUrl('orderId');
	
	var options = new Object();
	options.orderid = orderId;
	//获取我的约见 记录
	
	ajax_get_appointment_detail(options,getAppointmentDetailSuc,getAppointmentDetailFailed);
}

function getAppointmentDetailSuc(data)
{
	console.log("getAppointmentDetailSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		return;
	}
	fillAppointmentMe(data);
	publishUserId = data.userid;
	publishUserName = data.nickname;
	appointmentType = data.appointmenttype;
	expertId = data.expertid;
	currentStatus = data.status;
	
}

function getAppointmentDetailFailed(data)
{
	console.log("getAppointmentDetail data:"+JSON.stringify(data));
}

function fillAppointmentMe(data)
{
	console.log('fillAppointmentMe data.'+JSON.stringify(data));
	
	$("#userPicBrief").attr('publishuser-id',data.userid);
	byId("userName").innerText = data.nickname;
	byId("headPic").src = data.userpicture;
	
	byId("appointmentType").innerText = getAppointmentTypeStr(data.appointmenttype);
	byId("fee").innerText = data.fee;
	
	byId("status").innerText = getAppointmentStatusStr(data.appointmenttype,data.status);
	byId('question').innerText = data.subject;
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	byId("createTime").innerText = getTimeAgo(time);
	//
	if(data.appointmenttype == '2')
	{
		//线下约见，用户提问，专家未确认
		if(data.status == '0')
		{
			$('#affirmDiv').removeClass('mui-hidden');
		}
		else if(data.status == '1')
		{
			//专家已确认 等等客户支付
		}
		else if(data.status == '2')
		{
			//客户已支付  显示聊天按钮  结束按钮
			$('#closeOrderDiv').removeClass('mui-hidden');
			//$('#closeDiv').removeClass('mui-hidden');
		}
		else if(data.status == '3')
		{
			//专家已确认流程结束
				
		}
		else if(data.status == '4')
		{
			//用户已确认流程结束
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

function initAppointmentStatus()
{
	console.log("initAppointmentStatus");
	
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
	options.userid = publishUserId; 
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
	$('#affirmDiv').addClass('mui-hidden');
	$('#closeOrderDiv').addClass('mui-hidden');
}
