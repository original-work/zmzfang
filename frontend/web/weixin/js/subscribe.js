function subscribe(data){
	var conf =  {
		"openid" : '',
		'issubscribe' : false
	}
	conf.openid = data.openid;
	
	ajax_is_subscribe();
	
	this.issubscribe = isSubcribe;
	function isSubcribe()
	{
		return conf.issubscribe;
	}
	
	function ajax_is_subscribe(options) {
		jQuery.ajax({
			url: "http://www.zmzfang.com/?r=wechat/is-subscribe&openid="+conf.openid,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'get', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				getSubscribeInfoSuc(data);
			},
			error: function(xhr, type, errorThrown) {
				getSubscribeFailed(errorThrown);
			}
		});
	}

	function getSubscribeInfoSuc(data)
	{
		console.log("getSubscribeInfoSuc  " + JSON.stringify(data));
		if(data)
		{
			if(data.code == 0)
			{
				//无记录 表示没有关注  提示请先关注  申请按钮不可用  关注按钮 亮起来
			}
			else if(data.code == 1 && data.info.unionid)
			{
				//有记录 表示已经关注  
				
				conf.issubscribe = true;
				console.log('getSubscribeInfoSuc unionid='+data.info.unionid);
			}
			
		}
		else
		{
			console.log("getSubscribeInfoSuc  返回异常");
			mui.toast('获取是否订阅返回空');
		}
	}

	function getSubscribeFailed(data)
	{
		console.log("getSubscribeFailed  " + JSON.stringify(data));
		mui.toast('获取是否订阅消息失败');
	}
}