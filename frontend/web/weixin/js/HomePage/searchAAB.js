var globalCnt = 10;
var agentStartSn = 0;
var matchAgentUl = $('#matchAgentUl');
var loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));

mui.ready(function() {
	var keys = getQueryStrFromUrl('keys');
	var inputKeys = $('#keywords').text();
	$('#keywords').attr('placeholder' ,'请输入公司、区域或人名');
	//初始化热词
	initHotAgentKeys();
	//初始化事件
	initHotAgentEvent();
	beginSearch(0)
	initFlush();
});

function initFlush()
{
	mui('.mui-scroll-wrapper').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				// callback: window['pullupRefresh'+callback]
				callback: pullupRefresh
			}
		}	
	);
}

//搜索按钮事件
mui('header').on('tap', '#searchBtn', function() {
	var keys = $('#keywords').val().trim();
	history.replaceState({}, '', getNewUrl(location.href,"key",keys));
	beginSearch(0)
});

// function enterPress(e){ //传入 event     PC端键盘事件
// 	var e = e || window.event;
// 	if(e.keyCode == 13)
// 	{
// 		matchAgentUl.innerHTML = '';
// 		var keys = $("#keywords").val().trim();
// 		agentStartSn = 0;
// 		beginSearch(keys);
// 	}
// }

function beginSearch(startsn)
{
	if(!(getQueryStrFromUrl('key') || getQueryStrFromUrl('hot') || getQueryStrFromUrl('area'))){
		$('#hotAgentDiv').show();
		$('#hotApartmentDiv').show();
		$('#newComer').show();
		$('.mui-i-select-list').hide();
		$('#matchAgentDiv').hide();
		$('#noDataDiv').hide();
		$('.mui-scroll-wrapper').css('top','44px');
		return;
	}
	var start = arguments[0] ? arguments[0] : 0;
	if(start == 0){
		mui('.mui-scroll-wrapper').scroll().scrollTo(0,0,100);
		agentStartSn = 0
		$('#matchAgentUl').html('')
	}
	var searchUrl = "http://www.zmzfang.com/?r=search/search-agent";

	var option = 
	{
		homecity: loginUser?loginUser.city:'',
		city:city?city:sessionStorage.getItem('SA_city'),
		keys:decodeURI(getQueryStrFromUrl('key')),
		hotKeyId:getQueryStrFromUrl('hot'),
		start:start,
		area:getQueryStrFromUrl('area'),
		count:globalCnt
	};
	ajax_to_server(searchUrl,option,searchSuc,searchFailed);
}

function searchSuc(data)
{
	console.log("searchSuc");
	
	if(data == null)
	{
		mui.toast('网络异常，未获取到数据');
	}
	else
	{
		if(data == '')
		{
			if(agentStartSn == 0)
			{
				$('#hotAgentDiv').hide();
				$('#hotApartmentDiv').hide();
				$('#newComer').hide();
				$('#noDataDiv').show();
				$('#matchAgentDiv').hide();
				$('.mui-i-select-list').show();
				$('#noDataPrompt').text('没有找到匹配的经纪人，换个关键词试试');
				$('.mui-scroll-wrapper').css('top','88px');
			}
			else
			{
				mui.toast('没有更多数据了');
			}
				
		}
		else if(data != '' && data.length > 0)
		{
			$('#hotAgentDiv').hide();
			$('#hotApartmentDiv').hide();
			$('#newComer').hide();
			$('#noDataDiv').hide();
			$('.mui-i-select-list').show();
			$('#matchAgentDiv').show();
			$('.mui-scroll-wrapper').css('top','88px');
			handleAgent(data);
		}
	}
}

function searchFailed(data)
{
	console.log("searchFailed data:"+JSON.stringify(data));
}

function handleAgent(data)
{
	// data.sort(function(item1,item2){
	// 	if(item1.datacompleterate > item2.datacompleterate)
	// 		return -1;
	// 	else if(item1.datacompleterate < item2.datacompleterate)
	// 		return 1;
	// 	else
	// 		return 0;
			
	// });
	for(var i in data)
	{
		matchAgentUl.append(fillAgentListLi(data[i]));
	}
	agentStartSn += data.length;
	//查看经纪人详情
	$('.agent-info').on('tap' , function() {
		var userId = this.getAttribute('user-id');
		console.log('userId:'+userId);
		$('#keywords').blur();
		var dstUrl = '../Agent/AgentInfo.html?userId='+userId;
		
		mui.openWindow({
			url: dstUrl,
			id: 'AgentInfo.html'
		});
		
	});
}

function fillAgentListLi(data) 
{
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	var organization = data.organization?data.organization:'';
	var storeinfo = data.storeinfo ? data.storeinfo:'';
	
	var liContent = '<li class="mui-table-view-cell mui-media question-li">';
	liContent += '<div class="agent-info" user-id="'+data.userid+'">';
	liContent += '<div style="width:62px; height:62px; border-radius:50%; overflow:hidden;float:left;margin-top:10px;">';
	liContent += '<img style="width:62px; height:62px; " src="'+data.picture+'" alt="个人头像" />';
	liContent += '</div>';
	liContent += '<div class="mui-media-body  mui-navigate-right" style="padding-left:20px;">';
	liContent += '<h4 class="mui-ellipsis bid-user-nickname" style="margin-left: 0px;overflow: visible;"><a href="../Mine/User.html?userId='+data.userid+'">'+data.nickname+'</a></h4>';
	liContent += '<h5 class="" style="margin-right: 0px;">'+organization+' '+storeinfo+'</h5><span style="position: absolute;top: 9px;right: 24px;"></span>';
	
	if(data.position)
	{
		liContent += '<h5 class="" style="margin-right: 0px;">'+data.position+'</h5>';
	}
	if(data.workperiod)
	{
		liContent += '<h5 class="" style="margin-right: 0px;">从业年限'+data.workperiod+'年</h5>';
	}
	liContent += '</div>';	
	liContent += '<div style="clear:both"></div></li>';	
	return liContent;
}


function pullupRefresh()
{
	var self = this;
	setTimeout(function() {
		beginSearch(agentStartSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}

function initHotAgentKeys()
{
	//获取经济人hot key
	var getHotAgentKeysUrl = 'http://www.zmzfang.com/?r=sql-config/get-search-params';

	var option = 
	{
		keytype:1,
	};
	ajax_to_server(getHotAgentKeysUrl,option,getHotAgentKeysSuc,getHotAgentKeysFailed);

	//获取买什么房hot key

	var option = 
	{
		keytype:2,
	};
	ajax_to_server(getHotAgentKeysUrl,option,getHotApartmentKeysSuc,getHotApartmentKeysFailed);

	ajax_to_server('http://www.zmzfang.com/?r=user/last','',getNews);

}
function getNews(data){
	for(var i in data)
	{
		$('#newComerDiv').append(fillAgentListLi(data[i]));
	}
	//查看经纪人详情
	$('.agent-info').on('tap' , function() {
		var userId = this.getAttribute('user-id');
		console.log('userId:'+userId);
		$('#keywords').blur();
		var dstUrl = '../Agent/AgentInfo.html?userId='+userId;
		
		mui.openWindow({
			url: dstUrl,
			id: 'AgentInfo.html'
		});
		
	});
}

function getHotAgentKeysSuc(data)
{
	console.log("getHotAgentKeysSuc");
	if(data == null)
	{
		mui.toast('网络异常，未获取到数据');
	}
	else
	{
		var htmlStr = '';
		var count = data.length;
		for(var i in data)
		{
			htmlStr += '<span type="'+data[i].id+'" class="thd';
			if(i%3==2)
			{
				htmlStr += " active";
			}
			htmlStr += '">'+data[i].hotkey+'</span>';
			if(i%3==2 && count-i >=3)
			{
				htmlStr += "<div class='line'></div>";
			}
		}
		$('#hotKeyDiv').html(htmlStr); 
	}
}

function getHotAgentKeysFailed(data)
{
	console.log("getHotAgentKeysFailed data:"+JSON.stringify(data));
}


function getHotApartmentKeysSuc(data)
{
	console.log("getHotApartmentKeysSuc");
	if(data == null)
	{
		mui.toast('网络异常，未获取到数据');
	}
	else
	{
		var htmlStr = '';
		var count = data.length;
		for(var i in data)
		{
			htmlStr += '<span type="'+data[i].id+'" class="thd';
			if(i%3==2)
			{
				htmlStr += " active";
			}
			htmlStr += '">'+data[i].hotkey+'</span>';
			if(i%3==2 && count-i >=3)
			{
				htmlStr += "<div class='line'></div>";
			}
		}
		$('#hotApartmentKeyDiv').html(htmlStr); 
	}
}

function getHotApartmentKeysFailed(data)
{
	console.log("getHotApartmentKeysFailed data:"+JSON.stringify(data));
}


function initHotAgentEvent()
{
	$('.thd').on('tap',function(){	
		hotKeyType =  $(this).attr('type');
		$('#keywords').val('');
		history.replaceState({}, '', getNewUrl(location.href,"hot",hotKeyType));
		beginSearch(0);
	});
}
