var headUrl;
var nickname;
var time;
var content;
var number;
var phone;

var byId = function(id) {
	return document.getElementById(id);
};

var wilddogioRef;
var expertWilddogioRef;
var loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
var contactsList = [];
var expertContactsList = [];

(function() {
	mui.init();
	mui.ready(function() {
		//phone = localStorage.getItem("phone") || "15800597248";
		// if(loginUser.expertflag == '1' && loginUser.expertid)
		// {
			//初始化专家相关div
			initExpertDiv();
			//初始化专家消息
			initExpertMsgs();
		// }
		//初始化用户消息
		initUserMsgs();
	});
	
	mui.back = function(){
		mui.openWindow({
			url: '../index.html'
		});
	};
			
//	IM.initSDK();
	//alert('loginUser.userid:'+loginUser.id);
	//IM._login(loginUser.id);
				
})();

function initUserMsgs()
{
	phone = loginUser.id;
	wilddogioRef = new Wilddog("https://zmzf0001.wilddogio.com/" + phone);
	var stateRef = wilddogioRef.child('stateinfo');
	stateRef.set("1");
	stateRef.onDisconnect().set("0");
	
	getContactsListFromWilddog();
}

function initExpertMsgs()
{
	phone = loginUser.expertid;
	expertWilddogioRef = new Wilddog("https://zmzf0001.wilddogio.com/" + phone);
	var stateRef = expertWilddogioRef.child('stateinfo');
	stateRef.set("1");
	stateRef.onDisconnect().set("0");
	
	getExpertContactsListFromWilddog();
}


function bindContactsList() {
	//绑定数据:
    console.log('bindContactsList contactsList.lenght:'+contactsList.length);
	byId("imUl").innerHTML = template('msg-template', {
		"record": contactsList,
		"loginuserid":loginUser.id
	});
	var msgItems = byId("imUl").querySelectorAll('.mui-table');
	[].forEach.call(msgItems, function(item, index) {

		item.addEventListener('tap', function(event) {
			var dstPhone = this.id.split("-")[1];
			var dstNickName = this.id.split("-")[2];
			console.log("dstPhone=" + dstPhone);
			localStorage.setItem("chatObjectId", dstPhone);
			localStorage.setItem("chatObjectNickName", dstNickName);
			
			mui.openWindow({
				url: './im-chat.html',
				id: './im-chat.html',
				show: {
					autoShow: true, //页面loaded事件发生后自动显示，默认为true
					aniShow: "slide-in-left", //页面显示动画，默认为”slide-in-right“；
					duration: 0 //页面动画持续时间，Android平台默认100毫秒，iOS平台默认200毫秒；
				}
			});
		}, false);
	});
};

function bindExpertContactsList() {
	//绑定数据:
    console.log('bindExpertContactsList expertContactsList.lenght:'+expertContactsList.length);
	byId("expertMsgsUl").innerHTML = template('msg-template', {
		"record": expertContactsList,
		"loginuserid":loginUser.expertid
	});
	var expertFlag = 1;
	var msgItems = byId("expertMsgsUl").querySelectorAll('.mui-table');
	[].forEach.call(msgItems, function(item, index) {

		item.addEventListener('tap', function(event) {
			var dstPhone = this.id.split("-")[1];
			var dstNickName = this.id.split("-")[2];
			console.log("dstPhone=" + dstPhone);
			localStorage.setItem("chatObjectId", dstPhone);
			localStorage.setItem("chatObjectNickName", dstNickName);
			
			var dstUrl = '../Message/im-chat.html?expertflag='+expertFlag;
			mui.openWindow({
				url: dstUrl,
				id: './im-chat.html',
				show: {
					autoShow: true, //页面loaded事件发生后自动显示，默认为true
					aniShow: "slide-in-left", //页面显示动画，默认为”slide-in-right“；
					duration: 0 //页面动画持续时间，Android平台默认100毫秒，iOS平台默认200毫秒；
				}
			});
		}, false);
	});
};

function getContactsListFromWilddog() {
	var childRef = wilddogioRef.child("list");
	console.log("getContactsListFromWilddog childRef=" + childRef.toString());
    contactsList = [];//清空
    var systemMsg = null;
    var sum = 0;
	childRef.orderByChild("time").on("value", function(snapshot) {
		contactsList = [];//清空
		systemMsg = null;
		var contacts = snapshot.val();
		console.log('contacts:'+JSON.stringify(contacts));
//		contact=JSON.parse(contact);
		snapshot.forEach(function(data) {
			var contact = data.val();
			console.log('contact begin:'+JSON.stringify(contact));
			console.log("time=" + contact.time);
			contact.time = formatStringyyyyMMddToTimeAgo(contact.time);
			
			console.log("contact after " + JSON.stringify(contact));
			//增加系统消息的处理
			if(contact.sender == 'system')
			{
				systemMsg = contact;
			}
			else
			{
				contactsList.push(contact);
			}
			
			if(contact.num)
		    {
		    	console.log('contact.num='+contact.num);
		    	sum += parseInt(contact.num);
		    }
		    if(contact.offlinenum)
		    {
		    	console.log('contact.offlinenum='+contact.offlinenum);
		    	sum += parseInt(contact.offlinenum);
		    }
		}) 
		
		if(systemMsg)
		{
			console.log('system message');
			contactsList.push(systemMsg);
		}
		bindContactsList();
			    
	});
	showMsgNotice(sum);
}

function getExpertContactsListFromWilddog() {
	var childRef = expertWilddogioRef.child("list");
	console.log("getExpertContactsListFromWilddog childRef=" + childRef.toString());
    expertContactsList = [];//清空
    var systemMsg = null;
    var sum = 0;
	childRef.orderByChild("time").on("value", function(snapshot) {
		expertContactsList = [];//清空
		systemMsg = null;
		var contacts = snapshot.val();
		console.log('contacts:'+JSON.stringify(contacts));
//		contact=JSON.parse(contact);
		snapshot.forEach(function(data) {
			var contact = data.val();
			console.log('contact begin:'+JSON.stringify(contact));
			console.log("time=" + contact.time);
			contact.time = formatStringyyyyMMddToTimeAgo(contact.time);
			
			console.log("contact after " + JSON.stringify(contact));
			//增加系统消息的处理
			if(contact.sender == 'system')
			{
				systemMsg = contact;
			}
			else
			{
				expertContactsList.push(contact);
			}
			
			if(contact.num)
		    {
		    	console.log('contact.num='+contact.num);
		    	sum += parseInt(contact.num);
		    }
		    if(contact.offlinenum)
		    {
		    	console.log('contact.offlinenum='+contact.offlinenum);
		    	sum += parseInt(contact.offlinenum);
		    }
		}) 
		
		if(systemMsg)
		{
			console.log('system message');
			expertContactsList.push(systemMsg);
		}
		bindExpertContactsList();
			    
	});
	showMsgNotice(sum);
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

function initExpertDiv()
{
	initExpertLink();
}

function initExpertLink()
{
	var content = '';
	content += '<div id="linkDiv" style="padding: 10px 10px;">';
	content += '			<div id="segmentedControl" class="mui-segmented-control mui-segmented-control-inverted">';
	content += '				<a id="userMsgsLink" class="mui-control-item" href="">';
	content += '					个人';
	content += '				</a>';
	content += '				<a id="expertMsgsLink" class="mui-control-item mui-active" href="">';
	content += '					专家';
	content += '				</a>';
	content += '			</div>';
	content += '		</div>';
			
	content += '		<div class="mui-slider-group">';
	content += '			<div id="userMsgsDiv" class="mui-content mui-scroll-wrapper mui-hidden">';
	content += '				<div class="mui-scroll">';
	content += '					<ul id="imUl" class="mui-table-view">';
							
	content += '					</ul>';
	content += '				</div>';
	content += '			</div>';
	content += '			<div id="expertMsgsDiv" class="mui-content mui-scroll-wrapper">';
	content += '				<div class="mui-scroll">';
	content += '					<ul id="expertMsgsUl" class="mui-table-view">';
							
	content += '					</ul>';
	content += '				</div>';
	content += '			</div>';
	content += '		</div>';
	
	$('.mui-content').html(content);
	//处理事件
	$("#userMsgsLink").on("tap", function(){
		//alert($(this).text());
		
		$('#expertMsgsDiv').addClass('mui-hidden');
		$('#userMsgsDiv').removeClass('mui-hidden');
		
	});
	
	$("#expertMsgsLink").on("tap", function(){
		//alert($(this).text());
		$('#expertMsgsDiv').removeClass('mui-hidden');
		$('#userMsgsDiv').addClass('mui-hidden');
	});
}
