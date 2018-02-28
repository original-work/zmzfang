(function(u) {
	
	u.getFavoriteRequirementSuccess = function (data)
	{
		console.log('getFavoriteRequirementSuccess:data'+JSON.stringify(data));
		//var requirementUl=document.getElementById('requirementUl');
		var requirementUl = $('#requirementUl');
		//var firstFrag = document.createDocumentFragment();
		var firstFrag = '';
		for(var i in data)
		{
			var id=data[i].id;
			//firstFrag.appendChild(fillRequirementListLi(data[i]));
			firstFrag += fillRequirementListLi(data[i]);
		}
		
		//requirementUl.innerHTML = "";
		//requirementUl.appendChild(firstFrag);
		requirementUl.html(firstFrag);
	}
			
	u.getFavoriteRequirementFailed = function(errorThrown, options)
	{
		console.log('getFavoriteRequirementFailed');
	}
			
	u.initMsgCntEvent = function()
	{
		var loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
		if(loginUser)
		{
			localStorage.setItem('zmzfangNotReadMsgCnt',0);
			getUserMsgCntFromWilddog(loginUser.id);
			if(loginUser.expertflag == '1' && loginUser.expertid)
			{
				getUserMsgCntFromWilddog(loginUser.expertid);
			}
			updateUserLoginTime(loginUser);
		}
	}
	
	u.getUserMsgCntFromWilddog = function(userid)
	{
		var sum = 0;
		wilddogioListRef = new Wilddog("https://zmzf0001.wilddogio.com/" + userid + "/list");
		
		console.log("getUserMsgCntFromWilddog wilddogioListRef=" + wilddogioListRef.toString());
		wilddogioListRef.on("value", function(snapshot) {
		    //console.log(snapshot.val());
		    sum = 0;
		    var allMsgs = JSON.stringify(snapshot.val());
		    console.log('allMsgs:'+allMsgs);
		    
		    snapshot.forEach(function(data) {
			    console.log("key " + data.key() + " value is " + data.val());
			    var lastMsg = data.val();
			    if(lastMsg.num)
			    {
			    	console.log('lastMsg.num='+lastMsg.num);
			    	sum += parseInt(lastMsg.num);
			    }
			    if(lastMsg.offlinenum)
			    {
			    	console.log('lastMsg.offlinenum='+lastMsg.offlinenum);
			    	sum += parseInt(lastMsg.offlinenum);
			    }
			    
			});
			showMsgNotice(sum);
			//获取未读消息成功后的处理方式
		}, function (errorObject) {
			console.log("The read failed: " + errorObject.code);
		});
		
	}
	
	u.showMsgNotice = function(cnt)
	{
		console.log('total:'+cnt);
		var oldCnt = localStorage.getItem('zmzfangNotReadMsgCnt');
		var newCnt = oldCnt + cnt;
		localStorage.setItem('zmzfangNotReadMsgCnt',newCnt);
		//处理样式
		if(newCnt == 0)
		{
			$('#notice').addClass('mui-hidden');
			$('#notice').html(0);
		}
		else if(newCnt > 0)
		{
			$('#notice').removeClass('mui-hidden');
			$('#notice').html(newCnt);
		}
		else if(newCnt >10)
		{
			$('#notice').removeClass('mui-hidden');
			$('#notice').html('10+');
		}
		
	}
	
	u.updateUserLoginTime = function(loginUser)
	{
		var nowTimestamp = Date.parse(new Date());
		console.log('nowTimestamp:' + nowTimestamp);
		
		var logintime = loginUser.logintime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(logintime);
		var lastLoginTimestamp = date.getTime();
		console.log('lastLoginTimestamp:' + lastLoginTimestamp);
			
		var interval = (nowTimestamp - lastLoginTimestamp)/1000;
		console.log('interval:' + interval);
		if(interval > 3600)
		{
			//超过一个小时则更新数据库中用户登录时间
			ajax_update_last_logintime({userid:loginUser.id});
			//更新本地缓存中的用户登陆时间
			var nowTime = getNowTimeStr();
			loginUser.logintime = nowTime;
			localStorage.setItem('zmzfangLoginUserInfo',JSON.stringify(loginUser));
		}
		//console.log('a:' + a);
	}
	
	u.ajax_update_last_logintime = function(options) {
		//startLoad();
		console.log(JSON.stringify(options));
		var updateLastLogintimeUrl = "http://www.zmzfang.com/index.php?r=user/update-lastlogintime&userid=";
		var url = updateLastLogintimeUrl+options.userid;
		console.log("ajax_update_last_logintime url:"+url);
		jQuery.ajax(url, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				console.log('ajax_update_last_logintime data:'+JSON.stringify(data));
			},
			error: function(xhr, type, errorThrown) {
				console.log('ajax_update_last_logintime fail');
			}
		});
	}
	
	u.getNowTimeStr = function() {
		var now = new Date();
		var timestamp = now.getFullYear() + '-' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + '-' + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) +' '+ (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) +':'+ (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) +':'+ (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
		console.log('timestamp:'+timestamp);
		return timestamp;
	}
})(window);