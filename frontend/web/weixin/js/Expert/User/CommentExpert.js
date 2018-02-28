var user = null;
var expertId;
var praise = '5';
var snId = '5';
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		expertId = getQueryStrFromUrl('expertId');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		showPrompt(snId);
	});

}(mui, document));

//提交按钮上增加tap事件
document.querySelector('#commit').addEventListener('tap', function() {
	console.log('commit click');
	if(checkCommentInfo())
	{
		console.log('initCommentInfo');
		var options = new Object();
		
		options.expertid = expertId;
		options.userid = user.id;
		options.comment = byId("detail").value;
		//计算点赞的个数 默认3个
		options.praisecnt = praise;
		ajax_add_comment(options,addCommentSuc,addCommentFailed);
	}
}, false);

//增加点赞事件
mui('#star').on('tap', '.favorite', function() {
	snId = this.getAttribute('sn');
	praise = this.getAttribute('praise');
	//console.log('snId:'+snId);
	//console.log('praise:'+praise);
	
	$(this).parent().children('.favorite').each(function(i){
    	if(i < snId)
    	{
    		//$(this).css('background-color', 'red');
    		$(this).removeClass("icon-fav-o");
			$(this).addClass("icon-fav");
    	}
    	else
    	{
    		$(this).addClass("icon-fav-o");
			$(this).removeClass("icon-fav");
    	}
 	});
	
	showPrompt(snId);
});
			
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

function showPrompt(data)
{
	var str = '';
	switch(data)
	{
		case '1':
			str = "不满意,对我没有帮助";
			break;
		case '2':
			str = "基本满意,对我略有帮助";
			break;
		case '3':
			str = "3星好评,对我有所帮助";
			break;
		case '4':
			str = "4星好评,对我很有帮助";
			break;
		case '5':
			str = "5星好评,对我帮助很大";
			break;
		default:
			break;
	}
	byId('prompt').innerText = str;
}
