var byId = function(id) {
	return document.getElementById(id);
};

//initUserAndCheck();
mui.init({
	swipeBack: false
});
jQuery(window).unbind('beforeunload');
 window.onbeforeunload = null;
 
var touxiangword;
var userid;
var openid = null;
var loginUser = null;

//业务逻辑，如果没有openid，则头像显示默认图像，手机号填空，昵称填未登陆，增加绑定链接；
//点击链接，则跳转到绑定页面；
//初始化用户信息及检查

function initUserAndCheck()
{
	initCheckView('./expert.html','../Mine/reg.html');
	//
	loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
	if(!loginUser)
	{
		byId('displayAfterLoginDiv').classList.add("mui-hidden");
	}
	//			
	//没有用户信息时的处理方式
	var noPhoneRegAfterJumpUrl = "../test/expert.html";
	localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
	var haveLoginUserInfoJumpUrl = null;//继续打开本页，不跳转
	var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=test/expert';
	checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl);
}
//如果有openid，则根据openid 获取用户信息，同原有逻辑
mui.ready(function() {
	$('#mineLink').addClass('mui-active');
	//初始化界面用户信息
	initUserInfo();
	//初始化账户信息；
	initAccountInfo();
	//初始化连接事件
	initLinkEvent();
	//initMemu();
	//测试代码更新用户信息
	updateUserInfo();
	//更新专家信息
	initExpertDetail();
});

//			document.querySelector('#bind').addEventListener('tap', function() {
//  			var dstUrl = 'http://www.zmzfang.com/?r=door/scope&view=test/expert';
//  			var noPhoneRegAfterJumpUrl = "../test/expert.html";
//				localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
//				alert('dstUrl:'+dstUrl);
//  			window.location.href = dstUrl;
//			},false);
		
function initUserInfo()
{
	loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
	if(loginUser)
	{
		//更新头像，昵称等信息
		byId("headPic").src = loginUser.picture;
		byId("nickname").innerText = loginUser.nickname;
		byId("phone").innerText = loginUser.phone;
	}
	else
	{
		byId("nickname").innerText = '未绑定微信';
		//显示绑定按钮
		$('#bind').removeClass('mui-hidden');
		var noPhoneRegAfterJumpUrl = "../test/expert.html";
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
	}
	
}

function initLinkEvent()
{
	console.log('initLinkEvent');
	var noUserInfoJumpFlag = 1;
	var noLoginUserInfoBindUrl = null;
	var hasPhoneJumpUrl;
	var noPhoneRegAfterJumpUrl ;
	
	document.querySelector('#expertInfo').addEventListener('tap', function() {
		//noPhoneRegAfterJumpUrl = "../Expert/Mine/MyExpert.html";
		//hasPhoneJumpUrl = "../Expert/Mine/MyExpert.html";
		//checkLoginUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl,noUserInfoJumpFlag,noLoginUserInfoBindUrl);
		initCheckView('./expert.html','../Mine/reg.html');
		//			
		//没有用户信息时的处理方式
		var noPhoneRegAfterJumpUrl = "../Expert/Mine/MyExpert.html";
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		var haveLoginUserInfoJumpUrl = "../Expert/Mine/MyExpert.html";//继续打开本页，不跳转
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/MyExpert';
		checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl);
	}, false);
	
	document.querySelector('#appointmentList').addEventListener('tap', function() {
		//我问
		//noPhoneRegAfterJumpUrl = "../Expert/Mine/AppointmentList.html";
		//hasPhoneJumpUrl = "../Expert/Mine/AppointmentList.html";
		//checkLoginUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl,noUserInfoJumpFlag,noLoginUserInfoBindUrl);
		initCheckView('./expert.html','../Mine/reg.html');
		//			
		//没有用户信息时的处理方式
		var noPhoneRegAfterJumpUrl = "../Expert/Mine/AppointmentList.html";
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		var haveLoginUserInfoJumpUrl = "../Expert/Mine/AppointmentList.html";//继续打开本页，不跳转
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/AppointmentList';
		checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl);
	}, false);
	
	document.querySelector('#appointmentMeList').addEventListener('tap', function() {
		//noPhoneRegAfterJumpUrl = "../Expert/Mine/AppointmentMeList.html";
		//hasPhoneJumpUrl = "../Expert/Mine/AppointmentMeList.html";
		//checkLoginUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl,noUserInfoJumpFlag,noLoginUserInfoBindUrl);
		initCheckView('./expert.html','../Mine/reg.html');
		//			
		//没有用户信息时的处理方式
		var noPhoneRegAfterJumpUrl = "../Expert/Mine/AppointmentMeList.html";
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		var haveLoginUserInfoJumpUrl = "../Expert/Mine/AppointmentMeList.html";//继续打开本页，不跳转
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/AppointmentMeList';
		checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl);
	}, false);
	
	
	document.querySelector('#myQuestionListPaid').addEventListener('tap', function() {
		//noPhoneRegAfterJumpUrl = "../Expert/Mine/MyQuestionListPaid.html";
		//hasPhoneJumpUrl = "../Expert/Mine/MyQuestionListPaid.html";
		//checkLoginUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl,noUserInfoJumpFlag,noLoginUserInfoBindUrl);
		initCheckView('./expert.html','../Mine/reg.html');
		//			
		//没有用户信息时的处理方式
		var noPhoneRegAfterJumpUrl = "../Expert/Mine/MyQuestionListPaid.html";
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		var haveLoginUserInfoJumpUrl = "../Expert/Mine/MyQuestionListPaid.html";//继续打开本页，不跳转
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/MyQuestionListPaid';
		checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl);
	}, false);
	
	document.querySelector('#expertHome').addEventListener('tap', function() {
		//noPhoneRegAfterJumpUrl = "../Expert/expert.html";
		//hasPhoneJumpUrl = "../Expert/expert.html";
		//checkLoginUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl,noUserInfoJumpFlag,noLoginUserInfoBindUrl);
		var dstUrl = '../Expert/expert.html';
		mui.openWindow({
			url: dstUrl,
			id: 'expert.html'
		});
	}, false);

	document.querySelector('#myAccount').addEventListener('tap', function() {
		//noPhoneRegAfterJumpUrl = "../Expert/Mine/Account.html";
		//hasPhoneJumpUrl = "../Expert/Mine/Account.html";
		//checkLoginUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl,noUserInfoJumpFlag,noLoginUserInfoBindUrl);
		initCheckView('./expert.html','../Mine/reg.html');
		//			
		//没有用户信息时的处理方式
		var noPhoneRegAfterJumpUrl = "../Expert/Mine/Account.html";
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		var haveLoginUserInfoJumpUrl = "../Expert/Mine/Account.html";//继续打开本页，不跳转
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/Account';
		checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl);
	}, false);
	
	document.querySelector('#inviteExpert').addEventListener('tap', function() {
		var dstUrl = '../Expert/User/Invite.html';
		mui.openWindow({
			url: dstUrl,
			id: 'expert.html'
		});
	}, false);
	
}

function updateUserInfo()
{
	if(!loginUser)
	{
		console.log('updateUserInfo loginUser not exist');
		return;
	}
	
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	var user = JSON.parse(data);
	
	ajax_get_user_info({
		userid: user.id
	});
}

function getUserInfoSuccess(data)
{
	localStorage.setItem('zmzfangLoginUserInfo',JSON.stringify(data));
}

function initAccountInfo()
{
	if(!loginUser)
	{
		console.log('initAccountInfo loginUser not exist');
		return;
	}
	
	var options = new Object();
	if(loginUser.expertflag == '0')
	{
		options.userid = loginUser.id;
		options.usertype = "1";
	}
	else if(loginUser.expertflag == '1')
	{
		options.userid = loginUser.expertid;
		options.usertype = "2";
	}
	else
	{
		return;
	}
	ajax_to_server(getAccountUrl,options,getAccountSuc,getAccountFailed);
}

function getAccountSuc(data)
{
	console.log("getAccountSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		//mui.toast('获取账户信息失败');
		return;
	}
	var accountInfo = data;
	localStorage.setItem("zmzfangAccountInfo",JSON.stringify(accountInfo));
}

function getAccountFailed(data)
{
	console.log("getAccountFailed data:"+JSON.stringify(data));
	mui.toast('获取账户信息失败');
}

function initExpertDetail()
{
	console.log('initExpertDetail');
	if(!loginUser)
	{
		console.log('initExpertDetail loginUser not exist');
		return;
	}
	
	if(loginUser.expertid && loginUser.expertid != '')
	{
		var options = new Object();
		//需要获取专家id
		options.id = loginUser.expertid;
		ajax_get_expert_detail(options,getExpertDetailSuc,getExpertDetailFailed);
	}
	else
	{
		//显示申请专家按钮
		$('#applyExpertLi').removeClass('mui-hidden');
	}
}

function getExpertDetailSuc(data)
{
	console.log('getExpertDetailSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	
	localStorage.setItem('zmzfangMyExpertInfo',JSON.stringify(data));
	if(data.status == '0')
	{
		//刚申请，正在审核
		$('#expertInfoLi').removeClass('mui-hidden');
		$('#expertInfoLi').find('#myExpert').text('我的专家(申请中)');
	}
	else if(data.status == '1')
	{
		//审核已经通过
		//显示约见我的，我的专家
		$('#expertInfoLi').removeClass('mui-hidden');
		$('#appointmentMeLi').removeClass('mui-hidden');
		$('#inviteExpertLi').removeClass('mui-hidden');
	}
	else if(data.status == '2')
	{
		//审核被拒绝 需要补充资料
		$('#expertInfoLi').removeClass('mui-hidden');
		$('#expertInfoLi').find('#myExpert').text('我的专家(资料不全)');
	}
	else if(data.status == '3')
	{
		//重新提交 再次申请中
		$('#expertInfoLi').removeClass('mui-hidden');
		$('#expertInfoLi').find('#myExpert').text('我的专家(申请中)');
	}
	else if(data.status == '10')
	{
		//重新提交 再次申请中
		$('#expertInfoLi').removeClass('mui-hidden');
		$('#expertInfoLi').find('#myExpert').text('我的专家(被拒绝)');
	}
	
}

function getExpertDetailFailed(data)
{
	console.log('getExpertDetailFailed .data:'+JSON.stringify(data));
	mui.toast('网络原因，获取专家详情失败');
}
