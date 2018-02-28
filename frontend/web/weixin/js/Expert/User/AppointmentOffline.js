var loginUser = null;

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
		byId('fee').innerText = expertInfo.offlinecharge;
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
		options.appointmentsubject = byId("detail").value;
		//计算点赞的个数 默认3个
		ajax_appointment_offline(options,appointmentOfflineSuc,appointmentOfflineFailed);
	}
}, false);

function appointmentOfflineSuc(data)
{
	console.log("appointmentOfflineSuc data:"+JSON.stringify(data));
	if(data)
	{
		console.log("appointmentOfflineSuc rscode:0");
		//跳转到我的 页面
		mui.toast("您的问题已经提交成功");
		//跳转到支付页面
		mui.back();
	}
	else
	{
		console.log("appointmentOfflineSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，问题提交失败");
	}
}

function appointmentOfflineFailed(data)
{
	console.log("appointmentOfflineFailed data:"+JSON.stringify(data));
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
	if(detailLen > 200)
	{
		mui.toast("字符超长，限100汉字");
	    return false;
	}	

	return true;
}