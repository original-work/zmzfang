var expertId = 0;
var user;
var expertName = '';
var expertSubject = '';
var historyAnswerStartSn = 0;
var commentStartSn = 0 ;
var globalCnt = 10;
var byId = function(id) {
	return document.getElementById(id);
};
var callback = 0;
var subscribeObj = null;

(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui.ready(function() {
		 
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		//$('#mineLink').addClass('mui-active');
		expertId = getQueryStrFromUrl('expertId');
		console.log('expertId:'+expertId);
		//检查本页面是否初次打开,初始化导航
		if(window.history.length < 3)
		{
			//mui.toast('分享或模板消息'+window.history.length);
		}
		
		initNavUi();
		//获取专家详细信息
		initExpertDetail();
		//获取该专家已经回答问题信息
		initAnswerInfo();
		//获取该专家点评信息
		initCommentInfo();
		//获取是否收藏信息()
		initFavoriteExpert();
		//增加微信分享处理
		//initWxShare();
		//增加是否关注信息处理
		initSubscribe();
		
		//增未注册时的处理
		var homeUrl = "../../HomePage/index.html";
		var regUrl = "../../Mine/reg.html";
		initCheckView(homeUrl,regUrl);
				
	});
	
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
	
}(mui, document));

//增加线上提问按钮事件
document.querySelector('#askQuestionOnline').addEventListener('tap', function() {
	//检查用户是否登录 未登陆则提示登陆
	
	console.log('askQuestionOnline click');
	//没有用户信息时候的处理
	if(!user)
	{			
		//没有用户信息时的处理方式 先提示用户绑定
		var noPhoneRegAfterJumpUrl = "../Expert/List/ExpertDetail.html?expertId="+expertId;
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/List/ExpertDetail&expertId='+expertId;
		mui.openWindow({
				url: noLoginUserInfoBindUrl
		});
	}
	
	//增加灭有手机号时的处理
	var noPhoneRegAfterJumpUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/List/ExpertDetail&expertId='+expertId;
	var hasPhoneJumpUrl = null;
	checkUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl);
	
	//用户没有关注，需要提示关注
	if(user && user.openid && user.openid != '')
	{
		console.log('subscribeObj.subScribeFlag:'+subscribeObj.issubscribe());
		if(!subscribeObj.issubscribe())
		{
			//未关注
			$('#subscribeDiv').removeClass('mui-hidden');
			setTimeout('hideSubscribeDiv()',10000)
			mui.toast('为获取优质服务，请先关注公众号');
			return;
		}
	}
	
	//用户没有手机号，需要注册
	if(user && user.phone && user.phone != '')
	{
		var dstUrl = "../User/QuestionOnline.html";
		mui.openWindow({
			url: dstUrl,
			id: 'QuestionOnline.html'
		});
	}
	
}, false);
//增加线下约见按钮事件
document.querySelector('#appointmentOffline').addEventListener('tap', function() {
	console.log('appointmentOffline click');
	
	////没有用户信息时候的处理
	if(!user)
	{
		//没有用户信息时的处理方式 先提示用户绑定
		var noPhoneRegAfterJumpUrl = "../Expert/List/ExpertDetail.html?expertId="+expertId;
		localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/List/ExpertDetail&expertId='+expertId;
		mui.openWindow({
				url: noLoginUserInfoBindUrl
		});
	}
	
	//增加灭有手机号时的处理
	var noPhoneRegAfterJumpUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/List/ExpertDetail&expertId='+expertId;
	var hasPhoneJumpUrl = null;
	checkUserPhone(noPhoneRegAfterJumpUrl,hasPhoneJumpUrl);
					
	
	//用户没有关注，需要提示关注
	if(user && user.openid && user.openid != '')
	{
		console.log('subscribeObj.subScribeFlag:'+subscribeObj.issubscribe());
		if(!subscribeObj.issubscribe())
		{
			//未关注
			$('#subscribeDiv').removeClass('mui-hidden');
			setTimeout('hideSubscribeDiv()',10000)
			mui.toast('为获取优质服务，请先关注公众号');
			return;
		}
	}
	
	//用户没有手机号，需要注册
	if(user && user.phone && user.phone != '')
	{
		var dstUrl = "../User/AppointmentOffline.html";
		mui.openWindow({
			url: dstUrl,
			id: 'AppointmentOffline.html'
		});
	}
	
}, false);

//增加收藏专家按钮事件
$('.favorite').on('tap', function() {
	console.log('favorite click');
	if($(this).attr( "xlink:href")=='icon-fav-o')
	{
		//增加收藏
		//$(this).removeClass("icon-fav-o");
		//$(this).addClass("icon-fav");
		addFavoriteExpert();
	}
	else
	{
		//取消收藏
		//$(this).addClass("icon-fav-o");
		//$(this).removeClass("icon-fav");
		removeFavoriteExpert();
	}
	
});

//增加关注关注按钮事件
document.querySelector('#subscribe').addEventListener('tap', function() {
	console.log('subscribe click');
	mui.toast('打开关注页面');
	mui.openWindow({
		url:'http://mp.weixin.qq.com/s?__biz=MzAxMzAxNDEwNQ==&mid=500989307&idx=1&sn=fc8c338ca17db652e84219687c3b171c#rd',
	}
	);
	
}, false);

//增加查看问题详情事件

//增加收听问题事件
//收听按钮上增加tap事件
//查看问题详情按钮
mui('#anserUl').on('tap', '.question-li', function() {
	var questionId = $(this).children('#questionBrief').attr('question-id');
	console.log('questionId:'+questionId);
	var dstUrl = './QuestionAnserDetail.html?questionId='+questionId;
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserDetail.html'
	});
	
});

//tap点击事件
document.querySelector('#historyLink').addEventListener('tap', function() {

	callback = 0;
	$('#commentLink').removeClass('mui-active');
	$('#historyLink').addClass('mui-active');
	
	$('#history').addClass('mui-hidden');
	$('#comment').addClass('mui-hidden');
	
	$('#history').removeClass('mui-hidden');
	var anserUl = document.getElementById('anserUl');
	if(historyAnswerStartSn == 0)
	{
		anserUl.innerHTML = '';
		//historyAnswerStartSn = 0;
	    initAnswerInfo();
	}
	//window.scrollTo(0,document.body.scrollHeight);
}, false);

//tap点击事件
document.querySelector('#commentLink').addEventListener('tap', function() {

	callback = 1;
	$('#historycommentLink').removeClass('mui-active');
	$('#commentLink').addClass('mui-active');
	
	$('#comment').addClass('mui-hidden');
	$('#history').addClass('mui-hidden');
	
	$('#comment').removeClass('mui-hidden');

	var commentUl = document.getElementById('commentUl');
	if(commentStartSn == 0)
	{
		//commentStartSn = 0;
		commentUl.innerHTML = '';
		initCommentInfo();
	}
	//window.scrollTo(0,document.body.scrollHeight);
}, false);

function initExpertDetail()
{
	console.log('initExpertDetail');
	var options = new Object();
	options.id = expertId;
	ajax_get_expert_detail(options,getExpertDetailSuc,getExpertDetailFailed);
}

function initAnswerInfo(startsn)
{
	console.log('initExpertDetail');
	var options = new Object();
	options.expertid = expertId;
	options.userid = user.id;
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = globalCnt;
	ajax_get_answer(options,getAnswerSuc,getAnswerFailed);
}

function getAnswerSuc(data)
{
	console.log('getAnswerSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	var anserUl = document.getElementById('anserUl');
	var firstFrag = document.createDocumentFragment();
	
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		if(data[i].answer != null)
		{
			firstFrag.appendChild(fillAnswerListLi(data[i]));
		}
	}
	historyAnswerStartSn += data.length;
	//anserUl.innerHTML = "";
	anserUl.appendChild(firstFrag);
}

function getAnswerFailed(data)
{
	console.log('getAnswerFailed .data:'+JSON.stringify(data));
}

function fillAnswerListLi(data) 
{
	console.log('answerlist:'+JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media question-li";
	
	var questiondate = data.questiondate;
	questiondate = questiondate.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(questiondate);
	var time = date.getTime();
	
	var liContent = '';
	liContent += '<div id="questionBrief" question-id="'+data.id+'">';
	liContent += '<div class="col-xs-12" >';
	liContent += '	<div id="userPicBrief" class="col-xs-2 mui-text-center">';
	liContent += '		<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img style="width:42px; height:42px; " src="'+data.picture+'" alt="个人头像">';
	liContent += '		</div>';
	liContent += '	</div>';
	liContent += '	<div class="col-xs-10">';
	liContent += '		<div>';
	liContent += '			<div class="col-xs-7">';
	liContent += '				<p>'+data.nickname+'</p>';
	liContent += '			</div>';
	liContent += '			<div class="col-xs-5">';
	liContent += '				<p class="publish-date mui-text-right" style="font-size:11px">'+getTimeAgo(time)+'</p>';
	liContent += '			</div>';
	liContent += '		</div>';
		
	liContent += '		<div class="question" style="">';
	liContent += '			<p id="questiondetail">'+data.questiondetail+'</p>';
	liContent += '		</div>';
	liContent += '	</div>';
		
	liContent += '</div>';	
	

	
	liContent += '<div id="anserBrief" class="col-xs-12">';
	liContent += '	<div id="expertBrief" class="col-xs-2 mui-text-center">';
			
	liContent += '	</div>';
	liContent += '	<div id="listen" class="col-xs-7">';
	liContent += '		<div class="col-xs-7 listenDiv" flag="0" question-userid="'+data.userid+'" question-expertid="'+data.expertid+'" question-id="'+data.id+'"> ';
	liContent += '				<button id="listenBtn" class="listen" type="button" class="mui-btn" style="width: 48px;height: 48px;border:0px;background-image:  url(../../img/play.png);">	';							
	liContent += '				</button>';
	liContent += '				<audio style="display:none" id="musicBox"  question-id="'+data.id+'" src="'+data.answer+'" controls></audio>';
	liContent += '		</div>';
			
	liContent += '		<div class="col-xs-5" style="font-size:11px;margin-top: 5px">';
	if(data.userid == user.id)
	{
		liContent += '				<span id="prompt">1元收听</span>';
	}
	else
	{
		liContent += '				<span id="prompt">点击播放</span>';
	}
	liContent += '		</div>';
	liContent += '	</div>';
	liContent += '	<div id="listenCnt" class="col-xs-3">';
	liContent += '		<p style="font-size: 11px;margin-top: 5px"><span class="mui-badge mui-badge-danger" style="">'+data.listenedcnt+'</span>人收听</p>';
	liContent += '	</div>';
	liContent += '</div>	';
	liContent += '</div>';
	
	ele.innerHTML = liContent;
	return ele;
}


function initCommentInfo(startsn)
{
	console.log('initCommentInfo');
	var options = new Object();
	options.expertid = expertId;
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = globalCnt;
	ajax_get_comment(options,getCommentSuc,getCommentFailed);
}

function getCommentSuc(data)
{
	console.log('getCommentSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	var commentUl = document.getElementById('commentUl');
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		firstFrag.appendChild(fillCommnetListLi(data[i]));
	}
	
	commentStartSn += data.length;
	//anserUl.innerHTML = "";
	commentUl.appendChild(firstFrag);
}

function getCommentFailed(data)
{
	console.log('getCommentFailed .data:'+JSON.stringify(data));
}

function fillCommnetListLi(data) 
{
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	var liContent = '';
	liContent += '<div id="commentBrief" class="col-xs-12">';
	liContent += '	<div id="userBrief" class="col-xs-2 mui-text-center">';
	liContent += '		<div style="width:36px; height:36px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img style="width:36px; height:36px; " src="'+data.picture+'" alt="个人头像">';
	liContent += '		</div>';
	liContent += '		<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
	liContent += '	</div>';
	liContent += '	<div id="listen" class="col-xs-7">';
	liContent += '		<div id="scoresDiv">';
	for(var i=0;i<5;i++)
	{
		if(i < data.praisecnt)
		{
			liContent += '<svg id="like" class="icon favorite" aria-hidden="true"><use id="favorite" xlink:href="#icon-star"></use></svg>';
		}
		else
		{
			liContent += '<svg id="like" class="icon favorite" aria-hidden="true"><use id="favorite" xlink:href="#icon-star-o"></use></svg>';
		}
	}

	liContent += '		</div>';
	liContent += '		<div id="commnentDiv">';
	liContent += '			<p id="commnent">'+data.comment+'</p>';
	liContent += '		</div>';
			
	liContent += '	</div>';
	liContent += '	<div class="col-xs-3 mui-text-right">';
	liContent += '		<p id="publishTime" style="font-size: 11px;margin-top: 5px">一天以前</p>';
	liContent += '</div>	';
	
	ele.innerHTML = liContent;
	return ele;
}

function getExpertDetailSuc(data)
{
	console.log('getExpertDetailSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	//
	data.expertid = expertId;
	localStorage.setItem('zmzfangExpertInfo',JSON.stringify(data));
	//填充
	byId("headPic").src = data.headpicture;
	
	byId("name").innerText = data.name;
	expertName = data.name;
	//线上答复个数
	byId('anserCnt').innerText = data.xsdf;
	//线下约见个数
	byId('appointmentCnt').innerText = data.xxdf;
	//点赞个数
	byId('praiseCnt').innerText = data.praisecnt;
	
	initArea(data.activeregion);
	
	byId("introduction").innerText = data.introduction;
	byId("expertisen").innerText = data.expertisen;
	
	byId('domain').innerHTML = getDomainStr(data.domain);
	byId("organization").innerText = data.organization;
	expertSubject = data.organization;
	
	byId("onlinecharge").innerText = data.onlinecharge;
	byId("offlinecharge").innerText = data.offlinecharge;
	
	byId("offlinetime").innerText = getOfflinetime(data.offlinetime);
	
	//byId("praiseCnt").innerText = data.
	//$("#userInfo").attr("user-id",data.id);
	initWxShare();
}

function getOfflinetime(data)
{
	var offlineTime = "每1小时";
	switch(data)
	{
		case '1':
			break;
		case '2':
			offlineTime = "每2小时";
			break;
		case '3':
			offlineTime = "每3小时";
			break;
		default:
			break;
	}
	return offlineTime;
}

function getExpertDetailFailed(data)
{
	console.log('getExpertDetailFailed .data:'+JSON.stringify(data));
	mui.toast('网络原因，获取专家详情失败');
}

function play()
{
	$(selectedListenBtn).css('background-image',"url(../../img/stop.png)");
	var test = $(selectedMusicBox).attr('question-id');
	//selectedListenBtn.style.background-image = "url(../../img/stop.png)";
	//var test = selectedMusicBox.attr('question-id');
	//alert('test'+test);
	var media = $(selectedMusicBox)[0];
	
	media.play();
	
	media.onended = function() {
	    //alert("音频播放完成");
	    $(selectedListenBtn).css('background-image',"url(../../img/play.png)");
	};
}

function initArea(data)
{
	var regionarray=data.split(",");
	//console.log(regionarray.length);
	var str = '';
	if(regionarray.length > 0)
	{
		for(var i=0;i<regionarray.length;i++)
		{
			byId("area").innerHTML += '<span class="item mui-badge mui-badge-success">' +getRegionStr(regionarray[i])+ ' </span>';
			
		}	
	}

}

function pullupRefresh()
{
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		//alert(callback);
		if(callback){
			initCommentInfo(commentStartSn);
			//alert('in comment')
		}else{
			initAnswerInfo(historyAnswerStartSn);
			//alert('in history')
		}
		self.endPullupToRefresh(false); 
	}, 1000);
}
/*
function pullupRefreshComment()
{
	console.log('pullupRefreshComment');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		initCommentInfo(commentStartSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}
*/

//判断是否收藏了该专家
function initFavoriteExpert()
{
	console.log('initFavoriteExpert');
	if(user == null)
	{
		return;
	}
	var options = new Object();
	options.userid = user.id;
	options.expertid = expertId;
	ajax_to_server(isFavoriteExpertUrl,options,isFavoriteExpertSuc,isFavoriteExpertFailed);
}

function isFavoriteExpertSuc(data)
{
	console.log('isFavoriteExpertSuc .data:'+JSON.stringify(data));
	if(data == '0')
	{
		$('#favorite').attr("xlink:href","#icon-fav");
	}
}

function isFavoriteExpertFailed(data)
{
	console.log('isFavoriteExpertFailed .data:'+JSON.stringify(data));
}


//收藏该专家
function addFavoriteExpert()
{
	console.log('addFavoriteExpert');
	if(user == null)
	{
		mui.toast('未能获取到您的登陆信息');
		//或者弹出登陆相关页面
		return;
	}
	var options = new Object();
	options.userid = user.id;
	options.expertid = expertId;
	ajax_to_server(addFavoriteExpertUrl,options,addFavoriteExpertSuc,addFavoriteExpertFailed);
}

function addFavoriteExpertSuc(data)
{
	console.log('addFavoriteExpertSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	if(data.rscode == '0')
	{
		//成功关注了该专家
		//修改收藏icon的背景色
		$('#favorite').attr("xlink:href","#icon-fav");
		mui.toast('成功关注'+expertName);
	}
}

function addFavoriteExpertFailed(data)
{
	console.log('addFavoriteExpertFailed .data:'+JSON.stringify(data));
}

//取消收藏该专家
function removeFavoriteExpert()
{
	console.log('removeFavoriteExpert');
	if(user == null)
	{
		mui.toast('未能获取到您的登陆信息');
		//或者弹出登陆相关页面
		return;
	}
	var str = '确认不再关注'+expertName;
	
	if(confirm(str))
	{
		var options = new Object();
		options.userid = user.id;
		options.expertid = expertId;
		ajax_to_server(deleteFavoriteExpertUrl,options,removeFavoriteExpertSuc,removeFavoriteExpertFailed);
	}
	
}

function removeFavoriteExpertSuc(data)
{
	console.log('removeFavoriteExpertSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	if(data.rscode == '0')
	{
		//成功取消该专家的关注
		//修改收藏icon的背景色
		$('#favorite').attr("xlink:href","#icon-fav-o");
		mui.toast('成功取消关注'+expertName);
	}
}

function removeFavoriteExpertFailed(data)
{
	console.log('removeFavoriteExpertFailed .data:'+JSON.stringify(data));
}

//增加微信分享处理
function initWxShare()
{
	var link = "http://www.zmzfang.com/weixin/Expert/List/ExpertDetail.html?expertId="+expertId;
	var imgUrl = byId("headPic").src;
	var param = new Object();
	// param.getJssdkConfUrl = calledUrl;
	var title = expertName + '(' + expertSubject + ')等你来问';
	var desc = '芝麻找房-房产交易垂直领域共享平台';
	
	param.title = title;
	param.desc = desc;
	param.link = link;
	param.imgUrl = imgUrl;
	wxShare(param);
}

function initSubscribe()
{
	console.log('initSubscribe');
	if(user && user.openid && user.openid != '')
	{
		var data = new Object();
		data.openid = user.openid;
		subscribeObj = new subscribe(data);
		
	}
}

function hideSubscribeDiv()
{
	console.log('hideSubscribeDiv');
	$('#subscribeDiv').addClass('mui-hidden');
}

			