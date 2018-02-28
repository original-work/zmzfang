var loginUser;
var startSn = 0;
var globalCnt = 5;
var allListUl;
var incomeListUl;
var paymentListUl;


var byId = function(id) {
	return document.getElementById(id);
};
	
(function($, doc) {
	mui.init({
		swipeBack: false
	});
	
	mui.ready(function() {
		//$('#mineLink').addClass('mui-active');
		var data = localStorage.getItem('zmzfangLoginUserInfo');
		console.log(JSON.stringify(data));
		if(!!data){
			loginUser = JSON.parse(data);
		}
		else
		{
			mui.toast("未获取到用户登陆信息");
			return;
		}
		allListUl = document.getElementById('allUl');
		incomeListUl = document.getElementById('incomeUl');
		paymentListUl = document.getElementById('paymentUl');
		initAccountDetail();
	});
	
	mui('#all').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#income').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
	mui('#payment').pullRefresh({
		up: {
				height:50,
				contentrefresh: '正在加载...',
				contentnomore:'没有更多数据了',
				callback: pullupRefresh
			}
		}	
	);
	
}(mui, document));

//tap点击事件
document.querySelector('#allLink').addEventListener('tap', function() {

	$('#income').addClass('mui-hidden');
	$('#payment').addClass('mui-hidden');
	
	$('#all').removeClass('mui-hidden');
	if(startSn == 0)
	{
		initAccountDetail();
	}
}, false);

document.querySelector('#incomeLink').addEventListener('tap', function() {

	$('#all').addClass('mui-hidden');
	$('#payment').addClass('mui-hidden');
	
	$('#income').removeClass('mui-hidden');
	if(startSn == 0)
	{
		initAccountDetail();
	}
}, false);

document.querySelector('#paymentLink').addEventListener('tap', function() {

	$('#all').addClass('mui-hidden');
	$('#income').addClass('mui-hidden');
	
	$('#payment').removeClass('mui-hidden');
	if(startSn == 0)
	{
		initAccountDetail();
	}
}, false);


function initAccountDetail(startsn,count)
{
	console.log("initAccountDetail");
	
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
	
	options.start = arguments[0] ? arguments[0] : 0;
	options.count = arguments[1] ? arguments[1] : globalCnt;
	//获取我的约见 记录
	ajax_to_server(getAccountDetailUrl,options,getAccountDetailSuc,getAccountDetailFailed);
}

function getAccountDetailSuc(data)
{
	console.log("getAccountDetailSuc data:"+JSON.stringify(data));
	
	if(!data || data.length == 0)
	{
		//showPromptInfo();
		mui.toast('没有获取到更多数据');
		return;
	}
	
	var allFrag = document.createDocumentFragment();
	var incomeFrag = document.createDocumentFragment();
	var paymentFrag = document.createDocumentFragment();
	
	for(var i in data)
	{
		console.log('\n i:'+i);
		allFrag.appendChild(fillAccountDetailListLi(data[i]));
		
		if(data[i].accounttype == '10')
		{
			//收入
			incomeFrag.appendChild(fillAccountDetailListLi(data[i]));
		}
		else if(data[i].accounttype == '20')
		{
			//支出
			paymentFrag.appendChild(fillAccountDetailListLi(data[i]));
		}
		
	}
	startSn += data.length;
	
	allListUl.appendChild(allFrag);
	incomeListUl.appendChild(incomeFrag);
	paymentListUl.appendChild(paymentFrag);
}

function getAccountDetailFailed(data)
{
	console.log("getAccountDetailFailed data:"+JSON.stringify(data));
}

function fillAccountDetailListLi(data)
{
	console.log(JSON.stringify(data));
	
	
	
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	liContent += '<div id="accountBrief" class="col-xs-12" order-id="'+data.orderid+'">';
	liContent += '		<div class="col-xs-3 mui-text-center">';
	liContent += '			<h5 id="sumdate">'+data.sumdate+'</h5>';
	liContent += '		</div>';
			
	liContent += '		<div class="col-xs-2 mui-text-center">';
	accounttype =  data.accounttype= 10?'收入':'支出';
	liContent += accounttype;
	// liContent += '			<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;margin:auto;">';
	// liContent += '				<img id="pic" style="width:42px; height:42px; " src="http://www.zmzfang.com/weixin/img/servicetype/'+data.servicetype+'.jpg" alt="个人头像">';
	// liContent += '			</div>';
	liContent += '		</div>';
	liContent += '		<div class="col-xs-7">';
	liContent += '			<div>';
	liContent += '				<div class="col-xs-5 mui-text-left">';
	liContent += '					<h5><span id="fee">'+data.actualfee+'</span>元</h5>';
	liContent += '				</div>';
	liContent += '				<div class="col-xs-7 mui-text-left">';
	liContent += '					<h5><span id="serviceType">'+getServiceTypeStr(data.servicetype)+'</span></h5>';
	liContent += '				</div>';
	liContent += '			</div>';
	var orderid = data.orderid?data.orderid:'无';
	liContent += '			<div style="padding-top: 5px;clear:both">';
	liContent += '				<h5 style="padding-left:5px">订单号:<span id="orderid">'+orderid+'</span></h5>';
	liContent += '			</div>';
	liContent += '		</div>';
			
	liContent += '	</div>	';
	
	ele.innerHTML = liContent;
	return ele;
}

function pullupRefresh()
{
	console.log('pullupRefresh');
	//alert('pullupRefresh id:' + this.element.getAttribute('id'));
	var self = this;
	setTimeout(function() {
		initAccountDetail(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}
