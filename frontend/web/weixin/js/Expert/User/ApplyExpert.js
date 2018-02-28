var user = null;
var applyInfo = new Object();

var selectRegionFlag = 0;
var selectedRegionValueArray = new Array();
var selectedRegionTextArray = new Array();

var selectDomainFlag = 0;
var selectedDomainValueArray = new Array();
var selectedDomainTextArray = new Array();

var offlinetime = 1;
var getJssdkConfUrl = "http://www.zmzfang.com/?r=door/get-jssdk&url=http://www.zmzfang.com/weixin/Expert/User/ApplyExpert.html";			
var businessCardLocalId = null;
var headPicLocalId = null;
var businessCardServerId = null;
var headPicServerId = null;
var serverIdArray = [];
var referee = '';

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
		initRefereeInfo();
		initJssdkConfig();
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
document.querySelector('#commit').addEventListener('tap', function() {
	console.log('commit click');
	if(checkSection2())
	{
		//进行提交工作
		uploadPics(commitApply);
		//commitApply();
	}

}, false);

//线下约见时长选择框
mui('.mui-input-row').on('tap', '.mui-radio', function() {
	$(this).children('.offlinetime-radio').attr('checked','checked');
	offlinetime = $(this).children('.offlinetime-radio').attr('data');
	console.log('select offlinetime:' + offlinetime);
});

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
	applyInfo.userid = user.id;
	applyInfo.name = byId("name").value;
	if(applyInfo.name == '')
	{
		mui.toast('您的姓名不可为空');
		return false;
	}
	
	applyInfo.organization = byId("organization").value;
	if(applyInfo.organization == '')
	{
		mui.toast('您的任职机构不能为空');
		return false;
	}
	
	var index = byId("workperiod").selectedIndex;
	applyInfo.workperiod = byId("workperiod").options[index].value;
	
	applyInfo.position = byId("position").value;
	if(applyInfo.position == '')
	{
		mui.toast('您的头衔职位不能为空');
		return false;
	}
	
	applyInfo.email = byId("email").value;
	if(!isEmail(applyInfo.email))
	{
		mui.toast('请输入正确的邮箱');
		return false;
	}
	
	//applyInfo.activeregion = byId("activeRegion").value;
	
	if(selectRegionFlag == 0)
	{
		mui.toast('请您选择活动区域');
		return false;
	}
	applyInfo.activeregion = selectedRegionValueArray.join();
	console.log('applyInfo.activeregion :' + applyInfo.activeregion);
	
	if(selectDomainFlag == 0)
	{
		mui.toast('请您选择领域');
		return false;
	}
	applyInfo.domain = selectedDomainValueArray.join();
	
//	if(businessCardLocalId == null)
//	{
//		mui.toast('请您选择名片');
//		return false;
//	}
	if(businessCardLocalId == null)
	{
		applyInfo.businesscard = 'a';
	}
	else
	{
		applyInfo.businesscard = businessCardLocalId;
	}
	
	applyInfo.referer = referee;
	console.log('applyInfo.userid :' + applyInfo.userid);
	console.log('applyInfo.name :' + applyInfo.name);
	console.log('applyInfo.organization :' + applyInfo.organization);
	console.log('applyInfo.workperiod :' + applyInfo.workperiod);
	console.log('applyInfo.position :' + applyInfo.position);
	console.log('applyInfo.email :' + applyInfo.email);
	console.log('applyInfo.activeregion :' + applyInfo.activeregion);
	console.log('applyInfo.domain :' + applyInfo.domain);
	console.log('applyInfo.businesscard :' + applyInfo.businesscard);
	console.log('applyInfo.referee :' + applyInfo.referee);
	return true;
}
			
//检查申请页面2
function checkSection2()
{
	//applyInfo.headpicture = byId("headpicture").value;
	if(headPicLocalId == null)
	{
		mui.toast('您的个人头像不能为空');
		return false;
	}
	
	applyInfo.headpicture = headPicLocalId;
	applyInfo.introduction = byId("introduction").value;
	if(applyInfo.introduction == '')
	{
		mui.toast('您的个人介绍不能为空');
		return false;
	}
	
	//applyInfo.expertisen = byId("expertisen").value;
	applyInfo.expertisen = byId("introduction").value;
	
	var fee = byId("onlinecharge").value;
	if(fee == null || fee == '' || isNaN(fee))
	{
		mui.toast("请输入有效数字");
		return false;
	}
	if(parseInt(fee) <= 0 || parseInt(fee) >11)
	{
		mui.toast("建议收费1至10元");
		return false;
	}
					
	applyInfo.onlinecharge = fee;
	
	applyInfo.offlinetime = offlinetime;
	//applyInfo.offlinecharge = byId("offlinecharge").value;
	fee = byId("offlinecharge").value;
	if(fee == null || fee == '' || isNaN(fee))
	{
		mui.toast("请输入有效数字");
		return false;
	}
	if(parseInt(fee) < 0 || parseInt(fee) > 1000)
	{
		mui.toast("建议收费1-1000元");
		return false;
	}
	applyInfo.offlinecharge = fee;
	//alert('offlinecharge fee:'+fee);
	
	console.log('applyInfo.headpicture :' + applyInfo.headpicture);
	console.log('applyInfo.introduction :' + applyInfo.introduction);
	console.log('applyInfo.expertisen :' + applyInfo.expertisen);
	console.log('applyInfo.onlinecharge :' + applyInfo.onlinecharge);
	console.log('applyInfo.offlinetime :' + applyInfo.offlinetime);
	console.log('applyInfo.offlinecharge :' + applyInfo.offlinecharge);
	return true;
}
	
	//发送ajax请求
function commitApply()
{
	console.log("commitApply");
	//alert('commitApply');
	/*
	{"userid":"100145","name":"柴磊","organization":"党中央","workperiod":"8年","position":"调研员","email":"chaileicsu@163.com","activeregion":"浦东新区","businesscard":"aaa.jpg","headpicture":"bbb.jpg","introduction":"aaa","expertisen":"bbb","onlinecharge":"20","offlinetime":"1小时","offlinecharge":"200"}
	*/
	ajax_add_expert(applyInfo,commitApplySuc,commitApplyFailed);
}
	
function commitApplySuc(data)
{
	console.log("commitApplySuc data:"+JSON.stringify(data));
	//alert('commitApplySuc:'+JSON.stringify(data));
	
	if(data.rscode == '0')
	{
		mui.toast('提交申请成功,准备上传图片');
		console.log("commitApplySuc rscode:0");
		//跳转到我的 页面
		//将微信serverdi图片信息上传给给后台
		
		var expertid = data.expertid;
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
		mui.toast('上传专家图像');
		ajax_add_weixin_pic(options,addWeixinPicSuccess,addWeixinPicFailed);

        //上传专家名片
        if(businessCardLocalId != null)
        {
        	options.type = '5';
			options.serverid = serverIdArray[1];
			options.localid = businessCardLocalId;
			//alert('ajax_add_weixin_pic 2:'+JSON.stringify(options));
			ajax_add_weixin_pic(options,addWeixinPicSuccess,addWeixinPicFailed);
        }
		
		localStorage.setItem("zmzfangExpertApplyFlag",'1');//标记为已申请
		mui.toast("您的申请已经提交成功，请您耐心等待");
		mui.back();
	}
	else
	{
		mui.toast('提交申请消息失败:'+JSON.stringify(data));
		console.log("commitApplySuc data:"+JSON.stringify(data));
	}
}
	
function commitApplyFailed(data)
{
	console.log("commitApplyFailed data:"+JSON.stringify(data));
	mui.toast('提交申请消息失败:'+JSON.stringify(data));
}
	
function initRegionPickerInfo()
{
	console.log('initPickerInfo');
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

			regionResult.innerHTML = "您选择的区域是:";
			regionResult.classList.add("show");
			
			for (i in selectedRegionTextArray){
				regionResult.innerHTML += '<span data="'+selectedRegionValueArray[i]+'" class="item mui-badge mui-badge-success">' +selectedRegionTextArray[i] + ' x</span>';
			}
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
			   
			selectRegionFlag = 1;//
		});
	}, false);
}

function initDomainPickerInfo()
{
	console.log('initPickerInfo');
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
					mui.toast('该区域已存在！');
					return;
				}
			}
						
			selectedDomainValueArray.push(items[0].value);
			selectedDomainTextArray.push(items[0].text);
			console.log(selectedDomainValueArray);

			domainResult.innerHTML = "您选择的领域域是:";
			domainResult.classList.add("show");
			
			for (i in selectedDomainTextArray){
				domainResult.innerHTML += '<span data="'+selectedDomainValueArray[i]+'" class="item mui-badge mui-badge-success">' +selectedDomainTextArray[i] + ' x</span>';
			}
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
			   
			selectDomainFlag = 1;//
		});
	}, false);
}

function newPlaceholder() {
    document.querySelector('#businessCardPic').addEventListener('tap', function() {
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
		
//	if(businessCardLocalId == null)
//	{
//		mui.toast('请您选择名片');
//		return false;
//	}
	
	if(headPicLocalId == null)
	{
		mui.toast('您的个人头像不能为空');
		return false;
	}
	var paths = [];
	serverIdArray = [];
	
	paths.push(headPicLocalId);
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
	alert("error" + JSON.stringify(data));
	console.log("error " + JSON.stringify(data));
}

//增加url参数处理
function initRefereeInfo()
{
	console.log('initRefereeInfo init');
	 var refereeInfo =  JSON.parse(localStorage.getItem('zmzfangRefereenInfo')) ;
	 
	 if(refereeInfo && refereeInfo.refereename && refereeInfo.refereename != ' ')
	 {
	 	console.log('refereeName:'+ refereeInfo.refereename);
	 	byId('referee').value = refereeInfo.refereename;
	 	
	 	referee = refereeInfo.refereename;
//	 	if(refereeInfo.refereeid && refereeInfo.refereeid != '')
//	 	{
//	 		referee += '#' + refereeInfo.refereeid;
//	 	}
	 	$('#refereeLi').removeClass('mui-hidden');
	 }
}