var loginUser = null;
var expertInfo;
var expertName;
var expertId;
var subScribeFlag = false;
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		initUrlParam();
		//正常点击邀请链接进来，应该已经写了缓存zmzfangLoginUserInfo  也就应该知道用户是否关注了
		initUserInfo();
	});

}(mui, document));

//邀请按钮上增加tap事件
document.querySelector('#apply').addEventListener('tap', function() {
	//检查是否有手机号，有的话则打开申请页面，没有的话则打开注册页面，注册完成后跳转到申请页面
	if(!subScribeFlag)
	{
		mui.toast('请先关注芝麻找房公众号');
		return;
	}
	var extraParam = {
		refereename:expertName,
		refereeid:expertId
	};
	localStorage.setItem('zmzfangRefereenInfo',JSON.stringify(extraParam));
			
	loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
	var haveLoginUserInfoJumpUrl = "../../Expert/User/ApplyExpert.html";//继续打开本页，不跳转
	if(loginUser)
	{
		if(loginUser.phone && loginUser.phone !='')
		{
			mui.openWindow({
				url: haveLoginUserInfoJumpUrl
			});
		}
		else if(loginUser.phone && loginUser.phone.length != 11 || (!loginUser.phone))
		{
			var noPhoneRegAfterJumpUrl = "../Expert/User/ApplyExpert.html";
			localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
			mui.openWindow({
				url: '../../Mine/reg.html'
			});
		}
		else
		{
			alert('123123');
		}
	}
	else
	{
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/User/ApplyExpert';
		mui.openWindow({
				url: noPhoneRegAfterJumpUrl
		});
	}
				
}, false);

//返回按钮tap事件
document.querySelector('#home').addEventListener('tap', function() {
	mui.openWindow({
			url: '../../test/expert.html'
	});
}, false);


//增加url参数处理
function initUrlParam()
{
	 urlString = String(window.document.location.href);
	 expertName = decodeURI(getQueryStrFromUrl("name"));
	 expertId = decodeURI(getQueryStrFromUrl("id"));
	 if(expertName && expertName != ' ')
	 {
	 	console.log('name:'+ decodeURI(expertName));
	 	byId('expertName').innerText = decodeURI(expertName);
	 }
	 else
	 {
	 	byId('expertName').innerText = '芝麻找房平台';
	 }
	
}

 function checkLoginUserInfo(haveLoginUserInfoJumpUrl,noLoginUserInfoBindUrl)
 {
 	var loginUserInfo = localStorage.getItem('zmzfangLoginUserInfo');
	if(loginUserInfo)
	{
		if(haveLoginUserInfoJumpUrl)
		{
			mui.openWindow({
			url: haveLoginUserInfoJumpUrl
		});
		}
	}
	else
	{
		//alert('openid null:'+openid);
		//跳转
		mui.openWindow({
			url: noLoginUserInfoBindUrl
		});
	}
 }

function initUserInfo()
{
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	console.log(JSON.stringify(data));
	if(!!data){
		loginUser = JSON.parse(data);
	}
	
	if(loginUser && loginUser.expertid && loginUser.expertid != '')
	{
		$('#homeDiv').removeClass("mui-hidden");
		$('#applyDiv').addClass("mui-hidden");
	}
	initSubscribe();
}

function initSubscribe()
{
	console.log('initSubscribe');
	if(loginUser && loginUser.openid && loginUser.openid != '')
	{
		//根据openid 获取 uid ，来查看用户是否关注公众号
		var options = new Object();
		var url = 'http://www.zmzfang.com/?r=wechat/is-subscribe&openid=';
		url += loginUser.openid;
		ajax_to_server(url,options,getSubscribeInfoSuc,getSubscribeFailed);
	}
}

function getSubscribeInfoSuc(data)
{
	console.log("getSubscribeInfoSuc  " + JSON.stringify(data));
	if(data)
	{
		if(data.code == 0)
		{
			//无记录 表示没有关注  提示请先关注  申请按钮不可用  关注按钮 亮起来
		}
		else if(data.code == 1 && data.info.unionid)
		{
			//有记录 表示已经关注  
			subScribeFlag = true;
			console.log('getSubscribeInfoSuc unionid='+data.info.unionid);
		}
		
	}
	else
	{
		console.log("getSubscribeInfoSuc  返回异常");
		mui.toast('获取是否订阅返回空');
	}
}

function getSubscribeFailed(data)
{
	console.log("getSubscribeFailed  " + JSON.stringify(data));
	mui.toast('获取是否订阅消息失败');
}
