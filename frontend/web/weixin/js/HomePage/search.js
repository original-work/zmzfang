var type = 1;
//类型，1表示需要求购需求，求租需求，求助需求；
//2 表示仅需要求购需求；
//3 表示仅需要求租需求；
//4 表示仅需求求助需求；

var globalCnt = 10;
var requirementStartSn = 0;
var rentStartSn = 0;
var helpStartSn = 0;
var matchRequirementUl = document.getElementById('matchRequirementUl');
var matchRentUl = document.getElementById('matchRentUl');
var matchHelpUl = document.getElementById('matchHelpUl');

var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		type = getQueryStrFromUrl('type');
		var keys = getQueryStrFromUrl('keys');
		var inputKeys = byId('keywords').value;
		initUi();
		if(keys && keys != '')
		{
			initSearch(keys);
		}
		else if(inputKeys && inputKeys != '')
		{
			initSearch(inputKeys);
			
		}
		initFlush();
	});
	
}(mui, document));

function initUi()
{
	if(type == 2)
	{
		byId('keywords').placeholder = '请输入求购需求关键字:地区/区域/小区名等';
	}
	else if(type ==3)
	{
		byId('keywords').placeholder = '请输入求租需求关键字:地区/区域/小区名等';
	}
	else if(type ==4)
	{
		byId('keywords').placeholder = '请输入求助关键字';
	}
	
	mui.scrollTo(0,500,function()
	{
		// $('#keywords').focus();
		// $('#keywords').trigger('tap');
	});
}

function initSearch(data)
{
	$('#keywords').val(decodeURI(data));
	beginSearch(decodeURI(data));
}

function initFlush()
{
	if(type == 1)
	{
		return;
	}
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

//查看求购需求详情
mui('#matchRequirementUl').on('tap', '.requirement-brief', function() {
	var requirementId = this.getAttribute('requirement-id');
	var city = this.getAttribute('city');
	console.log('requirementId:'+requirementId);
	$('#keywords').blur();
	var publishUserId = this.getAttribute('publishuser-id');
	var dstUrl = '../HomePage/RequirementDetail.html?requirementId='+requirementId+'&userId='+publishUserId+'&city='+city;
	
	mui.openWindow({
		url: dstUrl,
		id: 'RequirementDetail.html'
	});
	
});

//查看求租需求详情
mui('#matchRentUl').on('tap', '.requirement-brief', function() {
	var requirementId = this.getAttribute('requirement-id');
	var city = this.getAttribute('city');
	console.log('requirementId:'+requirementId);
	$('#keywords').blur();
	var publishUserId = this.getAttribute('publishuser-id');
	var dstUrl = '../HomePage/RentRequirementDetail.html?requirementId='+requirementId+'&userId='+publishUserId+'&city='+city;
	
	mui.openWindow({
		url: dstUrl,
		id: 'RequirementDetail.html'
	});
	
});

//查看求助需求详情
mui('#matchHelpUl').on('tap', '.help-brief', function() {
	var requirementId = this.getAttribute('help-id');
	
	console.log('requirementId:'+requirementId);
	$('#keywords').blur();
	var publishUserId = this.getAttribute('publishuser-id');
	var dstUrl = '../HomePage/HelpDetail.html?requirementId='+requirementId+'&userId='+publishUserId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'HelpDetail.html'
	});
	
});


//更多求购 按钮事件
mui('#matchRequirementDiv').on('tap', '#moreRequirementDiv', function() {
	var keys = byId('keywords').value;
	var dstUrl = './search.html?type=2&keys='+keys;
	
	mui.openWindow({
		url: dstUrl,
		id: 'search.html'
	});
	
});

//更多求租 按钮事件
mui('#matchRentDiv').on('tap', '#moreRentDiv', function() {
	var keys = byId('keywords').value;
	var dstUrl = './search.html?type=3&keys='+keys;
	
	mui.openWindow({
		url: dstUrl,
		id: 'search.html'
	});
	
});

//更多求助 按钮事件
mui('#matchHelpDiv').on('tap', '#moreHelpDiv', function() {
	var keys = byId('keywords').value;
	var dstUrl = './search.html?type=4&keys='+keys;
	
	mui.openWindow({
		url: dstUrl,
		id: 'search.html'
	});
	
});


//搜索按钮事件
mui('header').on('tap', '#searchBtn', function() {
	var keys = byId('keywords').value.trim();
	if(keys && keys != '')
	{
		matchRequirementUl.innerHTML = '';
		matchRentUl.innerHTML = '';
		matchHelpUl.innerHTML = '';
		//var keys = $("#keywords").val().trim();
		requirementStartSn = 0;
		rentStartSn = 0;
		helpStartSn = 0;
		beginSearch(keys);
	}
	else
	{
		mui.toast('请输入有效字符');
	}
	
});


function enterPress(e){ //传入 event
	var e = e || window.event;
	console.log('111111');
	if(e.keyCode == 13)
	{
		console.log('22222');
		//alert('aaaa');
		//document.getElementByIdx_x_x("txtAdd").focus();
		matchRequirementUl.innerHTML = '';
		matchRentUl.innerHTML = '';
		matchHelpUl.innerHTML = '';
		var keys = $("#keywords").val().trim();
		requirementStartSn = 0;
		rentStartSn = 0;
		helpStartSn = 0;
		beginSearch(keys);
	}
}

function beginSearch(keys,startsn)
{
	var searchRequirementUrl = 'http://www.zmzfang.com/?r=search/search-requirement';
	var start = arguments[1] ? arguments[1] : 0;
	var option = 
	{
		keys:keys,
		type:type,
		start:startsn,
		count:globalCnt
	};
	ajax_to_server(searchRequirementUrl,option,searchSuc,searchFailed);
}

function searchSuc(data)
{
	console.log("searchSuc data:"+JSON.stringify(data));
	$('#publishContent').addClass('mui-hidden');
	if(data == null)
	{
		console.log('a');
		mui.toast('网络异常，未获取到数据');
	}
	else
	{
		if(type == 1)
		{
			$('#noDataDiv').addClass('mui-hidden');
			$('#matchRequirementDiv').addClass('mui-hidden');
			$('#matchRentDiv').addClass('mui-hidden');
			$('#matchHelpDiv').addClass('mui-hidden');
			if(data.requirement == '' && data.rent == '' && data.help == '')
			{
				$('#noDataDiv').removeClass('mui-hidden');
				
				//mui.toast('未搜索到合适数据');
			}
			else
			{
				if(data.requirement != '' && data.requirement.length > 0)
				{
					handleRequirement(data.requirement);
					
				}
				if(data.rent != '' && data.rent.length > 0)
				{
					handleRent(data.rent);
				}
				if(data.help != '' && data.help.length > 0)
				{
					handleHelp(data.help);
				}
			}
			
		}
		else if(type == 2)
		{
			if(data.requirement == '')
			{
				if(requirementStartSn == 0)
				{
					$('#noDataDiv').removeClass('mui-hidden');
					$('#noDataPrompt').text('没有找到匹配的求购需求，换个关键词试试');
					$('#matchRequirementDiv').addClass('mui-hidden');
				}
				else
				{
					mui.toast('没有更多数据了');
				}
					
			}
			else if(data.requirement != '' && data.requirement.length > 0)
			{
				handleRequirement(data.requirement);	
			}
		}
		else if(type == 3)
		{
			if(data.rent == '')
			{
				if(rentStartSn == 0)
				{
					$('#noDataDiv').removeClass('mui-hidden');
					$('#noDataPrompt').text('没有找到匹配的求租需求，换个关键词试试');
					$('#matchRentDiv').addClass('mui-hidden');	
				}
				else
				{
					mui.toast('没有更多数据了');
				}
				
			}
			else if(data.rent != '' && data.rent.length > 0)
			{
				handleRent(data.rent);
			}
		}
		else if(type == 4)
		{
			if(data.help == '')
			{
				if(helpStartSn == 0)
				{
					$('#noDataDiv').removeClass('mui-hidden');
					$('#noDataPrompt').text('没有找到匹配的求助，换个关键词试试');
					$('#matchHelpDiv').addClass('mui-hidden');	
				}
				else
				{
					mui.toast('没有更多数据了');
				}
				
			}
			else if(data.help != '' && data.help.length > 0)
			{
				handleHelp(data.help);
			}
		}
	}
}

function searchFailed(data)
{
	console.log("searchFailed data:"+JSON.stringify(data));
}

function handleRequirement(data)
{
	$('#noDataDiv').addClass('mui-hidden');
	$('#matchRequirementDiv').removeClass('mui-hidden');
	if(type == 1)
	{
		$('#moreRequirementDiv').removeClass('mui-hidden');
	}
	
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		firstFrag.appendChild(fillRequirementListLi(data[i]));
		if(type == 1 && i > 5)
		{
			break;
		}
	}
	requirementStartSn += data.length;
	matchRequirementUl.appendChild(firstFrag);
}

function fillRequirementListLi(data) 
{
	console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var updatetime = data.updatetime;
	updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(updatetime);
	var time = getTimeAgo(date.getTime());

	var feeDom ='';
	
	var rate = data.dividerate.length >1?"分":"";
	if(data.agentfee>0){
		feeDom = '<p class="mui-badge mui-badge-danger" style="position:absolute;right:15px;top:26px;">'+rate+'佣&nbsp;'+data.agentfee+'</p>';
	}

	var subject = data.subject;
	
	

	var liContent = '';
	liContent += '<div id="requirementBrief" class="requirement-brief" publishuser-id="'+data.publishuserid+'" requirement-id="'+data.id+'" city="'+data.city+'">';
	liContent += '<div style="width:42px; height:60px;position:relative;overflow:hidden;float:left;">';
	liContent += '<img class="mui-media-object" src="'+data.picture+'" alt="个人头像" />';
	liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
	liContent += '</div>';
	liContent += '<div style="margin-left: 50px;overflow:hidden;">';
	liContent += '<p class="requirement-subject" style="margin-right: 50px;color:#000;">'+subject+'</p>';
	liContent += '<p><span>'+data.housetype+'室</span> - <span>'+data.budget+'万</span></p>';
	liContent += '<p style="text-overflow: ellipsis;overflow:hidden;">'+data.detail+'</p>';
	liContent += '</div>';
	liContent += feeDom+'<p class="publish-date" style="position:absolute;right:15px;top:5px">'+time+'</p>';
	liContent += '</div>';
	
	ele.innerHTML = liContent;
	return ele;
}

function handleRent(data)
{
	$('#noDataDiv').addClass('mui-hidden');
	$('#matchRentDiv').removeClass('mui-hidden');
	if(type == 1)
	{
		$('#moreRentDiv').removeClass('mui-hidden');
	}
	
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		firstFrag.appendChild(fillRentListUlLi(data[i]));
		
		if(type == 1 && i > 5)
		{
			break;
		}
	}

	rentStartSn += data.length;
	matchRentUl.appendChild(firstFrag);
}

function fillRentListUlLi(data) 
{
	//console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media rent-li";
	
	// console.log(data);
		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());

		var feeDom ='';
		
		var subject = data.subject;
		
		var liContent = '';
		liContent += '<div id="requirementBrief" class="requirement-brief" publishuser-id="'+data.publishuserid+'" requirement-id="'+data.id+'" city="'+data.city+'">';
		liContent += '<div style="width:42px; height:60px;position:relative;overflow:hidden;float:left;">';
		liContent += '<img class="mui-media-object" src="'+data.publishuserpicture+'" alt="个人头像" />';
		liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.publishusername+'</div>';
		liContent += '</div>';
		liContent += '<div style="margin-left: 50px;overflow:hidden;">';
		liContent += '<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+subject+'</p>';
		liContent += '<p><span>'+data.housetype+'室</span> - <span>'+data.budget+'</span>元/月</p>';
		liContent += '<p style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;">'+data.detail+'</p>';
		liContent += '</div>';
		liContent += feeDom+'<p class="publish-date" style="position:absolute;right:15px;top:12px">'+time+'</p>';
		liContent += '</div>';

		ele.innerHTML = liContent;
	return ele;
}

function handleHelp(data)
{
	$('#noDataDiv').addClass('mui-hidden');
	$('#matchHelpDiv').removeClass('mui-hidden');
	if(type == 1)
	{
		$('#moreHelpDiv').removeClass('mui-hidden');
	}
	
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		firstFrag.appendChild(fillHelpListUlLi(data[i]));
		if(type == 1 && i > 5)
		{
			break;
		}
	}

	helpStartSn += data.length;
	matchHelpUl.appendChild(firstFrag);
}

function fillHelpListUlLi(data) 
{
	//console.log(JSON.stringify(data));
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media rent-li";
	
	var updatetime = data.updatetime;
	updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(updatetime);
	var time = getTimeAgo(date.getTime());
	var feeDom ='';

	var subject = data.subject;
	var liContent = '';

	liContent += 	'<div id="helpBrief" class="help-brief" contactor="'+data.contactor+'" help-id="'+data.helpid+'" publishuser-id="'+data.publishuserid+'"> ';
	liContent += 		'<div class="col-xs-2 mui-text-center">';
	liContent += 			'<div style="width:60px; height:60px;  overflow:hidden;">';
	liContent += 				'<img style="width:45px; height:45px; border-radius:100%;" src="'+data.picture+'" alt="个人头像">';
	liContent += 				'<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
	liContent += 			'</div>';
	liContent += 		'</div>';				
	liContent += 		'<div class="col-xs-10">';
	liContent += 			'<div>';
	liContent += 				'<div class="col-xs-7 mui-text-left">';
	liContent += 					'<p><span>悬赏</span> - <span>红包'+data.rewardfee+'元</span></p>';
	liContent += 				'</div>';
	liContent += 				'<div class="col-xs-5 mui-text-right">';
	liContent += 					'<p class="publish-date" style="">'+time+'</p>';
	liContent += 				'</div>';			
	liContent += 			'</div>';
	liContent += 			'<div>';
	liContent += 				'<div class="col-xs-9 mui-text-left">';
	liContent += 					'<p id="detail"><span>求助</span> - <span>'+data.forhelpsubject+data.forhelpdetail+'</span></p>';
	liContent += 				'</div>';
	liContent += 				'<div class="col-xs-3 mui-text-right">';
	liContent += 					'<p class="reply-times" style="">'+data.replycnt+'条回复</p>';
	liContent += 				'</div>';
	liContent += 			'</div>';

	liContent += 		'</div>';	
	liContent += 	'</div>';

	ele.innerHTML = liContent;
	return ele;
}

function pullupRefresh()
{
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		keys = $("#keywords").val().trim();
		if(type == 2)
		{
			beginSearch(keys,requirementStartSn);
		}
		else if(type ==3)
		{
			beginSearch(keys,rentStartSn);
		}
		else if(type ==4)
		{
			beginSearch(keys,helpStartSn);
		}
		
		self.endPullupToRefresh(false); 
	}, 1000);
}

function initHotAgentEvent()
{
	$('.recommend').on('tap',function(){	
		var skill =  $(this).text();
	});
}
