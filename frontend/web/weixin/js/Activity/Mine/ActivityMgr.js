mui.init({
	swipeBack: false
});

mui.ready(function() {
	//$('#mineLink').addClass('mui-active');
	$('.mui-content').Auth({'phone':true,'wechat':true,'openid':true});
	//在进入到当前页前，请确保用户已经注册，且手机号码不为空，避免后续多个页面进行校验
	//初始化连接事件
	initLinkEvent();
	
});


function initLinkEvent()
{
	console.log('initLinkEvent');
	
	//我发布的活动列表事件
	document.querySelector('#activityList').addEventListener('tap', function() {
		var dstUrl = './MyActivityList.html';
		mui.openWindow({
			url: dstUrl,
			id: 'MyActivityList.html'
		});
	}, false);
	
	//我参加的活动列表 事件
	document.querySelector('#applyedActivityList').addEventListener('tap', function() {
		var dstUrl = './ApplyedActivity.html';
		mui.openWindow({
			url: dstUrl,
			id: './applyedActivity.html'
		});
	}, false);
	
	//我收藏的活动列表事件
	document.querySelector('#favoriteActivityList').addEventListener('tap', function() {
		var dstUrl = './FavoriteActivity.html';
		mui.openWindow({
			url: dstUrl,
			id: 'FavoriteActivity.html'
		});
	}, false);
	
	//活动公司信息点击事件
	document.querySelector('#activityOrganization').addEventListener('tap', function() {
		var dstUrl = './ActivityOrganization.html';
		mui.openWindow({
			url: dstUrl,
			id: 'ActivityOrganization.html'
		});
	}, false);
	
	//发布活动
	document.querySelector('#publishActivity').addEventListener('tap', function() {
		var dstUrl = './Activity.html';
		mui.openWindow({
			url: dstUrl,
			id: 'Activity.html'
		});
	}, false);
		
	
}
