var loginUser = null;
var type = null;//type 1表示新建 工作经历，2表示修改工作经历
var resumeId = null;//简历id
var basicInfo = null;
var pic;
var picname;
var result = true;
			
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
	basicInfo = JSON.parse(localStorage.getItem('zmzfangResumeBasicInfo'));
	//初始化工作城市
	initWorkCityPicker();
	//初始化籍贯城市
	initHomeCityPicker();
	
	if(type == 2)
	{
		//如果是修改基本信息 则从缓存中初始化相应基本信息
		$('#title').text('修改基本信息');
		$('#deleteBasicInfoBtn').text('删除');
		initBasicInfo();
	}
	//初始化微信分享  我的收藏页面不需要分享
	//wxShare();
});


//增加列表中tap事件
document.querySelector('#age').addEventListener('tap', function() {
	var options = JSON.parse('{"type":"month","beginYear":1960,"endYear":2017}');
	var picker = new mui.DtPicker(options);
	picker.show(function(rs) {
		//console.log('选择时间：'+rs.text);
		$('#age').text(rs.text);
	});
}, false);

document.querySelector('#workPeriod').addEventListener('tap', function() {
	//级联示例
	var numPicker = new mui.PopPicker();
	var numArray = new Array();
	for(var i=1;i<30;i++)
	{	
		numArray.push({value:i,text:i+"年"});
	}
	
	numPicker.setData(numArray);
	numPicker.show(function(items) {
		console.log("你选择的是:" + items[0].text);
		$('#workPeriod').text(items[0].text);
		//返回 false 可以阻止选择框的关闭
		//return false;
	});
}, false);

 //增加保存工作信息按钮事件
document.querySelector('#saveBasicInfo').addEventListener('tap', function() {
	console.log('saveBasicInfo click');
	if(checkBasicInfo())
	{
		saveBasicInfo();
	}
}, false);

//增加保存基本信息按钮事件
document.querySelector('#saveBasicInfoBtn').addEventListener('tap', function() {
	console.log('saveBasicInfoBtn click');
	if(checkBasicInfo())
	{
		saveBasicInfo();
	}
    
}, false);

//增加删除基本信息按钮事件
document.querySelector('#deleteBasicInfoBtn').addEventListener('tap', function() {
	console.log('deleteBasicInfoBtn click');
	if(type == "1")
	{
		//新增，则为取消；
		mui.back();
	}
	else{
		//删除操作
		deleteBasicInfo();
	}
    
}, false);


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
			
function initBasicInfo()
{
	if(basicInfo)
	{
		
		//$('#headPic').val(basicInfo.userheadpic);
		$('.pick-button').css('background-image','url('+basicInfo.userheadpic+')')
		picname = basicInfo.userheadpic;
		
		$('#realName').val(basicInfo.realname);
		$('#organization').val(basicInfo.organization);
		
		$('#workCity').text(basicInfo.city);
		$('#homeCity').text(basicInfo.homecity);
		
		$('#age').text(basicInfo.age);
		$('#workPeriod').text(basicInfo.workperiod);
		initSelectElementByText('education',basicInfo.education);
		$('#phone').val(basicInfo.phone);
		$('#resumeDetail').val(basicInfo.resumedetail);
		
		initSelectElementByText('position',basicInfo.position);
		resumeId = basicInfo.id;
	}
}

function checkBasicInfo()
{
	if(!loginUser)
	{
		mui.toast('用户未登陆');
		return false;
	}
	
	if($('#realName').val().trim() == '')
	{
		mui.toast('名字不能填空');
		return false;
	}
	if($('#phone').val().trim() == '')
	{
		mui.toast('电话不能填空');
		return false;
	}
	
	if($('#resumeDetail').val().trim() == '')
	{
		mui.toast('求职附言不能填空');
		return false;
	}
	
	var detailLen = getByteLen($('#resumeDetail').val().trim());
	if(detailLen < 20)
	{
		mui.toast('求职附言不能小于10个汉字');
		return false;
	}
	return true;
}

function saveBasicInfo()
{
	/**
	userid	用户ID
	usertype	用户类型，0表示普通用户，1表示经纪人
	userheadpic	用户头像
	realname	姓名
	organization	目前工作单位
	city	目前工作城市
	homecity	籍贯
	workperiod	工作经验，年限
	age	年龄
	phone	联系方式
	resumedetail	求职附言

	**/
	
	var info = new Object();
	info.userid = loginUser.id;
	if(loginUser.agentflag == "1")
	{
		info.usertype = 2;
	}
	else
	{
		info.usertype = 1;
	}
	
	//info.userheadpic = $('#headPic').val();
	info.realname = $('#realName').val();
	
	info.organization = $('#organization').val();
	info.city = $('#workCity').text();
	info.homecity = $('#homeCity').text();
	
	info.age = $('#age').text();
	info.workperiod = $('#workPeriod').text();
	info.phone = $('#phone').val();
	info.position = getSelectElementText('position');
	info.education = getSelectElementText('education');
	info.resumedetail = $('#resumeDetail').val();
	uploadPic();
	if(!result){
		return;
	}
	var picture = picname;
	//alert(picture);
	info.userheadpic = picture;
				
	var url = addResumeBasicInfoUrl;
	if(type==2)
	{
		info.resumeid = resumeId;
		url = modifyResumeBasicInfoUrl;
	}
	
	ajax_to_server(url,info,saveBasicInfoSuc,saveBasicInfoFailed);
}

function saveBasicInfoSuc(data)
{
	console.log('saveBasicInfoSuc data:'+JSON.stringify(data));
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

function saveBasicInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

//初始化工作城市按钮
function initWorkCityPicker()
{
	//级联示例
	var cityPicker = new mui.PopPicker({
		layer: 2
	});
	cityPicker.setData(cityData);
	var showCityPickerButton = document.getElementById('workCity');
	
	showCityPickerButton.addEventListener('tap', function(event) {
		cityPicker.show(function(items) {
			
			console.log("你选择的城市是:" + items[0].text + " " + items[1].text);
			showCityPickerButton.innerText = items[0].text + " " + items[1].text;
			//返回 false 可以阻止选择框的关闭
			//return false;
		});
	}, false);
}

//初始化籍贯城市按钮
function initHomeCityPicker()
{
	//级联示例
	var cityPicker = new mui.PopPicker({
		layer: 2
	});
	cityPicker.setData(cityData);
	var showCityPickerButton = document.getElementById('homeCity');
	
	showCityPickerButton.addEventListener('tap', function(event) {
		cityPicker.show(function(items) {
			
			console.log("你选择的城市是:" + items[0].text + " " + items[1].text);
			showCityPickerButton.innerText = items[0].text + " " + items[1].text;
			//返回 false 可以阻止选择框的关闭
			//return false;
		});
	}, false);
}

function deleteBasicInfo()
{
	var info = new Object();
	info.userid = loginUser.id;
	info.resumeid = basicInfo.id;
	var url = deleteResumeBasicInfoUrl;
	ajax_to_server(url,info,deleteBasicInfoSuc,deleteBasicInfoFailed);
}

function deleteBasicInfoSuc(data)
{
	console.log('deleteBasicInfoSuc data:'+JSON.stringify(data));
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

function deleteBasicInfoFailed(data)
{
	mui.toast('保存信息失败'+JSON.stringify(data));
}

// 图片渲染
$('#file').on('change',function(){
	$('.pick-button label').html('<div class="imgpath"><img src="../../js/PicUpload/loading.gif" width="80" height="80" /><span></span></div>');
	lrz(this.files[0], {width: 128})
	.then(function (rst) {
		var img = new Image();
		img.src = rst.base64;
		img.onload = function () {
			$('.imgpath img').attr('src',rst.base64)
		};
		
		pic = rst.base64
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