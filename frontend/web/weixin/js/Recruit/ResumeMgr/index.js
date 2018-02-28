mui.init({
	swipeBack: false
});

mui.ready(function() {
	$('.mui-content').Auth({'phone':true,'wechat':true,'openid':true});
	$('#mineLink').addClass('mui-active');
	var loginUser = null;
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	loginUser = JSON.parse(data);
//	if(loginUser && loginUser.agentflag != 1){
//		mui.alert('对不起,只有经纪人才可以发布职位',null,null,
//		function(){window.location.href="../index.html";});
//	}
	//在进入到当前页前，请确保用户已经注册，且手机号码不为空，避免后续多个页面进行校验
	//初始化连接事件
	initLinkEvent();
	
});


function initLinkEvent()
{
	console.log('initLinkEvent');
	
	//投递列表事件
	document.querySelector('#deliveryList').addEventListener('tap', function() {
		var dstUrl = './DeliveryList.html';
		mui.openWindow({
			url: dstUrl,
			id: 'DeliveryList.html'
		});
	}, false);
	
	//收藏职位列表 事件
	document.querySelector('#favoritePositionList').addEventListener('tap', function() {
		var dstUrl = './FavoritePositionList.html';
		mui.openWindow({
			url: dstUrl,
			id: './FavoritePositionList.html'
		});
	}, false);
	
	//我的简历列表事件
	document.querySelector('#myResumeDetail').addEventListener('tap', function() {
		var dstUrl = './MyResumeDetail.html';
		mui.openWindow({
			url: dstUrl,
			id: 'MyResumeDetail.html'
		});
	}, false);
		
	
}
