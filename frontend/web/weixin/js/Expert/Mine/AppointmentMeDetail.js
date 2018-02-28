var orderId;
var loginUser;
var questionId;
var publishUserId;
var appointmentType;
var expertId;
var questionUserId;
var currentStatus;
var answerFile;
var gobalInterval = 0;
var flag = 0;//全局播放标志
var cnt = 0;
var countTid = 0;
var countingDownTid = 0;
var playFlag = false;
var media;
var voice = {
    localId: '',
    serverId: ''
};
			
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
		initAppointmentDetail();
		initAppointmentStatus();
		ajax_get_jssdk_conf();
		
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

//增加开始录音按钮的事件

document.querySelector('#tape').addEventListener('tap', function() {
	console.log('tape click');
	//var userId = this.getAttribute('publishuser-id');
	if(flag == 0)
	{
		//开始录音
		beginTape();
	}
	else if(flag == 1)
	{
		//停止录音
		stopTape();
	}
	else if(flag == 2)
	{
		//试听播放
		beginPlay();
	}
	else if(flag == 3)
	{
		//试听停止
		stopPlay();
	}
	
}, false);

//提交上传按钮事件
document.querySelector('#uploadAnser').addEventListener('tap', function() {
	console.log('uploadAnser click');
	//var userId = this.getAttribute('publishuser-id');
	uploadTapeToWxServer();
}, false);

//已答复后的播放语音
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

//重置录音按钮呢事件
document.querySelector('#resetTape').addEventListener('tap', function() {
	console.log('listenRecord click');
	voice.localId = '';
	voice.serverId = '';
	flag = 0;
	globalCnt = 0;
	byId('dida').innerText = 0;
	byId("tape").innerText = "开始录音";
	byId("prompt").innerText = "一次答复最多可以录音60秒钟，点击可停止";
	
	mui.toast('重置完成');
	
}, false);

//线上提问，专家拒绝答复 未答复时生效
document.querySelector('#rejectOnline').addEventListener('tap', function() {
	console.log('reject click');
	//用户支付完成
	//console.log('appointmentType:'+appointmentType);
	//console.log('currentStatus:'+currentStatus);
	if(appointmentType == '1' && currentStatus == "1")
	{
		//线上提问，用户已支付，专家拒绝
		//console.log('1111111');
		var status = '3';
		modifyOrderStatus(status);
	}
	else
	{
		mui.toast('无法拒绝用户');
	}
	
}, false);

//初始化约见信息
function initAppointmentDetail()
{
	console.log("initAppointmentDetail");
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	orderId = getQueryStrFromUrl('orderId');
//	if(!orderId || orderId == '')
//	{
//		orderId = localStorage.getItem('zmzfangAppointmentOrderId');
//	}
	
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
	appointmentType = data.appointmenttype;
	expertId = data.expertid;
	currentStatus = data.status;
	if(data.appointmenttype == "1")
	{
		questionId = data.questionid;
		initQuestionAnserInfo();
	}
	
	showControl();
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
	questionUserId = data.userid;
	byId("appointmentType").innerText = getAppointmentTypeStr(data.appointmenttype);
	byId("fee").innerText = data.fee;
	
	byId("status").innerText = getAppointmentStatusStr(data.appointmenttype,data.status);
	byId('question').innerText = data.subject;
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	byId("createTime").innerText = getTimeAgo(time);
}

//初始化约见状态信息
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

//初始化jssdk
function ajax_get_jssdk_conf(options) {
	jQuery.ajax({
		url: "http://www.zmzfang.com/?r=door/get-jssdk&url="+escape(window.document.location.href),
		// data: JSON.stringify(options),
		dataType: 'json', //服务器返回json格式数据
		type: 'get', //HTTP请求类型
		timeout: 10000, //超时时间设置为10秒；
		async: false,
		success: function(data) {
			getJssdkConfSuccess(data);
		},
		error: function(xhr, type, errorThrown) {
			getJssdkConfFailed(errorThrown);
		}
	});
}

function getJssdkConfSuccess(data) {
	console.log("config  " + JSON.stringify(data));
	wx.config({
		debug: false,
		appId: data.appId,
		timestamp: data.timestamp,
		nonceStr: data.nonceStr,
		signature: data.signature,
		jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
			'startRecord',
			'stopRecord',
			'onVoiceRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'onVoicePlayEnd',
			'uploadVoice',
			'downloadVoice'
		]
	});
	wx.ready(function() {
		console.log('wxjssdk ready');
		wx.onVoiceRecordEnd({
		    // 录音时间超过一分钟没有停止的时候会执行 complete 回调
		    complete: function (res) {
		       // var localId = res.localId; 
		        mui.toast('录音结束，最长一分钟');
		        voice.localId = res.localId;
		        flag = 2;
		    }
		});
		wx.onVoicePlayEnd({
		    success: function (res) {
		        var localId = res.localId; // 返回音频的本地ID
		    	//alert('播放结束了');
		    }
		});
	});

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
	options.userid = publishUserId;
	options.questionid = questionId;
	//获取我的约见 记录
	ajax_get_question_by_id(options,getQuestionByIdSuc,getQuestionByIdFailed);
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
	//media.src = answerFile;
	byId('duration').innerText = data.duration;
	
	//data.answer;
}

function getQuestionByIdFailed(data)
{
	console.log("getQuestionByIdFailed data:"+JSON.stringify(data));
}

function uploadTapeToWxServer()
{
	//alert('uploadRecord start');
	if (voice.localId == '') {
		mui.toast('请先使用 录音接口录制一段声音');
		return;
	}
	wx.uploadVoice({
		localId: voice.localId,
		success: function (res) {
			//alert('上传语音成功，serverId 为' + res.serverId + '    localId 为' + voice.localId);
			console.log('上传语音成功，serverId 为' + res.serverId + '   localId 为' + voice.localId);
			voice.serverId = res.serverId;
			uploadTapeToZmzfangServer();
		}
	});
}

function uploadTapeToZmzfangServer()
{
		//alert('downloadRecord start');
		if (voice.serverId == '') {
			mui.toast('上传录音serverid异常');
			return;
		}

		var status = "1";//表示初始状态
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		var user = JSON.parse(data);
		//var questionid = "1";//对应 t_question_answer 表的 id 字段
		
		//alert('expertid is '+ user.expertid);

		var options = {
			questionid: questionId,
			expertid: user.expertid,
			serverid: voice.serverId,
			localid: voice.localId,
			status: status,
			orderid:orderId
		};
			
		//alert("ajax_add_audio_new options:"+JSON.stringify(options));
		ajax_add_audio_new(options,addAudioSuc,addAudioFailed);
}

function addAudioSuc(data)
{
	console.log("addAudioSuc data:"+JSON.stringify(data));
	//alert("addAudioSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('上传语音答复失败');
		return;
	}
	
	if(data.rscode == '0')
	{
		//上传成功后，更改状态
		//var status = '2';
		//modifyOrderStatus(status);
		//状态转为在后台更新
		location.reload();
	}
	else
	{
		mui.toast('上传语音答复失败,rscode='+JSON.stringify(data));
		alert('上传语音答复失败,rscode='+JSON.stringify(data));
		return;
	}
	
}

function addAudioFailed(data)
{
	console.log("addAudioFailed data:"+JSON.stringify(data));
	mui.toast('上传语音答复失败,error='+JSON.stringify(data));
	//alert("addAudioFailed data:"+JSON.stringify(data));
}

function modifyOrderStatus(status)
{
	var options = new Object();
	options.userid = questionUserId;
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

function showControl()
{
	//线上提问
	if(appointmentType == '1')
	{
		if(currentStatus == '1')
		{
			//用户已经支付
			$("#alreadyAnserInfo").addClass('mui-hidden');
			$("#anserInfo").removeClass('mui-hidden');
		}
		else if(currentStatus == '2')
		{
			//专家已答复
			$("#alreadyAnserInfo").removeClass('mui-hidden');
			$("#anserInfo").addClass('mui-hidden');
		}
	}
}

//开始录音
function beginTape()
{
	//开始录音
	//alert('开始录音');
	wx.startRecord({
		success: function (res) {
			//alert('ok');
			counting();
			byId("tape").innerText = "停止";
			byId("prompt").innerText = "正在录音...";
			flag = 1;   
		},
		cancel: function () {
			alert('用户拒绝授权录音');
		}
    });
	
	byId("prompt").innerText = "调度录音接口中";
}

//停止录音
function stopTape()
{
	wx.stopRecord({
		success: function (res) {
			voice.localId = res.localId;
			//alert(voice.localId);
		},
		fail: function (res) {
			//alert(JSON.stringify(res));
			mui.toast('停止录音异常:'+JSON.stringify(res))
		}
	});
	gobalInterval = cnt;
	//byId("tape").innerText = "试听";
	//byId("prompt").innerText = "可点击试听，也可以重置后重新录音";
	flag = 2;
	
	//$("#resetTape").removeClass('mui-disabled');
	//$("#uploadAnser").removeClass('mui-disabled');
}

//开始播放
function beginPlay()
{
	if (voice.localId == '') {
		mui.toast('请先录制一段声音');
		return;
	}
	wx.playVoice({
		localId: voice.localId
	});
	countingDown();
	byId("tape").innerText = "停止";
	byId("prompt").innerText = "正在播放，可点击试听，也可以重置重新录音";
	//重置和提交按钮 不可操作
	$("#resetTape").addClass('mui-disabled');
	$("#uploadAnser").addClass('mui-disabled');
	
	flag = 3; 	
}

//停止播放
function stopPlay()
{
	//
	if (voice.localId == '') {
		mui.toast('请先录制一段声音');
		return;
	}
		wx.stopVoice({
			localId: voice.localId
		});
		
	flag = 2;
	byId("tape").innerText = "试听";
	byId("prompt").innerText = "可点击试听，也可以重置后重新录音";
	//重置和提交按钮 可操作
	$("#resetTape").removeClass('mui-disabled');
	$("#uploadAnser").removeClass('mui-disabled');
}

//增加计数
function counting() {
	cnt = 0;
	countTid = setInterval(function() {
		if(cnt < 180)
		{
			console.log('i:'+cnt);
			cnt++;
			byId('dida').innerText = cnt;
			if(flag == 2)
			{
				clearInterval(countTid);
				countTid = 0;
				byId("tape").innerText = "试听";
				byId("prompt").innerText = "可点击试听，也可以重置后重新录音";
				$("#resetTape").removeClass('mui-disabled');
				$("#uploadAnser").removeClass('mui-disabled');
			}
		}
//		else
//		{
//			console.log('end i:'+cnt);
//			clearInterval(tid);
//			this.innerText = "试听播放";
//			//如果用户录音未停止，则进行停止
//			stopTape();
//			$("#resetTape").removeClass('mui-disabled');
//			$("#uploadAnser").removeClass('mui-disabled');
//		}
	},1000);
}

//倒计时
function countingDown() {
	var cnt = gobalInterval;
	countingDownTid = setInterval(function() {
		if(cnt > 0)
		{
			console.log('i:'+cnt);
			cnt--;
			byId('dida').innerText = cnt;
			if(flag == 2)
			{
				byId('dida').innerText = gobalInterval;
				clearInterval(countingDownTid);
				countingDownTid = 0;
			}
		}
		else
		{
			console.log('end i:'+cnt);
			clearInterval(countingDownTid);
			countingDownTid = 0;
			//如果用户录音未停止，则进行停止
			byId('dida').innerText = gobalInterval;
			byId("tape").innerText = "试听";
			byId("prompt").innerText = "可点击试听，也可以重置后重新录音";
			$("#resetTape").removeClass('mui-disabled');
			$("#uploadAnser").removeClass('mui-disabled');
		}
	},1000);
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
