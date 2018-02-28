mui.init({
	swipeBack: false
});
			
mui.ready(function() {
	initMyActivityInfo();//初始化我发布的活动列表
	//初始化微信分享  我的收藏页面不需要分享
	//wxShare();
});
			
//增加列表中tap事件
mui('#activityUl').on('tap', '.activity-brief', function() {
	var activityId = this.getAttribute('activity-id');
    var activityPublishuserId = this.getAttribute('publishuser-id');
	var dstUrl = './MyActivityDetail.html?activityId='+activityId+"&publishuserid="+activityPublishuserId;
	mui.openWindow({
		url: dstUrl,
		id: 'ActivityDetail.html'
	});
});
			
//初始化我发布的活动列表
function initMyActivityInfo()
{
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	var user = JSON.parse(data);
	
	var userid = user.id;
	console.log("userid:"+userid);
	
	var optionObj = new Object();
	optionObj.userid = userid;
	optionObj.start = "0";
	optionObj.count = "30";
	var url = getActivityListByUseridUrl;
	console.log('initMyActivityInfo:'+JSON.stringify(optionObj));
	ajax_to_server(url,optionObj,getActivitySuccess,getActivityFailed);

}
			
function getActivitySuccess(data)
{
	console.log('getActivitySuccess:data'+JSON.stringify(data));
	var activityUl = $('#activityUl');
	var firstFrag = document.createDocumentFragment();
	
	//无数据显示提示
	if(!data || data.length == 0)
	{
		var prompt = '<li class="mui-table-view-cell mui-media">';
		prompt +=			'<div class="mui-text-center">暂无发布</div>';
		prompt +=			'</li>';
		activityUl.html(prompt);
		return;
	}
	
	//有数据显示列表
	for(var i in data.data)
	{
		firstFrag.appendChild(NewCommonActivityLi(data.data[i]));
	}

	activityUl[0].appendChild(firstFrag);	
}
			
function getActivityFailed(errorThrown, options)
{
	mui.toast('获取活动信息失败');
}