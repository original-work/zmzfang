var area = '%';
var domain = '%';//1 政策，2贷款，3 交易税费 4 法律纠纷 5 市场行情
var globalCnt = 30;

var policyListUl = document.getElementById('policyListUl');
var loanListUl = document.getElementById('loanListUl');
var tradingListUl = document.getElementById('tradingListUl');
var lawListUl = document.getElementById('lawListUl');
var marketUl = document.getElementById('marketUl');

var startSn = 0;
//var policyStartSn = 0;
//var loanStartSn = 0;
//var tradingStartSn = 0;
//var lawStartSn = 0;
//var marketStartSn = 0;

var currentUl = tradingListUl;
var byId = function(id) {
	return document.getElementById(id);
};

(function($, doc) {
	mui.init({
		swipeBack: false,
		gestureConfig:{
			doubletap:true
		},
	});
	
	mui('#policy').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#loan').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#trading').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#law').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#market').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui.ready(function() {
		//$('#mineLink').addClass('mui-active');
		initExpertList();

	});
//	mui.back = function(){
//		mui.openWindow({
//			url: '../../test/expert.html'
//		});
//	};
	
}(mui, document));


mui('#policyListUl').on('tap', '.expert-brief', function() {
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = './ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
	
});

mui('#loanListUl').on('tap', '.expert-brief', function() {
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = './ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
	
});

mui('#tradingListUl').on('tap', '.expert-brief', function() {
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = './ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
});

mui('#lawListUl').on('tap', '.expert-brief', function() {
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = './ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
});

/*
$('#area').change(function(){ 
	//alert($(this).children('option:selected').val()); 
	var id=$(this).children('option:selected').val();//这就是selected的值 
	console.log('select area:'+id);
	area = id;
	
	policyStartSn = 0;
	loanStartSn = 0;
	tradingStartSn = 0;
	lawStartSn = 0;
	marketStartSn = 0;
	
	policyListUl.innerHTML = "";
	loanListUl.innerHTML = "";
	tradingListUl.innerHTML = "";
	lawListUl.innerHTML = "";
	marketListUl.innerHTML = "";
	
	initExpertList();
}) 
*/
//tap点击事件
//document.querySelector('#policyLink').addEventListener('tap', function() {
//	resetAllActive();
//	$('#policyLink').addClass('mui-active');
//	domain = '1';
//	hiddenAll();
//	$('#policy').removeClass('mui-hidden');
//	
//	currentUl = policyListUl;
//	
//	//没有数据时重启加载，有数据时只显示不通过网络获取
//	if(policyStartSn < globalCnt)
//	{
//		policyStartSn = 0;
//		policyListUl.innerHTML = '';
//		initExpertList();
//	}
//	
//}, false);

document.querySelector('#loanLink').addEventListener('tap', function() {
	resetAllActive();
	$('#loanLink').removeClass('mui-btn-grey');
	$('#loanLink').addClass('mui-btn-green');
	hiddenAll();
	$('#loan').removeClass('mui-hidden');
	
}, false);

document.querySelector('#tradingLink').addEventListener('tap', function() {
	resetAllActive();
	$('#tradingLink').removeClass('mui-btn-grey');
	$('#tradingLink').addClass('mui-btn-green');
	hiddenAll();
	$('#trading').removeClass('mui-hidden');
	
}, false);

document.querySelector('#lawLink').addEventListener('tap', function() {
	resetAllActive();
	$('#lawLink').removeClass('mui-btn-grey');
	$('#lawLink').addClass('mui-btn-green');
	//domain = '4';
	hiddenAll();
	$('#law').removeClass('mui-hidden');	
}, false);

//document.querySelector('#marketLink').addEventListener('tap', function() {
//	resetAllActive();
//	$('#marketLink').addClass('mui-active');
//	domain = '5';
//	hiddenAll();
//	$('#market').removeClass('mui-hidden');
//	
//	currentUl = marketListUl;
//	
//	//没有数据时重启加载，有数据时只显示不通过网络获取
//	if(marketStartSn < globalCnt)
//	{
//		marketStartSn = 0;
//		marketListUl.innerHTML = '';
//		initExpertList();
//	}
//	
//}, false);

function resetAllActive()
{
	//$('#policyLink,#loanLink,#tradingLink,#lawLink,#marketLink').removeClass('mui-active');
	$('#loanLink,#tradingLink,#lawLink').removeClass('mui-btn-green');
	$('#loanLink,#tradingLink,#lawLink').addClass('mui-btn-grey');
}

function hiddenAll()
{
	$('#policy,#loan,#trading,#law,#market').addClass('mui-hidden');
}

			
function initExpertList(startsn,count)
{
	console.log("initExpertList");
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	var options = new Object();
	if(area == '130000')
	{
		area = '%';
	}
	var start = arguments[0] ? arguments[0] : 0;
	var count = arguments[1] ? arguments[1] : globalCnt;
	
	options.activeregion = area;
	options.domain = domain;
	options.start = start;
	options.count = count;
	ajax_get_expert_list(options,getExpertListSuc,getExpertListFailed);
	//ajax_get_expert_list(options,getExpertListSuc,getExpertListFailed);
}

function getExpertListSuc(data)
{
	console.log("getExpertListSuc data:"+JSON.stringify(data));
	
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('获取专家列表失败');
		return;
	}
	if(data.rscode == '1')
	{
		mui.toast('没有更多的专家了');
		return;
	}
	
    var tradingFrag = document.createDocumentFragment();
    var loanFrag = document.createDocumentFragment();
    var lawFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		if(hasDomain(data[i].domain,'1') || hasDomain(data[i].domain,'3') || hasDomain(data[i].domain,'3'))
		{
			tradingFrag.appendChild(fillExpertListLi(data[i]));
		}
		if(hasDomain(data[i].domain,'2'))
		{
			loanFrag.appendChild(fillExpertListLi(data[i]));
		}
		if(hasDomain(data[i].domain,'4'))
		{
			lawFrag.appendChild(fillExpertListLi(data[i]));
		}
		
	}

	tradingListUl.appendChild(tradingFrag);
	loanListUl.appendChild(loanFrag);
	lawListUl.appendChild(lawFrag);
	startSn += data.length;
	//updateStartSn(data.length);
}

function getExpertListFailed(data)
{
	console.log("getExpertListFailed data:"+JSON.stringify(data));
}

function fillExpertListLi(data) 
{
	console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";

	var liContent = '';
	liContent += '<div id="expertBrief" class="expert-brief" expert-id="'+data.id+'" >';
	liContent += '	<div id="userPicBrief" style="position:relative;float:left;width:42px; height:42px; border-radius:50%; overflow:hidden;">';
	liContent += '		<img id="expertHeadPic" style="width:42px; height:42px; " src="'+data.headpicture+'" alt="个人头像">';
	liContent += '	</div>';
	liContent += '	<div style="margin-left:60px;">';
	liContent += '		<div>';
	liContent += '			<h5 style="position:relative;float:right;"><span id="scores">'+data.praisecnt+'</span>℃</h5>';
	liContent += '			<p id="domain"><span style="color:#666;">'+data.name+'</span> | <small>'+data.position+'</small></p>';
	liContent += '			<p>'+data.organization+'</p>';
	liContent += '		</div>';
	liContent += '	</div>	';
	liContent += '	<div class="expertisenDiv" style="margin-top:10px;padding:5px 10px;">';
	liContent += '		<p id="expertisen">'+data.expertisen+'</p>';
	liContent += '	</div>';
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
		//var sn = getStartSn();
		initExpertList(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}

//function updateStartSn(length)
//{
//	if(domain == '1')
//	{
//		policyStartSn += length;
//	}
//	else if(domain == '2')
//	{
//		loanStartSn += length;
//	}
//	else if(domain == '3')
//	{
//		tradingStartSn += length;
//	}
//	else if(domain == '4')
//	{
//		lawStartSn += length;
//	}
//	else if(domain == '5')
//	{
//		marketStartSn += length;
//	}
//}

//function getStartSn()
//{
//	if(domain == '1')
//	{
//		return policyStartSn;
//	}
//	else if(domain == '2')
//	{
//		return loanStartSn;
//	}
//	else if(domain == '3')
//	{
//		return tradingStartSn;
//	}
//	else if(domain == '4')
//	{
//		return lawStartSn;
//	}
//	else if(domain == '5')
//	{
//		return marketStartSn;
//	}
//}
