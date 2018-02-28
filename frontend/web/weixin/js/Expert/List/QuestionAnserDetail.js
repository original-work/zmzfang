var loginUser;
var questionId;
var expertId;
var expertName;
var answerFile;
var questionUserId;
var selectedMusicBox;
var selectedListenBtn;
var fee;
var playFlag = false;
var subScribeFlag = false;
var shareSubject = '';
var media;
var listenpermission = 0;//收听权限，默认都是0 不能免费收听
var gobalInterval = 0;
var countingDownTid = 0;

var byId = function(id) {
	return document.getElementById(id);
};
	
(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui.ready(function() {
		//$('#mineLink').addClass('mui-active');
		loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
		if(!loginUser)
		{
			console.log('用户未登陆');
		}
		questionId = getQueryStrFromUrl('questionId');
		//问题答复信息
		media = byId('musicBox');
		initQuestionAnserInfo();
		
		//检查本页面是否初次打开,初始化导航
		initNavUi();
		//检查是否关注了微信公众号
		initSubscribe();
	});
}(mui, document));

//增加用户头像的点击事件
document.querySelector('#expertBrief').addEventListener('tap', function() {
	console.log('expertPicBrief click');
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = '../List/ExpertDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'ExpertDetail.html'
	});
}, false);

//增加注册绑定事件
document.querySelector('.need-login button').addEventListener('tap', function() {
	
	var regUrl = '../../Mine/reg.html';
	mui.openWindow({
		url: regUrl
	});
}, false);

mui('#lastestAnserUl').on('tap', '#questionBrief', function() {
	var questionId = $(this).attr('question-id');
	var dstUrl = './QuestionAnserDetail.html?questionId='+questionId;
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserDetail.html'
	});
});
			
//增加点评事件
document.querySelector('#comment').addEventListener('tap', function() {
	console.log('comment click');
	if(!loginUser)
	{
		mui.toast('未能获取到您的用户信息，暂不能点评');
		return ;
	}
	var dstUrl = '../User/CommentExpert.html?expertId=';
	dstUrl += $("#expertBrief").attr('expert-id');
	mui.openWindow({
		url: dstUrl
	});
}, false);

//增加点赞事件
document.querySelector('#praise').addEventListener('tap', function() {
	console.log('praise click');
	if($('#praise').hasClass('praised'))
	{
		mui.toast('已经点赞了，不能贪心哦');
		return;
	}
	else
	{
		$('#praise').addClass('praised');
		var praiseCnt =  parseInt(byId('praiseCnt').innerText) + 1;
		byId('praiseCnt').innerText = praiseCnt;
		//同步点赞个数至后台
		var options = new Object();
		options.expertid = $("#expertBrief").attr('expert-id');
		options.praisecnt = 1;
		ajax_to_server(addExpertPraiseCntUrl,options,addPraiseSuc,addPraiseFailed);
	}
	
}, false);


//增加收听按钮事件
document.querySelector('#listenBtn').addEventListener('tap', function() {
	console.log('listen click');

	//未登陆的情况下，提示需要绑定，然后跳转到当前页
	if(loginUser == null)
	{
		mui.toast('您还未登陆');
		var noLoginUserInfoBindUrl = 'http://www.zmzfang.com/?r=door/scope&view=Expert/List/QuestionAnserDetail&questionId='+questionId;
		mui.openWindow({
				url: noLoginUserInfoBindUrl
		});
		return;
	}
	
	//收听问题，暂时不需要强制关注
//	if(!subScribeFlag)
//	{
//		$('#subscribeDiv').removeClass('mui-hidden');
//		mui.toast('为获取优质服务，请先关注公众号');
//		return;
//	}
	
	//用户无手机号码，则提示注册
	if(loginUser.phone && loginUser.phone.length != 11 || (!loginUser.phone))
	{
		//原有页面隐藏，显示提示绑定页面；
		mui.toast('您还没有绑定手机号');
		 byId("displayAfterLoginDiv").classList.add("mui-hidden");
		 byId("needLoginDiv").classList.remove("mui-hidden");
		 var noPhoneRegAfterJumpUrl = "../Expert/List/QuestionAnserDetail.html?questionId="+questionId;
		 localStorage.setItem('zmzfangRegAfterJumpUrl',noPhoneRegAfterJumpUrl);
		 return;
	}
	
	//判断是否 已经付费了，如果付费了，直接进行播放，如果没有付费，则先进行付费
	selectedMusicBox = $('#musicBox');
	selectedListenBtn = $('#listenBtn');
	if(playFlag)
	{
		//stop
		stop();
		return;
	}
	
	if(listenpermission == 1)
	{
		play();
		
		return;
	}

	//用户本人登陆
	
	var options = new Object();
		
	options.userid = loginUser.id;
	options.questionuserid = questionUserId;
	options.questionexpertid = expertId;
	options.questionid = questionId;
	
	//计算点赞的个数 默认3个
	ajax_listen_answer(options,listenAnswerSuc,listenAnswerFailed);
	
}, false);

//增加关注关注按钮事件
document.querySelector('#subscribe').addEventListener('tap', function() {
	console.log('subscribe click');
	mui.toast('打开关注页面');
	mui.openWindow({
		url:'http://mp.weixin.qq.com/s?__biz=MzAxMzAxNDEwNQ==&mid=500989307&idx=1&sn=fc8c338ca17db652e84219687c3b171c#rd',
	}
	);
	
}, false);

function initQuestionAnserInfo()
{
	console.log("initQuestionAnserInfo");
	
	var options = new Object();
	if(loginUser)
	{
		options.userid = loginUser.id;
	}
	else
	{
		options.userid = '0';
	}
	
	options.questionid = questionId;
	//获取我的约见 记录
	ajax_get_question_by_id(options,getQuestionByIdSuc,getQuestionByIdFailed);
}

function getQuestionByIdSuc(data)
{
	console.log("getQuestionByIdSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	//填充 收听次数
	byId('userPic').src = data.userpicture;
	byId('userName').innerText = data.usernickname;
	questionUserId = data.userid;
	$("#userPicBrief").attr("publish-user-id",data.userid);    
	
	var createtime = data.questiondate;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = date.getTime();
	
	byId("createTime").innerText = getTimeAgo(time);
	byId('question').innerText = data.questionsubject;
	shareSubject = data.questionsubject;
	byId('listenCnt').innerText = data.listenedcnt;
	
	expertId = data.expertid;
	byId('expertPic').src = data.expertpicture;
	byId('expertName').innerText = data.expertname;
	expertName = data.expertname;
	byId('praiseCnt').innerText = data.praisecnt;
	//byId('domain').innerHTML = getDomainStr(data.domain);
	
	byId('organization').innerText = data.organization;
	$("#expertBrief").attr("expert-id",data.expertid);    
	
	byId('musicBox').src = data.answer;
	byId('duration').innerText = data.duration + '秒';
	gobalInterval = parseInt(data.duration);
	console.log('录音时长'+media.duration);
	listenpermission = data.listenpermission;
	if(listenpermission == 1)
	{
		byId('prompt').innerText = '限免收听'; 
	}
	
	byId('lastLoginTime').innerText = data.logintime.split(' ')[0];
	//alert('录音时长'+media.duration);
	//answerFile = data.answer;
	//data.answer;
	//获取该专家最近答复的问题
	getExpertLastestAnswer();
	initWxShare();
}

function getQuestionByIdFailed(data)
{
	console.log("getQuestionByIdFailed data:"+JSON.stringify(data));
}

function play()
{
	$(selectedListenBtn).css('background-image',"url(../../img/stop.png)");
	console.log('play');
	//selectedListenBtn.style.background-image = "url(../../img/stop.png)";
	//var test = selectedMusicBox.attr('question-id');
	//alert('test'+test);
	//media = $(selectedMusicBox)[0];
	media = byId('musicBox');
	media.play();	
	playFlag = true;
	countingDown();
	//修改收听次数
	modifyListenCnt();
	    
	media.onended = function() {
	    //alert("音频播放完成");
	    $(selectedListenBtn).css('background-image',"url(../../img/play.png)");
	    playFlag = false;
	    
	};
}

function stop()
{
	console.log('stop');
	//media = $(selectedMusicBox)[0];
	$(selectedListenBtn).css('background-image',"url(../../img/play.png)");
	media.pause();
	//media.stop();
	playFlag = false;
}

function getExpertLastestAnswer()
{
	console.log('getExpertLastestAnswer');
	var options = new Object();
	options.expertid = expertId;
	options.userid = loginUser?loginUser.id:0;
	options.start = 0;
	options.count = 6;
	ajax_get_answer(options,getAnswerSuc,getAnswerFailed);
}

function getAnswerSuc(data)
{
	console.log('getAnswerSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	var lastestAnserUl = document.getElementById('lastestAnserUl');
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		if(data[i].answer != null)
		{
			firstFrag.appendChild(fillAnswerListLi(data[i]));
		}
	}
	lastestAnserUl.innerHTML = "";
	lastestAnserUl.appendChild(firstFrag);
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
	liContent += '		<div style="width:32px; height:32px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img style="width:32px; height:32px; " src="'+data.picture+'" alt="个人头像">';
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
	liContent += '</div>';
	
	ele.innerHTML = liContent;
	return ele;
}

//增加微信分享处理
function initWxShare()
{
	var link = "http://www.zmzfang.com/weixin/Expert/List/QuestionAnserDetail.html?questionId="+questionId;
	var imgUrl = byId('expertPic').src;
	var param = new Object();
	// param.getJssdkConfUrl = calledUrl;
	var title = expertName + '回答了问题"'+ shareSubject;
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
	if(loginUser && loginUser.openid && loginUser.openid != '')
	{
		//根据openid 获取 uid ，来查看用户是否关注公众号
		var options = new Object();
		var url = 'http://www.zmzfang.com/?r=wechat/is-subscribe&openid=';
		url += loginUser.openid;
		ajax_to_server(url,options,getSubscribeInfoSuc,getSubscribeFailed,true);
	}
}

function getSubscribeInfoSuc(data)
{
	console.log("getSubscribeInfoSuc  " + JSON.stringify(data));
	if(data)
	{
		if(data.code == 0)
		{
			//无记录 表示没有关注  提示请先关注  申请按钮不可用  关注按钮 亮起来
		}
		else if(data.code == 1 && data.info.unionid)
		{
			//有记录 表示已经关注  
			subScribeFlag = true;
			console.log('getSubscribeInfoSuc unionid='+data.info.unionid);
		}
		
	}
	else
	{
		console.log("getSubscribeInfoSuc  返回异常");
		mui.toast('获取是否订阅返回空');
	}
}

function getSubscribeFailed(data)
{
	console.log("getSubscribeFailed  " + JSON.stringify(data));
	mui.toast('获取是否订阅消息失败');
}

function modifyListenCnt()
{
	console.log('modifyListenCnt');
	var options = new Object();
	options.userid = loginUser.id;
	options.questionid = questionId;
	ajax_to_server(modifyListenCntUrl,options,modifyListenCntSuc,modifyListenCntFailed);
}

function modifyListenCntSuc(data)
{
	console.log('modifyListenCntSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	if(data.rscode && data.rscode == '0')
	{
		//更新收听人数
		var cnt = byId('listenCnt').value;
		console.log('cnt:'+cnt);
		byId('listenCnt').innerText = parseInt(cnt) + 1;
	}
}

function modifyListenCntFailed(data)
{
	console.log('modifyListenCntFailed .data:'+JSON.stringify(data));
}

//倒计时
function countingDown() {
	var cnt = gobalInterval;
	countingDownTid = setInterval(function() {
		if(cnt > 0)
		{
			//console.log('i:'+cnt);
			cnt--;
			byId('duration').innerText = cnt + '秒';
			if(!playFlag)
			{
				byId('duration').innerText = gobalInterval + '秒';
				clearInterval(countingDownTid);
				countingDownTid = 0;
			}
		}
		else
		{
			console.log('end i:'+cnt);
			clearInterval(countingDownTid);
			countingDownTid = 0;
			//如果用户录音未停止，则进行停止
			byId('duration').innerText = gobalInterval + '秒';
		
		}
	},1000);
}

function addPraiseSuc(data)
{
	console.log("addPraiseSuc data:"+JSON.stringify(data));
	if(data.rscode == '0')
	{
		console.log("addPraiseSuc rscode:0");
	}
	else
	{
		console.log("addPraiseSuc data:"+JSON.stringify(data));
	}
}

function addPraiseFailed(data)
{
	console.log("addPraiseFailed data:"+JSON.stringify(data));
	//mui.toast("网络原因，点赞提交失败");
}


