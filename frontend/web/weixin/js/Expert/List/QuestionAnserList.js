var user = null;
var selectedMusicBox;
var selectedListenBtn;
var currentOrderId;
var startSn = 0;
var globalCnt = 30;
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
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
	
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		initQuestionAnserList();
	});
	
//	mui.back = function(){
//		mui.openWindow({
//			url: '../../test/expert.html'
//		});
//	};

}(mui, document));

//查看问题详情按钮
mui('#questionListUl').on('tap', '.question-li', function() {
	var questionId = $(this).children('#questionBrief').attr('question-id');
	console.log('questionId:'+questionId);
	var dstUrl = './QuestionAnserDetail.html?questionId='+questionId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'QuestionAnserDetail.html'
	});
	
});

function initQuestionAnserList(startsn,count)
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
	var questionListUl = document.getElementById('questionListUl');
	var firstFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		if(data[i].answer != null)
		{
			firstFrag.appendChild(fillQuestionListUlLi(data[i]));
		}
	}
	startSn += data.length;
	//anserUl.innerHTML = "";
	questionListUl.appendChild(firstFrag);
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
	liContent += '				<button id="listenBtn" class="listen" type="button" class="mui-btn" style="width: 48px;height: 48px;border:0px;background-image:  url(../../img/play.png);">	';							
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

function pullupRefresh()
{
	console.log('pullupRefresh');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		initQuestionAnserList(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}