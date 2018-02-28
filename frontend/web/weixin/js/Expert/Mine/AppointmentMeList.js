var user = null;
var expertId = '8';
var orderId ;
var publishUserId;

var waitAffirmListUl;
var waitPayListUl;
var waitAnswerListUl;
var alreadyAnswerListUl;
var currentLi;//当前li 用于删除
var dstUl;//目标Ul 用于增加 
var startSn = 0;
var globalCnt = 30;
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
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		else
		{
			mui.toast("未获取到用户登陆信息");
			return;
		}
		expertId = user.expertid;
		
		waitAffirmListUl = document.getElementById('waitAffirmUl');
		waitPayListUl = document.getElementById('waitPayUl');
		waitAnswerListUl = document.getElementById('waitAnswerUl');
		alreadyAnswerListUl = document.getElementById('alreadyAnswerUl');
		
		initAppointmentList();
		
	});
	
	mui('#waitAffirm').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#waitPay').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#waitAnswer').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#alreadyAnswerPay').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
//	mui.back = function(){
//		mui.openWindow({
//			url: '../../test/expert.html'
//		});
//	};
}(mui, document));

//约见我的列表中确认 事件
mui('#waitAffirmUl').on('tap', '#affirm', function() {
	//var orderId = this.getAttribute('order-id');
	orderId = $(this).parents('#affirmDiv').attr('order-id');
	publishUserId = $(this).parents('#affirmDiv').attr('publishuser-id');
	
	//alert('orderId:'+orderId);
	//发送状态修改消息
	
	currentLi = $(this).parents('.mui-table-view-cell');
	modifyOrderStatus('1');
	//删除对应li
	//$(this).parents('.mui-table-view-cell').empty();
	
});

//约见我的列表中拒绝 事件
mui('#waitAffirmUl').on('tap', '#reject', function() {
	orderId = $(this).parents('#affirmDiv').attr('order-id');
	publishUserId = $(this).parents('#affirmDiv').attr('publishuser-id');
	//alert('orderId:'+orderId);
	currentLi = $(this).parents('.mui-table-view-cell');
	modifyOrderStatus('7');
});

//约见我的列表中li的tap 事件
mui('#waitAffirmUl,#waitPayUl,#waitAnswerUl,#alreadyAnswerUl').on('tap', '.appointment-me-brief', function() {
	var orderId = this.getAttribute('order-id');
	console.log('orderId:'+orderId);
	var appointmentType = this.getAttribute('appointmenttype');
	var dstUrl = './AppointmentMeDetail.html?orderId='+orderId;
	//var dstUrl = './AppointmentMeDetail.html';
	//localStorage.setItem('zmzfangAppointmentOrderId',orderId);
	
	if(appointmentType == '2')
	{
		dstUrl = './AppointmentMeDetailOffline.html?orderId='+orderId;
	}
	
	
	mui.openWindow({
		url: dstUrl,
		id: 'AppointmentMeDetail.html'
	});
	
});

//tap 点击等待确认 事件
document.querySelector('#waitAffirmLink').addEventListener('tap', function() {
	$('#waitAffirm').removeClass('mui-hidden');
	$('#waitPay').addClass('mui-hidden');
	$('#waitAnswer').addClass('mui-hidden');
	$('#alreadyAnswer').addClass('mui-hidden');
	
	if(startSn == 0)
	{
		initAppointmentList();
	}
}, false);

//tap 点击等待支付确认 事件
document.querySelector('#waitPayLink').addEventListener('tap', function() {
	$('#waitAffirm').addClass('mui-hidden');
	$('#waitPay').removeClass('mui-hidden');
	$('#waitAnswer').addClass('mui-hidden');
	$('#alreadyAnswer').addClass('mui-hidden');
	
	if(startSn == 0)
	{
		initAppointmentList();
	}
}, false);

//tap 点击等待处理确认 事件
document.querySelector('#waitAnswerLink').addEventListener('tap', function() {
	$('#waitAffirm').addClass('mui-hidden');
	$('#waitPay').addClass('mui-hidden');
	$('#waitAnswer').removeClass('mui-hidden');
	$('#alreadyAnswer').addClass('mui-hidden');
	
	if(startSn == 0)
	{
		initAppointmentList();
	}
}, false);

//tap 点击等待处理确认 事件
document.querySelector('#alreadyAnswerLink').addEventListener('tap', function() {
	$('#waitAffirm').addClass('mui-hidden');
	$('#waitPay').addClass('mui-hidden');
	$('#waitAnswer').addClass('mui-hidden');
	$('#alreadyAnswer').removeClass('mui-hidden');
	
	if(startSn == 0)
	{
		initAppointmentList();
	}
}, false);

function initAppointmentList(startsn,count)
{
	console.log("initAppointmentList");
	
	var options = new Object();
	options.expertid = expertId;
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	
	//获取约见我的 记录
	ajax_get_appointment_as_expert(options,getAppointmentAsExpertSuc,getAppointmentAsExpertFailed);
}

function getAppointmentAsExpertSuc(data)
{
	console.log("getAppointmentAsExpertSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('没有更多的数据了');
		return;
	}
	var waitAffirmFrag = document.createDocumentFragment();
	var waitPayFrag = document.createDocumentFragment();
	var waitAnswerFrag = document.createDocumentFragment();
	var alreadyAnswerFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		if(data[i].appointmenttype == "1")
		{
			//线上提问
			if(data[i].status == '0')
			{
				//待支付 隐藏掉   
				//waitPayFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
			else if(data[i].status == '1')
			{
				//已支付 待答复
				waitAnswerFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
			else if(data[i].status == '2' || data[i].status == '3')
			{
				// 增加已拒绝
				alreadyAnswerFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
			
		}
		else if(data[i].appointmenttype == "2")
		{
			//线下约见
			if(data[i].status == '0')
			{
				//待确认
				waitAffirmFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
			else if(data[i].status == '1')
			{
				//已确认 待支付
				waitPayFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
			else if(data[i].status == '2' || data[i].status == '3' || data[i].status == '4')
			{
				//客户支付完成 线下沟通
				waitAnswerFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
			else
			{
				//平台 打款完成，系统完成
				alreadyAnswerFrag.appendChild(fillAppointmentMeListLi(data[i]));
			}
		}
	}
	startSn += data.length;
	
	waitAffirmListUl.appendChild(waitAffirmFrag);
	waitPayListUl.appendChild(waitPayFrag);
	waitAnswerListUl.appendChild(waitAnswerFrag);
	alreadyAnswerListUl.appendChild(alreadyAnswerFrag);
}

function getAppointmentAsExpertFailed(data)
{
	console.log("getAppointmentAsExpertFailed data:"+JSON.stringify(data));
}

function fillAppointmentMeListLi(data)
{
	console.log(JSON.stringify(data));

	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	liContent += '<div id="appointmentMeBrief" class="col-xs-12">';	
	liContent += '	<div id="userPicBrief" class="col-xs-2 mui-text-center">';	
	liContent += '		<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';	
	liContent += '			<img style="width:42px; height:42px; " src="'+data.userpicture+'" alt="个人头像">';	
	liContent += '		</div>';	
	liContent += '	</div>';	
	liContent += '	<div class="col-xs-10">';	
	liContent += '		<div class="appointment-me-brief" publishuser-id="'+data.userid+'" order-id="'+data.appointmentorederid+'" appointmenttype="'+data.appointmenttype+'">';	
	liContent += '			<div>';	
	liContent += '				<div class="col-xs-7">';	
	liContent += '					<span>'+data.nickname+'</span>';	
	liContent += '				</div>';	
	liContent += '				<div class="col-xs-5">';	
	liContent += '					<p class="type mui-text-right" style="font-size:11px">'+getAppointmentTypeStr(data.appointmenttype)+'</p>';	
	liContent += '				</div>';	
	liContent += '			</div>';	
			
	liContent += '			<div>';	
	liContent += '				<div class="col-xs-6">';	
	liContent += '					<h5>约见主题</h5>';	
	liContent += '				</div>';	
	liContent += '			</div>';	
	liContent += '			<div class="subject" style="">';	
	liContent += '				<p>'+data.subject+'</p>';	
	liContent += '			</div>';	
			
	liContent += '			<div>';	
	liContent += '			<div class="col-xs-6">';	
	liContent += '				<h5>价格:'+data.fee+'元/次</h5>';	
	liContent += '			</div>';	
	liContent += '			<div class="col-xs-6">';	
	liContent += '				<h5>状态:<span>'+getAppointmentStatusStr(data.appointmenttype,data.status)+'</span></h5>';	
	liContent += '			</div>';	
	liContent += '			</div>';	
			
	liContent += '		</div>';	
			
	if(data.appointmenttype == '2' && data.status == '0')
	{
		liContent += '		<div style="clear:both" id="affirmDiv" order-id="'+data.appointmentorederid+'" publishuser-id="'+data.userid+'">';	
		liContent += '			<div class="col-xs-6">';	
		liContent += '				<button id="affirm" type="button" class="mui-btn" style="width: 90%;height: 30px;margin-top: 5px;background-color: #4cd964;color: #fff;">';	
		liContent += '					确认';	
		liContent += '				</button>';	
		liContent += '			</div>';	
		liContent += '			<div class="col-xs-6">';	
		liContent += '				<button id="reject" type="button" class="mui-btn" style="width: 90%;height: 30px;margin-top: 5px;background-color: #4cd964;color: #fff;">';	
		liContent += '					拒绝';	
		liContent += '				</button>';	
		liContent += '			</div>';
	}
		
	liContent += '		</div>';		
	liContent += '		<div class="col-xs-12">';	
	liContent += '			<h5 class="mui-text-right" style="font-size:11px">'+getTimeAgo(time)+'</h5>';	
	liContent += '		</div>';	
	liContent += '	</div>';	
	liContent += '</div>';	
	ele.innerHTML = liContent;
	return ele;
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
		//mui.toast("语音答复成功");
		//将对于li 删除掉
		currentLi.remove();
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

function pullupRefresh()
{
	console.log('pullupRefresh');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		initAppointmentList(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}
