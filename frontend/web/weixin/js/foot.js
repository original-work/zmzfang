var domain = 'http://www.zmzfang.com/weixin/';
document.write('<nav id="mainBar" class="mui-bar mui-bar-tab">'
			+'<a id="homeLink" class="mui-tab-item-own" href="'+domain+'HomePage/index.html">'
				+'<svg  class="mui-icon icon" aria-hidden="true" style="top:0"><use xlink:href="#icon-home"></use></svg>'
				+'<span class="mui-tab-label">首页</span>'
			+'</a>'
			+'<a id="flashLink" class="mui-tab-item-own" href="'+domain+'HomePage/searchAgent.html">'
				+'<span class="mui-icon mui-icon-paperplane"style="font-size: 2rem;margin: -5px 0 0 -8px;"></span>'
				+'<span class="mui-tab-label">找人</span>'
			+'</a>'
			+'<a id="expertLink" class="mui-tab-item-own" href="'+domain+'Expert/expert.html">'
				+'<span class="mui-icon mui-icon-pengyouquan"></span>'
				+'<span class="mui-tab-label">快问</span>'
			+'</a>'
			+'<a id="msgLink" class="mui-tab-item-own " href="'+domain+'/Message/im-list.html">'
				+'<span class="mui-icon mui-icon-chatboxes"><span id="notice" style="display:none" class="mui-badge"></span></span>'
				+'<span class="mui-tab-label">消息</span>'
			+'</a>'
			+'<a id="mineLink" class="mui-tab-item-own " href="'+domain+'mine.html">'
				+'<svg  class="mui-icon icon" aria-hidden="true" style="top:0"><use xlink:href="#icon-mine"></use></svg>'
				+'<span class="mui-tab-label">我的</span>'
			+'</a>'
		+'</nav>'
);

var loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
if(loginUser && loginUser.id){

	// wilddog初始化
	//if(typeof(wilddog) == 'undefined'){
	var config = {
		syncURL: "https://sickeeer.wilddogio.com"
	};
	wilddog.initializeApp(config);
	var ref = wilddog.sync().ref();
	//}


	// 监听总未读
	var me =loginUser.id;
	var total = 0;
	ref.child('list/'+me).on('value', function(snapshot,error)
	{
		total = 0;
		snapshot.forEach(function(data) {
			total +=data.val().unlook;
		});
		if(parseInt(total)>0){
			document.getElementById('notice').style.display=''
			document.getElementById('notice').innerHTML=total;
		}else{
			document.getElementById('notice').style.display='none'
		}
	});
	
}else{
	console.log("unlogin");
}