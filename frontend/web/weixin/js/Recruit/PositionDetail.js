$('.mui-content').Auth({'wechat':false,'openid':false,'phone':false});
var loginUser = userInfo;
var positionId = null;// 招聘信息id
var publishUserId = null; // 招聘发布人信息id
var id
var byId = function(id) {
	return document.getElementById(id);
};
 //初始化url参数来获取需求id和用户id,如果没有继续执行
initUrlParam();
mui.init({
	swipeBack: false
});

mui.ready(function() {
	$('#mineLink').addClass('mui-active')
	//初始化职位信息
	initPositionInfo();
	//初始化是否投递信息
	initDeliveryInfo();
	//初始化收藏信息
	initFavoritePosition();
	//初始化 登陆用户信息
	
	
	//初始化微信分享  我的收藏页面不需要分享
	// wxShare();
	
});

//增加url参数处理
function initUrlParam()
{
	 id = getQueryStrFromUrl("id");
}
function initPositionInfo()
{
	var info = new Object();
	info.recruitid = id;
	ajax_to_server('http://www.zmzfang.com/?r=recruit/get-recruit-detail',info,detailInfo);
}
function detailInfo(res){
	console.log('get-recruit-detail:'+JSON.stringify(res));
	$('#positionSubject').text(res.recruitsubject);
	$('#recruitPosition').text(res.recruitposition);
	$('#recruitSalary').text(res.salary);
	$('#location').text(res.location);
	$('#workPeriod').text(res.workperiod);
	$('#education').text(res.education);
	$('#recruitCount').text(res.recruitcount);
	
	if(res.organizationlogo && res.organizationlogo != '')
	{
		$('#organizationPic').attr('src',res.organizationlogo);
		$('#organizationPic').removeClass('mui-hidden');
	}
	else
	{
		console.log('organization:'+res.organization.length);
		if(res.organization)
		{
			if(res.organization.length > 4)
			{
				$('#fake1').text(res.organization.substr(0,4));
			}
			else
			{
				$('#fake1').text(res.organization);
			}
			
			$('#fake1').removeClass('mui-hidden');
		}
		
	}
	
	$('#organizationInfo').text(res.organizationinfo);
	$('#positionDetail').text(res.positiondetail);
	$('#publishUserPic').attr('src',res.headpic);
	$('#publishUserName').text(res.publishusername);
	$('#organization').text(res.organization);
	$('#publishUserPosition').text(res.position);
	publishUserId = res.publishuserid;
	initCommit(res)
	
	var shareSubject = "招聘："+res.recruitposition + ","+glb.salary[res.salary]+","+glb.workperiod[res.workperiod]+" " + res.publishusername + res.position + " 门店直招";
	wxShare({'title':shareSubject,"desc":'更多福利待遇赶快来看！','imgUrl':res.headpic,'link':window.document.location.href})
}
function initCommit(res){
	$('#applyBtn').on('tap',function(){
		var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if(!loginUser){return;}
		var info = new Object();
		info.userid = loginUser.id;
		info.recruitid = id;
		info.recruituserid = res.publishuserid;
		if(loginUser.id == res.publishuserid)
		{
			mui.toast('不能投递自己发布的职位');
			return;
		}
		ajax_to_server('http://www.zmzfang.com/?r=resume-delivery/add-delivery',info,commitInfo);
	});
	
	$('#favoriteBtn').on('tap',function(){
		var done = false;
		if(!$.wechated()){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-wechat').show();}
		if(!$.openided() && !done){done =true;$('.mui-content').hide();$('#authMessage').show();$('.need-openid').show();}
		if(!$.phoned() && !done ){$('.mui-content').hide();$('#authMessage').show();$('.need-phone').show();}
		if($('#favoriteBtn').text() == "已收藏")
		{
			var btnArray = ['否', '是'];
			 mui.confirm('您确定取消关注吗?', '芝麻找房', btnArray, function(e) {
                    if (e.index == 1) {
                        console.log('确定取消了关注');
                        deleteFavoritePosition();
                    } else {
                        console.log('不取消');
                    }
            })
		}
		else
		{
			addFavoritePosition();
		}
		
	})
}

function commitInfo(res){
	if(res.rscode == 0){
		mui.alert('投递成功')
		//发送模板消息 --- 后台直接发送完成
		//发送站内信
		$("#applyBtn").text("已申请");
		$("#applyBtn").addClass('mui-disabled');
		sendMsgToUserByWildog();
		
	}else if(res.rscode == 1){
		if(res.message){
			mui.alert(res.message)
		}else{
			mui.alert('投递失败!');
		}
		
	}
}

function initFavoritePosition()
{
	if(loginUser)
	{
		var options = {};
		options.userid = loginUser.id;
		options.recruitid = id;
		var dstUrl = isFavoritePositionUrl;
		
		ajax_to_server(dstUrl,options,isFavoritePositionSuc,isFavoritePositionFailed);
	}
	else
	{
		mui.toast('无法获取用户信息');
	}
}

function isFavoritePositionSuc(data)
{	
	if(data.rscode=="0"){
		console.log("isFavoritePositionSuc");
		$("#favoriteBtn").text("已收藏");
	}else{
		console.log("isFavoritePositionSuc");
	}
	
}
	        

function isFavoritePositionFailed(data)
{
	//console.log("isFavoritePositionFailed");
	mui.toast('获取信息失败 '+JSON.stringify(data));
}

function addFavoritePosition()
{
	if(loginUser)
	{

		var options = {};
		options.userid = loginUser.id;
		options.recruitid = id;
		var dstUrl = addFavoritePositionUrl;
		
		ajax_to_server(dstUrl,options,addFavoritePositionSuc,addFavoritePositionFailed);
	}
	else
	{
		mui.toast('无法获取用户信息');	
	}
}

function addFavoritePositionSuc(data)
{	
	console.log("addFavoritePositionSuc data:"+JSON.stringify(data));
	if(data.rscode=="0"){
		console.log("addFavoritePositionSuc");
		mui.toast('收藏成功');
		$("#favoriteBtn").text("已收藏");
    	
	}else{
		mui.toast('获取信息失败 '+JSON.stringify(data));
	}
	
}
	        

function addFavoritePositionFailed(data)
{
	mui.toast('获取信息失败 '+JSON.stringify(data));
}		

function deleteFavoritePosition()
{
	if(loginUser)
	{
		var options = {};
		options.userid = loginUser.id;
		options.recruitid = id;
		var dstUrl = deleteFavoritePositionUrl;
		
		ajax_to_server(dstUrl,options,deleteFavoritePositionSuc,deleteFavoritePositionFailed);
	}
	else
	{
		mui.toast('无法获取用户信息');	
	}
}

function deleteFavoritePositionSuc(data)
{	
	console.log("deleteFavoritePositionSuc data:"+JSON.stringify(data));
	if(data.rscode=="0"){
		console.log("addFavoritePositionSuc");
		mui.toast('取消收藏成功');
		$("#favoriteBtn").text("收藏");
    	
	}else{
		mui.toast('获取信息失败 '+JSON.stringify(data));
	}
	
}
	        

function deleteFavoritePositionFailed(data)
{
	mui.toast('获取信息失败 '+JSON.stringify(data));
}

function initDeliveryInfo()
{
	if(loginUser)
	{
		var options = {};
		options.userid = loginUser.id;
		options.recruitid = id;
		var dstUrl = isDeliveryUrl;
		
		ajax_to_server(dstUrl,options,getIsDeliverySuc,null);
	}
}

function getIsDeliverySuc(data)
{	
	console.log("getIsDeliverySuc data:"+JSON.stringify(data));
	if(data.rscode=="1"){
		console.log("getIsDeliverySuc");
		//已经投递
		
		$("#applyBtn").text("已申请");
		$("#applyBtn").addClass('mui-disabled');
		
	}
}
	        
function sendMsgToUserByWildog()
{
	console.log('sendMsgToUserByWildog');
	
	var toUserid = publishUserId;
	var toNickname = $('#publishUserName').text();
	var fromNickname = loginUser.nickname;
	var now = new Date();
	
	var subject = $('#positionSubject').text();
	
	var content = '「'+fromNickname+'」对您 ['+subject+' ]有兴趣，快来查看吧。';
	//						content += '时间是：'+ now.toLocaleString();
	var imgsrc = loginUser.picture?loginUser.picture:'http://www.zmzfang.com/weixin/img/favicon.ico';
	var template = {"imgsrc":imgsrc ,"title": "收到简历提醒","url": "http://www.zmzfang.com/weixin/Recruit/PositionMgr/PositionIPublished.html"}
	
	sendSystemMsgToWildog(toUserid,content,template,'zmzs',null);	
}