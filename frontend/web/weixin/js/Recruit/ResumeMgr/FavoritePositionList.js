mui.init({
	swipeBack: false
});
			
mui.ready(function() {
	$('#mineLink').addClass('mui-active')
	initFavoriteInfo();//初始化收藏的需求列表
	//初始化微信分享  我的收藏页面不需要分享
	//wxShare();
});
			
//增加列表中tap事件
mui('#positionUl').on('tap', '.position-brief', function() {
	var positionId = this.getAttribute('position-id');
    var positionPublishuserId = this.getAttribute('publishuser-id');
	var dstUrl = '../PositionDetail.html?positionId='+positionId+"&publishuserid="+positionPublishuserId;
	mui.openWindow({
		url: dstUrl,
		id: 'PositionDetail.html'
	});
});
			
//初始化收藏的需求列表
function initFavoriteInfo()
{
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	var user = JSON.parse(data);
	
	var userid = user.id;
	console.log("userid:"+userid);
	
	var optionObj = new Object();
	optionObj.userid = userid;
	optionObj.start = "0";
	optionObj.count = "30";
	var url = getFavoritePositionUrl;
	ajax_to_server(url,optionObj,getFavoriteRequirementSuccess,getFavoriteRequirementFailed);

}
			
function getFavoriteRequirementSuccess(data)
{
	console.log('getFavoriteRequirementSuccess:data'+JSON.stringify(data));
	var requirementUl = $('#positionUl');
	var firstFrag = document.createDocumentFragment();
	
	//无数据显示提示
	if(!data || data.length == 0)
	{
		var prompt = '<li class="mui-table-view-cell mui-media">';
		prompt +=			'<div class="mui-text-center">暂无收藏</div>';
		prompt +=			'</li>';
		requirementUl.html(prompt);
		return;
	}
	
	//有数据显示列表
	for(var i in data)
	{
		var id=data[i].id;
		firstFrag.appendChild(NewCommonPositionLi(data[i]));
	}

	requirementUl[0].appendChild(firstFrag);	
}
			
function getFavoriteRequirementFailed(errorThrown, options)
{
	mui.toast('获取我的职位收藏失败');
}