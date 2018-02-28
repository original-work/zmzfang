var loginUser = null;
var expertInfo;
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			loginUser = JSON.parse(data);
		}
		
		expertInfo = JSON.parse(localStorage.getItem('zmzfangExpertInfo'));
		byId('fee').innerText = expertInfo.onlinecharge;
	});

}(mui, document));

//提交按钮上增加tap事件
document.querySelector('#commit').addEventListener('tap', function() {
	console.log('commit click');
	if(!loginUser)
	{
		mui.toast("未获取到您的登陆信息");
		return;
	}
	
	if(!expertInfo)
	{
		mui.toast("未获取到专家信息");
		return;
	}
	
	if(expertInfo.userid == loginUser.id)
	{
		mui.toast("你不能给自己提问");
		return;
	}
	
	if(checkQuestionInfo())
	{
		var options = new Object();
		
		options.expertid = expertInfo.expertid;
		options.userid = loginUser.id;
		options.questionsubject = byId("detail").value;
		options.questiondetail = byId("detail").value;
		//计算点赞的个数 默认3个
		if($('#commit').hasClass('allow'))
		{
			ajax_ask_question_online(options,askQuestionOnlineSuc,askQuestionOnlineFailed);
			$('#commit').removeClass('allow').addClass('not-allow');
			$('#commit').html('正在提交');
		}
		else
		{
			mui.toast('已经提交，请勿重复提交');
		}
	
	}
}, false);

function askQuestionOnlineSuc(data)
{
	console.log("askQuestionOnlineSuc data:"+JSON.stringify(data));
	if(data && data.rscode == 1)
	{
		console.log("askQuestionOnlineSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，问题提交失败:"+JSON.stringify(data));
		
	}
	else if(data && data.orderid)
	{
		console.log("askQuestionOnlineSuc");
		//跳转到我的 页面
		mui.toast("您的问题已经提交成功");
		//跳转到支付页面
		pay('芝麻找房商品',data.orderid,data.fee);
	}
	else
	{
		console.log("askQuestionOnlineSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，问题提交失败"+JSON.stringify(data));
	}
}

function askQuestionOnlineFailed(data)
{
	console.log("askQuestionOnlineFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，问题提交失败");
}

function checkQuestionInfo()
{
	var detail = byId("detail").value;
	if(detail == null || detail == '')
	{
		mui.toast("问题不能为空，请至少输入5个汉字");
	    return false;
	}
	var detailLen = getByteLen(detail.trim());
	//alert('detailLen:'+detailLen);
	if(detailLen < 10)
	{
		mui.toast("请至少输入5个字符");
	    return false;
	}	
	if(detailLen > 400)
	{
		mui.toast("字符超长，限200汉字");
	    return false;
	}	

	return true;
}

function pay(subject,orderid,fee)
{
	localStorage.setItem('zmzfangPayInfo',null);
	var dstUrl = '../Mine/MyPay.html';
	
	var payInfo = new Object();
	payInfo.orderid = orderid;
	payInfo.subject = subject;
	payInfo.fee = fee;
	payInfo.expertId = expertInfo.expertid;
	payInfo.jumpFlag = true;
	payInfo.ordertype = "1";//线上提问
	localStorage.setItem('zmzfangPayInfo',JSON.stringify(payInfo));
	
	mui.openWindow({
		url: dstUrl,
		id: 'MyPay.html'
	});
}
