var byId = function(id) {
	return document.getElementById(id);
};
var wilddogioRef;
var wilddogioListRef;
var dstWilddogioRef;
var dstWilddogioListRef;
var phone;
var dstPhone;
var srcNickName;
var dstNickName;
var expertOpenFlag = false;

var loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
var loginExpert = JSON.parse(localStorage.getItem("zmzfangMyExpertInfo"));
//var headUrl = "http://www.zmzfang.com/weixin/img/head/wuzy.jpg";
var headUrl;

var ui = {
	body: document.querySelector('body'),
	footer: document.querySelector('footer'),
	footerRight: document.querySelector('.footer-right'),
	footerLeft: document.querySelector('.footer-left'),
	btnMsgType: document.querySelector('#msg-type'),
	boxMsgText: document.querySelector('#msg-text'),
	boxMsgSound: document.querySelector('#msg-sound'),
	btnMsgImage: document.querySelector('#msg-image'),
	areaMsgList: document.querySelector('#msg-list'),
	boxSoundAlert: document.querySelector('#sound-alert'),
	h: document.querySelector('#h'),
	content: document.querySelector('.mui-content'),
	subject: document.querySelector('#subject')
};

var record = [];

(function() {
	mui.init({
		gestureConfig: {
			tap: true, //默认为true
			doubletap: true, //默认为false
			longtap: true, //默认为false
			swipe: true, //默认为true
			drag: true, //默认为true
			hold: true, //默认为false，不监听
			release: true //默认为false，不监听
		}
	});

	mui.ready(function() {
		//phone = localStorage.getItem("phone");
		initUrlParam();
		dstPhone = localStorage.getItem("chatObjectId") ;
		dstNickName = localStorage.getItem("chatObjectNickName") ;
		
		if(expertOpenFlag)
		{
			phone = loginUser.expertid ;
			srcNickName = loginExpert.name;
			headUrl = loginExpert.headpicture || "http://www.zmzfang.com/weixin/img/head/default.jpg";
		}
		else
		{
			phone = loginUser.id ;
			srcNickName = loginUser.nickname;
			headUrl = loginUser.picture || "http://www.zmzfang.com/weixin/img/head/default.jpg";
		}
		console.log('im.chat init id='+phone);
		
		//ui.subject.innerText =  localStorage.getItem("chatObjectSubject");
		ui.subject.innerText = dstNickName;
		//byId("title-chat").innerText = dstPhone;
		//byId("title-chat").innerText = 'test';
		wilddogioRef = new Wilddog("https://zmzf0001.wilddogio.com/" + phone);
		wilddogioListRef = new Wilddog("https://zmzf0001.wilddogio.com/" + phone + "/list");
		dstWilddogioRef = new Wilddog("https://zmzf0001.wilddogio.com/" + dstPhone);
		dstWilddogioListRef = new Wilddog("https://zmzf0001.wilddogio.com/" + dstPhone + "/list");
		
		var stateRef = wilddogioRef.child('stateinfo');
		stateRef.set("1");
		stateRef.onDisconnect().set("0");
		//IM.initSDK();
		//IM._login(phone);

		ui.h.style.width = ui.boxMsgText.offsetWidth + 'px';
		var footerPadding = ui.footer.offsetHeight - ui.boxMsgText.offsetHeight;
		var msgItemTap = function(msgItem, event) {
			var msgType = msgItem.getAttribute('msg-type');
			var msgContent = msgItem.getAttribute('msg-content')

		};
		var imageViewer = new mui.ImageViewer('.msg-content-image', {
			dbl: false
		});
		var bindMsgList = function() {
			//绑定数据:
			/*tp.bind({
				template: 'msg-template',
				element: 'msg-list',
				model: record
			});*/
			ui.areaMsgList.innerHTML = template('msg-template', {
				"record": record
			});
			var msgItems = ui.areaMsgList.querySelectorAll('.msg-item');
			[].forEach.call(msgItems, function(item, index) {
				item.addEventListener('tap', function(event) {
					msgItemTap(item, event);
				}, false);
			});
			imageViewer.findAllImage();
			ui.areaMsgList.scrollTop = ui.areaMsgList.scrollHeight + ui.areaMsgList.offsetHeight;
		};

		//从野狗云获取聊天记录
		getMsgFromWilddog();
		updateWilddogList();

		window.addEventListener('resize', function() {
			ui.areaMsgList.scrollTop = ui.areaMsgList.scrollHeight + ui.areaMsgList.offsetHeight;
		}, false);
		var send = function(msg) {
			//			record.push(msg);
			//			bindMsgList();
			toRemote(msg);
		};

		function msgTextFocus() {
			ui.boxMsgText.focus();
			setTimeout(function() {
				ui.boxMsgText.focus();
			}, 150);
		}
		//解决长按“发送”按钮，导致键盘关闭的问题；
		ui.footerRight.addEventListener('touchstart', function(event) {
			if (ui.btnMsgType.classList.contains('mui-icon-paperplane')) {
				msgTextFocus();
				event.preventDefault();
			}
		});
		//解决长按“发送”按钮，导致键盘关闭的问题；
		ui.footerRight.addEventListener('touchmove', function(event) {
			if (ui.btnMsgType.classList.contains('mui-icon-paperplane')) {
				msgTextFocus();
				event.preventDefault();
			}
		});

		ui.footerRight.addEventListener('release', function(event) {
			if (ui.btnMsgType.classList.contains('mui-icon-paperplane')) {
				//showKeyboard();
				ui.boxMsgText.focus();
				setTimeout(function() {
					ui.boxMsgText.focus();
				}, 150);
				//							event.detail.gesture.preventDefault();
				console.log("test srcNickName:"+srcNickName+" dstNickName:"+dstNickName);
				send({
					headUrl: headUrl,
					time: getTimeStamp(),
					sender: 'self',
					type: 'text',
					content: ui.boxMsgText.value.replace(new RegExp('\n', 'gm'), '<br/>'),
					sendernickname:srcNickName,
					sendeenickname:dstNickName
				});

				ui.boxMsgText.value = '';
				mui.trigger(ui.boxMsgText, 'input', null);
			} else if (ui.btnMsgType.classList.contains('mui-icon-mic')) {
				ui.btnMsgType.classList.add('mui-icon-compose');
				ui.btnMsgType.classList.remove('mui-icon-mic');
				ui.boxMsgText.style.display = 'none';
				ui.boxMsgSound.style.display = 'block';
				ui.boxMsgText.blur();
				document.body.focus();
			} else if (ui.btnMsgType.classList.contains('mui-icon-compose')) {
				ui.btnMsgType.classList.add('mui-icon-mic');
				ui.btnMsgType.classList.remove('mui-icon-compose');
				ui.boxMsgSound.style.display = 'none';
				ui.boxMsgText.style.display = 'block';
				//--
				//showKeyboard();
				ui.boxMsgText.focus();
				setTimeout(function() {
					ui.boxMsgText.focus();
				}, 150);
			}
		}, false);

		ui.boxMsgText.addEventListener('input', function(event) {
			ui.btnMsgType.classList[ui.boxMsgText.value == '' ? 'remove' : 'add']('mui-icon-paperplane');
			ui.btnMsgType.setAttribute("for", ui.boxMsgText.value == '' ? '' : 'msg-text');
			ui.h.innerText = ui.boxMsgText.value.replace(new RegExp('\n', 'gm'), '\n-') || '-';
			ui.footer.style.height = (ui.h.offsetHeight + footerPadding) + 'px';
			ui.content.style.paddingBottom = ui.footer.style.height;
		});
		var focus = false;
		ui.boxMsgText.addEventListener('tap', function(event) {
			ui.boxMsgText.focus();
			setTimeout(function() {
				ui.boxMsgText.focus();
			}, 0);
			focus = true;
			setTimeout(function() {
				focus = false;
			}, 1000);
			event.detail.gesture.preventDefault();
		}, false);
		//点击消息列表，关闭键盘
		ui.areaMsgList.addEventListener('click', function(event) {
			if (!focus) {
				ui.boxMsgText.blur();
			}
		})

		function getMsgFromWilddog() {
//			console.log("getMsgFromWilddog dstPhone=" + dstPhone);
			var childRef = wilddogioRef.child(dstPhone);
			console.log("getMsgFromWilddog childRef=" + childRef.toString());
			childRef.orderByChild("time").limitToLast(15).on("child_added", function(snapshot) {
//				console.log(JSON.stringify(snapshot.val()));
				record.push(snapshot.val());
				bindMsgList();
				updateWilddogList();
			});

		}

	});

})();

function toRemote(info) {

	var sendinfo = {
		"headUrl": info.headUrl,
		"sender": 'self',
		"time": info.time,
		"sendee": dstPhone,
		"type": "text",
		"content": info.content,
		"sendernickname": info.sendernickname,
		"sendeenickname": info.sendeenickname
	};

	sendMsgToWilddog(sendinfo);
	//sendMsgToYtx(sendinfo);
	sendListInfoToWilddog(sendinfo);
 	sendMsgToWx(sendinfo);
};

function sendMsgToWilddog(sendinfo) {
	//var childRef = wilddogioRef.child(dstPhone + "/" + sendinfo.time);
	var childRef = wilddogioRef.child(sendinfo.sendee + "/" + sendinfo.time);
	console.log(" 1 childRef=" + childRef.toString());
	childRef.set(sendinfo);
	
	
	childRef = dstWilddogioRef.child(phone + "/" + sendinfo.time);
	console.log(" dstWilddogioRef childRef=" + childRef.toString());
	if(sendinfo.sender == 'self')
	{
		sendinfo.sender = phone;
	}
	childRef.set(sendinfo);

}

function sendRecvMsgToWilddog(recvinfo) {
	//var childRef = wilddogioRef.child(dstPhone + "/" + sendinfo.time);
	var childRef = wilddogioRef.child(recvinfo.sender + "/" + recvinfo.time);
	console.log(" childRef=" + childRef.toString());
	childRef.set(recvinfo);
}

//将收到的消息保存到list中
function sendRecvMsgToWilddogList(recvinfo) {
	//var childRef = wilddogioRef.child(dstPhone + "/" + sendinfo.time);
	console.log("sendRecvMsgToWilddogList begin ");
	var childRef = wilddogioListRef.child(recvinfo.sender);
	console.log(" childRef=" + childRef.toString());
	childRef.set(recvinfo);
	console.log("sendRecvMsgToWilddogList end ");
}

//更新list中num的数量
function updateWilddogList() {
	//var childRef = wilddogioRef.child(dstPhone + "/" + sendinfo.time);
	console.log("updateWilddogList begin ");
	var childRef = wilddogioListRef.child(dstPhone);
	console.log(" childRef=" + childRef.toString());
	childRef.once("value", function(data) {
  		// 执行业务处理，此回调方法只会被调用一次
  		console.log("data:"+JSON.stringify(data.val()));
  		var listInfo = data.val();
  		if(listInfo && listInfo.num > 0)
  		{
  			console.log("updateWilddogList reset num 0");
  			childRef.update({"num":0});
  		}
  	})
	
	console.log("updateWilddogList end ");
}


/**
 * 添加PUSH消息，只做页面操作 供push和拉取消息后使用
 * 
 * @param obj
 * @constructor
 */
function ReviceNewMsg(obj) {
	var you_sender = obj.msgSender; //消息发送人
	var you_Receiver = obj.msgReceiver; //接收者群组Im消息时，接收者为群组id

	// 是否为mcm消息 0普通im消息 1 start消息 2 end消息 3发送mcm消息
	var you_msgContent = obj.msgContent;

	var version = obj.msgId;
	var msgTime = obj.msgDateCreated;
	if (0 == obj.mcmEvent) { // 0普通im消息
		var msgType = obj.msgType;
		var str = '';

		// obj.msgType; //消息类型1:文本消息 2：语音消息 3：视频消息 4：图片消息 5：位置消息 6：文件
		if (1 == msgType || 0 == msgType) {

			if (you_Receiver == IM._user_account) {
				contens = you_msgContent.split("#-#");
				var reciveInfo = {
					"headUrl": contens[1],
					"sender": you_sender,
					"time": getTimeStamp(),
					"sendee": you_Receiver,
					"type": "text",
					'num':0,
					"content": contens[0],
					"sendernickname" : contens[2],
					"sendeenickname" : contens[3]
				};
				console.log("reciveInfo="+JSON.stringify(reciveInfo));
				if (reciveInfo.headUrl != null) {
					//sendMsgToWilddog(reciveInfo);
					sendRecvMsgToWilddog(reciveInfo);
					sendRecvMsgToWilddogList(reciveInfo);
				}
			}

		}

	}
}

function sendMsgToYtx(sendInfo) {
	if (sendInfo.sendee != null && sendInfo.content != "") {
		IM.DO_sendMsg(sendInfo.content + "#-#"+
			sendInfo.headUrl + "#-#" + sendInfo.sendernickname + "#-#" + sendInfo.sendeenickname , sendInfo.type, sendInfo.sendee);
	}
}

/**
 * 获取当前时间戳 YYYYMMddHHmmss
 * 
 * @returns {*}
 */
function getTimeStamp() {
	var now = new Date();
	var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) + (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) + (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) + (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
	return timestamp;
}

function sendListInfoToWilddog(message) {
	var childRef = wilddogioListRef.child(message.sendee);
	console.log("sendListInfoToWilddog childRef=" + childRef.toString());
	message.num = 0;//add by chail on 20160804
	message.offlinenum = 0;//add by chail on 20160804
	console.log("message="+JSON.stringify(message));
	childRef.set(message);
	mui.toast("向[" + message.sendeenickname + "]发送的一条消息");
	
	//更新对方节点
	childRef = dstWilddogioListRef.child(phone);
	console.log("sendListInfoToWilddog dstWilddogioListRef childRef=" + childRef.toString());
	message.num = 1;//add by chail on 20160804
	message.offlinenum = 0;//add by chail on 20160804
	if(message.sender == 'self')
	{
		message.sender = phone;
	}
	
	console.log("message="+JSON.stringify(message));
	childRef.once("value", function(data) {
  		// 执行业务处理，此回调方法只会被调用一次
  		console.log("data:"+JSON.stringify(data.val()));
  		var listInfo = data.val();
  		if(listInfo && listInfo.num)
  		{
  			//存在在原值基础上加1
  			console.log("num:"+listInfo.num);
  			var num = parseInt(listInfo.num) + 1;
  			message.num = num;
  			childRef.set(message);
  		}
  		else
  		{
  			childRef.set(message);
  		}
	})
	
}

function sendMsgToWx(sendInfo)
{
	//将最后一条消息写到内存中
	localStorage.setItem("zmzfangLastChatMsg",sendInfo.content);
	//判断用户是否在线，在线则不处理，不在线在调用
	console.log("sendMsgToWx begin ");
	var childRef = dstWilddogioRef.child('stateinfo');
	console.log(" childRef=" + childRef.toString());
	childRef.once("value", function(data) {
  		// 执行业务处理，此回调方法只会被调用一次
  		console.log("dstuser stateinfo:"+JSON.stringify(data.val()));
  		var info = data.val();
  		if(info && info == 0)
  		{
  			//离线状态 发送模板消息
  			console.log("sendMsgToWx dstuser offline");
  			sendMsgToUserByWxTpl();
  		}
  	})
	
	console.log("sendMsgToWx end ");
}

function sendMsgToUserByWxTpl() {
	//想发送模板消息
	console.log('sendMsgToUserByWxTpl');
	if(!loginUser)
	{
		return;
	}
	//userid = user.id;
	//console.log("userid:"+userid);
	
	var message = localStorage.getItem("zmzfangLastChatMsg");
	//var message = '您有一条新的消息请查收';
	//var toOpenid = 'oWfKWsz1sL1IvkSoF6i5rsY-3xTE';//wuzy
	var toUserid = dstPhone;
	var fromUserid = phone;//chail
	var templateId = 1;
//	var parameter = new Object();
//	parameter.toNickname = dstNickName;
//	parameter.fromNickname = srcNickName;
//	//parameter.time = getTimeStamp();
//	parameter.content = message;
	var toNickname = dstNickName;
	var fromNickname = srcNickName;
	
	var col = [];
	var url = 'http://www.zmzfang.com/?r=door/scope&view=Message/im-chat&id='+fromUserid+'&nickname='+fromNickname;
	
	ajax_send_template_message({
		toUserid:toUserid,
		toNickname:toNickname,
		fromUserid:fromUserid,
		fromNickname:fromNickname,
		templateId:templateId,
		content:message,
		col:col,
		url:url
		
	});
}

function getUserStateSuccess(obj)
{
	console.log('getUserStateSuccess');
	//如果离线则向目标用户发送微信模板消息
	if(!obj.state || obj.state == 2)
	{
		sendMsgToUserByWxTpl();	
	}
	
}

function getUserStateFailed(obj)
{
	console.log('getUserStateFailed');
	//如果获取状态信息失败  则向目标用户发送微信模板消息
	sendMsgToUserByWxTpl();
}

//function ajax_send_template_message(options) {
//	console.log('ajax_send_template_message options:'+JSON.stringify(options));
//	var sendTplMsgUrl = "http://www.zmzfang.com/?r=wechat/send-template-message";
//	jQuery.ajax({
//		url: sendTplMsgUrl,
//		data: JSON.stringify(options),
//		dataType: 'json', //服务器返回json格式数据
//		type: 'post', //HTTP请求类型
//		timeout: 10000, //超时时间设置为10秒；
//		async: false,
//		success: function(data) {
//			console.log('发送模板消息成功');
//			console.log(JSON.stringify(data));
//			//成功后，处理应答
//			sendTplMsgSuccess(data);
//		},
//		error: function(xhr, type, errorThrown) {
//			console.log('发送模板消息失败');
//			//toastMSG = '发送模板消息失败';
//			//mui.toast(toastMSG+xhr+type);
//		}
//	});
//}
			
function sendTplMsgSuccess(data){
	if(data.errcode==0){
		//mui.toast("提交成功");
		//mui.back();
		console.log('发送模板消息成功');
		//更新聊天对方 list中的未读消息数量
		//updateOfflineMsgCntOnWilddog();
	}else{
		//mui.toast("提交失败，请重试！");
		console.log('发送模板消息失败');
		//updateOfflineMsgCntOnWilddog();
	}
}

//function updateOfflineMsgCntOnWilddog()
//{
//	console.log('updateOfflineMsgCntOnWilddog begin');
//	//更新对方的 离线消息记录
//	var fromUserid = loginUser.id;
//	var toUserid = dstPhone;
//	
//	var childRef = dstWilddogioListRef.child(fromUserid);
//	console.log('updateOfflineMsgCntOnWilddog childRef:'+childRef.toString());
//	childRef.once("value", function(data) {
//		// 执行业务处理，此回调方法只会被调用一次
//		console.log("data:"+JSON.stringify(data.val()));
//		var listInfo = data.val();
//		if(listInfo.offlinenum)
//		{
//			//存在在原值基础上加1
//			console.log("offlinenum:"+listInfo.offlinenum);
//			var num = parseInt(listInfo.offlinenum) + 1;
//			childRef.update({"offlinenum":num});
//		}
//		else
//		{
//			//不存在设置为1
//			childRef.update({"offlinenum":1});
//		}
//	})
//}

//增加url参数处理
function initUrlParam()
{
	  
	var chatObjectId = getQueryStrFromUrl("id");
	var chatObjectNickName = getQueryStrFromUrl("nickname");
	var expertFlag = getQueryStrFromUrl('expertflag');
	
	var chatObjectNickName = decodeURI(chatObjectNickName);
	console.log('chatObjectId chatObjectId:'+chatObjectId);
	console.log('chatObjectId chatObjectNickName:'+chatObjectNickName);
	 
	if(chatObjectId && chatObjectId != ' ')
	{
		localStorage.setItem('chatObjectId',chatObjectId);
	}
	 
	if(chatObjectNickName && chatObjectNickName != ' ')
	{
		localStorage.setItem('chatObjectNickName',chatObjectNickName);
	}
	
	if(expertFlag && expertFlag != '' && expertFlag == '1')
	{
		expertOpenFlag = true;
	}
}