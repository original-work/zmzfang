var user=null;
var startSn = 0;
var globalCnt = 30;
var onlineCnt = 0;
var offlineCnt = 0;
var onlineAppointmentListUl;
var offlineAppointmentListUl;

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
		onlineAppointmentListUl = document.getElementById('onlineAppointmentUl');
		offlineAppointmentListUl = document.getElementById('offlineAppointmentUl');
		initAppointmentList();
		
		//检查本页面是否初次打开,初始化导航
		initNavUi();
	});
	
	mui('#online').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#offline').pullRefresh({
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

//我的约见列表中li的tap 事件
mui('#onlineAppointmentUl,#offlineAppointmentUl').on('tap', '.my-appointment-brief', function() {
	var orderId = this.getAttribute('order-id');
	console.log('orderId:'+orderId);
	var appointmentType = this.getAttribute('appointmenttype');
	var dstUrl = './MyAppointmentDetail.html?orderId='+orderId;
	if(appointmentType == '2')
	{
		dstUrl = './MyAppointmentDetailOffline.html?orderId='+orderId;
	}
	
	mui.openWindow({
		url: dstUrl,
		id: 'MyAppointmentDetail.html'
	});
	
});

//tap点击事件
document.querySelector('#onlineLink').addEventListener('tap', function() {
	
	$('#offlineLink').removeClass('mui-active');
	$('#onlineLink').addClass('mui-active');
	
	$('#offline').addClass('mui-hidden');
	$('#online').removeClass('mui-hidden');
	
	if(startSn == 0)
	{
		initAppointmentList();
	}
}, false);

document.querySelector('#offlineLink').addEventListener('tap', function() {
	
	$('#onlineLink').removeClass('mui-active');
	$('#offlineLink').addClass('mui-active');
	
	$('#online').addClass('mui-hidden');
	$('#offline').removeClass('mui-hidden');
	
	if(startSn == 0)
	{
		initAppointmentList();
	}
}, false);

document.querySelector('#onlinePromptLink').addEventListener('tap', function() {
	var dstUrl = '../List/ExpertList.html';
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertList.html'
	});
}, false);

document.querySelector('#offlinePromptLink').addEventListener('tap', function() {
	var dstUrl = '../List/ExpertList.html';
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertList.html'
	});
}, false);

function initAppointmentList(startsn,count)
{
	console.log("initAppointmentList");
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	var options = new Object();
	options.userid = user.id;
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	//获取我的约见 记录
	ajax_get_appointment(options,getAppointmentSuc,getAppointmentFailed);
	
}

function getAppointmentSuc(data)
{
	console.log("getAppointmentSuc data:"+JSON.stringify(data));
	
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('没有获取到更多数据');
		if(onlineCnt == 0)
		{
			$('#onlinePromptLi').removeClass('mui-hidden');
			
		}
		if(offlineCnt == 0)
		{
			$('#offlinePromptLi').removeClass('mui-hidden');
		}
		return;
	}
	
	var onlineFrag = document.createDocumentFragment();
	var offlineFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		if(data[i].appointmenttype == '1')
		{
			onlineFrag.appendChild(fillMyAppointmentListLi(data[i]));
			onlineCnt++;
		}
		else if(data[i].appointmenttype == '2')
		{
			offlineFrag.appendChild(fillMyAppointmentListLi(data[i]));
			offlineCnt++;
		}
		
	}
	startSn += data.length;
	//onlineAppointmentListUl.innerHTML = "";
	onlineAppointmentListUl.appendChild(onlineFrag);
	
	//offlineAppointmentListUl.innerHTML = "";
	offlineAppointmentListUl.appendChild(offlineFrag);
}

function getAppointmentFailed(data)
{
	console.log("getAppointmentFailed data:"+JSON.stringify(data));
	mui.toast('网络问题，获取信息失败');
}

function fillMyAppointmentListLi(data)
{
	console.log(JSON.stringify(data));
	
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	liContent += '<div id="appointmentBrief" class="col-xs-12">';	
	liContent += '<div id="userPicBrief" class="col-xs-2 mui-text-center">';	
	liContent += '	<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';	
	liContent += '		<img style="width:42px; height:42px; " src="'+data.expertpicture+'" alt="个人头像">';	
	liContent += '	</div>';	
	liContent += '</div>';	
	liContent += '<div class="col-xs-10">';	
	liContent += '	<div class="my-appointment-brief" expert-id="'+data.expertid+'" order-id="'+data.appointmentorederid+'" appointmenttype="'+data.appointmenttype+'">';	
	liContent += '		<div>';	
	liContent += '			<div class="col-xs-9"> <p>';	
	liContent += '				<span style="color:#666;">'+data.expertname+'</span> ';	
	liContent += '				 | <small>'+data.expertorganization+'</small>';	
	liContent += '			</p></div>';	
	liContent += '			<div class="col-xs-3">';	
	liContent += '				<p class="type mui-text-right" style="font-size:11px">'+getAppointmentTypeStr(data.appointmenttype)+'</p>';	
	liContent += '			</div>';	
	liContent += '		</div>';	
		
	liContent += '		<div>';	
	liContent += '			<div class="col-xs-6">';	
	liContent += '				<h5>价格:'+data.fee+'元/次</h5>';	
	liContent += '			</div>';	
	liContent += '			<div class="col-xs-6">';	
	liContent += '				<h5>状态:<span>'+getAppointmentStatusStr(data.appointmenttype,data.status)+'</span></h5>';	
	liContent += '			</div>';	
	liContent += '		</div>';	
			
	liContent += '		<div>';	
	liContent += '			<div class="col-xs-6">';	
	liContent += '				<h5>约见主题</h5>';	
	liContent += '			</div>';	
	liContent += '		</div>';	
	liContent += '		<div class="subject" style="">';	
	liContent += '			<p>'+data.subject+'</p>';	
	liContent += '		</div>';	
	liContent += '	</div>';	
		
	liContent += '	<div class="col-xs-12">';	
	liContent += '		<h5 class="mui-text-right" style="font-size:11px">'+getTimeAgo(time)+'</h5>';	
	liContent += '	</div>';	
	liContent += '</div>';	
	liContent += '</div>';	
	
	ele.innerHTML = liContent;
	return ele;
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
