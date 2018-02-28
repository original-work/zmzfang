var afterPaySucFun;
function listenAnswerSuc(data)
{
	console.log("listenAnswerSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		mui.toast('收听问题返回异常:'+JSON.stringify(data));
		return;
	}
	
	if(data.rscode == '0')
	{
		//已经付费了 进行播放
		play();
		return;
	}
	else if(data.orderid != null)
	{
		//进行支付
		mui.toast('已有订单，准备支付');
		console.log('begin pay click');
		var requestionInfo = new Object();
		currentOrderId = data.orderid;
		requestionInfo.orderid = data.orderid;
		requestionInfo.subject = '芝麻找房商品';
		requestionInfo.fee = data.fee;
		requestionInfo.code = 'aa';
		requestionInfo.openid = loginUser.openid;
		wepay(requestionInfo,modifyOrderStatus);
	}
}

function listenAnswerFailed(data)
{
	console.log("listenAnswerFailed data:"+JSON.stringify(data));
	mui.toast('收听问题返回异常:'+JSON.stringify(data));
}

function modifyOrderStatus()
{
	mui.toast("支付已成功");
	//跳转到支付页面
	//提示信息修改为点击播放
	byId('prompt').innerText = "点击播放";
		
//	var options = new Object();
//	options.userid = loginUser.id;
//	options.orderid = currentOrderId;
//	options.status = '1';
//	//alert("modifyOrderStatus options:"+JSON.stringify(options));
//	ajax_modify_pay_question_order_status(options,modifyOrderStatusSuc,modifyOrderStatusFailed);
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
		//跳转到支付页面
		//提示信息修改为点击播放
		byId('prompt').innerText = "点击播放";
	}
	else
	{
		console.log("modifyOrderStatusSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，问题提交失败");
	}
}

function modifyOrderStatusFailed(data)
{
	console.log("modifyOrderStatusFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，修改状态失败");
}




function wepay(options,paySucFun)
{
	console.log('wepay:options '+ JSON.stringify(options));
	//actionPayPublicAccount($WIDout_trade_no,$WIDsubject,$WIDtotal_fee,$WIDbody,$code,$WIDopenid)
	var wxpayurl = "http://www.zmzfang.com/index.php?r=wechat/pay-public-account";
	var sucFun = sendWepaySuc;
	var failFun = sendWepayFailed;
	afterPaySucFun = paySucFun;
	
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
			mui.toast("支付成功，准备修改状态");
			//alert('支付成功，准备修改状态');
			//alert('afterPaySucFun:'+afterPaySucFun);
			//byId("successDiv").classList.remove("mui-hidden");
			//修改状态
			afterPaySucFun();
			//modifyOrderStatus();
			
		} else {
			//alert("res1=" + JSON.stringify(res));
			mui.toast('支付未成功(取消或者异常)');
			//byId("failedDiv").classList.remove("mui-hidden");
			}
		}
	);
}
