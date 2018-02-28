var loginUser = null;
var resumeId = null;
var resumeUserId = null;
var deliveryId = null;
var recruitId = null;

initUrlParam();

mui.init({
	swipeBack: false
});
			
mui.ready(function() {
	$('#mineLink').addClass('mui-active');
	var data = localStorage.getItem('zmzfangLoginUserInfo');
	loginUser = JSON.parse(data);
	
	initResumeBasicInfo();
	initResumeWorkInfo();
	initResumeEduInfo();
	
	initDeliveryInfo();
	initWxShareBackUrl();
	//wxShare();
});
			

$('#deliveryBtn').on('tap',function(){
	console.log('tap........');
	var optionObj = {};
	optionObj.recruitid = recruitId;
	optionObj.recruituserid = loginUser.id;
	optionObj.deliveryid = deliveryId;
	optionObj.status = 1;
	optionObj.result = "无";
	var url = modifyDeliveryUrl;
	ajax_to_server(url,optionObj,modifyDeliverySuccess,modifyDeliveryFailed);
	
});
			
//增加url参数处理
function initUrlParam()
{
	 resumeId = getQueryStrFromUrl("resumeId");
	 resumeUserId = getQueryStrFromUrl("resumeUserId");
	 deliveryId = getQueryStrFromUrl("deliveryId");
	 recruitId = getQueryStrFromUrl("recruitId");
}

//初始化简历基本信息
function initResumeBasicInfo()
{
	var optionObj = new Object();
	optionObj.userid = resumeUserId;
	optionObj.resumeid = resumeId;
	var url = getResumeBasicInfoUrl;
	ajax_to_server(url,optionObj,getResumeBasicInfoSuccess,getResumeBasicInfoFailed);

}
			
function getResumeBasicInfoSuccess(data)
{
	console.log('getResumeBasicInfoSuccess:data'+JSON.stringify(data));
	if(data == null || data == '')
	{
		$("#noResumePromptDiv").removeClass('mui-hidden');
		return;
	}
	
	$("#basicInfoDiv").removeClass('mui-hidden');
	
	$('#headPic').attr('src',data.userheadpic);
	$('#realName').text(data.realname);
	$('#organization').text(data.organization);
	//$('#workCity').text(data.workcity);
	$('#homeCity').text(data.homecity);
	$('#edu').text(data.education);
	$('#age').text(data.age);
	$('#workPeriod').text(data.workperiod);
	
	$('#phone').text(data.phone);
	//$('#resumeDetail').text(data.resumedetail);
}
			
function getResumeBasicInfoFailed(errorThrown, options)
{
	mui.toast('获取我的简历信息失败');
}

//初始化工作基本信息
function initResumeWorkInfo()
{
	var optionObj = new Object();
	optionObj.userid = resumeUserId;
	optionObj.resumeid = resumeId;
	var url = getResumeWorkInfoListUrl;
	ajax_to_server(url,optionObj,getResumeWorkInfoSuccess,getResumeWorkInfoFailed);

}
			
function getResumeWorkInfoSuccess(data)
{
	console.log('getResumeWorkInfoSuccess:data'+JSON.stringify(data));
	if(data == null || data == '')
	{
		// mui.toast('未获取到工作经历信息失败'+JSON.stringify(data));
		return;
	}
	$("#workDiv").removeClass('mui-hidden');
	
	var workUl = $('#workUl');
	var firstFrag = document.createDocumentFragment();
	
	//有数据显示列表
	for(var i in data)
	{
		firstFrag.appendChild(NewCommonWorkInfoLi(data[i],false));
	}

	workUl[0].appendChild(firstFrag);	
}
			
function getResumeWorkInfoFailed(errorThrown, options)
{
	mui.toast('获取简历信息失败');
}

//初始化教育经历基本信息
function initResumeEduInfo()
{
	var optionObj = new Object();
	optionObj.userid = resumeUserId;
	optionObj.resumeid = resumeId;
	var url = getResumeEduInfoListUrl;
	ajax_to_server(url,optionObj,getResumeEduInfoSuccess,getResumeEduInfoFailed);

}
			
function getResumeEduInfoSuccess(data)
{
	console.log('getResumeBasicInfoSuccess:data'+JSON.stringify(data));
	if(data == null || data == '')
	{
		// mui.toast('获取教育经历信息失败'+JSON.stringify(data));
		return;
	}
	
	$("#eduDiv").removeClass('mui-hidden');
	var eduUl = $('#eduUl');
	var firstFrag = document.createDocumentFragment();
	
	//有数据显示列表
	for(var i in data)
	{
		firstFrag.appendChild(NewCommonEduInfoLi(data[i],false));
	}

	eduUl[0].appendChild(firstFrag);	
	
	//$('#resumeDetail').text(data.resumedetail);
}
			
function getResumeEduInfoFailed(errorThrown, options)
{
	mui.toast('获取教育经历信息失败');
}

//初始化投递信息
function initDeliveryInfo()
{
	var optionObj = new Object();
	optionObj.deliveryid = deliveryId;
	optionObj.recruitid = recruitId;
	var url = getDeliveryUrl;
	ajax_to_server(url,optionObj,getDeliverySuccess,getDeliveryFailed);

}
			
function getDeliverySuccess(data)
{
	console.log('getDeliverySuccess:data'+JSON.stringify(data));
	if(data == null || data == '')
	{
		mui.toast('获取信息失败'+JSON.stringify(data));
		return;
	}
	
	if(data && data.rscode && data.rscode == "1")
	{
		mui.toast('获取信息失败'+JSON.stringify(data));
		return;
	}
	
	if(data && data.status)
	{
		if(data.status == "0")
		{
			//未处理  按钮可以点击
			$('#deliveryBtn').text('标记为已处理');
		}
		else if(data.status == "1")
		{
			//已处理 按钮表示不可用
			$('#deliveryBtn').text('已处理');
			$('#deliveryBtn').addClass('mui-disabled');
			$('#footer').css('background','#B1A7A7');
		}
	}
}
			
function getDeliveryFailed(errorThrown, options)
{
	mui.toast('获取信息失败');
}

function modifyDeliverySuccess(data)
{
	console.log('modifyDeliverySuccess:data'+JSON.stringify(data));
	
	if(data && data.rscode == "0")
	{
		mui.toast('修改信息成功'+JSON.stringify(data));
		$('#deliveryBtn').text('已处理');
		$('#deliveryBtn').addClass('mui-disabled');
		$('#footer').css('background','#B1A7A7');
		return;
	}
	else{
		mui.toast('修改信息失败'+JSON.stringify(data));
		return;
	}
}
			
function modifyDeliveryFailed(errorThrown, options)
{
	mui.toast('修改信息失败');
}
