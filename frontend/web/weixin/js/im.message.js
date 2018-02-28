/**
 * Created by wuzy 2016/7/5.
 */

var IM = {

	_appid: '8aaf070855b647ab0155b88e887a00a7', // 应用ID
	_apptoken: "b29021cf486b1c4167441af41e9cd659",


	/** 以下不要动，不需要改动 */
	_timeoutkey: null,
	_username: null,
	_user_account: null,
	_content_type_t : 'text', // 文本文件
	_onMsgReceiveListener: null,
 	_noticeReceiveListener : null,
	_onConnectStateChangeLisenter: null,
	_isMcm_active: false,
	_local_historyver: 0,
	_msgId: null, // 消息ID，查看图片时有用
	_pre_range: null, // pre的光标监控对象
	_pre_range_num: 0, // 计数，记录pre中当前光标位置，以childNodes为单位
	_fireMessage: 'fireMessage',
	_serverNo: 'XTOZ',
	_forbidDiv: '<span style="color:#FF0000; font-size: 16px; font-weight:bold;margin-left:-15px;">X</span>', //禁用标志
	_failAudioMap: {},
	_getPersonDetailUrl: 'http://116.228.89.198:8080/get_person_detail.php',		
	_followActivityUrl : "http://116.228.89.198:8080/follow_activity.php",
	_getActivityListUrl : "http://116.228.89.198:8080/get_activity_list.php",	
	_sysid : "sysmessage",
	_sysimgsrc : "images/logo_540x540.png",
	_sex : null,
	/**
	 * 初始化
	 * 
	 * @private
	 */


	initUser: function() {
		IM._user_account = plus.storage.getItem("personid");
	},

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

//		IM.DO_push_createMsgDiv(obj);
		ReviceNewMsg(obj);

		// 播放铃声前，查看是否是群组，如果不是直接播放，如果是查看自定义提醒类型，根据类型判断是否播放声音

		//              document.getElementById('im_ring').play();

	},




	/**
	 * 事件，主动拉取消息
	 * 
	 * @param sv
	 * @param ev
	 * @constructor
	 */
	EV_syncMsg: function(sv, ev) {
		var obj = new RL_YTX.SyncMsgBuilder();
		obj.setSVersion(sv);
		obj.setEVersion(ev);

		RL_YTX.syncMsg(obj, function(obj) {
			alert("错误码： " + obj.code + "; 错误描述：" + obj.msg);
		});
	},



	/**
	 * 样式，用户申请加入系统通知界面
	 * 
	 * @param you_sender --
	 *            对方帐号：发出消息时对方帐号，接收消息时发送者帐号
	 * @param name --
	 * 			对方nickname
	 * @param msgtype --
	 *            消息类型1:文本消息 2：语音消息 3：视频消息 4：图片消息 5：位置消息 6：文件
	 * @param time --
	 *            服务器接收消息时间
	 * @param you_msgContent --
	 *            消息内容
	 * @constructor
	 */
	DO_sysMsg_addImlist: function(groupId,groupName, memberId,memberName,activityId) {

		var sysli = document.getElementById("sysmessage");		
		var time = new Date().getTime();
		if(sysli != null){
			var num = document.getElementById("sysmessage-num").innerText;
			num++;
			document.getElementById("sysmessage-num").innerText = num;
			document.getElementById("sysmessage-num").className="mui-badge mui-pull-right";
			document.getElementById("sysmessage-content").innerText = memberName +" 申请参加 "+ groupName;
			
			document.getElementById("sysmessage-time").innerText = IM._getTimeStampForSimple(time);
		
		}else{
			var imUl = document.getElementById("imUl");
			var li = document.createElement('li');
			li.className = 'mui-table-view-cell mui-media';
			li.id = IM._sysid;
			
			var img = document.createElement("img");
			img.setAttribute("class", "mui-media-object mui-pull-left");
			img.setAttribute("style", "border-radius: 50%;");
			img.setAttribute("id", IM._sysid + "-img");
			img.setAttribute("src", IM._sysimgsrc);
			
			var div00 = document.createElement("div");
			div00.setAttribute("class", "mui-slider-right mui-disabled");
			
			var a1 = document.createElement("a");
			a1.setAttribute("class", "mui-btn mui-btn-red");
			a1.innerText = "删除";
			
			
			var div01 = document.createElement("div");
			div01.setAttribute("class", "mui-slider-handle mui-table");

			var div1 = document.createElement("div");
			div1.setAttribute("class", "mui-media-body");

			var span1 = document.createElement("span");
			span1.setAttribute("class", "mui-ellipsis");
			span1.setAttribute("style", "display:inline-block; width:100px;");
			span1.setAttribute("id", IM._sysid + "-nickname");
			span1.innerText = memberName;

			var font1 = document.createElement("font");
			font1.setAttribute("id", IM._sysid + "-time");
			font1.setAttribute("class", "mui-pull-right");
			font1.setAttribute("size", "2");
			font1.innerText = IM._getTimeStampForSimple(time);

			var p1 = document.createElement("p");
			p1.setAttribute("class", "mui-ellipsis");
			p1.setAttribute("style", "padding-right: 10px;");

			var span2 = document.createElement("span");
			span2.setAttribute("class", "mui-ellipsis");
			span2.setAttribute("style", "display:inline-block; width:150px;");
			span2.setAttribute("id", IM._sysid + "-content");
			span2.innerText = memberName +" 申请参加 "+ groupName;

			var span3 = document.createElement("span");
			span3.setAttribute("class", "mui-badge mui-pull-right");
			span3.setAttribute("style", "background-color: red; color: white;");
			span3.setAttribute("id", IM._sysid + "-num");
			span3.innerText = "1";

			p1.appendChild(span2);
			p1.appendChild(span3);
			
			div00.appendChild(a1);

			div1.appendChild(span1);
			div1.appendChild(font1);
			div1.appendChild(p1);

			div01.appendChild(img);
			div01.appendChild(div1);
			
			li.appendChild(div00);
			li.appendChild(div01);

			imUl.appendChild(li);
			
		}
		
		IM._changeMaintabMessageNum(1);
		
		IM.EV_saveApplyInfo(groupId,groupName, memberId,memberName,activityId);
		
	},
	

	

        /**
         * 事件，存储申请消息
         * 
         * @constructor
         */
        EV_saveApplyInfo : function(groupId,groupName, memberId,memberName,activityId) {
			var apply = {
				groupId : groupId,
				groupName : groupName,
				memberId : memberId,
				memberName : memberName,
				activityId : activityId				
			}
			
			var applys = plus.storage.getItem("apply-buffer");
//			console.log(applys);
			if(applys != null){
				applys = applys.split("|");
				applys.push(JSON.stringify(apply));
//				console.log(JSON.stringify(apply));
				plus.storage.setItem("apply-buffer",applys.join("|"));
			}else{
				applys = [];
				applys.push(JSON.stringify(apply));
//				console.log(JSON.stringify(apply));
				plus.storage.setItem("apply-buffer",applys.join("|"));
			}
        },

	/**
	 * 样式，push监听到消息时添加右侧页面样式
	 * 
	 * @param you_sender --
	 *            对方帐号：发出消息时对方帐号，接收消息时发送者帐号
	 * @param name --
	 * 			对方nickname
	 * @param msgtype --
	 *            消息类型1:文本消息 2：语音消息 3：视频消息 4：图片消息 5：位置消息 6：文件
	 * @param time --
	 *            服务器接收消息时间
	 * @param you_msgContent --
	 *            消息内容
	 * @constructor
	 */
	DO_pushMsg_addImlist: function(you_sender, name, msgtype, time, you_msgContent) {
		var imUl = document.getElementById("imUl");
		var items = imUl.getElementsByTagName("li");
		var noLi = true;
		if (items.length > 0) {
			mui.each(items, function(index, item) {
				if (item.id == you_sender) {
					var num = document.getElementById(you_sender + "-num").innerText;
					num++;
					document.getElementById(you_sender + "-num").innerText = num;
					document.getElementById(you_sender+"-num").className="mui-badge mui-pull-right";
					document.getElementById(you_sender + "-content").innerText = you_msgContent;
					document.getElementById(you_sender + "-time").innerText = IM._getTimeStampForSimple(time);
					IM._changeMaintabMessageNum(1);
					noLi = false;
				}
			});
		}

		if (noLi) {

			var personinfo = IM._getPersoninfo(you_sender);
			var li = document.createElement('li');
			li.className = 'mui-table-view-cell mui-media';
			li.id = you_sender;
			
			
			
			
			var img = document.createElement("img");
			img.setAttribute("class", "mui-media-object mui-pull-left");
			img.setAttribute("style", "border-radius: 50%;");
			img.setAttribute("id", you_sender + "-img");
			img.setAttribute("src", personinfo.headportrait);
			
			var div00 = document.createElement("div");
			div00.setAttribute("class", "mui-slider-right mui-disabled");
			
			var a1 = document.createElement("a");
			a1.setAttribute("class", "mui-btn mui-btn-red");
			a1.innerText = "删除";
			
			
			var div01 = document.createElement("div");
			div01.setAttribute("class", "mui-slider-handle mui-table");

			var div1 = document.createElement("div");
			div1.setAttribute("class", "mui-media-body");

			var span1 = document.createElement("span");
			span1.setAttribute("class", "mui-ellipsis");
			span1.setAttribute("style", "display:inline-block; width:100px;");
			span1.setAttribute("id", you_sender + "-nickname");
			span1.innerText = personinfo.nickname;

			var font1 = document.createElement("font");
			font1.setAttribute("id", you_sender + "-time");
			font1.setAttribute("class", "mui-pull-right");
			font1.setAttribute("size", "2");
			font1.innerText = IM._getTimeStampForSimple(time);

			var p1 = document.createElement("p");
			p1.setAttribute("class", "mui-ellipsis");
			p1.setAttribute("style", "padding-right: 10px;");

			var span2 = document.createElement("span");
			span2.setAttribute("class", "mui-ellipsis");
			span2.setAttribute("style", "display:inline-block; width:150px;");
			span2.setAttribute("id", you_sender + "-content");
			span2.innerText = you_msgContent;

			var span3 = document.createElement("span");
			span3.setAttribute("class", "mui-badge mui-pull-right");
			span3.setAttribute("style", "background-color: red; color: white;");
			span3.setAttribute("id", you_sender + "-num");
			span3.innerText = "1";

			p1.appendChild(span2);
			p1.appendChild(span3);
			
			div00.appendChild(a1);

			div1.appendChild(span1);
			div1.appendChild(font1);
			div1.appendChild(p1);

			div01.appendChild(img);
			div01.appendChild(div1);
			
			li.appendChild(div00);
			li.appendChild(div01);

			imUl.appendChild(li);
			
			IM._changeMaintabMessageNum(1);
			
		}
	},


	/**
	 * 样式，
	 * 
	 * @param you_sender --
	 *            接收帐号：群组帐号
	 * @param you_sender --
	 *            对方帐号：发出消息时对方帐号，接收消息时发送者帐号
	 * @param name --
	 * 			对方nickname
	 * @param msgtype --
	 *            消息类型1:文本消息 2：语音消息 3：视频消息 4：图片消息 5：位置消息 6：文件
	 * @param time --
	 *            服务器接收消息时间
	 * @param you_msgContent --
	 *            消息内容
	 * @constructor
	 */
	DO_pushGroupMsg_addImlist: function(you_Receiver,you_sender, name, msgtype, time, you_msgContent) {
		var imUl = document.getElementById("imUl");
		var items = imUl.getElementsByTagName("li");
		var noLi = true;
		if (items.length > 0) {
			mui.each(items, function(index, item) {
				var groupidTMP = item.id.split("-");
				var groupid = groupidTMP[0];
				if (groupid == you_Receiver) {
					var num = document.getElementById(you_Receiver + "-num").innerText;
					num++;
					document.getElementById(you_Receiver + "-num").innerText = num;
					document.getElementById(you_Receiver+"-num").className="mui-badge mui-pull-right";
					document.getElementById(you_Receiver + "-content").innerText = you_msgContent;
					document.getElementById(you_Receiver + "-time").innerText = IM._getTimeStampForSimple(time);
					IM._changeMaintabMessageNum(1);
					noLi = false;
				}
			});
		}

//		if (noLi) {
//
//			var li = document.createElement('li');
//			li.className = 'mui-table-view-cell mui-media';
//			li.id = you_Receiver;
//			
//			
//			
//			
//			var img = document.createElement("img");
//			img.setAttribute("class", "mui-media-object mui-pull-left");
//			img.setAttribute("style", "border-radius: 50%;");
//			img.setAttribute("id", you_Receiver + "-img");
//			img.setAttribute("src", "images/qunzu.png");
//			
//			var div00 = document.createElement("div");
//			div00.setAttribute("class", "mui-slider-right mui-disabled");
//			
//			var a1 = document.createElement("a");
//			a1.setAttribute("class", "mui-btn mui-btn-red");
//			a1.innerText = "删除";
//			
//			
//			var div01 = document.createElement("div");
//			div01.setAttribute("class", "mui-slider-handle mui-table");
//
//			var div1 = document.createElement("div");
//			div1.setAttribute("class", "mui-media-body");
//
////			var span1 = document.createElement("span");
////			span1.setAttribute("class", "mui-ellipsis");
////			span1.setAttribute("style", "display:inline-block; width:100px;");
////			span1.setAttribute("id", you_Receiver + "-nickname");
////			span1.innerText = groupName;
//
//			var font1 = document.createElement("font");
//			font1.setAttribute("id", you_Receiver + "-time");
//			font1.setAttribute("class", "mui-pull-right");
//			font1.setAttribute("size", "2");
//			var time = new Date().getTime();
//			font1.innerText = IM._getTimeStampForSimple(time);
//
//			var p1 = document.createElement("p");
//			p1.setAttribute("class", "mui-ellipsis");
//			p1.setAttribute("style", "padding-right: 10px;");
//
//			var span2 = document.createElement("span");
//			span2.setAttribute("class", "mui-ellipsis");
//			span2.setAttribute("style", "display:inline-block; width:150px;");
//			span2.setAttribute("id", you_Receiver + "-content");
//			span2.innerText = you_msgContent;
//
//			var span3 = document.createElement("span");
//			span3.setAttribute("class", "mui-badge mui-pull-right");
//			span3.setAttribute("style", "background-color: red; color: white;");
//			span3.setAttribute("id", you_Receiver + "-num");
//			span3.innerText = "1";
//
//			p1.appendChild(span2);
//			p1.appendChild(span3);
//			
//			div00.appendChild(a1);
//
////			div1.appendChild(span1);
//			div1.appendChild(font1);
//			div1.appendChild(p1);
//
//			div01.appendChild(img);
//			div01.appendChild(div1);
//			
//			li.appendChild(div00);
//			li.appendChild(div01);
//
//			imUl.appendChild(li);
//			
//			IM._changeMaintabMessageNum(1);
//			
//		}
	},	


	/**
	 * 样式，构建群组消息列表
	 * 
	 * @param groupId --
	 *            群组帐号：发出消息时群组帐号，接收消息时发送者帐号
	 * @param groupName --
	 * 			群组名称
	 * @constructor
	 */
	DO_addGrouplist: function(groupId, groupName,owner) {
		var imUl = document.getElementById("imUl");
		var items = imUl.getElementsByTagName("li");
		var noLi = true;
		var groupidTmp = groupId +"-"+owner;
		if (items.length > 0) {
			mui.each(items, function(index, item) {
				if (item.id == groupidTmp) {
					noLi = false;
					return;
				}
			});
		}

		if (noLi) {

			var li = document.createElement('li');
			li.className = 'mui-table-view-cell mui-media';
			li.id = groupidTmp;
			
			
			
			
			var img = document.createElement("img");
			img.setAttribute("class", "mui-media-object mui-pull-left");
			img.setAttribute("style", "border-radius: 50%;");
			img.setAttribute("id", groupId + "-img");
			img.setAttribute("src", "images/qunzu.png");
			
			var div00 = document.createElement("div");
			div00.setAttribute("class", "mui-slider-right mui-disabled");
			
			var a1 = document.createElement("a");
			a1.setAttribute("class", "mui-btn mui-btn-red");
			a1.innerText = "删除";
			
			
			var div01 = document.createElement("div");
			div01.setAttribute("class", "mui-slider-handle mui-table");

			var div1 = document.createElement("div");
			div1.setAttribute("class", "mui-media-body");

			var span1 = document.createElement("span");
			span1.setAttribute("class", "mui-ellipsis");
			span1.setAttribute("style", "display:inline-block; width:100px;");
			span1.setAttribute("id", groupId + "-nickname");
			span1.innerText = groupName;

			var font1 = document.createElement("font");
			font1.setAttribute("id", groupId + "-time");
			font1.setAttribute("class", "mui-pull-right");
			font1.setAttribute("size", "2");
			var time = new Date().getTime();
			font1.innerText = IM._getTimeStampForSimple(time);

			var p1 = document.createElement("p");
			p1.setAttribute("class", "mui-ellipsis");
			p1.setAttribute("style", "padding-right: 10px;");

			var span2 = document.createElement("span");
			span2.setAttribute("class", "mui-ellipsis");
			span2.setAttribute("style", "display:inline-block; width:150px;");
			span2.setAttribute("id", groupId + "-content");
			span2.innerText = "欢迎回到" + groupName;

			var span3 = document.createElement("span");
			span3.setAttribute("class", "mui-badge mui-pull-right");
			span3.setAttribute("style", "background-color: red; color: white;");
			span3.setAttribute("id", groupId + "-num");
			span3.innerText = "1";

			p1.appendChild(span2);
			p1.appendChild(span3);
			
			div00.appendChild(a1);

			div1.appendChild(span1);
			div1.appendChild(font1);
			div1.appendChild(p1);

			div01.appendChild(img);
			div01.appendChild(div1);
			
			li.appendChild(div00);
			li.appendChild(div01);

			imUl.appendChild(li);
			
			IM._changeMaintabMessageNum(1);
			
		}
	},
	
	
	/**
	 * 从本地存储中获取用户信息
	 * @param persionid --
	 *            用户id，消息通讯是的用户账号
	 * @constructor
	 */
	_getPersonLocalInfo: function(personid) {
		var personinfo = null;
		var personinfoTmp = plus.storage.getItem(personid+"-info");
//		console.log("personid: "+personid +"  personinfo: "+JSON.stringify(personinfoTmp));
		if(personinfo != null ){
			personinfo = JSON.parse(personinfoTmp);

		}else{
			personinfo = IM._getPersoninfo(personid);
		}
		return personinfo;

	},
	

	/**
	 * 获取用户信息
	 * @param persionid --
	 *            用户id，消息通讯是的用户账号
	 * @constructor
	 */
	_getPersoninfo: function(personid) {
		var personinfo = null;
		console.log("正在获取用户信息！" +personid);		
		mui.ajax(IM._getPersonDetailUrl, {
			data: JSON.stringify({
				'personid': personid
			}),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				personinfo = data;
//				console.log("personid: "+personid +"  personinfo: "+JSON.stringify(personinfo));
			},
			error: function(xhr, type, errorThrown) {
				//异常处理；
				console.log("获取用户信息失败，请重试！"+personid);
				mui.alert('获取用户信息失败，请重试！');
			}
		});
		plus.storage.setItem(personid+"-info",JSON.stringify(personinfo));
//		console.log("personid: "+personid +"  personinfo: "+JSON.stringify(personinfo));
		return personinfo;

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
	 * 更改主界面显示的消息数
	 * 
	 * @returns {*}
	 */
	_changeMaintabMessageNum: function(number) {
		var b = plus.webview.getWebviewById('tab-webview-main.html');
		mui.fire(b, 'messageNumChanged', {
			num: number
		});
	},
	

	/**
	 * 系统消息存本地
	 * msgContent = 'applay'|persionid|nickname|activityid|topic
	 * @returns {*}
	 */
	_saveSysMessage: function(personid,name,time,msgContent) {
		var records = plus.storage.getItem(IM._sysid+"-record");
		var contens = msgContent.split("|");
		if(records == null){
			records=[];
			var record={
				"personid": contens[1],
                "name": contens[2],
                "time": time,
                "activityid": contens[3],
                "topic": contens[4]
				};
				
			records.push(JSON.stringify(record));	
			plus.storage.setItem(personid+"-record",records.join("|"));
		}else{
			var record={
				"personid": contens[1],
                "name": contens[2],
                "time": time,
                "activityid": contens[3],
                "topic": contens[4]
				};				
			records = records.split("|");
			records.push(JSON.stringify(record));
			plus.storage.setItem(personid+"-record",records.join("|"));
		}			


	},	

   /**
     * 事件，获取群组成员列表
     * 
     * @param groupId
     * @constructor
     */
    EV_getGroupMemberList : function(groupId) {
        console.log('get Group Member List...');
        var obj = new RL_YTX.GetGroupMemberListBuilder();
        obj.setGroupId(groupId);
        obj.setPageSize(-1);

        RL_YTX.getGroupMemberList(obj, function(obj) {
                    console.log('get Group Member List SUCC...');
                    IM._saveGroupMembers(groupId,obj);
                }, function(obj) {
                    alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                });
    },


	/**
	 * 群组成员存本地
	 * 
	 * @returns {*}
	 */
	_saveGroupMembers: function(groupId,obj) {

		plus.storage.removeItem(groupId+"-members");
		var members = [];
        for(var i=0;i<obj.length;i++){
        	if(obj[i].member == null){
        		continue;
        	}
			var personinfo = IM._getPersonLocalInfo(obj[i].member);
            var memberTmp = {
            		"memberId": obj[i].member, //
	                "nickName": obj[i].nickName, 
	                "headportrait":personinfo.headportrait,
	                "speakState": obj[i].speakState,//禁言状态 1:不禁言  2:禁言
	                "role": obj[i].role, //角色 1:创建者  2:管理员  3：成员
	                "sex": obj[i].sex  //   /性别 1:男 2：女          
            };
            
            members.push(JSON.stringify(memberTmp));				
        };
        plus.storage.setItem(groupId+"-members",members.join("|"));

        var memberlistadminView = plus.webview.getWebviewById('member-list-admin.html'+groupId);
		var memberlistView = plus.webview.getWebviewById('member-list.html'+groupId);
		if(memberlistadminView != null ){
			mui.fire(memberlistadminView, 'memberChanged', {
				groupid: groupId
			});
		}
	 	if(memberlistView != null ){
			mui.fire(memberlistView, 'memberChanged', {
				groupid: groupId
			});
		}

	},		

	
	/**
	 * 群组消息存本地
	 * 
	 * @returns {*}
	 */
	_saveGroupMessage: function(you_Receiver,personid,msgType,time,msgContent,isSelf) {
		var records = plus.storage.getItem(you_Receiver+"-record");
		if(isSelf){
			if(records == null){
				records=[];
				var record={
					"sender": 'self',
	                "type": msgType,
	                "time": time,
	                "content": msgContent
					};
					
				records.push(JSON.stringify(record));	
				plus.storage.setItem(you_Receiver+"-record",records.join("|"));
			}else{
				var record={
					"sender": 'self',
	                "type": msgType,
	                "time": time,
	                "content": msgContent
					};				
				records = records.split("|");
				records.push(JSON.stringify(record));
				plus.storage.setItem(you_Receiver+"-record",records.join("|"));
			}			
		}else{
			if(records == null){
			records=[];
			var record={
				"sender": personid,
                "type": msgType,
                "time": time,
                "content": msgContent
				};
				
			records.push(JSON.stringify(record));	
			plus.storage.setItem(you_Receiver+"-record",records.join("|"));
			}else{
				var record={
					"sender": personid,
	                "type": msgType,
	                "time": time,
	                "content": msgContent
					};				
				records = records.split("|");
				records.push(JSON.stringify(record));
				plus.storage.setItem(you_Receiver+"-record",records.join("|"));
			}
		}

	},		
	
	/**
	 * 个人消息存本地
	 * 
	 * @returns {*}
	 */
	_saveMessage: function(personid,msgType,time,msgContent,isSelf) {
		var records = plus.storage.getItem(personid+"-record");
		if(isSelf){
			if(records == null){
				records=[];
				var record={
					"sender": 'self',
	                "type": msgType,
	                "time": time,
	                "content": msgContent
					};
					
				records.push(JSON.stringify(record));	
				plus.storage.setItem(personid+"-record",records.join("|"));
			}else{
				var record={
					"sender": 'self',
	                "type": msgType,
	                "time": time,
	                "content": msgContent
					};				
				records = records.split("|");
				records.push(JSON.stringify(record));
				plus.storage.setItem(personid+"-record",records.join("|"));
			}			
		}else{
			if(records == null){
			records=[];
			var record={
				"sender": personid,
                "type": msgType,
                "time": time,
                "content": msgContent
				};
				
			records.push(JSON.stringify(record));	
			plus.storage.setItem(personid+"-record",records.join("|"));
		}else{
			var record={
				"sender": personid,
                "type": msgType,
                "time": time,
                "content": msgContent
				};				
			records = records.split("|");
			records.push(JSON.stringify(record));
			plus.storage.setItem(personid+"-record",records.join("|"));
		}
		}

	},	

	/**
	 * 群组消息推送至聊天界面
	 * 
	 * @returns {*}
	 */
	_pushGroupMessageToChat: function(you_Receiver,personid,msgType,msgContent) {
		console.log("push message to chat :" + msgContent);
		var personidChatView = plus.webview.getWebviewById('im-group-chat.html-'+you_Receiver);
		var personinfo = IM._getPersonLocalInfo(personid);
		if(personidChatView != null ){
			var record={
				"sender": personid,
				 "headportrait":personinfo.headportrait,
                "nickname":personinfo.nickname,
                "type": msgType,
                "content": msgContent
				};			
			plus.storage.setItem(you_Receiver+"-sendeebuffer",JSON.stringify(record));
			mui.fire(personidChatView, 'newMsgArrive', {
				personid: personid
			});
			
			IM._changeMaintabMessageNum(-1);
		}

	},	

	/**
	 * 系统消息推送至界面
	 * 
	 * @returns {*}
	 */
	_pushSysMsgTolist: function() {
		
		var systemMessageListView = plus.webview.getWebviewById('system-message-list.html');
		if(systemMessageListView != null ){
			mui.fire(systemMessageListView, 'newSystemMsgArrive', {
				personid: 1
			});

			var num = document.getElementById("sysmessage-num").innerText;  
			document.getElementById("sysmessage-num").innerText=0;
			document.getElementById("sysmessage-num").className="hideThisSpan mui-pull-right";
			IM._changeMaintabMessageNum(-num);
		}

	},			




	       /**
         * 样式，发送消息
         */
        DO_sendMsg : function(content,type,dstuser) {

            var im_send_content = content;

            var msgid = new Date().getTime();
            var content_type = '';
            var content_you = '';
            var b = false;
            content_type = type;
            content_you = dstuser;
            
            
            if (im_send_content == undefined || im_send_content == null
                    || im_send_content == '')
                return;

            console.log('发送时间:[' + msgid + '] content_type[' + content_type
                    + '] 接收人[' + content_you + '] im_send_content['
                    + im_send_content + ']');

     // 发送消息至服务器
            if (IM._content_type_t == content_type) {
                IM.EV_sendTextMsg(msgid, im_send_content, content_you);
//              var contens = im_send_content.split("|");
//              if( contens[0] == "apply" || contens[0] == "reply" ){
//              	
//              }else{
//              	IM._saveMessage(content_you, 'text', msgid, im_send_content,true);
//              }

            } ;

        },

       /**
         * 事件，发送消息
         * 
         * @param msgid
         * @param text
         * @param receiver
         * @constructor
         */
        EV_sendTextMsg : function(oldMsgid, text, receiver) {
//          console.log('send Text message: receiver:[' + receiver
//                  + ']...connent[' + text + ']...');
            
            var obj = new RL_YTX.MsgBuilder();
            obj.setText(text);
            obj.setType(1);
            obj.setReceiver(receiver);
            var msgId = RL_YTX.sendMsg(obj, function(obj) {
                        setTimeout(function() {
                                   
                                    console.log('send Text message succ');

                                }, 300)
                    }, function(obj) {
                        setTimeout(function() {
                            alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                            }, 300)
                    });
        },
        
        
       /**
         * 事件，创建群组
         * 
         * @param groupName
         * @param groupType
         * @param permission
         * @param declare       
         * @constructor
         */
        EV_createGroup : function(groupName,groupType, permission,declare) {
            //如果有类型则传值
            if(!!declare){
                var regx1 = /^[\\x00-\\x7F\a-zA-Z\u4e00-\u9fa5、，。！；《》【】”“’‘：:,.!;_\s-]{0,128}$/;//只含有汉字、数字、字母、下划线，下划线位置不限
                if(regx1.exec(declare) == null){
                    alert("群组说明只允许中英文数字和中文符号、，。！；《》【】”“’‘：及英文符号:,.!;和@_-，长度不超过128");                   
                    return;
                };
                
                if(declare.substring(0,1) == "g" || declare.substring(0,1) == "G"){
                    alert("群组说明不能以g或G开头");
                    $("#createGroup_bt").removeAttr("disabled");
                    return;
                }
            }
            //如果群组说明不是空，校验说明的合法性
                
            
            console.log('create group...groupName[' + groupName
                    + '] permission[' + permission + ']'+ '] declare[' + declare + ']');

            var obj = new RL_YTX.CreateGroupBuilder();
            obj.setGroupName(groupName);
            obj.setPermission(permission);
            if(!!groupType){
                obj.setGroupType(groupType);
            }

            if(!!declare){
                obj.setDeclared(declare);
            }
            // target参数 1讨论组 2 群组
            //群组权限 必选  1：默认可直接加入  2：需要身份验证    3:私有群组（不能主动加入，仅能管理员邀请） 默认为1
            if (permission == 4) {
                obj.setTarget(1);
                // 校验邀请参数是否符合要求
                var memberSts = $("#pop_invite_area").val();
                var memberArr = memberSts.split(",");
                if (memberArr.length > 50) {
                    alert("邀请用户过多！");

                    return;
                }
                for (var i in memberArr) {
                    if (i == IM._user_account) {

                        return;
                    };
                    if (!IM.DO_checkContact(memberArr[i])) {
                        return;
                    }
                };
            } else {
                obj.setTarget(2);
            };

            RL_YTX.createGroup(obj, function(obj) {
                        var groupId = obj.data;
						plus.storage.removeItem("groupidapply");
                        console.log('create group succ... groupId[' + groupId
                                + ']');

                        if (permission == 4) {// 如果是讨论组
                        } else {
							var startActivityDetailView = plus.webview.getWebviewById('startActivity_detail.html');
							mui.fire(startActivityDetailView, 'createGroupOK', {
								groupId: groupId
							});	
							//群组创建成功后加载至界面
							if(groupId != null && groupName != null){
								 IM.DO_addGrouplist(groupId,groupName,IM._user_account);
							}
															
                        }
                    }, function(obj) {        
                    	plus.storage.removeItem("groupidapply");
                        alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                    });

        },
 
         /**
         * 事件，用户申请加入群
         * 
         * @param groupId
         *            群组id 必选
         * @constructor
         */
        EV_joinGroup : function(groupId,activityid) {
            console.log('join group...groupId[' + groupId  + ']' );
            var obj = new RL_YTX.JoinGroupBuilder();
            obj.setGroupId(groupId);
            obj.setDeclared(activityid);

			//发送请求
			RL_YTX.joinGroup(obj, function(){
			//操作成功
				mui.toast("已提交加入群组申请");
			},function(obj){
			//操作失败
				mui.toast("加入群组申请提交失败");
			}); 
        }, 
        
    	/**
         * 事件，对活动感兴趣/参与活动/审批活动
         * 
         * @param activityid
         *            活动id 必选
         * @param memberId
         *            成员id 必选
         * @param confirm
         *            是否同意 必选 1—感兴趣，2—申请参与，3—同意，4—拒绝
         * @constructor
         */
        EV_followActivity : function(activityid, memberId, confirm) {
            console.log('confirm join activity...activityid[' + activityid
                    + '] memberId[' + memberId + '] confirm[' + confirm + ']');

				mui.ajax(IM._followActivityUrl, {
						data: JSON.stringify({
							'activityid': activityid,
							'personid': memberId,
							'type': confirm					
						}),
						dataType: 'json', //服务器返回json格式数据
						type: 'post', //HTTP请求类型
						timeout: 10000, //超时时间设置为10秒；
						success: function(data) {
								if( (data.rscode == 0) && (confirm == 4) ){
									
									console.log("拒绝/删除成功");
								}
								console.log("提交结果:"+data.rscode);
						}
					}); 
        },          
        
        
        /**
         * 事件，用户申请加入确认操作
         * 
         * @param groupId
         *            群组id 必选
         * @param memberId
         *            成员id 必选
         * @param confirm
         *            是否同意 必选 1 不同意 2同意
         * @constructor
         */
        EV_confirmJoinGroup : function(groupId, memberId, confirm,activityId) {
            console.log('confirm join group...groupId[' + groupId
                    + '] memberId[' + memberId + '] confirm[' + confirm + ']');
            var obj = new RL_YTX.ConfirmJoinGroupBuilder();
            obj.setGroupId(groupId);
            obj.setMemberId(memberId);
            obj.setConfirm(confirm);

            RL_YTX.confirmJoinGroup(obj, function() {
                        if (1 == confirm)
                           IM.EV_followActivity(activityId,memberId,4);
                           console.log("已拒绝" +memberId +"的申请" );
                        if (2 == confirm)
                        	IM.EV_followActivity(activityId,memberId,3);
                            console.log('已同意' +memberId +"的申请");
                  
                    }, function(obj) {
                         mui.alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                    });
        },   
        
        /**
         * 事件，notice群组通知消息的监听器，被动接收消息
         * 
         * @param obj
         * @constructor
         */
        EV_noticeReceiveListener : function(obj) {
            console.log('notice message groupId:[' + obj.groupId
                    + ']...auditType[' + obj.auditType + ']...msgId:['
                    + obj.msgId + ']...');
            IM.DO_notice_createMsgDiv(obj);


        },    
        
        /**
         * 添加群组事件消息，只处理页面
         * 
         * @param obj
         * @constructor
         */
        DO_notice_createMsgDiv : function(obj) {
        	var you_sender = IM._serverNo;
            //var you_sender = obj.serviceNo;
            var groupId = obj.groupId;
            var name = '系统通知';
            var groupName = obj.groupName;
            //var version = obj.version;//改版
            var version = obj.msgId;
            var declare = obj.declared;  //存储activityid
            
            var peopleId = obj.member;
            var people = (!!obj.memberName) ? obj.memberName : obj.member;
            var you_msgContent = '';
            // 1,(1申请加入群组，2邀请加入群组，3直接加入群组，4解散群组，5退出群组，6踢出群组，7确认申请加入，8确认邀请加入，9邀请加入群组的用户因本身群组个数超限加入失败(只发送给邀请者)10管理员修改群组信息，11用户修改群组成员名片12新增管理员变更通知)
            var auditType = obj.auditType;
            var groupTarget = (obj.target==2)?"群组":"讨论组";
            if (1 == auditType) {
            	IM.DO_sysMsg_addImlist(groupId,groupName, peopleId,people,declare);
            	IM._pushSysMsgTolist();
            	
            } else if (2 == auditType) {
               
            } else if (3 == auditType) {
                
            } else if (4 == auditType) {
               // 解散群组的操作,解散时机待讨论
            } else if (5 == auditType) {
                //退出群组的操作,从活动中移除该成员
            } else if (6 == auditType) {
                if(IM._user_account == peopleId){
				var li = document.getElementById(groupId);			
				li.parentNode.removeChild(li)
				}else{
					//更新群组成员列表
				}
            } else if (7 == auditType) {
            	
                console.log(obj.confirm);
                if (2 != obj.confirm) {

                    console.log('管理员拒绝'+people+'加入群组'); 
                       
                } else {
                   console.log('管理员同意'+people+'加入群组');
                   IM.EV_getGroupList();    
                }
            } else if (8 == auditType) {
              
            } else if (10 == auditType) {
                
            } else if (11 == auditType) {
              
            } else if(12 == auditType){
                
            } else {
                '未知type[' + auditType + ']';
            }
        },
        
        /**
         * 踢出群组成员
         * 
         * @param groupId
         * @param memberId
         * @constructor
         */
        EV_deleteGroupMember : function(groupId, memberId,activityId) {
            console.log("delete group member groupId:[" + groupId
                    + "],memberId:[" + memberId + "]");
            var builder = new RL_YTX.DeleteGroupMemberBuilder(groupId, memberId);
            RL_YTX.deleteGroupMember(builder, function() {
                        console.log("delete group member suc");
                        IM.EV_followActivity(activityId,memberId,4);
                    }, function(obj) {
                        alert("用户删除失败");
                        console.log("错误码： " + obj.code+"; 错误描述："+obj.msg);
                    });
        },      
        
        /**
         * 事件，获取群组列表
         * 
         * @constructor
         */
        EV_getGroupList : function() {
            var obj = new RL_YTX.GetGroupListBuilder();
            obj.setPageSize(-1);
            obj.setTarget(2);// target传125是一起查， 1是讨论组 2是群组
            RL_YTX.getGroupList(obj, function(obj) {
            			plus.storage.setItem("groupNumbers",obj.length);
                        for (var i in obj) {
                            var groupId = obj[i].groupId;
                            var groupName = obj[i].name;
                            var owner = obj[i].owner;
                            var isNotice = obj[i].isNotice;
                            var target = obj[i].target;
                            console.log("[groupid=]" + groupId + "[;groupName=]"+ groupId + "[;owner=]" +owner + "[;isNotice=]"+ isNotice + "[;target=]" +target );
                            if(groupId != null && groupName != null){
                            	IM.DO_addGrouplist(groupId,groupName,owner);
                            }
							
                        }
                    }, function(obj) {
                        alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                    });
        },
        
        /**
         * 解散群组
         * 
         * @param groupId
         * @constructor
         */
        EV_dismissGroup : function(groupId) {
            console.log('dismiss Group...');
            var obj = new RL_YTX.DismissGroupBuilder();
            obj.setGroupId(groupId);

            RL_YTX.dismissGroup(obj, function() {
                        console.log('dismiss Group SUCC...');
                        // 将群组从列表中移除

                        // 关闭群组聊天页面
                    }, function(obj) {
                        alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                    });
        },

        /**
         * 退出群组
         * 
         * @param groupId
         * @constructor
         */
        EV_quitGroup : function(groupId) {
            console.log('quit Group...');
            var obj = new RL_YTX.QuitGroupBuilder();
            obj.setGroupId(groupId);

            RL_YTX.quitGroup(obj, function() {
                        console.log('quit Group SUCC...');
                        // 将群组从列表中移除

                        // 关闭群组聊天页面
                    }, function(obj) {
                        alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                    });
        },
        
       /**
         * 群组免打扰功能是指群组收到消息的时候，是否震动手机或振铃（震动或振铃是在应用层处理，通过sdk可以设置此状态并保存在服务端，切换手机时，群组的状态也可同步）
         * 
         * @param groupId
         * @param isNotice
         * @constructor
         */
        EV_groupPersonalization : function(groupId, isNotice) {
            console.log("set group notice,groupId:[" + groupId + "],isNotice["
                    + isNotice + "]");
            var builder = new RL_YTX.SetGroupMessageRuleBuilder(groupId,
                    isNotice);
            RL_YTX.setGroupMessageRule(builder, function() {
                console.log("set groupNotice suc");
                // 切换btn样式
                if (isNotice == 2) {
                   免打扰
                } else {
                    提醒
                }
               
            }, function(obj) {
                //alert("set groupNotice error:" + obj.code);
                alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
            });
        },      
        
        /**
         * 整合用户信息传给服务器
         */
        EV_updateMyInfo : function() {

            var nickName = plus.storage.getItem("nickname");;
         	
         	if(nickName == null){
         		return;
         	}
           
            var sex = plus.storage.getItem("sex");
            if (sex = "女"){
            	sex = 2;
            }else{
            	sex =1;	
            }
			console.log("update my info: nickname= " +nickName);

            var uploadPersonInfoBuilder = new RL_YTX.UploadPersonInfoBuilder(
                    nickName, sex,null ,null );

            RL_YTX.uploadPerfonInfo(uploadPersonInfoBuilder, function(obj) {
      					console.log("用户信息修改成功");
      					
                    }, function(obj) {
                        alert("错误码："+obj.code+"; 错误描述："+obj.msg)
                    });
        },        
        
        /**
         * 事件，获取登录者个人信息
         * 
         * @constructor
         */
        EV_getMyInfo : function() {
            RL_YTX.getMyInfo(function(obj) {
                if (!!obj && !!obj.nickName) {
                    IM._username = obj.nickName;
                    console.log(IM._username);
                    if(IM._username  == null){
                    	IM.EV_updateMyInfo();
                    }
                    IM._sex = obj.sex;
                    console.log(IM._sex);
                }else{
                	IM.EV_updateMyInfo();
                };
              
            }, function(obj) {
                if (520015 != obj.code) {
                    alert("错误码： " + obj.code+"; 错误描述："+obj.msg);
                }
            });
        },        
        
        EV_getUserState: function(userid) {
        	console.log('userid:'+userid);
			var userStateBuilder =  new RL_YTX.GetUserStateBuilder();
			userStateBuilder.setUseracc(userid);
			RL_YTX.getUserState(userStateBuilder, 
			function(obj){
				console.log('user acc:'+obj.useracc);
				console.log('user state:'+obj.state);
				console.log('user network:'+obj.network);
				console.log('user device:'+obj.device);
				getUserStateSuccess(obj);
				//获取成功
				//obj.useracc 对方账号
				//obj.state 对方在线状态1:在线2:离线当用户为离线状态时，obj.state,obj.network和obj.device为undefined
				//obj.network对方网络状态 1:WIFI 2:4G 3:3G 4:2G(EDGE) 5: INTERNET  6: other
				//obj.device对方登录终端1:Android 2:iPhone10:iPad11:Android Pad20:PC 21:H5
			}, function(resp){
			    //获取失败
			    console.log("获取用户"+id+"的信息失败");
			    getUserStateFailed(resp);
			});

		},
	
};