	document.write("<script language=javascript src='http://res.wx.qq.com/open/js/jweixin-1.0.0.js'></script>");
	
	function wxShare(conf_outer){
			var conf_inner =  {
				"getJssdkConfUrl" : escape(window.document.location.href),
				"title" : '芝麻找房 - 服务买家的精准找房平台！',
				"desc" : '我要买房，快来约我！',
				"link" : 'http://www.zmzfang.com/weixin/HomePage/RequirementList.html',
				"imgUrl" :'http://www.zmzfang.com/assets/frontend/images/logo-common.jpg'
			}
			var conf=$.extend({},conf_inner,conf_outer);
			// console.log('wxShare conf:'+JSON.stringify(conf));
			ajax_get_jssdk_conf();
			
			function ajax_get_jssdk_conf(options) {
				//console.log(JSON.stringify(options));
				// console.log('ajax_get_jssdk_conf getJssdkConfUrl:'+conf.getJssdkConfUrl);
				jQuery.ajax({
					url: "http://www.zmzfang.com/?r=door/get-jssdk&url="+conf.getJssdkConfUrl,
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
				// console.log("config  " + JSON.stringify(data));
				wx.config({
					debug: false,
					appId: data.appId,
					timestamp: data.timestamp,
					nonceStr: data.nonceStr,
					signature: data.signature,
					jsApiList: [
						// 所有要调用的 API 都要加到这个列表中
						'onMenuShareTimeline',
						'onMenuShareAppMessage',
						'onMenuShareQQ',
						'onMenuShareWeibo',
						'onMenuShareQZone'
					]
				});
				wx.ready(function() {
					console.log('wxjssdk ready');
					// alert('wxjssdk ready');
					wx.onMenuShareTimeline({
					    title: conf.title, // 分享标题
					    link: conf.link, // 分享链接
					    imgUrl: conf.imgUrl, // 分享图标
					    success: function () { 
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					
					wx.onMenuShareAppMessage({
					    title: conf.title, // 分享标题
					    desc: conf.desc, // 分享描述
					    link: conf.link, // 分享链接
					    imgUrl: conf.imgUrl, // 分享图标
					    type: '', // 分享类型,music、video或link，不填默认为link
					    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
					    success: function () { 
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareQQ({
					    title: conf.title, // 分享标题
					    desc: conf.desc, // 分享描述
					    link: conf.link, // 分享链接
					    imgUrl: conf.imgUrl, // 分享图标
					    success: function () { 
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					       // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareWeibo({
					    title: conf.title, // 分享标题
					    desc: conf.desc, // 分享描述
					    link: conf.link, // 分享链接
					    imgUrl: conf.imgUrl, // 分享图标
					    success: function () { 
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareQZone({
					    title: conf.title, // 分享标题
					    desc: conf.desc, // 分享描述
					    link: conf.link, // 分享链接
					    imgUrl: conf.imgUrl, // 分享图标
					    success: function () { 
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () { 
					        // 用户取消分享后执行的回调函数
					    }
					});
				});

			}

			function getJssdkConfFailed(data) {
				console.log("error " + JSON.stringify(data));
			}
	}