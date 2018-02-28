var byId = function(id) {
	return document.getElementById(id);
};

var upload = {
};

upload.headPicLocalId = null;
upload.businessCardLocalId = null;
upload.headPicServerId = null;
upload.businessCardServerId = null;
upload.serverIdArray = [];

//var getJssdkConfUrl = "http://www.zmzfang.com/?r=door/get-jssdk&url=http://www.zmzfang.com/weixin/Mine/MySettingModify.html";
var getJssdkConfUrl = "http://www.zmzfang.com/?r=door/get-jssdk&url=";
var addWeixinPicUrl = "http://www.zmzfang.com/index.php?r=user/add-wx-pic";

(function() {
	
	upload.setHostUrl = function(path)
	{
		getJssdkConfUrl += path;
	}
	
	/**
	 * 初始化图片域占位
	 */
	upload.newPlaceholder = function() {
        document.querySelector('#headPic').addEventListener('tap', function() {
			var self = this;
			wx.chooseImage({
				count: 1, // 默认9
				sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有original compressed
				sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
				success: function(res) {
					var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
					upload.headPicLocalId = localIds;
					byId("headPic").src = localIds;
				}
			});
		}, false);

 		document.querySelector('#businessCardPic').addEventListener('tap', function() {
			var self = this;
			wx.chooseImage({
				count: 1, // 默认9
				sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有original compressed
				sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
				success: function(res) {
					var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
					upload.businessCardLocalId = localIds;
					byId("businessCardPic").src = localIds;
				}
			});
		}, false);
		
	};

	upload.initJssdkConfig = function()
	{
		upload.newPlaceholder();
		ajax_get_jssdk_conf();
	};
	

	upload.uploadPics = function(successFun) {
		
		if(upload.headPicLocalId == null && byId("headPic").src == null)
		{
			mui.toast('您的个人头像不能为空');
			return false;
		}
		var paths = [];
		upload.serverIdArray = [];
		
		if(upload.headPicLocalId != null)
		{
			paths.push(upload.headPicLocalId);
		}
		
		if(upload.businessCardLocalId != null)
		{
			paths.push(upload.businessCardLocalId);
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
					upload.serverIdArray.push(res.serverId);
					
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
    
})();

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