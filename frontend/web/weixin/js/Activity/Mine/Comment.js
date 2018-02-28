var user = null;
var activityId;

var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		activityId = getQueryStrFromUrl('activityId');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		activityId = getQueryStrFromUrl("activityId");
	});

}(mui, document));

//提交按钮上增加tap事件
document.querySelector('#commit').addEventListener('tap', function() {
	console.log('commit click');
	if(checkCommentInfo())
	{
		console.log('initCommentInfo');
		var options = new Object();
		
		options.activityid = activityId;
		options.userid = user.id;
		options.comment = byId("detail").value;
		var dstUrl = addActivityCommentUrl;
		ajax_to_server(dstUrl,options,addCommentSuc,addCommentFailed);
	}
}, false);


			
function addCommentSuc(data)
{
	console.log("addCommentSuc data:"+JSON.stringify(data));
	if(data.rscode == '0')
	{
		console.log("addCommentSuc rscode:0");
		//跳转到我的 页面
		mui.toast("您的评论已经提交成功");
		mui.back();
	}
	else
	{
		console.log("addCommentSuc data:"+JSON.stringify(data));
		mui.toast("网络原因，评论提交失败");
	}
}

function addCommentFailed(data)
{
	console.log("addCommentFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，评论提交失败");
}

function checkCommentInfo()
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
