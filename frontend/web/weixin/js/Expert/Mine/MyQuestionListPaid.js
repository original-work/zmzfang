var user = null;
var startSn = 0;
var globalCnt = 30;
var playFlag = false;
var media;

var byId = function(id) {
	return document.getElementById(id);
};
			
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
		initPayQuestionList();
	});
	
	mui('#questionListDiv').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
//	mui.back = function(){
//		mui.openWindow({
//			url: '../../test/expert.html'
//		});
//	};

}(mui, document));

//查看问题详情按钮
mui('#questionListUl').on('tap', '.question-brief', function() {
	/*
	var expertId = this.getAttribute('expert-id');
	console.log('expertId:'+expertId);
	var dstUrl = '../List/QuestionAnserDetail.html?expertId='+expertId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserDetail.html'
	});
	*/
});

//收听按钮上增加tap事件

mui('#questionListUl').on('tap', '.listenDiv', function() {
	console.log('listenBtn');
	
	
	//判断是否 已经付费了，如果付费了，直接进行播放，如果没有付费，则先进行付费
	if(user == null)
	{
		mui.toast('您还未登陆');
	}
	var selectedMusicBox = $(this).children('#musicBox');
	var selectedListenBtn = $(this).children('#listenBtn');
	var media = $(selectedMusicBox)[0];
	
	if(playFlag)
	{
		//stop
		media.pause();
		playFlag = false;
		$(selectedListenBtn).css('background-image',"url(../../img/play.png)");
	}
	else
	{
		$(selectedListenBtn).css('background-image',"url(../../img/stop.png)");
		media.play();
		playFlag = true;
		media.onended = function() {
		    $(selectedListenBtn).css('background-image',"url(../../img/play.png)");
		    playFlag = false;
		};
	}
	
	
	
	
		
	
});

function initPayQuestionList(startsn,count)
{
	var options = new Object();
	options.userid = user.id;
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	
	//计算点赞的个数 默认3个
	ajax_get_pay_question(options,getPayQuestionSuc,getPayQuestionFailed);
}

function getPayQuestionSuc(data)
{
	console.log("getPayQuestionSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		mui.toast('没有更多的数据了');
		return;
	}
	var questionListUl = document.getElementById('questionListUl');
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		if(data[i].answer)
		{
			firstFrag.appendChild(fillQuestionListUlLi(data[i]));
		}
	}
	startSn += data.length;
	//anserUl.innerHTML = "";
	questionListUl.appendChild(firstFrag);
}

function getPayQuestionFailed(data)
{
	console.log("getPayQuestionFailed data:"+JSON.stringify(data));
	mui.toast("网络原因，获取付费列表失败");
}

function fillQuestionListUlLi(data) 
{
	//console.log(JSON.stringify(data));

	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var createdate = data.createdate;
	createdate = createdate.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createdate);
	var time = date.getTime();
	
	var liContent = '';
	liContent += '<div id="questionBrief" class="col-xs-12">';
	liContent += '	<div id="userPicBrief" class="col-xs-2 mui-text-center">';
	liContent += '		<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img style="width:42px; height:42px; " src="'+data.questionuserpicture+'" alt="个人头像">';
	liContent += '		</div>';
	liContent += '	</div>';
	liContent += '	<div class="col-xs-10 question-brief" publishuser-id="5320" expert-id="474">';
	liContent += '		<div>';
	liContent += '			<div class="col-xs-7">';
	liContent += '				<p>'+data.questionusernickname+'</p>';
	liContent += '			</div>';
	liContent += '			<div class="col-xs-5">';
	liContent += '				<p class="publish-date mui-text-right" style="font-size:11px">'+getTimeAgo(time)+'</p>';
	liContent += '			</div>';
	liContent += '		</div>';
		
	liContent += '		<div class="question" style="">';
	liContent += '			<p>'+data.questionsubject+'</p>';
	liContent += '		</div>';
	liContent += '	</div>';
		
	liContent += '	</div>';	

	liContent += '	<div id="anserBrief" class="col-xs-12">';
	liContent += '		<div id="listen" class="col-xs-7">';
	liContent += '			<div class="col-xs-5" style="font-size:11px;margin-top: 5px;text-align:right;">';
	liContent += '				<span class="mui-hidden">1元收听</span>';
	liContent += '			</div>';
	liContent += '			<div class="col-xs-7 listenDiv">';
	liContent += '				<button id="listenBtn" class="listen" type="button" class="mui-btn" style="width: 48px;height: 48px;border:0px;background-image:  url(../../img/play.png);">	';							
	liContent += '				</button>';
	liContent += '				<audio style="display:none" id="musicBox" src="'+data.answer+'" controls></audio>';
	liContent += '			</div>';
			
	
	liContent += '		</div>';
	liContent += '		<div id="listenCnt" class="col-xs-3">';
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

function pullupRefresh()
{
	console.log('pullupRefresh');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		initPayQuestionList(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}