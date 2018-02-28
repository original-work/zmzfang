var byId = function(id) {
	return document.getElementById(id);
};

var getJssdkConfUrl = "http://www.zmzfang.com/?r=door/get-jssdk&url=http://www.zmzfang.com/weixin/Publish/HousePublish2.html";

(function() {

	var index = 1;
	var size = null;
	var imageIndexIdNum = 0;
	var starIndex = 0;
	var upload = {

		imageList: byId("image-list"),
		submitBtn: byId("commitHousePublish")
	};
	upload.files = [];
	upload.getFileInputArray = function() {
		return [].slice.call(upload.imageList.querySelectorAll('.file'));
	};
	upload.addFile = function(path) {
		upload.files.push({
			name: "images" + index,
			path: path
		});
		index++;
	};
	/**
	 * 初始化图片域占位
	 */
	upload.newPlaceholder = function() {
		var fileInputArray = upload.getFileInputArray();
		if (fileInputArray &&
			fileInputArray.length > 0 &&
			fileInputArray[fileInputArray.length - 1].parentNode.classList.contains('space')) {
			return;
		};
		imageIndexIdNum++;
		var placeholder = document.createElement('div');
		placeholder.setAttribute('class', 'image-item space');
		//删除图片
		var closeButton = document.createElement('div');
		closeButton.setAttribute('class', 'image-close');
		closeButton.innerHTML = 'X';
		//小X的点击事件
		closeButton.addEventListener('tap', function(event) {
			setTimeout(function() {
				upload.imageList.removeChild(placeholder);
			}, 0);
			return false;
		}, false);

		//
		var fileInput = document.createElement('div');
		fileInput.setAttribute('class', 'file');
		fileInput.setAttribute('id', 'image-' + imageIndexIdNum);

		fileInput.addEventListener('tap', function(event) {
			var self = this;
			var index = (this.id).substr(-1);
			var filesLength=upload.files.length;
			if(filesLength >=9){
				mui.toast("最多选9张照片");
				return;
			}

			wx.chooseImage({
				count: 9 - filesLength, // 默认9
				sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
				sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
				success: function(res) {
					var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片

					if (localIds.length > 1) {
						for (var i = 0; i < localIds.length; i++) {
							upload.addFile(localIds[i]);
							upload.newImage(localIds[i]);
						}
					} else {
						upload.addFile(localIds);
						upload.newImage(localIds);
					}
				}
			});
		}, false);
		placeholder.appendChild(fileInput);
		upload.imageList.appendChild(placeholder);
	};

	/**
	 * 增加图片
	 */
	upload.newImage = function(imageUrl) {

		imageIndexIdNum++;
		var placeholder = document.createElement('div');
		placeholder.setAttribute('class', 'image-item ');
		//删除图片
		var closeButton = document.createElement('div');
		closeButton.setAttribute('class', 'image-close');
		closeButton.innerHTML = 'X';
		//小X的点击事件
		closeButton.addEventListener('tap', function(event) {
			setTimeout(function() {
				upload.imageList.removeChild(placeholder);
			}, 0);
			return false;
		}, false);

		//
		var fileInput = document.createElement('div');
		fileInput.setAttribute('class', 'file');
		fileInput.setAttribute('id', 'image-' + imageIndexIdNum);

		placeholder.style.backgroundImage = 'url(' + imageUrl + ')';

		placeholder.appendChild(closeButton);
		placeholder.appendChild(fileInput);
		upload.imageList.appendChild(placeholder);
	};

	upload.newPlaceholder();
	ajax_get_jssdk_conf();
})();

function ajax_get_jssdk_conf(options) {
	//console.log(JSON.stringify(options));
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