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
	//初始化收藏信息
	initFavoriteActivity();
	//获取报名人数
	initApplyInfo();
	//获取评论信息
	initCommentInfo();
	
	//初始化 登陆用户信息
	//$('.mui-content').Auth();
	
	//初始化微信分享
	// wxShare();
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
	
	$('#city').text(res.activitycity);
	$('#type').text(res.activitytype);
	
	
	$('#detail').html(res.activitydetail.replace(/\\/g, ""));
	
	$('#userPic').attr('src',res.headpic);
	$('#userName').text(res.publishusername);
	if (res.organization) {
		$('#organization').text(res.organization);
	}else{
		$('#organization').text('个人用户');
	}
	if (res.position) {
		$('#position').text(res.position);
	}else{
		$('#position').text('');
	}
	if(parseInt(res.fee) == 0)
	{
		$('#fee').text('免费');
	}
	else
	{
		$('#fee').text(res.fee+'元/人');
	}
	if(parseInt(res.personcount) == 0)
	{
		$('#personCnt').text('不限');
	}
	else
	{
		$('#personCnt').text(res.personcount+'人');
	}
	publishUserId = res.publishuserid;
	//增加主办方信息的处理
	var orginfo = data.orginfo;
	if(orginfo)
	{
		$('#orgName').text(orginfo.organization);
		$('#contactName').text(orginfo.contactname);
		$('#contactPhone').text(orginfo.contactphone);
		$('#orgDiv').removeClass('mui-hidden');
	}
	
	var shareSubject = res.activitysubject + ","+"活动时间:"+res.begintime;
	var shareDetail = orginfo?orginfo.organization:res.publishusername;
	// var shareDetail = res.activitydetail.length > 20? res.activitydetail.substr(0,20):res.activitydetail;
	wxShare({'title':shareSubject,"desc":shareDetail,'imgUrl':res.headpic,'link':window.document.location.href})
	
	initCommit(res)
}
function initCommit(res){
	$('#applyBtn').on('tap',function(){
		var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){done = true;$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if(!loginUser){return;}
		if(done)
		{
			return;
		}
		
		
		var info = new Object();
		info.applyuserid = loginUser.id;
		info.activityid = activityId;
		
		if(loginUser.id == publishUserId)
		{
			mui.toast('不能申请自己发布的活动');
			return;
		}
		ajax_to_server('http://www.zmzfang.com/?r=activity/add-activity-apply',info,commitInfo);
	});
	
	$('#favorite').on('tap', function() {
	   	var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){done=true;$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if(!loginUser){return;}
		if(done)
		{
			return;
		}
		
    	if($('#favorite').children('use').attr("xlink:href") == '#icon-fav-o'){
				ajax_to_server('http://www.zmzfang.com/?r=activity/add-favorite-activity',{
					userid: loginUser.id,
					activityid: activityId
				},favSuccess);
		}else{//如果已经收藏则取消收藏
				ajax_to_server('http://www.zmzfang.com/?r=activity/delete-favorite-activity',{
					userid: loginUser.id,
					activityid: activityId
				},DfavSuccess);
		}
    })
	
    $('#comment').on('tap', function() {
    	//增加验证信息
	   	var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){done = true;$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if(!loginUser){return;}
	    if(done)
		{
			return;
		}
	    
    	var dstUrl = "./Mine/Comment.html?activityId="+activityId;
    	mui.openWindow({
			url: dstUrl,
			id: 'Comment.html'
		});
	});
}

function commitInfo(res){
	console.log('xxxx');
	console.log('commitInfo res='+JSON.stringify(res));
	if(res.rscode == 0){
		mui.toast('报名成功')
		$("#applyBtn").text("已报名");
		$("#applyBtn").addClass('mui-disabled');
		
	}else if(res.rscode == 1){
		if(res.message){
			mui.toast(res.message)
		}else{
			mui.toast('报名失败!');
		}
		
	}
}

function initFavoriteActivity()
{
	if(loginUser)
	{
		var options = {};
		options.userid = loginUser.id;
		options.activityid = activityId;
		var dstUrl = isFavoriteActivityUrl;
		
		ajax_to_server(dstUrl,options,isFavoriteActivitySuc,isFavoriteActivityFailed);
	}
	else
	{
		mui.toast('无法获取用户信息');	
	}
}

function isFavoriteActivitySuc(res){
	if(res.rscode == 0){
		$('#favorite use').attr('xlink:href','#icon-fav')
	}
}
function isFavoriteActivityFailed(res){
	mui.toast('初始化收藏失败')
}

//增加收藏事件			
function favSuccess(res){
	if(res.rscode == 0){
		$('#favorite use').attr('xlink:href','#icon-fav');
	}
}
function DfavSuccess(res){
	if(res.rscode == 0){
		$('#favorite use').attr('xlink:href','#icon-fav-o');
	}
}

function initApplyInfo()
{
	var info = new Object();
	info.activityid = activityId;
	info.publishuserid = publishUserId;
	info.start = 0;
	info.count = 100;
	ajax_to_server(getApplyUserlistByActivityidUrl,info,getApplyUserlistSuc);
	
	
	info.activityid = activityId;
	info.applyuserid = loginUser.id;
	ajax_to_server(isActivityApplyUrl,info,isActivityApplySuc);
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
    var sliderItem = '<div class="swiper-slide">';
    //console.log(' data.data.length:'+ data.data.length);
	for(var i in data.data)
	{
		sliderItem += fillBidListLi(data.data[i]);
		
		if(loginUser && data.data[i].biduserid == loginUser.id)
		{
			bidFlag = 1;
		}
		
		if(parseInt(i)+1 == data.data.length)
		{								
			sliderItem += '</div>';
			//$('#bidUl').append(sliderItem);
			allItem += sliderItem;
			sliderItem = '';
		}
		else if((parseInt(i)+1) % 6 == 0)
		{
			
			sliderItem += '</div>';
			//$('#bidUl').append(sliderItem);
			allItem += sliderItem;
			sliderItem = '<div class="swiper-slide">';
		}	
	}
	
	$('#bidUl').append(allItem);
	byId("bidCnt").innerText = data.count?data.count:0;
	var swiper = new Swiper('.swiper-container');
	
}

function isActivityApplySuc(data){
	
	console.log('isActivityApplySuc:'+JSON.stringify(data));
	if(data && data.rscode == "0")
	{
		//已经申请了；
		$("#applyBtn").text("已报名");
		$("#applyBtn").addClass('mui-disabled');
	}
	
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
function fillBidListLi(data)
{								
	var liContent = '<li class="col-xs-2">';
	liContent += '<div id="bidInfo" class="bid-info" user-id="'+data.id+'">';
	if(1==data.agentflag)
	{
		liContent += '<a href="../Agent/AgentInfo.html?userId='+data.id+'"><img style="width:42px; height:42px; border-radius:50%; overflow:hidden;" src="'+data.picture+'" alt="个人头像" /></a>';
	}
	else
	{
		liContent += '<a href="../Mine/User.html?userId='+data.userid+'"><img style="width:42px; height:42px; border-radius:50%; overflow:hidden;" src="'+data.picture+'" alt="个人头像" /></a>';
	}
	
	liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
	liContent += '</div></li>';	
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