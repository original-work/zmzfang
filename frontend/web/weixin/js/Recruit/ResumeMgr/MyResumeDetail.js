var loginUser = null;
var resumeId = null;
var organization = '无';
var nativeplace = '无';
mui.init({
	swipeBack: false
});
			
mui.ready(function() {
	$('#mineLink').addClass('mui-active');
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	loginUser = JSON.parse(data);
	
	initResumeBasicInfo();//初始化基本信息
	//初始化微信分享  我的简历页面暂不需要分享
	//wxShare();
});
			
//增加基本信息按钮
mui('#noResumePromptDiv').on('tap', '#publishBasicInfo', function() {
	var type = 1;//1 表示新建 2 表示修改
	var dstUrl = './ResumeBasicInfo.html?type='+type;
	mui.openWindow({
		url: dstUrl,
		id: 'ResumeBasicInfo.html'
	});
});

//修改基本信息按钮
mui('#basicInfoDiv').on('tap', '#modifyBasicInfo', function() {
	var type = 2;//1 表示新建 2 表示修改
	var dstUrl = './ResumeBasicInfo.html?type='+type;
	mui.openWindow({
		url: dstUrl,
		id: 'ResumeBasicInfo.html'
	});
});
		
//增加工作信息按钮
mui('#workDiv').on('tap', '#publishWorkInfo', function() {
	var type = 1;//1 表示新建 2 表示修改
	var dstUrl = './ResumeWorkInfo.html?type='+type;
	mui.openWindow({
		url: dstUrl,
		id: 'ResumeWorkInfo.html'
	});
});

//修改工作信息按钮
mui('#workDiv').on('tap', '#modifyWorkInfo', function() {
	var type = 2;//1 表示新建 2 表示修改
	var dstUrl = './ResumeWorkInfo.html?type='+type+'&workId='+$(this).attr('workid');
	//将用户的工作信息写入到缓存中
	
	mui.openWindow({
		url: dstUrl,
		id: 'ResumeWorkInfo.html'
	});
});

//增加教育信息按钮
mui('#eduDiv').on('tap', '#publishEduInfo', function() {
	var type = 1;//1 表示新建 2 表示修改
	var dstUrl = './ResumeEduInfo.html?type='+type;
	mui.openWindow({
		url: dstUrl,
		id: 'ResumeEduInfo.html'
	});
});

//修改教育信息按钮
mui('#eduDiv').on('tap', '#modifyEduInfo', function() {
	var type = 2;//1 表示新建 2 表示修改
	var dstUrl = './ResumeEduInfo.html?type='+type+'&eduId='+$(this).attr('eduid');;
	
	//将用户的教育信息写入到缓存中
	
	mui.openWindow({
		url: dstUrl,
		id: 'ResumeEduInfo.html'
	});
});

		
//初始化简历基本信息
function initResumeBasicInfo()
{
	var optionObj = new Object();
	optionObj.userid = loginUser.id;
	var url = getResumeBasicInfoByUserIdUrl;
	ajax_to_server(url,optionObj,getResumeBasicInfoSuccess,getResumeBasicInfoFailed);

}
			
function getResumeBasicInfoSuccess(data)
{
	console.log('getResumeBasicInfoSuccess:data'+JSON.stringify(data));
	if(data == null || data == '')
	{
		//$("#noResumePromptDiv").removeClass('mui-hidden');
		//return;
		//没有获取到基本信息，则生成基本信息
		$("#basicInfoDiv").removeClass('mui-hidden');
		initBasicInfoDefault();
		return;
	}
	
	$("#basicInfoDiv").removeClass('mui-hidden');
	
	$('#headPic').attr('src',data.userheadpic);
	$('#realName').text(data.realname);
	$('#organization').text(data.organization);
	//$('#workCity').text(data.workcity);
	$('#homeCity').text(data.homecity);
	
	$('#age').text(data.age);
	$('#workPeriod').text(data.workperiod);
	
	$('#phone').text(data.phone);
	$('#education').text(data.education);
	$('#resumeDetail').text(data.resumedetail);
	localStorage.setItem('zmzfangResumeBasicInfo',JSON.stringify(data));
	resumeId = data.id;
	
	initResumeWorkInfo();
	initResumeEduInfo();
}
			
function getResumeBasicInfoFailed(errorThrown, options)
{
	mui.toast('获取我的简历信息失败');
}

//按照用户信息初始化基本信息
function initBasicInfoDefault()
{
	if(loginUser.agentflag == "1")
	{
		initAgentInfo();
	}
	else
	{
		saveBasicInfo();
	}
}

//初始化工作基本信息
function initResumeWorkInfo()
{
	var optionObj = new Object();
	optionObj.userid = loginUser.id;
	optionObj.resumeid = resumeId;
	var url = getResumeWorkInfoListUrl;
	ajax_to_server(url,optionObj,getResumeWorkInfoSuccess,getResumeWorkInfoFailed);

}
			
function getResumeWorkInfoSuccess(data)
{
	console.log('getResumeWorkInfoSuccess:data'+JSON.stringify(data));
	if(data == null)
	{
		mui.toast('获取工作经历信息失败'+JSON.stringify(data));
		return;
	}
	$("#workDiv").removeClass('mui-hidden');
	
	var workUl = $('#workUl');
	var firstFrag = document.createDocumentFragment();
	
	//有数据显示列表
	for(var i in data)
	{
		firstFrag.appendChild(NewCommonWorkInfoLi(data[i]));
	}

	workUl[0].appendChild(firstFrag);	
	localStorage.setItem('zmzfangResumeWorkInfo',JSON.stringify(data));
}
			
function getResumeWorkInfoFailed(errorThrown, options)
{
	mui.toast('获取我的简历信息失败');
}

//初始化教育经历基本信息
function initResumeEduInfo()
{
	var optionObj = new Object();
	optionObj.userid = loginUser.id;
	optionObj.resumeid = resumeId;
	var url = getResumeEduInfoListUrl;
	ajax_to_server(url,optionObj,getResumeEduInfoSuccess,getResumeEduInfoFailed);

}
			
function getResumeEduInfoSuccess(data)
{
	console.log('getResumeBasicInfoSuccess:data'+JSON.stringify(data));
	if(data == null)
	{
		mui.toast('获取教育经历信息失败'+JSON.stringify(data));
		return;
	}
	
	$("#eduDiv").removeClass('mui-hidden');
	var eduUl = $('#eduUl');
	var firstFrag = document.createDocumentFragment();
	
	//有数据显示列表
	for(var i in data)
	{
		firstFrag.appendChild(NewCommonEduInfoLi(data[i]));
	}

	eduUl[0].appendChild(firstFrag);	
	
	//$('#resumeDetail').text(data.resumedetail);
	localStorage.setItem('zmzfangResumeEduInfo',JSON.stringify(data));
}
			
function getResumeEduInfoFailed(errorThrown, options)
{
	mui.toast('获取我的简历信息失败');
}

function saveBasicInfo()
{
	/**
	userid	用户ID
	usertype	用户类型，0表示普通用户，1表示经纪人
	userheadpic	用户头像
	realname	姓名
	organization	目前工作单位
	city	目前工作城市
	homecity	籍贯
	workperiod	工作经验，年限
	age	年龄
	phone	联系方式
	resumedetail	求职附言

	**/
	
	var info = new Object();
	info.userid = loginUser.id;
	if(loginUser.agentflag == "1")
	{
		info.usertype = 2;
	}
	else
	{
		info.usertype = 1;
	}
	
		/**
	{"id":"10145","nickname":"chail","phone":"15002168836","picture":"http://www.zmzfang.com/weixin/img/headpic/201705251041343539.jpg","password":"","email":"chaileicsu@163.com","sex":"1","city":"上海市","realname":"chail","agentflag":"0","identitycard":"","expertflag":"1","srcflag":"3","totaltimes":"751","logintime":"2017-05-18 18:13:03","createtime":"2016-07-27 14:14:29","openid":"oWfKWsz1sL1IvkSoF6i5rsY-3xTE","wxunionid":"oW_4wuFdemWjc4gkgcOrR-hdzNXc","tags":"","validflag":"1","max_requirement":"1","max_supplyment":"2","havemsg":"122","activeregion":"","expertid":"20","datacompleterate":"94"}
	**/
	
	info.realname = loginUser.realname;
	info.userheadpic = loginUser.picture;
	
	//info.organization = $('#organization').val();
	info.city = loginUser.city;
	info.homecity = loginUser.city;
	
	info.age = "无";
	info.workperiod = "无";
	info.phone = loginUser.phone;
	
	info.position = "无";
	
	if(loginUser.agentflag == "1")
	{
		info.organization = organization;
		info.homecity = nativeplace;
	}
	else
	{
		info.organization = "无";
	}
	
	info.education = '无';
	info.resumedetail = '无';
	var url = addResumeBasicInfoUrl;
	ajax_to_server(url,info,saveBasicInfoSuc,saveBasicInfoFailed);
}

function saveBasicInfoSuc(data)
{
	console.log('saveBasicInfoSuc data:'+JSON.stringify(data));
	if(data && data.rscode == 0)
	{
		//mui.toast('保存信息成功');
		//mui.back();
		initResumeBasicInfo();//重新初始化页面
	}
	else
	{
		mui.toast('保存信息失败'+JSON.stringify(data));
	}
}

function saveBasicInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

function initAgentInfo()
{
	var options = new Object();
	options.id = loginUser.id;
	ajax_get_agent_detail(options,getAgentDetailSuc,getAgentDetailFailed);
}

function getAgentDetailSuc(data)
{
	console.log('getAgentDetailSuc data:'+JSON.stringify(data));
	if(data && data.organization)
	{
		organization = data.organization;
		nativeplace = data.nativeplace;
	}
	saveBasicInfo();
}

function getAgentDetailFailed(data)
{
	console.log("getAgentDetailFailed");
}