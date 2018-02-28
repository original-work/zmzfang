var user = null;
var modifyInfo = new Object();

var selectRegionFlag = 0;
var selectedRegionValueArray = new Array();
var selectedRegionTextArray = new Array();

var selectDomainFlag = 0;
var selectedDomainValueArray = new Array();
var selectedDomainTextArray = new Array();

var expertId;
var offlinetime = 1;
var getJssdkConfUrl = "http://www.zmzfang.com/?r=door/get-jssdk&url=http://www.zmzfang.com/weixin/Expert/Mine/MyExpert.html";			
var businessCardLocalId = null;
var headPicLocalId = null;
var businessCardServerId = null;
var headPicServerId = null;
var serverIdArray = [];
var expertStatus = 0;//专家当前状态
var rejectReason = '';//专家申请被拒绝原因
var byId = function(id) {
	return document.getElementById(id);
};
			
(function($, doc) {
	mui.init({
		swipeBack: false
	});
			
	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			user = JSON.parse(data);
		}
		else
		{
			mui.toast("未获取到用户登陆信息");
			return;
		}
		expertId = user.expertid;
		
		initExpertDetail();
		
		initRegionPickerInfo();
		initDomainPickerInfo();
		
	});

}(mui, document));
	
//增加事件
//在下一步按钮上增加tap事件
document.querySelector('#nextStep').addEventListener('tap', function() {
	console.log('nextStep click');
	if(checkSection1())
	{
		$('#applyExperDiv1').addClass('mui-hidden');
		$("#applyExperDiv2").removeClass('mui-hidden');
	}
}, false);

//在上一步按钮上增加tap事件
document.querySelector('#preStep').addEventListener('tap', function() {
	console.log('preStep click');
	
	$('#applyExperDiv2').addClass('mui-hidden');
	$("#applyExperDiv1").removeClass('mui-hidden');

}, false);

//在提交按钮上增加tap事件
document.querySelector('#save').addEventListener('tap', function() {
	console.log('save click');
	if(checkSection1() && checkSection2())
	{
		//进行提交工作
		if(headPicLocalId == null && businessCardLocalId == null)
		{
			modifyExpert();
		}
		else
		{
			uploadPics(modifyExpert);
		}
		
	}

}, false);

//线下约见时长选择框
function initOfflineDiv()
{
	mui('.mui-input-row').on('tap', '.mui-radio', function() {
	$(this).children('.offlinetime-radio').attr('checked','checked');
	offlinetime = $(this).children('.offlinetime-radio').attr('data');
	console.log('select offlinetime:' + offlinetime);
	});
}


function initExpertDetail()
{
	console.log('initExpertDetail');
	var options = new Object();
	//需要获取专家id
	options.id = expertId;
	ajax_get_expert_detail(options,getExpertDetailSuc,getExpertDetailFailed);
}

function initJssdkConfig()
{
	newPlaceholder();
	ajax_get_jssdk_conf();
}

//检查申请页面1
function checkSection1()
{
	if(user == null)
	{
		mui.toast("用户未正常登陆");
		return false;
	}
	modifyInfo.expertid = user.expertid;
	modifyInfo.userid = user.id;
	modifyInfo.name = byId("name").value;
	if(modifyInfo.name == '')
	{
		mui.toast('您的姓名不可为空');
		return false;
	}
	
	modifyInfo.organization = byId("organization").value;
	if(modifyInfo.organization == '')
	{
		mui.toast('您的任职机构不能为空');
		return false;
	}
	
	var index = byId("workperiod").selectedIndex;
	modifyInfo.workperiod = byId("workperiod").options[index].value;
	
	modifyInfo.position = byId("position").value;
	if(modifyInfo.position == '')
	{
		mui.toast('您的头衔职位不能为空');
		return false;
	}
	
	modifyInfo.email = byId("email").value;
	if(!isEmail(modifyInfo.email))
	{
		mui.toast('您的邮箱不能为空');
		return false;
	}
	
	//modifyInfo.activeregion = byId("activeRegion").value;
	
	if(selectRegionFlag == 0)
	{
		mui.toast('请您选择活动区域');
		return false;
	}
	modifyInfo.activeregion = selectedRegionValueArray.join();
	console.log('modifyInfo.activeregion :' + modifyInfo.activeregion);
	
	if(selectDomainFlag == 0)
	{
		mui.toast('请您选择领域');
		return false;
	}
	modifyInfo.domain = selectedDomainValueArray.join();
	
	//modifyInfo.businesscard = byId("businessCardPic").src;
	
	if(businessCardLocalId == null)
	{
		modifyInfo.businesscard = byId("businessCardPic").src;
	}
	else
	{
		modifyInfo.businesscard = businessCardLocalId;
	}
	
	console.log('modifyInfo.userid :' + modifyInfo.userid);
	console.log('modifyInfo.name :' + modifyInfo.name);
	console.log('modifyInfo.organization :' + modifyInfo.organization);
	console.log('modifyInfo.workperiod :' + modifyInfo.workperiod);
	console.log('modifyInfo.position :' + modifyInfo.position);
	console.log('modifyInfo.email :' + modifyInfo.email);
	console.log('modifyInfo.activeregion :' + modifyInfo.activeregion);
	console.log('modifyInfo.domain :' + modifyInfo.domain);
	console.log('modifyInfo.businesscard :' + modifyInfo.businesscard);
	return true;
}
			
//检查申请页面2
function checkSection2()
{
	//modifyInfo.headpicture = byId("headPic").src;
	if(headPicLocalId == null)
	{
		modifyInfo.headpicture = byId("headPic").src;
	}
	else
	{
		modifyInfo.headpicture = headPicLocalId;
	}
	
	
	modifyInfo.introduction = byId("introduction").value;
	if(modifyInfo.introduction == '')
	{
		mui.toast('您的个人简介不能为空');
		return false;
	}
	
	modifyInfo.expertisen = modifyInfo.introduction;
//	if(modifyInfo.expertisen == '')
//	{
//		mui.toast('您的专长介绍不能为空');
//		return false;
//	}
	
	modifyInfo.onlinecharge = byId("onlinecharge").value;
	if(modifyInfo.onlinecharge == '' || isNaN(modifyInfo.onlinecharge))
	{
		mui.toast('您的在线提问收费不规范，请填写合法数字');
		return false;
	}
	if(parseInt(modifyInfo.onlinecharge) < 1 || parseInt(modifyInfo.onlinecharge) > 50)
	{
		mui.toast('在线提问金额设定建议在1-50间');
		return false;
	}
	
	modifyInfo.offlinetime = offlinetime;
	modifyInfo.offlinecharge = byId("offlinecharge").value;
	if(modifyInfo.offlinecharge == '' || isNaN(modifyInfo.offlinecharge))
	{
		mui.toast('您的线下约见收费不规范，请填写合法数字');
		return false;
	}
	if(parseInt(modifyInfo.offlinecharge) < 1 || parseInt(modifyInfo.offlinecharge) > 1000)
	{
		mui.toast('线下约见收费金额设定建议在1-1000间');
		return false;
	}
	
	
	console.log('modifyInfo.headpicture :' + modifyInfo.headpicture);
	console.log('modifyInfo.introduction :' + modifyInfo.introduction);
	console.log('modifyInfo.expertisen :' + modifyInfo.expertisen);
	console.log('modifyInfo.onlinecharge :' + modifyInfo.onlinecharge);
	console.log('modifyInfo.offlinetime :' + modifyInfo.offlinetime);
	console.log('modifyInfo.offlinecharge :' + modifyInfo.offlinecharge);
	return true;
}
	
	//发送ajax请求
function modifyExpert()
{
	console.log("modifyExpert");
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	ajax_modify_expert(modifyInfo,modifyExpertSuc,modifyExpertFailed);
}
	
function modifyExpertSuc(data)
{
	console.log("modifyExpertSuc data:"+JSON.stringify(data));
	//alert('modifyExpertSuc:'+JSON.stringify(data));
	
	if(data.rscode == '0')
	{
		console.log("modifyExpertSuc rscode:0");
		//跳转到我的 页面
		//将微信serverdi图片信息上传给给后台
		
		var expertid = user.expertid;
		var houseid = '0';
				
		var type = "4";//表示专家头像
		var status = "1";//表示初始状态
		
		var options = {
			type: type,
			userid: expertid,
			houseid: houseid,
			housepicsn: '0',
			serverid: serverIdArray[0],
			localid: headPicLocalId,
			url: "",
			status: status
		};
		//上传专家头像
		//alert('ajax_add_weixin_pic 1:'+JSON.stringify(options));
		if(headPicLocalId != null)
		{
			mui.toast('上传专家图像');
			ajax_add_weixin_pic(options,addWeixinPicSuccess,addWeixinPicFailed);
		}

        //上传专家名片
        if(businessCardLocalId != null)
        {
        	options.type = '5';
        	if(headPicLocalId != null)
        	{
        		options.serverid = serverIdArray[1];
        	}
        	else
        	{
        		options.serverid = serverIdArray[0];
        	}
			
			options.localid = businessCardLocalId;
			//alert('ajax_add_weixin_pic 2:'+JSON.stringify(options));
			ajax_add_weixin_pic(options,addWeixinPicSuccess,addWeixinPicFailed);
        }
		
		localStorage.setItem("zmzfangExpertApplyFlag",'1');//标记为已申请
		mui.toast("您的修改已提交成功，请您耐心等待");
		mui.back();
	}
	else
	{
		mui.toast('修改专家信息失败:'+JSON.stringify(data));
		console.log("modifyExpertSuc data:"+JSON.stringify(data));
	}
}
	
function modifyExpertFailed(data)
{
	console.log("modifyExpertFailed data:"+JSON.stringify(data));
}
	
function initRegionPickerInfo()
{
	console.log('initRegionPickerInfo');
	var regionPicker = new mui.PopPicker();
	regionPicker.setData(regionData);
	var showRegionPickerButton = byId('showRegionPicker');
	var regionResult = byId('regionResult');
	
	showRegionPickerButton.addEventListener('tap', function(event) {
		regionPicker.show(function(items) {
			//regionResult.innerText = JSON.stringify(items[0]);
			//返回 false 可以阻止选择框的关闭
			//return false;
			if(selectedRegionValueArray.length >2){
				mui.toast('您最多可选3个区域，请删除后再操作！');
				return;
			}
			
			for (i in selectedRegionValueArray){
				if(items[0].value == selectedRegionValueArray[i]){
					mui.toast('该区域已存在！');
					return;
				}
				else
				{
					if(selectedRegionValueArray[i] == '130000')
					{
						mui.toast('您已选择所有区域');
						return;
					}
				}
				
			}
						
			selectedRegionValueArray.push(items[0].value);
			selectedRegionTextArray.push(items[0].text);
			console.log(selectedRegionValueArray);

			showRegionResult();
			selectRegionFlag = 1;//
		});
	}, false);
}

function initDomainPickerInfo()
{
	console.log('initDomainPickerInfo');
	var domainPicker = new mui.PopPicker();
	domainPicker.setData(domainData);
	var showDomainPickerButton = byId('showDomainPicker');
	var domainResult = byId('domainResult');
	
	showDomainPickerButton.addEventListener('tap', function(event) {
		domainPicker.show(function(items) {
			//DomainResult.innerText = JSON.stringify(items[0]);
			//返回 false 可以阻止选择框的关闭
			//return false;
			if(selectedDomainValueArray.length >2){
				mui.toast('您最多可选3个领域，请删除后再操作！');
				return;
			}
			
			for (i in selectedDomainValueArray){
				if(items[0].value == selectedDomainValueArray[i]){
					mui.toast('该领域已存在！');
					return;
				}
			}
						
			selectedDomainValueArray.push(items[0].value);
			selectedDomainTextArray.push(items[0].text);
			console.log(selectedDomainValueArray);

			showDomainResult();
			   
			selectDomainFlag = 1;//
		});
	}, false);
}

function newPlaceholder() {
    document.querySelector('#businessCardPic').addEventListener('tap', function() {
    	console.log('businessCardPic click');
		wx.chooseImage({
			count: 1, // 默认9
			sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有original compressed
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function(res) {
				var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				businessCardLocalId = localIds;
				byId("businessCardPic").src = localIds;
			}
		});
	}, false);
	
	document.querySelector('#headPic').addEventListener('tap', function() {
		wx.chooseImage({
			count: 1, // 默认9
			sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有original compressed
			sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
			success: function(res) {
				var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
				headPicLocalId = localIds;
				byId("headPic").src = localIds;
			}
		});
	}, false);
	

};

function ajax_get_jssdk_conf(options) {
	//console.log(JSON.stringify(options));
	console.log('ajax_get_jssdk_conf getJssdkConfUrl:'+getJssdkConfUrl);
	jQuery.ajax({
		url: getJssdkConfUrl,
		data: JSON.stringify(options),
		dataType: 'json', //服务器返回json格式数据
		type: 'get', //HTTP请求类型
		timeout: 10000, //超时时间设置为10秒；
		async: false,
		success: function(data) {

			getJssdkConfSuccess(data);
		},
		error: function(xhr, type, errorThrown) {
			getJssdkConfFailed(errorThrown);
		}
	});
}

function getJssdkConfSuccess(data) {
	console.log("config  " + JSON.stringify(data));
	wx.config({
		debug: false,
		appId: data.appId,
		timestamp: data.timestamp,
		nonceStr: data.nonceStr,
		signature: data.signature,
		jsApiList: [
			// 所有要调用的 API 都要加到这个列表中
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage'
		]
	});
	wx.ready(function() {
		// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
	});

}

function getJssdkConfFailed(data) {
	console.log("error " + JSON.stringify(data));
}

function uploadPics(successFun) {
	
	if(headPicLocalId == null && byId("headPic").src == null)
	{
		mui.toast('您的个人头像不能为空');
		return false;
	}
	var paths = [];
	serverIdArray = [];
	
	if(headPicLocalId != null)
	{
		paths.push(headPicLocalId);
	}
	
	if(businessCardLocalId != null)
	{
		paths.push(businessCardLocalId);
	}
	
	var i = 0;
	var length = paths.length;
	function uploadImageToWeixin() {
		var localId=paths[i].toString();
		wx.uploadImage({
			localId: localId,
			success: function(res) {
				i++;
				//alert('已上传：' + i + '/' + length + "serverId=" + res.serverId);
				mui.toast('已上传：' + i+'张图片');
				serverIdArray.push(res.serverId);
				
				if (i < length) {
					uploadImageToWeixin();
				}
				//
				if (i == length)
				{
					//全部上传完成 调度发布函数
					//alert('begin publish');
					successFun();
				}
			},
			fail: function(res) {
				alert(JSON.stringify(res));
			}
		});
	}
	uploadImageToWeixin();
}


function ajax_add_weixin_pic(options) {
	//alert(addWeixinPicUrl);
	jQuery.ajax(addWeixinPicUrl, {
		data: JSON.stringify(options),
		dataType: 'json', //服务器返回json格式数据
		type: 'post', //HTTP请求类型
		timeout: 10000, //超时时间设置为10秒；
		async: false,
		success: function(data) {
			//验证通过后进行登录
			addWeixinPicSuccess(data);
		},
		error: function(xhr, type, errorThrown) {
			addWeixinPicFailed(errorThrown, options);
			//				toastMSG = '验证码不正确';
			//				mui.toast(toastMSG);
		}
	});
}

function addWeixinPicSuccess(data) {
	//alert("addWeixinPicSuccess success" + JSON.stringify(data));
	console.log("error " + JSON.stringify(data));
}

function addWeixinPicFailed(error, data) {
	//alert("error" + JSON.stringify(data));
	console.log("error " + JSON.stringify(data));
}

function getExpertDetailSuc(data)
{
	console.log('getExpertDetailSuc .data:'+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		return;
	}
	//
	data.expertid = expertId;
	localStorage.setItem('zmzfangMyExpertInfo',JSON.stringify(data));
	//填充
	
	byId("name").value = data.name;
	byId("organization").value = data.organization;
	//从业年限的处理
	initSelectElementByValue('workperiod',data.workperiod);
	
	byId("position").value = data.position;
	byId("email").value = data.email;
	
	//增加状态相关处理
	expertStatus = data.status;
	rejectReason = data.reason;
	byId('reason').innerText = data.reason;
	//根据状态初始化界面
	initUIByStatus();
	
	
	//区域的处理
	console.log('activeregion:'+data.activeregion);
	initSelectedRegion(data.activeregion);
	//byId("area").innerText = data.activeregion;
	//领域的处理
	console.log('domain:'+data.domain);
	initSelectedDomain(data.domain);
	
	//名片
	byId("businessCardPic").src = data.businesscard;
	
	//头像
	byId("headPic").src = data.headpicture;
	
	byId("introduction").value = data.introduction;
	byId("expertisen").value = data.expertisen;
	
	byId("onlinecharge").value = data.onlinecharge;
	byId("offlinecharge").value = data.offlinecharge;
	
	//线下约见时间
	initOfflineTime(data.offlinetime);
	
}

function getExpertDetailFailed(data)
{
	console.log('getExpertDetailFailed .data:'+JSON.stringify(data));
	mui.toast('网络原因，获取专家详情失败');
}

function initUIByStatus()
{
	if(expertStatus == '0' || expertStatus == '3')
	{
		//申请中
		$('#title').text('我的专家(申请中)');
		//不允许修改
	}
	else if(expertStatus == '1')
	{
		//已通过
		//部分可修改 部分不可修改

		//显示保存按钮
		$('#save').removeClass('mui-hidden');
		//修改标题头
		
		//全部可修改
		//$('#name').removeAttr('disabled');
		//$('#organization').removeAttr('disabled');
		$('#workperiod').removeAttr('disabled');
		$('#position').removeAttr('disabled');
		$('#email').removeAttr('disabled');
		//$('#area').removeAttr('disabled');
		//$('#domain').removeAttr('disabled');
		//$('#businessCardPic').removeAttr('disabled');
		//$('#headPic').removeAttr('disabled');
		$('#introduction').removeAttr('disabled');
		
		$('#onlinecharge').removeAttr('disabled');
		$('#offlinecharge').removeAttr('disabled');
		
//		$('#showRegionPicker').removeAttr('disabled');
//		$('#showDomainPicker').removeAttr('disabled');
//		$('#regionPickerDiv').removeClass('mui-hidden');
//		$('#domainPickerDiv').removeClass('mui-hidden');
		
		$('.offlinetime-radio').removeAttr('disabled');
		initOfflineDiv();
		initJssdkConfig();//当审核通过后，允许修改图片
	}
	else if(expertStatus == '2')
	{
		//显示被拒绝原因
		$('#reasonDiv').removeClass('mui-hidden');
		//显示保存按钮
		$('#save').removeClass('mui-hidden');
		//修改标题头
		$('#title').text('我的专家(需补充资料)');
		
		//全部可修改
		$('#name').removeAttr('disabled');
		$('#organization').removeAttr('disabled');
		$('#workperiod').removeAttr('disabled');
		$('#position').removeAttr('disabled');
		$('#email').removeAttr('disabled');
		$('#area').removeAttr('disabled');
		$('#domain').removeAttr('disabled');
		$('#businessCardPic').removeAttr('disabled');
		$('#headPic').removeAttr('disabled');
		$('#introduction').removeAttr('disabled');
		
		$('#onlinecharge').removeAttr('disabled');
		$('#offlinecharge').removeAttr('disabled');
		
		$('#showRegionPicker').removeAttr('disabled');
		$('#showDomainPicker').removeAttr('disabled');
		$('#regionPickerDiv').removeClass('mui-hidden');
		$('#domainPickerDiv').removeClass('mui-hidden');
		
		$('.offlinetime-radio').removeAttr('disabled');
		initOfflineDiv();
		initJssdkConfig();//当审核未通过时允许修改图片
	}
	else if(expertStatus == '10')
	{
		//显示被拒绝原因
		$('#reasonDiv').removeClass('mui-hidden');
		$('#title').text('我的专家(已拒绝)');
	}
}

function initSelectedRegion(data)
{
	var regionarray=data.split(",");
	//console.log(regionarray.length);
	var str = '';
	var regionResult = byId('regionResult');
	if(regionarray.length > 0)
	{
		for(var i=0;i<regionarray.length;i++)
		{
			selectedRegionValueArray.push(regionarray[i]);
			selectedRegionTextArray.push(getRegionStr(regionarray[i]));
		}
		selectRegionFlag = 1;//
	}

	showRegionResult();
	
}

function initSelectedDomain(data)
{
	data = "1,2,3";
	var domainarray=data.split(",");
	var str = '';
	var domainResult = byId('domainResult');
	if(domainarray.length > 0)
	{
		for(var i=0;i<domainarray.length;i++)
		{
			selectedDomainValueArray.push(domainarray[i]);
			selectedDomainTextArray.push(getDomainStrNew(domainarray[i]));
		}
		selectDomainFlag = 1;//
	}

	showDomainResult();
}

function initOfflineTime(data)
{
	var offlinetime;
	$(".offlinetime-radio").each(function(i){
   		offlinetime = $(this).attr('data');
   		if(data == offlinetime)
   		{
   			$(this).attr('checked','checked');
   		}
   });
 
}

function showRegionResult()
{
	var regionResult = byId('regionResult');
	regionResult.innerHTML = "您选择的区域是:";
	regionResult.classList.add("show");
	
	for (i in selectedRegionTextArray){
		if(expertStatus == '2')
		{
			regionResult.innerHTML += '<span data="'+selectedRegionValueArray[i]+'" class="item mui-badge mui-badge-success">' +selectedRegionTextArray[i] + ' x</span>';
		}
		else
		{
			regionResult.innerHTML += '<span data="'+selectedRegionValueArray[i]+'" class="item mui-badge mui-badge-success">' +selectedRegionTextArray[i] + ' </span>';
		}
		
	}
	if(expertStatus == '2')
	{
		//被拒绝后，可以修改所有资料
		$('.item').on('tap', function() {
			$(this).remove();
			for(var i =0;i<selectedRegionValueArray.length;i++){  
				if(selectedRegionValueArray[i]==$(this).attr('data')){
	        		selectedRegionValueArray.splice(i,1);
	        		selectedRegionTextArray.splice(i,1);
	    		}
			}
			if(!selectedRegionValueArray.length){
				regionResult.innerHTML ='';
				regionPicker.setData(regionData);
				selectRegionFlag = 0;
				regionResult.classList.remove("show");
			}
		});
	}
	
}

function showDomainResult()
{
	var domainResult = byId('domainResult');
	domainResult.innerHTML = "您选择的领域是:";
	domainResult.classList.add("show");
	
	for (i in selectedDomainTextArray){
		if(expertStatus == '2')
		{
			domainResult.innerHTML += '<span data="'+selectedDomainValueArray[i]+'" class="item mui-badge mui-badge-success">' +selectedDomainTextArray[i] + ' x</span>';
		}
		else
		{
			domainResult.innerHTML += '<span data="'+selectedDomainValueArray[i]+'" class="item mui-badge mui-badge-success">' +selectedDomainTextArray[i] + ' </span>';
		}
		
	}
	
	if(expertStatus == '2')
	{
		//被拒绝后，可以修改所有资料
		$('.item').on('tap', function() {
			$(this).remove();
			for(var i =0;i<selectedDomainValueArray.length;i++){  
				if(selectedDomainValueArray[i]==$(this).attr('data')){
	        		selectedDomainValueArray.splice(i,1);
	        		selectedDomainTextArray.splice(i,1);
	    		}
			}
			if(!selectedDomainValueArray.length){
				domainResult.innerHTML ='';
				domainPicker.setData(domainData);
				selectDomainFlag = 0;
				domainResult.classList.remove("show");
			}
		});
		
	}
}

