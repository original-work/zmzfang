var byId = function(id) {
	return document.getElementById(id);
};

var requestionInfo = new Object();
var payParameter = {};
var loginUser;
var accountInfo;
var payInfo;

mui.init();
			
mui.ready(function() {
	loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
	if(!loginUser)
	{
		console.log('用户未登陆');
	}
	initAccountInfo();
	//accountInfo = JSON.parse(localStorage.getItem("zmzfangAccountInfo"));
	payInfo = JSON.parse(localStorage.getItem("zmzfangPayInfo"));
	initPayInfo();
})

//微信支付按钮上增加tap事件
document.querySelector('#commit').addEventListener('tap', function() {
	
	if(!loginUser)
	{
		mui.toast('用户未登陆');
		return;
	}
	
	//console.log('wxopenid:'+wxopenid);
	if(loginUser.openid == undefined)
	{
		mui.toast('用户openid不存在');
		return;
	}
	
	console.log('commit click');
	requestionInfo.orderid = payInfo.orderid;
	requestionInfo.subject = '芝麻找房商品';
	requestionInfo.fee = payInfo.fee;
	requestionInfo.code = 'aa';
	requestionInfo.openid = loginUser.openid;
	wepay(requestionInfo);
}, false);

//账户支付按钮上增加tap事件
document.querySelector('#accountPay').addEventListener('tap', function() {
	if(!loginUser || !accountInfo)
	{
		mui.toast('用户未登陆');
		return;
	}
	
	console.log('accountPay click');
	//再次确认 支付金额 是否 小于账户余额
	if(parseInt(payInfo.fee) < parseInt(accountInfo.remainedprofit))
	{
		var str = "确认使用您的账户付款 " + payInfo.fee;
		str += "元";
		if(confirm(str))
		{
			payUseAccount();
		}
		
	}
}, false);


function initPayInfo()
{
	byId("orderid").innerText = payInfo.orderid;
	byId("fee").innerText = payInfo.fee;
	//账户余额等于0 继续隐藏不显示
	if(accountInfo && parseInt(accountInfo.remainedprofit) > 0)
	{
		$('#accountPayDiv').removeClass('mui-hidden');
		byId('account').innerText = accountInfo.remainedprofit;
		//需要支付金额 小于账户余额 则标记 账户支付按钮 可用
		if(parseInt(payInfo.fee) <= parseInt(accountInfo.remainedprofit))
		{
			$('#accountPay').removeClass('mui-disabled');
			$('#accountPay').removeClass('mui-btn-grey');
			$('#accountPay').addClass('mui-btn-green');
		}	 
	}
}

function wepay(options)
{
	console.log('wepay:options '+ JSON.stringify(options));
	//actionPayPublicAccount($WIDout_trade_no,$WIDsubject,$WIDtotal_fee,$WIDbody,$code,$WIDopenid)
	var wxpayurl = "http://www.zmzfang.com/index.php?r=wechat/pay-public-account";
	var sucFun = sendWepaySuc;
	var failFun = sendWepayFailed;
	
	wxpayurl += "&WIDout_trade_no=" + options.orderid;
	wxpayurl += "&WIDsubject=" + options.subject;
	wxpayurl += "&WIDtotal_fee=" + options.fee;
	wxpayurl += "&WIDbody=" + options.subject;
	wxpayurl += "&code=" + options.code;
	wxpayurl += "&WIDopenid=" + options.openid;
	
	jQuery.ajax(wxpayurl, {
		data: JSON.stringify(options),
		dataType: 'json', //服务器返回json格式数据
		type: 'post', //HTTP请求类型
		timeout: 3000, //超时时间设置为10秒；
		async: false,
		success: function(data) {
			sucFun(data);
		},
		error: function(xhr, type, errorThrown) {
			//addReportFailed(errorThrown);
			failFun(errorThrown);
		}
	});
}

function sendWepaySuc(data)
{
	console.log("sendWepaySuc data:"+JSON.stringify(data));
	console.log("sendWepaySuc data.appId:"+data.appId);
	
	if(data.appId)
	{
		payParameter = data;
		console.log("aaaaaaaaaaaaaa."+payParameter.appId);
		//alert('a');
		if (typeof WeixinJSBridge == "undefined") {
			console.log("bbbbbbbbbbbbbbbbbbb");
			//alert('b');
			if (document.addEventListener) {
				document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
			} else if (document.attachEvent) {
				document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
				document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
			}
		} else {
			//alert('c');
			console.log("ccccccccccc");
			onBridgeReady();
		}
	}
	else
	{
		mui.toast('支付异常 appid为空');
	}
}

function sendWepayFailed(data)
{
	console.log("sendWepayFailed data:"+JSON.stringify(data));
}

function onBridgeReady() {
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest', {
		"appId": payParameter.appId,
		"timeStamp": payParameter.timeStamp.toString(),
		"nonceStr": payParameter.nonceStr,
		"package": payParameter.package,
		"signType": payParameter.signType,
		"paySign": payParameter.paySign
	},
	function(res) {
		//alert("appId="+payParameter.appId);
		//alert("payParameter" + JSON.stringify(payParameter));

		if (res.err_msg == "get_brand_wcpay_request:ok") {
			//alert("res="+JSON.stringify(res));
			//alert('wcpay ok');
			//byId("successDiv").classList.remove("mui-hidden");
			//发送修改状态按钮
			//跳转到专家详情页
			//mui.toast("支付成功，准备修改状态");
			paySucback();
			//modifyOrderStatus();
			
		} else {
			//alert("支付异常：res1=" + JSON.stringify(res));
			mui.toast('支付未成功(取消或者异常)');
			//byId("failedDiv").classList.remove("mui-hidden");
			}
		}
	);
}

function modifyOrderStatus()
{
	var options = new Object();
	options.expertid = payInfo.expertId;
	options.orderid = payInfo.orderid;
	options.status = '1';
	if(payInfo.ordertype == OrderType.getType('APPOINTMENT_OFFLINE'))
	{
		options.status = '2';
	}
	
	ajax_modify_order_status(options,modifyOrderStatusSuc,modifyOrderStatusFailed);
}

function modifyOrderStatusSuc(data)
{
	console.log("modifyOrderStatusSuc data:"+JSON.stringify(data));
	//alert("modifyOrderStatusSuc data:"+JSON.stringify(data));
	if(data && data.rscode == '0')
	{
		console.log("modifyOrderStatusSuc");
		//跳转到我的 页面
		mui.toast("支付已成功");
		//跳转到原有页面
		if(payInfo.jumpFlag)
		{
			//返回2页到专家详情页
			window.history.go(-2);
		}
		else
		{
			mui.back();
		}
	}
	else
	{
		console.log("modifyOrderStatusSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，支付状态修改失败:"+JSON.stringify(data));
	}
}

function modifyOrderStatusFailed(data)
{
	console.log("modifyOrderStatusFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，修改状态失败");
}

function payUseAccount()
{
	console.log("payUseAccount");
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
		mui.toast('用户信息不正常');
		return;
	}

	if(payInfo.ordertype == '1')
	{
		options.servicetype = '2001';//线上提问支出
		options.subject = '线上提问支出';
	}
	else if(payInfo.ordertype == '2')
	{
		options.servicetype = '2002';//线下约见支出
		options.subject = '线下约见支出';
	}
	else
	{
		mui.toast('业务类型不正常');
		return;
	}
	
	options.ordertype = payInfo.ordertype;
	options.orderid = payInfo.orderid;
	options.fee = payInfo.fee;
	
	
	console.log('options:'+JSON.stringify(options));
	//使用账户支付
	ajax_to_server(payUseAccountUrl,options,payUseAccountSuc,payUseAccountFailed);
}

function payUseAccountSuc(data)
{
	console.log("payUseAccountSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('支付未成功.error:'+JSON.stringify(data));
		return;
	}
	
	if(data.rscode == '0')
	{
		mui.toast('使用账户支付成功');
		if(payInfo.jumpFlag)
		{
//			var dstUrl = '../List/ExpertDetail.html?expertId='+payInfo.expertId;
//			mui.openWindow({
//				url: dstUrl,
//				id: 'ExpertDetail.html'
//			});
			//返回2页到专家详情页
			window.history.go(-2);
		}
		else
		{
			mui.back();
		}
	}
	
}

function payUseAccountFailed(data)
{
	console.log("payUseAccountFailed data:"+JSON.stringify(data));
	mui.toast('支付未成功.error:'+JSON.stringify(data));
}

function paySucback()
{
	mui.toast("支付已成功");
	//跳转到原有页面
	if(payInfo.jumpFlag)
	{
		//返回2页到专家详情页
		window.history.go(-2);
	}
	else
	{
		mui.back();
	}
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
	accountInfo = data;
	localStorage.setItem("zmzfangAccountInfo",JSON.stringify(accountInfo));
}

function getAccountFailed(data)
{
	console.log("getAccountFailed data:"+JSON.stringify(data));
	mui.toast('获取账户信息失败');
}