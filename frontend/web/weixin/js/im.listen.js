/**
 * Created by wuzy 2016/7/5.
 */

var IM = {

	_appid: '8aaf070855b647ab0155b88e887a00a7', // 应用ID
	_apptoken: "b29021cf486b1c4167441af41e9cd659",

	/** 以下不要动，不需要改动 */
	_username: null,
	_user_account: null,
	_content_type_t: 'text', // 文本文件
	_onMsgReceiveListener: null,
	_noticeReceiveListener: null,
	_onConnectStateChangeLisenter: null,

	/**
	 * 初始化
	 * 
	 * @private
	 */

	initSDK: function() {
		// 初始化SDK
		var resp = RL_YTX.init(IM._appid, null, null, null);
		if (!resp) {
			alert('SDK初始化错误');
			return;
		};
		if (200 == resp.code) { // 初始化成功

			if ($.inArray(174004, resp.unsupport) > -1 || $.inArray(174009, resp.unsupport) > -1) { //不支持getUserMedia方法或者url转换
				console.log('拍照、录音、音视频呼叫都不支持'); //拍照、录音、音视频呼叫都不支持

			} else if ($.inArray(174007, resp.unsupport) > -1) { //不支持发送附件
				console.log('不支持发送附件');

			} else if ($.inArray(174008, resp.unsupport) > -1) { //不支持音视频呼叫，音视频不可用
				console.log('不支持音视频呼叫，音视频不可用');

			};
		} else if (174001 == resp.code) { // 不支持HTML5
			var r = confirm(resp.msg);
			if (r == true || r == false) {
				window.close();
			}
		} else if (170002 == resp.code) { //缺少必须参数
			console.log("错误码：170002,错误码描述" + resp.msg);
		} else {
			console.log('未知状态码');
		};

	},

	/**
	 * 正式处理登录逻辑，此方法可供断线监听回调登录使用 获取时间戳，获取SIG，调用SDK登录方法
	 * 
	 * @param user_account
	 * @private
	 */
	_login: function(user_account) {
		IM._user_account = user_account;
		var timestamp = IM._getTimeStamp();
		var appid = IM._appid;
		var apptoken = IM._apptoken;
		var sig = hex_md5(appid + user_account + timestamp + apptoken);
		IM.EV_login(user_account, sig, timestamp);

	},

	/**
	 * 事件，登录 去SDK中请求登录
	 * 
	 * @param user_account
	 * @param sig
	 * @param timestamp --
	 *            时间戳要与生成SIG参数的时间戳保持一致
	 * @constructor
	 */
	EV_login: function(user_account, sig, timestamp) {
		console.log("EV_login");

		var loginBuilder = new RL_YTX.LoginBuilder(1, user_account, '',
			sig, timestamp);
		RL_YTX.login(loginBuilder, function(obj) {
			console.log("EV_login succ...");

			IM._user_account = user_account;
			//			IM._username = user_account;
			// 注册PUSH监听
			IM._onMsgReceiveListener = RL_YTX.onMsgReceiveListener(
				function(obj) {
					IM.EV_onMsgReceiveListener(obj);
				});

			// 注册群组通知事件监听
			IM._noticeReceiveListener = RL_YTX.onNoticeReceiveListener(
				function(obj) {
					IM.EV_noticeReceiveListener(obj);
				});

			// 服务器连接状态变更时的监听
			IM._onConnectStateChangeLisenter = RL_YTX.onConnectStateChangeLisenter(function(obj) {
				// obj.code;//变更状态 1 断开连接 2 重练中 3 重练成功 4 被踢下线 5
				// 断线需要人工重连
				if (1 == obj.code) {
					console.log('onConnectStateChangeLisenter obj.code:' + obj.msg);
				} else if (2 == obj.code) {
					console.log('网络状况不佳，正在试图重连服务器');
				} else if (3 == obj.code) {
					console.log('连接成功');
				} else if (4 == obj.code) {
					IM.DO_logout();
					alert("错误码：" + obj.code + "; 错误描述：" + obj.msg);
				} else if (5 == obj.code) {
					console.log('网络状况不佳，正在试图重连服务器');
					IM._login(IM._user_account);
				} else {
					console.log('onConnectStateChangeLisenter obj.code:' + obj.msg);
				}
			});

			//			IM.EV_getMyInfo();
			//			IM.EV_getGroupList();

			// 登录后拉取未读过的消息
			//			if (IM._local_historyver <= parseInt(obj.historyver) && parseInt(obj.historyver) < parseInt(obj.version)) {
			//				IM._local_historyver = parseInt(obj.historyver)
			//				IM.EV_syncMsg(parseInt(obj.historyver) + 1, obj.version);
			//			}

		}, function(obj) {

			alert("错误码： " + obj.code + "; 错误描述：" + obj.msg);
		});
	},

	/**
	 * 登出
	 * 
	 * @constructor
	 */
	DO_logout: function() {
		// 销毁PUSH监听
		IM._onMsgReceiveListener = null;

		// 服务器连接状态变更时的监听
		IM._onConnectStateChangeLisenter = null;

	},

	/**
	 * 事件，push消息的监听器，被动接收信息
	 * 
	 * @param obj
	 * @constructor
	 */
	EV_onMsgReceiveListener: function(obj) {
		console.log('Receive message sender:[' + obj.msgSender + ']...msgId:[' + obj.msgId + ']...content[' + obj.msgContent + ']');

		ReviceNewMsg(obj);

	},

	/**
	 * 获取当前时间戳 YYYYMMddHHmmss
	 * 
	 * @returns {*}
	 */
	_getTimeStamp: function() {
		var now = new Date();
		var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) + (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) + (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) + (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
		return timestamp;
	},

	/**
	 * 时间戳转为 YYYYMMddHHmm
	 * 
	 * @returns {*}
	 */
	_getTimeStampForSimple: function(time) {
		var now = new Date();
		var timestamp = null;
		var tt = time * 1;
		var time = new Date(tt);
		if (time.getFullYear() < now.getFullYear()) {
			timestamp = "去年";
		} else {
			if (time.getMonth() < now.getMonth()) {
				timestamp = "1月前";
			} else {
				var days = now.getDate() - time.getDate();
				if (days == 1) {
					timestamp = "昨天";
				} else if (days == 2) {
					timestamp = "前天";
				} else if (days > 2) {
					timestamp = days + "天前";
				} else {
					timestamp = (time.getHours() >= 10 ? time.getHours() : "0" + time.getHours()) + ":" + (time.getMinutes() >= 10 ? time.getMinutes() : "0" + time.getMinutes());
				}
			}
		}
		return timestamp;
	},

	/**
	 * 事件，notice群组通知消息的监听器，被动接收消息
	 * 
	 * @param obj
	 * @constructor
	 */
	EV_noticeReceiveListener: function(obj) {
		console.log('notice message groupId:[' + obj.groupId + ']...auditType[' + obj.auditType + ']...msgId:[' + obj.msgId + ']...');
		IM.DO_notice_createMsgDiv(obj);

	},

};

var loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
//var phone = localStorage.getItem("phone");
var phone = null;
if(loginUser)
{
	phone = loginUser.id;
}


var wilddogioRefListen = new Wilddog("https://zmzf0001.wilddogio.com/" + phone + "/list");
var wilddogioRef = new Wilddog("https://zmzf0001.wilddogio.com/" + phone + "/");
var message = {};
(function() {
	if (!!phone) {
		IM.initSDK();
		IM._login(phone);
	}

})();

function ReviceNewMsg(obj) {

	message.sender = obj.msgSender; //消息发送人
	message.sendee = obj.msgReceiver; //接收者群组Im消息时，接收者为群组id

	// 是否为mcm消息 0普通im消息 1 start消息 2 end消息 3发送mcm消息
	var contens = obj.msgContent.split("#-#");
	message.content = contens[0];
	message.headUrl = contens[1];
	message.sendernickname = contens[2];
	message.sendeenickname = contens[3];
	
	message.time = IM._getTimeStamp();
	message.type = "text";
	
	getContactsInfoFromWilddog(message);
	sendMsgToWilddog(message);

}

function getContactsInfoFromWilddog(message) {
	var childRef = wilddogioRefListen.child(message.sender);
	console.log("getContactsInfoFromWilddog childRef=" + childRef.toString());
	childRef.once("value", function(data) {
		// 执行业务处理，此回调方法只会被调用一次
		console.log('data.va():'+JSON.stringify(data.val()));
		if (data.val() != null && data.val().num != null) {
			var num = data.val().num;
			num++;
			message.num = num;
		} else {
			message.num = 1;
		}
		message.offlinenum = 0;
		sendContactsInfoToWilddog(message);
	})
}

function sendContactsInfoToWilddog(message) {
	var childRef = wilddogioRefListen.child(message.sender);
	console.log("sendContactsInfoToWilddog childRef=" + childRef.toString());
	console.log("message="+JSON.stringify(message));
	childRef.set(message);
	mui.toast("收到[" + message.sendernickname + "]发来的一条消息");
	getContactsListFromWilddog();
}

function sendMsgToWilddog(sendinfo) {
	var childRef = wilddogioRef.child(sendinfo.sender + "/" + sendinfo.time);
	console.log(" childRef=" + childRef.toString());
	childRef.set(sendinfo);

}

