var byId = function(id) {
	return document.getElementById(id);
};

var loginUser;
var accountInfo;
var account = 0;
var canDrawedAccount = 0;
mui.init();
			
mui.ready(function() {
	loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
	if(!loginUser)
	{
		console.log('用户未登陆');
	}
	accountInfo = JSON.parse(localStorage.getItem("zmzfangAccountInfo"));
	//账户余额
	byId("remainedProfit").innerText = accountInfo.remainedprofit;
	var remained = parseInt(accountInfo.remainedprofit)
	var locking = parseInt(accountInfo.lockingprofit);
	var limit = 2000;
	canDrawedAccount = remained > (limit-locking) ? (limit-locking):remained;
	//byId("canDrawed").innerText = canDrawedAccount;
})

//增加查看提现历史记录按钮事件
document.querySelector('#history').addEventListener('tap', function() {
	console.log('history click');
	var dstUrl = "../Mine/DrawedList.html";
	mui.openWindow({
		url: dstUrl,
		id: 'DrawedList.html'
	});
}, false);

//增加提现按钮事件
document.querySelector('#commit').addEventListener('tap', function() {
	console.log('commit click');
	//check
	account = byId('account').value;
	console.log('account:'+account);
	if(!isNaN(account) && parseInt(account) < 10)
	{
		mui.toast('提现金额需要大于或等于10元');
		return;	
	}
	
	if(!isNaN(account) && parseInt(account) < canDrawedAccount)
	{
		applyDrawed();
	}
	else
	{
		mui.toast('请输入合法金额');
	}
}, false);


function applyDrawed()
{
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
	options.account = account;
	ajax_to_server(applyDrawedUrl,options,applyDrawedSuc,applyDrawedFailed);
}

function applyDrawedSuc(data)
{
	console.log("applyDrawedSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('提现申请提交失败');
		return;
	}
	if(data.rscode == '0')
	{
		mui.toast('提现申请提交成功');
		mui.back();
		return;
	}
}

function applyDrawedFailed(data)
{
	console.log("applyDrawedFailed data:"+JSON.stringify(data));
	mui.toast('提现申请提交失败');
}



