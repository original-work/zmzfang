var loginUser = null;
var type = null;//type 1表示新建 活动，2表示修改活动
var activityId = null;//简历id
var basicInfo = null;
var pic;
var picname;
var result = true;

var havaOrgFlag = false;
var cityPicker = new mui.PopPicker({
		layer: 2
	});
	
var byId = function(id) {
	return document.getElementById(id);
};
 //初始化url参数来获取需求id和用户id,如果没有继续执行
initUrlParam();
		    
mui.init({
	swipeBack: false
});
			
mui.ready(function() {
	//$('#mineLink').addClass('mui-active')
	loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
	basicInfo = JSON.parse(localStorage.getItem('zmzfangActivityInfo'));
	
	//初始化活动城市
	initCityPicker();
	
	//初始化活动公司信息
	initActivityOrganizationInfo();
	if(type == 2)
	{
		//如果是修改基本信息 则从缓存中初始化相应基本信息
		$('#title').text('修改活动信息');
		//$('#deleteInfoBtn').text('删除');
		
		initActivityInfo();
	}
	//初始化微信分享  我的收藏页面不需要分享
	//wxShare();
});

//增加列表中tap事件
document.querySelector('#beginDate').addEventListener('tap', function() {
	var options = JSON.parse('{"type":"datetime","beginYear":2017,"endYear":2018}');
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		console.log('选择时间：'+rs.text);
		$('#beginDate').text(rs.text);
	});
}, false);

//增加列表中tap事件
document.querySelector('#endDate').addEventListener('tap', function() {
	var options = JSON.parse('{"type":"datetime","beginYear":2017,"endYear":2018}');
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		console.log('选择时间：'+rs.text);
		$('#endDate').text(rs.text);
	});
}, false);



 //增加保存活动信息按钮事件
document.querySelector('#saveInfo').addEventListener('tap', function() {
	console.log('saveInfo click');
	if(checkInfo())
	{
		saveActivityInfo();
	}
}, false);

//增加保存活动信息按钮事件
document.querySelector('#saveInfoBtn').addEventListener('tap', function() {
	console.log('saveInfoBtn click');
	if(checkInfo())
	{
		$('#saveInfoBtn').addClass('mui-disabled');
		$('#saveInfoBtn').css('background-color','grey');
		saveActivityInfo();
	}
    
}, false);

//增加删除活动信息按钮事件
document.querySelector('#deleteInfoBtn').addEventListener('tap', function() {
	console.log('deleteInfoBtn click');
//	if(type == "1")
//	{
//		//新增，则为取消；
//		mui.back();
//	}
//	else{
//		//删除操作
//		deleteActivityInfo();
//	}
	mui.back();
    
}, false);

$('#authFlag').on('tap',function(){
	if($('#authFlag').hasClass('mui-active'))
	{
		if(havaOrgFlag)
		{
			$('#organizationNameLi').removeClass('mui-hidden');
			$('#contactNameLi').removeClass('mui-hidden');
			$('#contactPhoneLi').removeClass('mui-hidden');
		}
		else
		{
			var btnArray = ['否', '是'];
			 mui.confirm('没有填写公司信息，前去填写?', '芝麻找房', btnArray, function(e) {
                    if (e.index == 1) {
                        console.log('前去填写公司信息');
                        mui.openWindow(
                        	{
                        		url:"./ActivityOrganization.html",
                        		id:"./ActivityOrganization.html"
                        	}
                        );
                    } else {
                        console.log('取消');
                    }
            })
		}
		
	}
	else
	{
		$('#organizationNameLi').addClass('mui-hidden');
		$('#contactNameLi').addClass('mui-hidden');
		$('#contactPhoneLi').addClass('mui-hidden');
	}
	
});
			
//增加url参数处理
function initUrlParam()
{
	 type = getQueryStrFromUrl("type"); 
	 if(type == ' ')
	 {
	 	//默认为新建
	 	type = 1;
	 }
}
			
function initActivityInfo()
{
	if(basicInfo)
	{
		//$('#headPic').val(basicInfo.userheadpic);
		$('#headpic').css("height","140px");
		$('.pick-button').css({"width":"100%","height":"140px","background-size":"100% 140px"});
		$('.pick-button').css('background-image','url('+basicInfo.activitypic+')');
		$('.pick-button label').css({'width':'100%','height':'140px'});
		$('.imgpath img').css({'width':'100%','height':'140px'});
		
		//$('.pick-button label').css({'width':'100%','height':'140px'});
		//$('.imgpath img').css({'width':'100%','height':'140px'});
		
		picname = basicInfo.activitypic;
	
		$('#activitySubject').val(basicInfo.activitysubject);
		initSelectElementByValue('activityType',basicInfo.activitytype);
		
		$('#beginDate').text(basicInfo.begintime);
		$('#endDate').text(basicInfo.endtime);
		
	    $('#activityCity').text(basicInfo.activitycity);
	    $('#activityLocation').val(basicInfo.location);
	    $('#personCnt').val(basicInfo.personcount);
	    $('#fee').val(basicInfo.fee);
	
	    $('#activityDetail').val(basicInfo.activitydetail);
	    
		if(basicInfo.organizationauth == "1")
		{
			$('#authFlag').addClass('mui-active');
			$('#organizationNameLi').removeClass('mui-hidden');
			$('#contactNameLi').removeClass('mui-hidden');
			$('#contactPhoneLi').removeClass('mui-hidden');
			
		}
		activityId = basicInfo.activityid;
	}
}

function checkInfo()
{
	if(!loginUser)
	{
		mui.toast('用户未登陆');
		return false;
	}
	
	if($('#activitySubject').val().trim() == '')
	{
		mui.toast('活动主题不能填空');
		return false;
	}
	
	if($('#activityCity').text() == '请选择')
	{
		mui.toast('活动城市不能为空');
		return false;
	}


	if($('#activityLocation').val().trim() == '')
	{
		mui.toast('活动地点不能填空');
		return false;
	}
		
	
	if($('#activityDetail').val().trim() == '')
	{
		mui.toast('活动详情不能填空');
		return false;
	}
	
	if(parseInt($('#fee').val().trim()) >= 0)
	{
		console.log('fee >= 0');
	}
	else
	{
		mui.toast('费用应该大于或等于0');
		return false;
	}
	
	return true;
}

function saveActivityInfo()
{
	var info = new Object();
	info.publishuserid = loginUser.id;
	if(loginUser.agentflag == "1")
	{
		info.publishusertype = 2;
	}
	else
	{
		info.publishusertype = 1;
	}
				
	info.activitysubject = $('#activitySubject').val();
	info.activitytype = getSelectElementValue('activityType');
	
	info.begintime = $('#beginDate').text();
	info.endtime = $('#endDate').text();
	info.activitycity = $('#activityCity').text();
	info.location = $('#activityLocation').val();
	info.personcount = $('#personCnt').val();
	info.fee = $('#fee').val();
	
	info.activitydetail = $('#activityDetail').val();
	
	info.organizationauth = $('#authFlag').hasClass('mui-active')? 1 :0;
	
	uploadPic();
	if(!result){
		return;
	}
	var picture = picname;
	//alert(picture);
	info.activitypic = picture;
				
	var url = addActivityUrl;
	if(type==2)
	{
		info.activityid = activityId;
		url = modifyActivityUrl;
	}
	
	ajax_to_server(url,info,saveActivityInfoSuc,saveActivityInfoFailed);
}

function saveActivityInfoSuc(data)
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

function saveActivityInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

//初始化城市按钮
function initCityPicker()
{
	//级联示例
	
	//cityPicker.setData(cityData);
	
	var data = cityData;
	
	for(var i in data)
	{
		//data[i].children.splice(0,data[i].children.length);
		data[i].children.unshift({value: "000000",text: "不限"});
	}
	data.unshift({value: '000000',
	text: '不限',
	children: []});
	cityPicker.setData(data);
				
	
	var showCityPickerButton = document.getElementById('activityCity');
	
	showCityPickerButton.addEventListener('tap', function(event) {
		cityPicker.show(function(items) {
			
			console.log("你选择的城市是:" + items[0].text + " " + items[1].text);
			if(items[1])
			{
				if(items[1].text == "不限")
				{
					showCityPickerButton.innerText = items[0].text;
				}
				else
				{
					showCityPickerButton.innerText = items[0].text + " " + items[1].text;
				}
			}
			else
			{
				showCityPickerButton.innerText = items[0].text;
			}
			
			//返回 false 可以阻止选择框的关闭
			//return false;
		});
	}, false);
}

function deleteActivityInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	info.activityid = basicInfo.activityid;
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

// 图片渲染
$('#file').on('change',function(){
	$('.pick-button label').html('<div class="imgpath"><img src="../../js/PicUpload/loading.gif" width="100%" height="140" /><span></span></div>');
	lrz(this.files[0], {width: 420})
	.then(function (rst) {
		$('#headpic').css("height","140px");
		$('.pick-button').css({"width":"100%","height":"140px"});
		$('.pick-button label').css({'width':'100%','height':'140px'});
		$('.imgpath img').css({'width':'100%','height':'140px'});
		var img = new Image();
		img.src = rst.base64;
		img.onload = function () {
			$('.imgpath img').attr('src',rst.base64)
		};
		
		pic = rst.base64;
		
	})

})
// 图片上传
function uploadPic() {
	if(!pic){
		return;
	}
	$.ajax({
		url: 'http://www.zmzfang.com/?r=user/headpic-upload',
		data: {base64:pic},
		async: false,
		type: 'POST',
		dataType:"json",
		beforeSend: function(){
			$('.imgpath').children('span').addClass('active');
			$('.imgpath').children('span').css('background-color','#007aff;');
			$('.imgpath').children('span').text('上传中');
		},
		success: function (data) {
			if(data.status > 0){
				// $('.imgpath').removeClass('active');
				$('.imgpath').children('span').css('background-color','#073');
				$('.imgpath').children('span').text('ok');
				mui.toast('头像已上传');
				picname = "http://www.zmzfang.com/weixin/img/headpic/"+data.picname;
			}else{
				// $('.imgpath').removeClass('active');
				$('.imgpath').children('span').css('background-color','#c00');
				$('.imgpath').children('span').text('fail');
				mui.toast('头像上传失败了！');
				result = false;
			}
			
		},error:function (){
			$('.imgpath').removeClass('active');
			$('.imgpath').children('span').css('background-color','#c00');
			$('.imgpath').children('span').text('fail');
			mui.toast('头像上传失败了！');
			result = false;
		}
	});
}

function initActivityOrganizationInfo()
{
	var url = getActivityOrgUrl;
	var info = new Object();
	info.userid = loginUser.id;
	
	ajax_to_server(url,info,getActivityOrganizationInfoSuc,getActivityOrganizationInfoFailed);
}

function getActivityOrganizationInfoSuc(data)
{
	console.log('getActivityOrganizationInfoSuc data:'+JSON.stringify(data));
	if(data && data.rscode == '0')
	{
		havaOrgFlag = true;
		$('#organizationName').val(data.data.organization);
		$('#contactName').val(data.data.contactname);
		$('#contactPhone').val(data.data.contactphone);
	}
	
}

function getActivityOrganizationInfoFailed(data)
{
	console.log('getActivityOrganizationInfoFailed data:'+JSON.stringify(data));
}