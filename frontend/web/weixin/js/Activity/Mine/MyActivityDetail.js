var loginUser = null;
var activityId = null;// 活动信息id
var publishUserId = null; // 活动发布人信息id

var byId = function(id) {
	return document.getElementById(id);
};
 //初始化url参数来获取活动id和用户id,如果没有继续执行
initUrlParam();
mui.init({
	swipeBack: false
});

mui.ready(function() {
	$('.mui-content').Auth({'wechat':false,'openid':false,'phone':false});
	loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));

	//初始化活动信息
	initActivityInfo();
	
	//获取报名人数
	initApplyInfo();
	//获取评论信息
	//initCommentInfo();

	//初始化微信分享
	// wxShare();
});

mui('#bidUl').on('tap', '.apply-user', function() {
	
	var userid = $(this).attr('user-id');
	var agentflag = $(this).attr('agent-flag');
	var dstUrl = 'http://www.zmzfang.com/weixin/Agent/AgentInfo.html?userid='+userid;
	if(agentflag==0){
		var dstUrl = 'http://www.zmzfang.com/weixin/Mine/User.html?userid='+userid;
	}
	
	console.log('dstUrl is '+dstUrl);
//	mui.openWindow({
//		url: dstUrl,
//		id: 'AgentInfo.html'
//	});
});
			
//增加url参数处理
function initUrlParam()
{
	 activityId = getQueryStrFromUrl("activityId");
	 publishUserId = getQueryStrFromUrl("publishuserid");
}
function initActivityInfo()
{
	var info = new Object();
	info.activityid = activityId;
	info.publishuserid = publishUserId;
	ajax_to_server(getActivityDetailUrl,info,detailInfo);
}

function detailInfo(data){
	
	console.log('detailinfo:'+JSON.stringify(data));
	var res = data.data;
	$('#background').attr('src',res.activitypic);
	$('#activitySubject').text(res.activitysubject);
	$('#startTime').text(res.begintime);
	$('#endTime').text(res.endtime);
		
	$('#location').text(res.location);
	
	$('#type').text(res.activitytype);
	
	$('#personCnt').text(res.personcnt);
	//$('#detail').text(res.activitydetail);
	$('#detail').html(res.activitydetail.replace(/\\/g, ""));
	
	$('#userPic').attr('src',res.headpic);
	$('#userName').text(res.publishusername);
	$('#organization').text(res.organization);
	$('#position').text(res.position);
	
	//增加主办方信息的处理
	var orginfo = data.orginfo;
	if(orginfo)
	{
		$('#orgName').text(orginfo.organization);
		$('#contactName').text(orginfo.contactname);
		$('#contactPhone').text(orginfo.contactphone);
		$('#orgDiv').removeClass('mui-hidden');
	}
	
	publishUserId = res.publishuserid;
	localStorage.setItem('zmzfangActivityInfo',JSON.stringify(res));
//	var shareSubject = res.activitysubject + ","+"活动时间:"+res.begintime;
//	var shareDetail = res.activitydetail.length > 20? res.activitydetail.substr(0,20):res.activitydetail;
//	wxShare({'title':shareSubject,"desc":shareDetail,'imgUrl':res.headpic,'link':window.document.location.href})
	
	initCommit(res)
}
function initCommit(res){
	
	
	$('#edit').on('tap', function() {
	   	var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if(!loginUser){return;}
		
		//将活动基本信息，写入到缓存中
		var dstUrl = "./Activity.html?type=2";//修改
    	mui.openWindow({
			url: dstUrl,
			id: 'Activity.html'
		});
    	
    })
	
    $('#delete').on('tap', function() {
    	//增加验证信息
	   	var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if(!loginUser){return;}
	    
    	deleteActivityInfo();
	});
}



function initApplyInfo()
{
	var info = new Object();
	info.activityid = activityId;
	info.publishuserid = publishUserId;
	info.start = 0;
	info.count = 100;
	ajax_to_server(getApplyUserlistByActivityidUrl,info,getApplyUserlistSuc);
}

function getApplyUserlistSuc(data){
	
	console.log('getApplyUserlistSuc:'+JSON.stringify(data));
	
    if(!data || data.data.length == 0)
	{
		$('#bidUl').html('<li style="list-style:none;color:#aaa;font-size:.85rem;text-align:center;padding:10px 0;">暂无人响应</li>');
		return;
	}

    $('#bidUl').html('');
    
    var allItem ='';
    
    //console.log(' data.data.length:'+ data.data.length);
	for(var i in data.data)
	{
		allItem += fillBidListLi(data.data[i]);
	}
	
	$('#bidUl').append(allItem);
	byId("bidCnt").innerText = data.count?data.count:0;
	var swiper = new Swiper('.swiper-container');
	
}

function initCommentInfo()
{
	var info = new Object();
	info.activityid = activityId;
	info.publishuserid = publishUserId;
	info.start = 0;
	info.count = 30;
	ajax_to_server(getActivityCommentUrl,info,getActivityCommentSuc,getCommentFailed);
}

function getActivityCommentSuc(data){
	
	console.log('getActivityCommentSuc:'+JSON.stringify(data));
	var res = data.data;
	if(!data || data.data.length == 0)
	{
		$('#commentUl').html('<li style="list-style:none;color:#aaa;font-size:.85rem;text-align:center;padding:10px 0;">暂无评论</li>');
		return;
	}
	var commentUl = document.getElementById('commentUl');
	var firstFrag = document.createDocumentFragment();
	 $('#commentUl').html('');
	for(var i in data.data)
	{
		console.log('\n i:'+i);
		firstFrag.appendChild(fillCommnetListLi(data.data[i]));
	}
	
	//commentStartSn += data.length;
	//anserUl.innerHTML = "";
	commentUl.appendChild(firstFrag);
	byId("commentCnt").innerText = data.count?data.count:0;
}
								
//填充报名的用户信息
//function fillBidListLi(data)
//{								
//	var liContent = '<li class="col-xs-2">';
//	liContent += '<div id="bidInfo" class="bid-info" user-id="'+data.id+'">';
//	if(1==data.agentflag)
//	{
//		liContent += '<a href="../../Agent/AgentInfo.html?userId='+data.id+'"><img style="width:42px; height:42px; border-radius:50%; overflow:hidden;" src="'+data.picture+'" alt="个人头像" /></a>';
//	}
//	else
//	{
//		liContent += '<a href="../../Mine/User.html?userId='+data.userid+'"><img style="width:42px; height:42px; border-radius:50%; overflow:hidden;" src="'+data.picture+'" alt="个人头像" /></a>';
//	}
//	
//	liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
//	liContent += '</div></li>';	
//	return liContent;
//}

//填充报名的用户信息
function fillBidListLi(data)
{								
	var createtime = data.createtime;
	createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
	var date = new Date(createtime);
	var time = getTimeAgo(date.getTime());
	
	var liContent = '';
	liContent += 	'<li class="mui-table-view-cell apply-user" user-id="'+data.id+'" agent-flag="'+data.agentflag+'">';
	liContent +=	'<div class="mydiv" style="top:10px; float:left; width:42px; height:42px; border-radius:50%; overflow:hidden;margin-left: auto;margin-right: auto;margin-top:0px;">';
	liContent +=	'<img id="headPic" width="42px" height="42px" style="margin-right: 10px; " src="'+data.picture+'" alt="个人头像" />';
	liContent +=	'</div>';
	liContent +=	'<div style="float:left; margin-left:10px;">';
	liContent +=	'<p>';
	liContent +=	'<span id="nickname">'+data.nickname+'</span>';
	liContent +=	'</p>';
	liContent +=    '<p class="publish-date" style="position:absolute;right:3px;top:12px">'+time+'</p>';
	
	liContent +=	'<p><span id="phone">'+data.phone+'</span></p>';
	liContent +=	'<p>';
	if(data.agentflag == 1)
	{
		//liContent +=	'<span id="company">'+organization+'</span>';
		liContent +=	'<span id="position">经纪人</span>';
	}
	else
	{
		//liContent +=	'<span id="position">个人用户</span>';
	}
	
	liContent +=	'</p>';
	liContent +=	'</div>';
	liContent +=	'</li>';
	return liContent;	
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
	//var time = date.getTime();
	var time = getTimeAgo(date.getTime());
	var liContent = '';
	liContent += '<div id="commentBrief" class="col-xs-12">';
	liContent += '	<div id="userBrief" class="col-xs-2 mui-text-center">';
	liContent += '		<div style="width:36px; height:36px; border-radius:50%; overflow:hidden;margin:auto;">';
	liContent += '			<img style="width:36px; height:36px; " src="'+data.picture+'" alt="个人头像">';
	liContent += '		</div>';
	liContent += '		<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
	liContent += '	</div>';
	liContent += '	<div id="comment" class="col-xs-10">';
	
	liContent += '		<div id="commnentDiv">';
	liContent += '			<p id="commnent">'+data.comment+'</p>';
	liContent += '			<p id="publishTime" style="font-size:8px;margin-top:10px;text-align:right;color:#333;">'+time+'</p>';
	liContent += '		</div>';
			
	liContent += '	</div>';
	
	ele.innerHTML = liContent;
	return ele;
}

function deleteActivityInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	info.activityid = activityId;
	var url = deleteActivityUrl;
	ajax_to_server(url,info,deleteActivityInfoSuc,deleteActivityInfoFailed);
}

function deleteActivityInfoSuc(data)
{
	console.log('deleteActivityInfoSuc data:'+JSON.stringify(data));
	if(data && data.rscode == 0)
	{
		mui.toast('删除信息成功');
		mui.back();
	}
	else
	{
		mui.toast('删除信息失败'+JSON.stringify(data));
	}
}

function deleteActivityInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}
