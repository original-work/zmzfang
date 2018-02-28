var user = null;
var type = 0;
var startSn = 0;
var globalCnt = 30;
var colleaguesCnt = 0;
var userId = 0;
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui('#colleaguesListDiv').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		initUI();
		initColleaguesList();
	});
	
}(mui, document));

//查看经纪人详情
mui('#colleaguesListUl').on('tap', '.bid-info', function() {
	var userId = this.getAttribute('user-id');
	console.log('userId:'+userId);
	
	var dstUrl = '../../Agent/AgentInfo.html?userId='+userId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'AgentInfo.html'
	});
	
});

function initColleaguesList(startsn,count)
{
	var options = new Object();
	
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	//options.userid = user.id;
	
	userId = getQueryStrFromUrl("userId");
	console.log('initColleaguesList userId:'+userId);
	if(userId)
	{
		options.userid = userId;
	}
	else
	{
		options.userid = user.id;
	}
	
	var dstUrl = getColleagueUrl;
	if(type == 2)
	{
		dstUrl = getCompetitorUrl;
	}
	
	ajax_to_server(dstUrl,options,getColleaguesListSuc,getColleaguesListFailed);
}

function getColleaguesListSuc(data)
{
	console.log("getColleaguesListSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		mui.toast('没有更多数据了');
		if(colleaguesCnt == 0)
		{
			$('#nodataPromptLi').removeClass('mui-hidden');	
		}
		return;
	}
	
	// var colleaguesListUl = document.getElementById('colleaguesListUl');
	var colleaguesListUl = $('#colleaguesListUl');
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		//console.log('\n i:'+i);
		firstFrag.appendChild(fillColleaguesListUlLi(data[i]));	
	}
	startSn += data.length;
	colleaguesCnt += data.length;
	
	
	colleaguesListUl.html(firstFrag);
}

function getColleaguesListFailed(data)
{
	console.log("getColleaguesListFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，获取信息失败");
}

function fillColleaguesListUlLi(data) 
{
	//console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media question-li";
	
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	var liContent = '';
	liContent += '<div id="bidInfo" class="bid-info" user-id="'+data.userid+'">';
	liContent += '<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;float:left;">';
	liContent += '<a href="../../Mine/User.html?userId='+data.userid+'"><img style="width:42px; height:42px; " src="'+data.picture+'" alt="个人头像" /></a>';
	liContent += '</div>';
	liContent += '<div class="mui-media-body" style="padding-left:10px;">';
	liContent += '<h4 class="mui-ellipsis bid-user-nickname" style="margin-left: 0px;overflow: visible;"><a href="../Mine/User.html?userId='+data.userid+'&type=1">'+data.nickname+'</a></h4>';
	liContent += '<h5 class="" style="margin-right: 0px;">'+data.organization+'</h5><span style="position: absolute;top: 9px;right: 24px;"><a href="../Message/im-chat.html?id='+data.userid+'&nickname='+data.nickname+'"><span class="mui-icon mui-icon-chatboxes"></span></a></span>';
	if(data.position)
	{
		liContent += '<h5 class="" style="margin-right: 0px;">'+data.position+'</h5>';
	}
	liContent += '<h5 class="" style="margin-right: 0px;">从业年限'+data.workperiod+'年</h5>';
	liContent += '</div>';	
	
	ele.innerHTML = liContent;
	return ele;
}

function pullupRefresh()
{
	console.log('pullupRefresh');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		initColleaguesList(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}

function initUI()
{
	type = getQueryStrFromUrl('type');//type 1表示获取同事，2表示获取竞争对手
	console.log('type:'+type);
	if(type == 2)
	{
		$('#title').text('竞争对手');
	}
}

