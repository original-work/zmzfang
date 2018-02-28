var loginUser = null;
var type = null;//type 1表示新建 工作经历，2表示修改工作经历

var workId = null;
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
		//如果是修改工作经历 则从缓存中初始化相应工作经历
		$('#title').text('修改工作经历');
		$('#deleteWorkInfoBtn').text('删除');
		initWorkInfo();
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
document.querySelector('#saveWorkInfo,#saveWorkInfoBtn').addEventListener('tap', function() {
	console.log('saveWorkInfo click');
	if(checkWorkInfo())
	{
		saveWorkInfo();
	}
    
}, false);

 //增加保存工作信息按钮事件
document.querySelector('#saveWorkInfoBtn').addEventListener('tap', function() {
	console.log('saveWorkInfoBtn click');
	if(checkWorkInfo())
	{
		saveWorkInfo();
	}
    
}, false);

//增加删除工作信息按钮事件
document.querySelector('#deleteWorkInfoBtn').addEventListener('tap', function() {
	console.log('deleteWorkInfoBtn click');
	if(type == "1")
	{
		//新增，则为取消；
		mui.back();
	}
	else{
		//删除操作
		deleteWorkInfo();
	}
    
}, false);

//增加url参数处理
function initUrlParam()
{
	 type = getQueryStrFromUrl("type");
	 workId = getQueryStrFromUrl("workId");
	 
	 if(type == ' ')
	 {
	 	//默认为新建
	 	type = 1;
	 }
	 if(workId == ' ')
	 {
	 	//默认为0
	 	workId = 0;
	 }
}
			
function initWorkInfo()
{
	var data = JSON.parse(localStorage.getItem('zmzfangResumeWorkInfo'));
	var workInfo = null;
	for(var i in data)
	{
		if(data[i].workid == workId)
		{
			workInfo = data[i];
			break;
		}
	}
	
	if(workInfo)
	{
		$('#organization').val(workInfo.organization);
		$('#position').val(workInfo.position);
		$('#beginDate').text(workInfo.begindate);
		$('#endDate').text(workInfo.enddate);
		$('#workDetail').val(workInfo.workdetail);
		
		workId = workInfo.workid;
	}
}

function checkWorkInfo()
{
	if(!loginUser)
	{
		mui.toast('用户未登陆');
		return false;
	}
	
	if($('#organization').val().trim() == '')
	{
		mui.toast('公司不能填空');
		return false;
	}
	if($('#position').val().trim() == '')
	{
		mui.toast('职位不能填空');
		return false;
	}
	
	if($('#workDetail').val().trim() == '')
	{
		mui.toast('经历描述不能填空');
		return false;
	}
	
	return true;
}

function saveWorkInfo()
{
	/**
	resumeid	简历ID
	userid	用户ID
	organization	工作单位
	position	职位名称
	begindate	工作开始时间，如201501
	enddate	工作结束时间，可以填至今
	workdetail	工作描述
	**/
	var basicInfo = JSON.parse(localStorage.getItem('zmzfangResumeBasicInfo'));
	var info = new Object();
	info.userid = loginUser.id;
	info.resumeid = basicInfo.id;
	info.organization = $('#organization').val();
	info.position = $('#position').val();
	info.begindate = $('#beginDate').text();
	info.enddate = $('#endDate').text();
	info.workdetail = $('#workDetail').val();

	var url = addResumeWorkInfoUrl;
	if(type == 2)
	{
		info.workid = workId;
		url = modifyResumeWorkInfoUrl;
	}
	
	ajax_to_server(url,info,saveWorkInfoSuc,saveWorkInfoFailed);
}

function saveWorkInfoSuc(data)
{
	console.log('saveWorkInfoSuc data:'+JSON.stringify(data));
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

function saveWorkInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

function deleteWorkInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	info.workid = workId;

	var url = deleteResumeWorkInfoUrl;
	ajax_to_server(url,info,deleteWorkInfoSuc,deleteWorkInfoFailed);
}

function deleteWorkInfoSuc(data)
{
	console.log('deleteWorkInfoSuc data:'+JSON.stringify(data));
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

function deleteWorkInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}
