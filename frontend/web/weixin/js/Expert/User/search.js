var type = 1;//1表示同时搜索专家和问题 2表示只搜索专家，3表示只搜索问题
var globalCnt = 10;
var expertStartSn = 0;
var questionStartSn = 0;
var matchExpertUl = document.getElementById('matchExpertUl');
var matchQuestionUl = document.getElementById('matchQuestionUl');

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
		byId('keywords').placeholder = '请输入感兴趣的专家';
	}
	else if(type ==3)
	{
		byId('keywords').placeholder = '请输入感兴趣的问题';
	}
	
	mui.scrollTo(0,500,function()
	{
		$('#keywords').focus();
		$('#keywords').trigger('tap');
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

mui('#matchExpertUl').on('tap', '.expert-brief', function() {
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = '../List/ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
	
});

//查看问题详情按钮
mui('#matchQuestionUl').on('tap', '.question-li', function() {
	var questionId = $(this).children('#questionBrief').attr('question-id');
	console.log('questionId:'+questionId);
	var dstUrl = '../List/QuestionAnserDetail.html?questionId='+questionId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserDetail.html'
	});
	
});

//更多专家按钮事件
mui('#matchExpertDiv').on('tap', '#moreExpertDiv', function() {
	var keys = byId('keywords').value;
	var dstUrl = '../User/search.html?type=2&keys='+keys;
	
	mui.openWindow({
		url: dstUrl,
		id: 'search.html'
	});
	
});

//更多问题按钮事件
mui('#matchQuestionDiv').on('tap', '#moreQuestionDiv', function() {
	var keys = byId('keywords').value();
	var dstUrl = '../User/search.html?type=3&keys='+keys;
	
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
		matchQuestionUl.innerHTML = '';
		matchExpertUl.innerHTML = '';
		//var keys = $("#keywords").val().trim();
		expertStartSn = 0;
		questionStartSn = 0;
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
		matchQuestionUl.innerHTML = '';
		matchExpertUl.innerHTML = '';
		var keys = $("#keywords").val().trim();
		expertStartSn = 0;
		questionStartSn = 0;
		beginSearch(keys);
	}
}

function beginSearch(keys,startsn)
{
	var start = arguments[1] ? arguments[1] : 0;
	var option = 
	{
		keys:keys,
		type:type,
		start:startsn,
		count:globalCnt
	};
	ajax_to_server(searchExpertAndQuestionUrl,option,searchSuc,searchFailed);
}

function searchSuc(data)
{
	console.log("searchSuc data:"+JSON.stringify(data));
	
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
			$('#matchExpertDiv').addClass('mui-hidden');
			$('#matchQuestionDiv').addClass('mui-hidden');
			if(data.expert == '' && data.question == '')
			{
				$('#noDataDiv').removeClass('mui-hidden');
				
				//mui.toast('未搜索到合适数据');
			}
			else
			{
				if(data.expert != '' && data.expert.length > 0)
				{
					handleExpert(data.expert);
					
				}
				if(data.question != '' && data.question.length > 0)
				{
					handleQuestion(data.question);
				}
			}
			
		}
		else if(type == 2)
		{
			if(data.expert == '')
			{
				if(expertStartSn == 0)
				{
					$('#noDataDiv').removeClass('mui-hidden');
					$('#noDataPrompt').text('没有找到匹配的专家，换个关键词试试');
					$('#matchExpertDiv').addClass('mui-hidden');
				}
				else
				{
					mui.toast('没有更多数据了');
				}
					
			}
			else if(data.expert != '' && data.expert.length > 0)
			{
				handleExpert(data.expert);	
			}
		}
		else if(type == 3)
		{
			if(data.question == '')
			{
				if(questionStartSn == 0)
				{
					$('#noDataDiv').removeClass('mui-hidden');
					$('#noDataPrompt').text('没有找到匹配的问题，换个关键词试试');
					$('#matchQuestionDiv').addClass('mui-hidden');	
				}
				else
				{
					mui.toast('没有更多数据了');
				}
				
			}
			else if(data.question != '' && data.question.length > 0)
			{
				handleQuestion(data.question);
			}
		}
		
	}
}

function searchFailed(data)
{
	console.log("searchFailed data:"+JSON.stringify(data));
}

function handleExpert(data)
{
	$('#noDataDiv').addClass('mui-hidden');
	$('#matchExpertDiv').removeClass('mui-hidden');
	if(type == 1)
	{
		$('#moreExpertDiv').removeClass('mui-hidden');
	}
	
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		firstFrag.appendChild(fillExpertListLi(data[i]));
		if(type == 1 && i > 5)
		{
			break;
		}
	}
	expertStartSn += data.length;
	matchExpertUl.appendChild(firstFrag);
	//matchExpertStartSn += data.length;
}

function fillExpertListLi(data) 
{
	console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	liContent += '<div id="expertBrief" class="col-xs-12 expert-brief" expert-id="'+data.id+'" >';
	liContent += '	<div id="userPicBrief" class="col-xs-2 mui-text-center">';
	liContent += '		<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img id="expertHeadPic" style="width:42px; height:42px; " src="'+data.headpicture+'" alt="个人头像">';
	liContent += '		</div>';
	liContent += '	</div>';
	liContent += '	<div class="col-xs-10">';
	liContent += '		<div>';
	liContent += '			<div class="col-xs-8">';
	liContent += '				<h5 id="domain" style="">'+data.name+' | '+data.organization+'</h5>';
	liContent += '			</div>';
	liContent += '			<div class="col-xs-4">';
	liContent += '				<p class="mui-text-right" style="font-size:11px"><span id="scores">'+data.praisecnt+'</span> <svg  class="icon" aria-hidden="true" style=""><use xlink:href="#icon-zan"></use></svg></p>';
	liContent += '			</div>';
	liContent += '		</div>';
		
	liContent += '		<div class="expertisenDiv" style="">';
	liContent += '			<p id="expertisen">'+data.expertisen+'</p>';
	liContent += '		</div>';
	liContent += '	</div>	';
	liContent += '</div>';
	
	ele.innerHTML = liContent;
	return ele;
}

function handleQuestion(data)
{
	$('#noDataDiv').addClass('mui-hidden');
	$('#matchQuestionDiv').removeClass('mui-hidden');
	if(type == 1)
	{
		$('#moreQuestionDiv').removeClass('mui-hidden');
	}
	
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		firstFrag.appendChild(fillQuestionListUlLi(data[i]));
		if(type == 1 && i > 5)
		{
			break;
		}
	}

	questionStartSn += data.length;
	matchQuestionUl.appendChild(firstFrag);
	//matchQuestionStartSn += data.length;
}

function fillQuestionListUlLi(data) 
{
	//console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media question-li";
	
	var questiondate = data.questiondate;
	questiondate = questiondate.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(questiondate);
	var time = date.getTime();
	
	var liContent = '';
	liContent += '<div id="questionBrief" class="col-xs-12" question-id="'+data.id+'">';
	liContent += '	<div id="userPicBrief" class="col-xs-2 mui-text-center">';
	liContent += '		<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img style="width:42px; height:42px; " src="'+data.userpicture+'" alt="个人头像">';
	liContent += '		</div>';
	liContent += '	</div>';
	liContent += '	<div class="col-xs-10" publishuser-id="5320" expert-id="474">';
	liContent += '		<div>';
	liContent += '			<div class="col-xs-7">';
	liContent += '				<p>'+data.usernickname+'</p>';
	liContent += '			</div>';
	liContent += '			<div class="col-xs-5">';
	liContent += '				<p class="publish-date mui-text-right" style="font-size:11px">'+getTimeAgo(time)+'</p>';
	liContent += '			</div>';
	liContent += '		</div>';
		
	liContent += '		<div class="question" style="">';
	liContent += '			<p>'+data.questionsubject+'</p>';
	liContent += '          <h5><span class="mui-badge mui-badge-danger" style="">'+data.listenedcnt+'</span>人收听</p></h5>';
	liContent += '		</div>';
	liContent += '	</div>';
		
	liContent += '	</div>';		
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
			beginSearch(keys,expertStartSn);
		}
		else if(type ==3)
		{
			beginSearch(keys,questionStartSn);
		}
				self.endPullupToRefresh(false); 
	}, 1000);
}
