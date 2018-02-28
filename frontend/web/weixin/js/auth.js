var userInfo = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
(function($) {
	$.fn.Auth=function(options){
		$.fn.Auth.defaults={
			phone:true,
			openid:true,
			wechat:true,
			autoLogin:true,
			// mode:'div',
			reUrl: 'http://www.zmzfang.com/weixin/HomePage/index.html',
			regUrl: 'http://www.zmzfang.com/weixin/Mine/reg.html',
			append: $('body')
		};
		return this.each(function() {
			var opts = $.extend({},$.fn.Auth.defaults,options);
			if(userInfo && userInfo.id < 10000){
				return;
			}
			var loginDiv = $(this);
			var done = false; //判断是否已经处理div
			var appendDom = function(){
				var dom = 
						'<div id="authMessage" style="text-align: center; margin-top: 60px;display:none;">'
							+'<p style="color: #000; font-size: 1.1rem;">芝麻找房微信端使用说明</p>'
							+'<p style="text-align: center;font-size: .85rem;margin-bottom:5px;color:#666;">'
								+'第一步：扫码关注，接收用户联系'
							+'</p>'
							+'<img style="width:45%;margin:0 auto;" src="http://www.zmzfang.com/assets/frontend/images/qrcode.jpg" class="img-responsive" alt="/">'
							+'<div style="width:45%;float:left;margin:10px 0 0 10px;">'
								+'<p style="text-align: center;font-size: .85rem;margin-bottom:5px;color:#666;">'
									+'第二步：点击个人中心'
								+'</p>'
								+'<img src="http://www.zmzfang.com/assets/frontend/images/q1.jpg" class="img-responsive" alt="/">'
							+'</div>'
							+'<div style="width: 45%;float:right;margin:10px 10px 0 0px;">'
								+'<p style="text-align: center;font-size: .85rem;margin-bottom:5px;color:#666;">'
									+'第三步：进入用户绑定'
								+'</p>'
								+'<img src="http://www.zmzfang.com/assets/frontend/images/q2.jpg" class="img-responsive" alt="/">'
							+'</div>'
							+'<div style="clear: both;height: 5px;"></div>'
						+'</div>'
						+'<div class="need-phone" style="text-align:center;display:none;">'
							+'<p>尚未绑定？</p>'
							+'<button type="button" class="mui-btn mui-btn-success" style="margin-right:10px;">新用户绑定</button>'
							+'<button type="button" class="back mui-btn mui-btn-success">返回</button>'
						+'</div>'
						+'<div class="need-wechat" style="text-align: center;display:none;">'
							+'<p>请从微信公众号登陆</p>'
							+'<button type="button" class="back mui-btn mui-btn-success">返回</button>'
						+'</div>'
						+'<div class="need-openid" style="text-align: center;display:none;">'
							+'<p>尝试自动登录？</p>'
							+'<button type="button" class="mui-btn mui-btn-success" style="margin-right:10px;">一键登录</button>'
							+'<button type="button" class="back mui-btn mui-btn-success">返回</button>'
						+'</div>'
						+'<div style="height:60px;"></div>'
				opts.append.append(dom);
				$('button.back').on('tap', function() {mui.openWindow({ url: opts.reUrl });});
				$('.need-openid button').on('tap', function() {mui.openWindow({ url: getWechatAuth()});});
				$('.need-phone button').on('tap', function() {mui.openWindow({ url: opts.regUrl});});
			}
			appendDom();
			var showAuthDiv = function(){ loginDiv.hide();$('#authMessage').show();}
			var getWechatAuth = function(){return 'http://www.zmzfang.com/?r=door/scope&view='+window.location.pathname.substring(8,window.location.pathname.indexOf('.html')) + '&' + window.location.search.substring(1);}
			// 先判断你是否在微信中
			if(opts.wechat){if(!$.wechated()){console.log('wechated false');done =true;showAuthDiv();$('.need-wechat').show()}}
			// 判断是否登录
			if(opts.openid && !done){if(!$.openided()){console.log('openided false');done =true;if(opts.autoLogin){mui.openWindow({ url: getWechatAuth()});}else{showAuthDiv();$('.need-openid').show()}}}
			// 判断是否存在手机号
			if(opts.phone && !done){if(!$.phoned()){console.log('phoned false');showAuthDiv();$('.need-phone').show()}}
		});//each End
	};//Auth End
	$.extend({
		wechated : function(){ /* has mui */return (mui.os.wechat)?true:false} /** hasnot mui   var ua = navigator.userAgent.toLowerCase();if(ua.match(/MicroMessenger/i)=="micromessenger") {return true;} else {return false;}   **/
		,openided : function(){ return (userInfo && userInfo.openid!='')?true:false}
		,phoned : function(){ return (userInfo && userInfo.phone.length > 8 && userInfo.phone!='')?true:false}
		,agented : function(){ return (userInfo && userInfo.agentflag == 1)?true:false}
	})
})(jQuery);