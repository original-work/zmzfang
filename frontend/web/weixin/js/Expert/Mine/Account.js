var byId = function(id) {
	return document.getElementById(id);
};

var loginUser;
var accountInfo;
mui.init();
			
mui.ready(function() {
	loginUser = JSON.parse(localStorage.getItem("zmzfangLoginUserInfo"));
	if(!loginUser)
	{
		console.log('用户未登陆');
	}
	initAccountInfo();
	
})

//增加查看明细按钮事件
document.querySelector('#showDetail').addEventListener('tap', function() {
	console.log('showDetail click');
	if(accountInfo == null || accountInfo.historyincome == null || accountInfo.historyincome == 0)
	{
		mui.toast('该账户暂无明细');
		return;
	}
	var dstUrl = "../Mine/AccountDetail.html";
	mui.openWindow({
		url: dstUrl,
		id: 'AccountDetail.html'
	});
}, false);

//增加提现按钮事件
document.querySelector('#drawed').addEventListener('tap', function() {
	console.log('drawed click');
	if(accountInfo == null || accountInfo.remainedprofit == null || accountInfo.remainedprofit == 0)
	{
		mui.toast('余额不足，无法提现');
		return;
	}
	
	var dstUrl = "../Mine/ApplyDrawed.html";
	mui.openWindow({
		url: dstUrl,
		id: 'ApplyDrawed.html'
	});
}, false);

var getOption = function() {
	var chartOption = {
		calculable: false,
		series: [{
			name: '访问来源',
			type: 'pie',
			radius: '65%',
			center: ['50%', '50%'],
			data: [{
				value: accountInfo.drawedprofit,
				name: '已提现'+accountInfo.drawedprofit
			}, {
				value: accountInfo.usedprofit,
				name: '已支出'+accountInfo.usedprofit
			}, {
				value: accountInfo.remainedprofit,
				name: '未提现'+accountInfo.remainedprofit
			},{
				value: accountInfo.lockingprofit,
				name: '已冻结'+accountInfo.lockingprofit
			}
			]
		}]
	} ;
	return chartOption;
};

function initChart()
{
	var pieChart = echarts.init(byId('pieChart'));
	pieChart.setOption(getOption());
	byId("pieChart").addEventListener('tap',function(){
		//var url = this.getAttribute('data-url');
		//plus.runtime.openURL(url);
		mui.toast('查看详情');
	},false);
}

function initAccountInfo()
{
	var options = new Object();
	if(loginUser.expertflag == '0')
	{
		options.userid = loginUser.id;
		options.usertype = "1";
	}
	else if(loginUser.expertflag == '1')
	{
		options.userid = loginUser.expertid;
		options.usertype = "2";
	}
	else
	{
		return;
	}
	ajax_to_server(getAccountUrl,options,getAccountSuc,getAccountFailed);
}

function getAccountSuc(data)
{
	console.log("getAccountSuc data:"+JSON.stringify(data));
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		//mui.toast('获取账户信息失败');
		return;
	}
	
	/*
	{"id":"2","userid":"20","usertype":"2","openid":"121213",
	"historyincome":"10000",
	"historyprofit":"9000",
	"drawedprofit":"6000",
	"usedprofit":"2000",
	"remainedprofit":"1000",
	"createtime":"2016-10-11 15:19:47","updatetime":"2016-10-11 15:19:51"}
	*/
	accountInfo = data;
	localStorage.setItem("zmzfangAccountInfo",JSON.stringify(accountInfo));
	byId('account').innerText = accountInfo.remainedprofit;
	byId('historyincome').innerText = accountInfo.historyincome;
	byId('historyprofit').innerText = accountInfo.historyprofit;
	byId('drawedprofit').innerText = accountInfo.drawedprofit;
	byId('usedprofit').innerText = accountInfo.usedprofit;
	byId('remainedprofit').innerText = accountInfo.remainedprofit;
	byId('lockingprofit').innerText = accountInfo.lockingprofit;
	var total = parseFloat(accountInfo.drawedprofit) + parseFloat(accountInfo.usedprofit) + parseFloat(accountInfo.remainedprofit)
	if(total  > 0)
	{
		$('#pieChart').removeClass('mui-hidden');
		initChart();
	}
	
}

function getAccountFailed(data)
{
	console.log("getAccountFailed data:"+JSON.stringify(data));
	mui.toast('获取账户信息失败');
}



