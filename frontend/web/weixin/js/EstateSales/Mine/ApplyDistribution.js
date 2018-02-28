var user = null;
var estateId;
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		estateId = getQueryStrFromUrl('estateId');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		
	});

}(mui, document));

//提交按钮上增加tap事件
document.querySelector('#commit').addEventListener('tap', function() {
	console.log('commit click');
	if(checkApplyInfo())
	{
		
		var options = new Object();
		
		options.expertid = expertId;
		options.userid = user.id;
		options.comment = byId("detail").value;
		//计算点赞的个数 默认3个
		options.praisecnt = praise;
		ajax_add_comment(options,applySuc,applyFailed);
	}
}, false);


			
function applySuc(data)
{
	console.log("applySuc data:"+JSON.stringify(data));
	if(data.rscode == '0')
	{
		console.log("applySuc rscode:0");
		//跳转到我的 页面
		mui.toast("您的申请已经提交成功");
		mui.back();
	}
	else
	{
		console.log("applySuc data:"+JSON.stringify(data));
		mui.toast("网络原因，申请提交失败");
	}
}

function applyFailed(data)
{
	console.log("applyFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，申请提交失败");
}

function checkApplyInfo()
{
	var detail = byId("detail").value;
	if(detail == null || detail == '')
	{
		mui.toast("评价不能为空，请至少输入5个汉字");
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
