var loginUser=null;

var globalCnt = 10;
var deliveryStartSn = 0;
var inviteStartSn = 0;

var deliveryCnt = 0;
var inviteCnt = 0;

var deliveryListUl;
var inviteListUl;

var byId = function(id) {
	return document.getElementById(id);
};
	
(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui.ready(function() {
		//检查本页面是否初次打开,初始化导航
		//initNavUi();
		//$('#mineLink').addClass('mui-active');
		loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
		
		if(!loginUser)
		{
			mui.toast("未获取到用户登陆信息");
			return;
		}
		deliveryListUl = document.getElementById('deliveryListUl');
		inviteListUl = document.getElementById('inviteListUl');
		
		initDeliveryList();
		//initInviteList();
		//检查本页面是否初次打开,初始化导航
		//initNavUi();
	});
	
	mui('#delivery').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefreshDelivery
			}
		}	
	);
	
	mui('#invite').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefreshInvite
			}
		}	
	);
	
//	mui.back = function(){
//		mui.openWindow({
//			url: '../../test/expert.html'
//		});
//	};
}(mui, document));

//增加列表中tap事件
mui('#deliveryListUl,#inviteListUl').on('tap', '.position-brief', function() {
	var positionId = this.getAttribute('position-id');
    var positionPublishuserId = this.getAttribute('publishuser-id');
	var dstUrl = '../PositionDetail.html?positionId='+positionId+"&publishuserid="+positionPublishuserId;
	mui.openWindow({
		url: dstUrl,
		id: 'PositionDetail.html'
	});
});

//tap点击事件
document.querySelector('#deliveryLink').addEventListener('tap', function() {
	
	$('#inviteLink').removeClass('mui-active');
	$('#deliveryLink').addClass('mui-active');
	
	$('#invite').addClass('mui-hidden');
	$('#delivery').removeClass('mui-hidden');
	
	if(deliveryStartSn == 0)
	{
		initDeliveryList();
	}
}, false);

document.querySelector('#inviteLink').addEventListener('tap', function() {
	
	$('#deliveryLink').removeClass('mui-active');
	$('#inviteLink').addClass('mui-active');
	
	$('#delivery').addClass('mui-hidden');
	$('#invite').removeClass('mui-hidden');
	
	if(inviteStartSn == 0)
	{
		initInviteList();
	}
}, false);

document.querySelector('#deliveryPromptLink').addEventListener('tap', function() {
	var dstUrl = '../index.html';
	mui.openWindow({
		url: dstUrl,
		id: 'index.html'
	});
}, false);

document.querySelector('#resumePromptLink').addEventListener('tap', function() {
	var dstUrl = './MyResumeDetail.html';
	mui.openWindow({
		url: dstUrl,
		id: 'MyResumeDetail.html'
	});
}, false);


function initDeliveryList(startsn,count)
{
	console.log("initDeliveryList");
	
	var options = new Object();
	
	options.userid = loginUser.id;
	var basicInfo = JSON.parse(localStorage.getItem('zmzfangResumeBasicInfo'));
	if(basicInfo)
	{
		options.resumeid = basicInfo.id;
	}
	else
	{
		$('#resumePromptLi').removeClass('mui-hidden');
		return;
	}
	
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	//获取我的简历投递 记录
	var url = getRecruitListByResumeidUrl;
	ajax_to_server(url,options,getDeliveryListSuc,getDeliveryListFailed);
}

function getDeliveryListSuc(data)
{
	console.log("getDeliveryListSuc data:"+JSON.stringify(data));
	
	if((data.rscode && data.rscode == "1") || (!data || data.length == 0))
	{
		//showPromptInfo();
		mui.toast('没有获取到更多数据');
		if(deliveryCnt == 0)
		{
			$('#deliveryPromptLi').removeClass('mui-hidden');
			
		}
		return;
	}
		
	
	var deliveryFrag = document.createDocumentFragment();
	var info = {};
	for(var i in data)
	{
		info.publishuserid = data[i].recruituserid;
		info.recruitid = data[i].recruitid;
		info.organizationpic = data[i].recruituserorganizationpic;
		info.publishusername = data[i].recruitusername;
		info.recruitsubject = data[i].recruitsubject;
		info.location = data[i].recruitlocation;
		info.workperiod = data[i].recruitworkperiod;
		info.position = data[i].recruituserposition;
		info.salary = data[i].recruitsalary;
		info.organization = data[i].recruituserorganization;
			
		deliveryFrag.appendChild(NewCommonPositionLi(info));
		deliveryCnt++;
	}
	
	deliveryStartSn += data.length;
	//onlineAppointmentListUl.innerHTML = "";
	deliveryListUl.appendChild(deliveryFrag);
}

function getDeliveryListFailed(data)
{
	//console.log("getDeliveryListFailed data:"+JSON.stringify(data));
	mui.toast('网络问题，获取信息失败');
}

function initInviteList(startsn,count)
{
	console.log("initInviteList");
	
	var options = new Object();
	options.userid = loginUser.id;
	var basicInfo = JSON.parse(localStorage.getItem('zmzfangResumeBasicInfo'));
	if(basicInfo)
	{
		options.resumeid = basicInfo.id;
	}
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	//获取我的简历投递 记录
	var url = getRecruitListByRecommendUrl;
	ajax_to_server(url,options,getInviteListSuc,getInviteListFailed);
}

function getInviteListSuc(data)
{
	console.log("getInviteListSuc data:"+JSON.stringify(data));
	
	if(data)
	{
		if(data.length == 0)
		{
			//showPromptInfo();
			mui.toast('没有获取到更多数据');
			if(inviteCnt == 0)
			{
				$('#invitePromptLi').removeClass('mui-hidden');
				
			}
			return;
		}
		
		var inviteFrag = document.createDocumentFragment();
		
		
		for(var i in data)
		{
			inviteFrag.appendChild(NewCommonPositionLi(data[i]));
			inviteCnt++;
		}
		
		inviteStartSn += data.length;
		//onlineAppointmentListUl.innerHTML = "";
		inviteListUl.appendChild(inviteFrag);
	}
	else
	{
		mui.toast('获取信息失败：'+JSON.stringify(data));
	}
	
}

function getInviteListFailed(data)
{
	//console.log("getInviteListFailed data:"+JSON.stringify(data));
	mui.toast('网络问题，获取信息失败');
}

function pullupRefreshDelivery()
{
	console.log('pullupRefreshDelivery');
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		initDeliveryList(deliveryStartSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}

function pullupRefreshInvite()
{
	console.log('pullupRefreshInvite');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		initInviteList(inviteStartSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}