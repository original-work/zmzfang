var startSn = 0;
var globalCnt = 10;
var initparams = JSON.parse(sessionStorage.getItem('activity_homepage_index_params'));
mui.init({
	swipeBack: false,
	gestureConfig:{
			doubletap:true
	},
	
});
			
mui.ready(function() {
	
	if(initparams && initparams.count){
		initActivityInfo(0,initparams.count);//获取需求列表
		console.log('sessionStorage works')
	}else{
		initActivityInfo(0);
	}
				
	// initActivityInfo();//初始化活动列表
	//初始化微信分享  我的收藏页面不需要分享
	//wxShare();
	var shareSubject = '讲座，沙龙，会议，培训，业内活动都在这里!';
	var shareDetail = '芝麻找房喊你来参加活动!';
	wxShare({'title':shareSubject,"desc":shareDetail,'link':window.document.location.href})
});

mui('#activity').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefreshActivity
			}
		}	
	);
			
//增加列表中tap事件
mui('#activityUl').on('tap', '.activity-brief', function() {
	var activityId = this.getAttribute('activity-id');
    var activityPublishuserId = this.getAttribute('publishuser-id');
	var dstUrl = './ActivityDetail.html?activityId='+activityId+"&publishuserid="+activityPublishuserId;
	
	var offset = parseInt($(".mui-scroll").css('transform').split(",")[5]);
	sessionStorage.setItem("activity_homepage_index_params" , '{"count":'+startSn+',"offset":'+offset+'}');
				
			
	mui.openWindow({
		url: dstUrl,
		id: 'ActivityDetail.html'
	});
});

//增加活动管理按钮事件
document.querySelector('#activityMgrBtn').addEventListener('tap', function() {
	console.log('activityMgrBtn click');
	var dstUrl = './Mine/ActivityMgr.html';
	mui.openWindow({
		url: dstUrl,
		id: 'ActivityMgr.html'
	});
}, false);

//初始化活动列表
function initActivityInfo(start,count)
{	
	var options = new Object();
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	var url = getActivityListUrl;
	ajax_to_server(url,options,getActivitySuccess,getActivityFailed);

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
		prompt +=			'<div class="mui-text-center">暂无活动</div>';
		prompt +=			'</li>';
		activityUl.html(prompt);
		return;
	}
	
	//有数据显示列表
	for(var i in data.data)
	{
		firstFrag.appendChild(NewCommonActivityLi(data.data[i]));
	}
	
	if(startSn == 0){ //首次加载
		if(initparams && initparams.offset){
			console.log('scroll to '+initparams.offset);
			mui('#activity').pullRefresh().scrollTo(0,initparams.offset,0);
			sessionStorage.removeItem('activity_homepage_index_params')
		}
	}
	
	startSn += data.data.length;
	activityUl[0].appendChild(firstFrag);	
}
			
function getActivityFailed(errorThrown, options)
{
	mui.toast('获取活动信息失败');
}

function pullupRefreshActivity()
{
	console.log('pullupRefreshActivity');
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		initActivityInfo(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}