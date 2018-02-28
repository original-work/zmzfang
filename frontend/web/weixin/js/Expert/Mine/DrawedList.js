var loginUser;
var startSn = 0;
var globalCnt = 30;
var historyListUl;
var accountInfo;

var byId = function(id) {
	return document.getElementById(id);
};
	
(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui.ready(function() {
		//$('#mineLink').addClass('mui-active');
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			loginUser = JSON.parse(data);
		}
		else
		{
			mui.toast("未获取到用户登陆信息");
			return;
		}
		historyListUl = document.getElementById('historyUl');
		accountInfo = JSON.parse(localStorage.getItem("zmzfangAccountInfo"));
		initDrawedList();
	});
	
	mui('.mui-scroll-wrapper').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
}(mui, document));

function initDrawedList(startsn,count)
{
	console.log("initDrawedList");
	
	var options = new Object();
	if(loginUser.expertflag == '0')
	{
		options.userid = loginUser.id;
		options.usertype = "1";
	}
	else if(loginUser.expertflag == '1')
	{
		options.userid = loginUser.expertid;
		options.usertype = "2";
	}
	else
	{
		return;
	}
	
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	//获取提现历史 记录
	ajax_to_server(getDrawedListUrl,options,getDrawedListSuc,getDrawedListFailed);
	//ajax_to_server(getAccountDetailUrl,options,getDrawedListSuc,getDrawedListFailed);
}

function getDrawedListSuc(data)
{
	console.log("getDrawedListSuc data:"+JSON.stringify(data));
	
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('没有获取到更多数据');
		return;
	}
	
	var historyFrag = document.createDocumentFragment();

	for(var i in data)
	{
		console.log('\n i:'+i);
		historyFrag.appendChild(fillDrawedListLi(data[i]));
	}
	startSn += data.length;
	
	historyListUl.appendChild(historyFrag);
}

function getDrawedListFailed(data)
{
	console.log("getDrawedListFailed data:"+JSON.stringify(data));
}

function fillDrawedListLi(data)
{
	console.log(JSON.stringify(data));

	var createtime = data.createtime;
	createtime = createtime.substr(0,10);
	createtime = createtime.replace(/-/g,'');
	//console.log('createtime:'+createtime);
		
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	liContent += '<div id="accountBrief" class="col-xs-12" order-id="'+data.id+'">';
	liContent += '		<div class="col-xs-3 mui-text-center">';
	liContent += '			<h5 id="sumdate">'+createtime+'</h5>';
	liContent += '		</div>';
			
	liContent += '		<div class="col-xs-2 mui-text-center">';
	liContent += '			<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '				<img id="pic" style="width:42px; height:42px; " src="http://www.zmzfang.com/weixin/img/servicetype/2004.jpg" alt="个人头像">';
	liContent += '			</div>';
	liContent += '		</div>';
	liContent += '		<div class="col-xs-7" style="padding-left:10px">';
	liContent += '			<div class="mui-text-left">';
	liContent += '				<h5><span id="fee">'+data.amount+'</span>元</h5>';
	liContent += '			</div>';
	liContent += '			<div class="mui-text-left">';
	liContent += '				<h5><span id="status">状态：'+DrawedStatus.getStatus(data.status)+'</span></h5>';
	liContent += '			</div>';
			
	liContent += '			<div style="clear:both">';
	liContent += '				<h5 style="">订单号:<span id="orderid">'+data.id+'</span></h5>';
	liContent += '			</div>';
	liContent += '		</div>';
			
	liContent += '	</div>	';
	
	ele.innerHTML = liContent;
	return ele;
}

function pullupRefresh()
{
	console.log('pullupRefresh');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		initDrawedList(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}
