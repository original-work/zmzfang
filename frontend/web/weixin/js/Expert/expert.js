var user = null;
var area = '%';
var domain = '%';
var globalCnt = 5;
var hotExpertUl = document.getElementById('hotExpertUl');
var hotQuestionUl = document.getElementById('hotQuestionUl');
var hotExpertStartSn = 0;
var hotQuestionStartSn = 0;
var callback = 0;

var byId = function(id) {
	return document.getElementById(id);
};

jQuery(window).unbind('beforeunload');
 window.onbeforeunload = null;
//启用双击监听
(function($, doc) {
	mui.init({
		swipeBack: false,
		gestureConfig:{
			doubletap:true
		},
	});

	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
			console.log(JSON.stringify(data));
			if(!!data){
				user = JSON.parse(data);
		}
		byId('expertLink').classList.add('mui-active');
		//getAdvertisementList();//获取推荐专家列表
		getHotExpertList();//获取热门专家列表
		getHotQuestionList();//获取热门问题列表
		initWxShare();//处理分享接口
		initAd();//处理广告
	});

//增加广告处理
function initAd()
{
	mui('#slider').on('tap', '.mui-slider-item', function() {
		var promotionId = this.getAttribute('id');
		console.log('promotionId:'+promotionId);
		
		if('ad1' == promotionId)
		{
			var myurl = 'https://hi.okchexian.com/page/prize/show?code=5763869658E712DEF410B&channel=zhimazhaofang&dealer=zhimazhaofang#!/index';
			mui.openWindow({
				url: myurl,
				id: 'ads'
			});
		}
		
	});	
	
	//增加广告列表中tap事件--- 推荐专家
//	mui('#slider').on('tap', '.mui-slider-item', function() {
//		var expertId = this.getAttribute('sn');
//		console.log('expertId:'+expertId);
//		var dstUrl = './List/ExpertDetail.html?expertId='+expertId;
//		mui.openWindow({
//			url: dstUrl,
//			id: 'ExpertDetail.html'
//		});
//	});	


}

//	mui('.mui-scroll-wrapper').pullRefresh({
//		up: {
//				height:50,
//				contentrefresh: '正在加载...',
//				contentnomore:'没有更多数据了',
//				// callback: window['pullupRefresh'+callback]
//				callback: pullupRefresh
//			}
//		}	
//	);
}(mui, document));

//tap点击问题
$("#questionSubject,#moreQuestion").on('tap', function() {
	var dstUrl = '../Expert/List/QuestionAnserList.html';
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserList.html'
	});
});

//tap点击专家
$("#moreExpert,#expertSubject").on('tap', function() {
	var dstUrl = '../Expert/List/ExpertList.html';
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertList.html'
	});
});

//查看问题详情按钮
mui('#hotQuestionUl').on('tap', '.question-li', function() {
	var questionId = $(this).children('#questionBrief').attr('question-id');
	console.log('questionId:'+questionId);
	var dstUrl = './List/QuestionAnserDetail.html?questionId='+questionId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserDetail.html'
	});
	
});

//查看专家详情按钮
mui('#hotExpertUl').on('tap', '.expert-brief', function() {
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = './List/ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
	
});


function getAdvertisementList()
{
	var locationid=2;//首页位置id，用于获取滑动广告列表
	var options = new Object();
	options.locationid = locationid;
	ajax_to_server(getAdvertListUrl,options,getAdvertisementListSuccess,getAdvertisementListFailed);
}

function getAdvertisementListFailed(data)
{
	
}

function getHotExpertList(startsn,count)
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
	
    var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		firstFrag.appendChild(fillExpertListLi(data[i]));
	}

	hotExpertUl.appendChild(firstFrag);
	hotExpertStartSn += data.length;
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
	liContent += '			<h5 style="position:relative;float:right;"><span id="scores">'+data.praisecnt+'</span></h5>';
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
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		var sn = getStartSn();
		initExpertList(sn);
		self.endPullupToRefresh(false); 
	}, 1000);
}

function pullupRefresh()
{
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		if(callback){
			//专家
			getHotExpertList(hotExpertStartSn);
			//alert('in comment')
		}else{
			//问题
			getHotQuestionList(hotQuestionStartSn);
			//alert('in history')
		}
		self.endPullupToRefresh(false); 
	}, 1000);
}

function getHotQuestionList(startsn,count)
{
	var options = new Object();
	
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	options.userid = 0;
	options.expertid = 0;
	if(user && user.id)
	{
		options.userid = user.id;
	}
	if(user && user.expertid)
	{
		options.expertid = user.expertid; 
	}
	//计算点赞的个数 默认3个
	ajax_get_answer_list(options,getAnswerListSuc,getAnswerListFailed);
}

function getAnswerListSuc(data)
{
	console.log("getAnswerListSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		mui.toast('没有更多数据了');
		return;
	}
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		if(data[i].answer != null)
		{
			firstFrag.appendChild(fillQuestionListUlLi(data[i]));
		}
	}
	hotQuestionStartSn += data.length;
	hotQuestionUl.appendChild(firstFrag);
}

function getAnswerListFailed(data)
{
	console.log("getAnswerListFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，问题提交失败");
}

function fillQuestionListUlLi(data) 
{
	//console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media question-li";
	
	var questiondate = data.anserdate;
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
	liContent += '				<p>'+data.username+'</p>';
	liContent += '			</div>';
	liContent += '			<div class="col-xs-5">';
	liContent += '				<p class="publish-date mui-text-right mui-hidden" style="font-size:11px">'+getTimeAgo(time)+'</p>';
	liContent += '			</div>';
	liContent += '		</div>';
		
	liContent += '		<div class="question" style="clear:both;">';
	liContent += '			<p style="text-indent:1.5rem">'+data.questionsubject+'</p>';
	liContent += '		</div>';
	liContent += '	</div>';
		
	liContent += '	</div>';	

	liContent += '	<div id="anserBrief" class="col-xs-12">';
	liContent += '		<div id="listen" class="col-xs-6">';
	liContent += '			<div class="col-xs-6" id="promptDiv" style="font-size:11px;margin-top: 5px;text-align:right">';
	if(data.listenpermission == 1)
	{
		liContent += '				<span id="prompt">限免收听</span>';
	}
	else
	{
		liContent += '				<span id="prompt">1元收听</span>';
	}
	
	liContent += '			</div>';
	liContent += '			<div class="col-xs-6 listenDiv" id="" flag="0" question-userid="'+data.userid+'" question-expertid="'+data.expertid+'"> ';
	liContent += '				<button id="listenBtn" class="listen" type="button" class="mui-btn" style="width: 36px;height: 36px;background-size:100% 100%;border:0px;background-image:  url(../img/play.png);">	';							
	liContent += '				</button>';
	liContent += '				<audio style="display:none" id="musicBox"  question-id="'+data.id+'" src="'+data.answer+'" controls></audio>';
	liContent += '			</div>';
			
	
	liContent += '		</div>';
	liContent += '		<div id="listenCnt" class="col-xs-4">';
	liContent += '			<p style="font-size: 11px;margin-top: 5px"><span class="mui-badge mui-badge-danger" style="">'+data.listenedcnt+'</span>人收听</p>';
	liContent += '		</div>';
	liContent += '		<div id="expertBrief" class="col-xs-2 mui-text-center">';
	liContent += '			<div style="width:36px; height:36px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '				<img style="width:36px; height:36px; " src="'+data.expertpicture+'" alt="个人头像">';
	liContent += '			</div>';
	liContent += '			<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.expertname+'</div>';
			
	liContent += '		</div>';
	liContent += '	</div>	';
	
	ele.innerHTML = liContent;
	return ele;
}

//增加微信分享处理
function initWxShare()
{
	var link = "http://www.zmzfang.com/weixin/Expert/expert.html";
	var imgUrl = 'http://www.zmzfang.com/assets/frontend/images/logo-common.jpg';
	var param = new Object();
	// param.getJssdkConfUrl = calledUrl;
	var title = '业内专家 行家里手';
	var desc = '芝麻找房-房产交易垂直领域共享平台';
	
	param.title = title;
	param.desc = desc;
	param.link = link;
	param.imgUrl = imgUrl;
	wxShare(param);
}