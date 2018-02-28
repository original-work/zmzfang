var loginUser = null;
var expertInfo;
var mask = mui.createMask(callback);//callback为用户点击蒙版时自动执行的回调；
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
		
		expertInfo = JSON.parse(localStorage.getItem('zmzfangMyExpertInfo'));
		initWxShare();
	});

}(mui, document));

//增加微信分享处理
function initWxShare()
{
	var expertName = expertInfo.name;
	var expertId = expertInfo.expertid;
	//var link = 'http://www.zmzfang.com/weixin/Expert/User/AcceptInvite.html?name='+expertName+'&id='+expertId;
	var link = 'http://www.zmzfang.com/?r=door/scope&view=Expert/User/AcceptInvite&noPhoneNoJump&name='+expertName+'&id='+expertId;
	var imgUrl = 'http://www.zmzfang.com/assets/frontend/images/logo-common.jpg';
	var param = new Object();
	// param.getJssdkConfUrl = calledUrl;
	var title = expertName + '邀请您成为芝麻找房专家';
	var desc = '芝麻找房-服务买家的精准找房平台';
	
	param.title = title;
	param.desc = desc;
	param.link = link;
	param.imgUrl = imgUrl;
	wxShare(param);
}

function shareAppMessage()
{
	console.log('shareAppMessage');
}

//邀请按钮上增加tap事件
document.querySelector('#invite').addEventListener('tap', function() {
	mask.show();
	$('#maskDiv').removeClass('mui-hidden');
	$('#showDiv').addClass('mui-hidden');
}, false);

function callback()
{
	console.log('callback');	
	$('#maskDiv').addClass('mui-hidden');
	$('#showDiv').removeClass('mui-hidden');
	
}
