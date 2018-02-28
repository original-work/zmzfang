var loginUser = null;
var type = null;//type 1表示新建 工作经历，2表示修改工作经历

var eduId = null;//学历id
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
	loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
	
	if(type == 2)
	{
		//如果是修改教育经历 则从缓存中初始化相应教育经历
		$('#title').text('修改教育经历');
		$('#deleteEduInfoBtn').text('删除');
		initEduInfo();
	}
	//初始化微信分享  我的收藏页面不需要分享
	//wxShare();
});

//增加列表中tap事件
mui('.mui-content').on('tap', '#beginDate', function() {
	var options = JSON.parse('{"type":"month","beginYear":1970,"endYear":2017}');
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		//console.log('选择时间：'+rs.text);
		$('#beginDate').text(rs.text);
	});
});

//增加列表中tap事件
mui('.mui-content').on('tap', '#endDate', function() {
	var options = JSON.parse('{"type":"month","beginYear":1970,"endYear":2017}');
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		//console.log('选择时间：'+rs.text);
		$('#endDate').text(rs.text);
	});
});

 //增加保存工作信息按钮事件
document.querySelector('#saveEduInfo').addEventListener('tap', function() {
	console.log('saveEduInfo click');
	if(checkEduInfo())
	{
		saveEduInfo();
	}
    
}, false);


//增加保存教育信息按钮事件
document.querySelector('#saveEduInfoBtn').addEventListener('tap', function() {
	console.log('saveEduInfoBtn click');
	if(checkEduInfo())
	{
		saveEduInfo();
	}
    
}, false);

//增加删除教育信息按钮事件
document.querySelector('#deleteEduInfoBtn').addEventListener('tap', function() {
	console.log('deleteEduInfoBtn click');
	if(type == "1")
	{
		//新增，则为取消；
		mui.back();
	}
	else{
		//删除操作
		deleteEduInfo();
	}
    
}, false);

//增加url参数处理
function initUrlParam()
{
	 type = getQueryStrFromUrl("type");
	 eduId = getQueryStrFromUrl("eduId");
	 
	 if(type == ' ')
	 {
	 	//默认为新建
	 	type = 1;
	 }
	 if(eduId == ' ')
	 {
	 	//默认为0
	 	eduId = 0;
	 }
}
			
function initEduInfo()
{
	var data = JSON.parse(localStorage.getItem('zmzfangResumeEduInfo'));
	var eduInfo = null;
	for(var i in data)
	{
		if(data[i].eduid == eduId)
		{
			eduInfo = data[i];
			break;
		}
	}
	
	if(eduInfo)
	{
		$('#schoolInfo').val(eduInfo.schoolinfo);
		$('#major').val(eduInfo.major);
		//$('#education').val(eduInfo.education);
		$('#beginDate').text(eduInfo.begindate);
		$('#endDate').text(eduInfo.enddate);
		
		initSelectElementByText('education',eduInfo.education);
		eduId = eduInfo.eduid;
		
		
	}
}

function checkEduInfo()
{
	if(!loginUser)
	{
		mui.toast('用户未登陆');
		return false;
	}
	
	if($('#schoolInfo').val().trim() == '')
	{
		mui.toast('学校不能填空');
		return false;
	}
	
	return true;
}

function saveEduInfo()
{
	var basicInfo = JSON.parse(localStorage.getItem('zmzfangResumeBasicInfo'));
	var info = new Object();
	info.userid = loginUser.id;
	
	info.resumeid = basicInfo.id;
	info.schoolinfo = $('#schoolInfo').val();
	info.major = $('#major').val();
	info.begindate = $('#beginDate').text();
	info.enddate = $('#endDate').text();
	info.education = getSelectElementText('education');

	var url = addResumeEduInfoUrl;
	if(type == 2)
	{
		info.eduid = eduId;
		url = modifyResumeEduInfoUrl;
	}
	
	ajax_to_server(url,info,saveEduInfoSuc,saveEduInfoFailed);
}

function saveEduInfoSuc(data)
{
	console.log('saveEduInfoSuc data:'+JSON.stringify(data));
	if(data && data.rscode == 0)
	{
		mui.toast('保存信息成功');
		mui.back();
	}
	else
	{
		mui.toast('保存信息失败'+JSON.stringify(data));
	}
}

function saveEduInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

function deleteEduInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	info.eduid = eduId;
	//info.resumeid = resumeId;
	

	var url = deleteResumeEduInfoUrl;
	ajax_to_server(url,info,deleteEduInfoSuc,deleteEduInfoFailed);
}

function deleteEduInfoSuc(data)
{
	console.log('deleteEduInfoSuc data:'+JSON.stringify(data));
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

function deleteEduInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}
