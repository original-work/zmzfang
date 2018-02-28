var loginUser = null;
var type = 1;//type 1表示新建 活动组织，2表示修改活动组织
var organizationId = null;

var byId = function(id) {
	return document.getElementById(id);
};
		    
mui.init({
	swipeBack: false
});
			
mui.ready(function() {
	//$('#mineLink').addClass('mui-active')
	loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
	
	initActivityOrganizationInfo();
});

//增加保存活动组织信息按钮事件
document.querySelector('#saveInfoBtn').addEventListener('tap', function() {
	console.log('saveInfoBtn click');
	if(checkInfo())
	{
		$('#saveInfoBtn').addClass('mui-disabled');
		$('#saveInfoBtn').css('background-color','grey');
		saveActivityOrganizationInfo();
	}
    
}, false);

//增加删除活动组织信息按钮事件
document.querySelector('#deleteInfoBtn').addEventListener('tap', function() {
	console.log('deleteInfoBtn click');
	if(type == "1")
	{
		//新增，则为取消；
		mui.back();
	}
	else{
		//删除操作
		deleteActivityOrganizationInfo();
	}
    
}, false);

			
function initActivityOrganizationInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	var url = getActivityOrgUrl;
	ajax_to_server(url,info,getActivityOrganizationInfoSuc,getActivityOrganizationInfoFailed);
}

function getActivityOrganizationInfoSuc(data)
{
	console.log('getActivityOrganizationInfoSuc:'+JSON.stringify(data));
	if(data)
	{
		if(data.rscode == "0")
		{
			$('#organizationName').val(data.data.organization);
			$('#organizationDetail').val(data.data.organizationdetail);
			$('#organizationLocation').val(data.data.organizationlocation);
			$('#contactName').val(data.data.contactname);
			$('#contactPhone').val(data.data.contactphone);
			organizationId = data.data.organizationid;
			//修改
			type = 2;
			//如果是修改基本信息 则从缓存中初始化相应基本信息
			$('#title').text('修改活动信息');
			$('#deleteInfoBtn').text('删除');
	
		}
		else if(data.rscode == "1")
		{
			//新增
		}
		
	}
	
}

function getActivityOrganizationInfoFailed(data)
{
	console.log('getActivityOrganizationInfoFailed:'+JSON.stringify(data));
	
}


function checkInfo()
{
	if(!loginUser)
	{
		mui.toast('用户未登陆');
		return false;
	}
	
	if($('#organizationName').val().trim() == '')
	{
		mui.toast('公司名称不能填空');
		return false;
	}
	
	
	
	return true;
}

function saveActivityOrganizationInfo()
{
	var info = new Object();
	info.userid = loginUser.id;

	info.organization = $('#organizationName').val();
	info.organizationdetail = $('#organizationDetail').val();
	info.organizationlocation = $('#organizationLocation').val();
	info.contactname = $('#contactName').val();
	info.contactphone = $('#contactPhone').val();
				
	var url = addActivityOrgUrl;
	if(type==2)
	{
		info.organizationid = organizationId;
		url = modifyActivityOrgUrl;
	}
	
	ajax_to_server(url,info,saveActivityOrganizationInfoSuc,saveActivityOrganizationInfoFailed);
}

function saveActivityOrganizationInfoSuc(data)
{
	console.log('saveActivityInfoSuc data:'+JSON.stringify(data));
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

function saveActivityOrganizationInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

function deleteActivityOrganizationInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	info.organizationid = organizationId;
	var url = deleteActivityOrgUrl;
	ajax_to_server(url,info,deleteActivityOrganizationInfoSuc,deleteActivityOrganizationInfoFailed);
}

function deleteActivityOrganizationInfoSuc(data)
{
	console.log('deleteActivityOrganizationInfoSuc data:'+JSON.stringify(data));
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

function deleteActivityOrganizationInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}
