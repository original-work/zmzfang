var loginUser = null;
var startSn = 0;
var globalCnt = 15;
var mask = mui.createMask(callback);
// var offset = parseInt(window.document.location.href.split('=')[1]);
var opt ={}
var city = '';//城市不限
mui.init(
{
	swipeBack: false,
	gestureConfig:{
			doubletap:true
	},
	pullRefresh: {
		container: '#pullrefresh',
		// down: {
		// 	callback: pulldownRefresh
		// },
		up: {
			height:50,
			contentrefresh: '正在加载...',
			contentnomore:'没有更多数据了',
			callback: pullupRefresh,
		}
	}
});
			
mui.ready(function() {
	wxShare({'title':'同行直招，跳槽首选，高薪职位都在这里！',"desc":'芝麻找房喊你来跳槽！','link':window.document.location.href})
	 var searchParameterRecruit = JSON.parse(sessionStorage.getItem('searchParameterRecruit'));
	 
	 if(searchParameterRecruit){
	 	console.log('searchParameterRecruit:'+JSON.stringify(searchParameterRecruit));
	 	 opt.recruitworkcity = searchParameterRecruit.recruitworkcity;
		 opt.recruitposition = searchParameterRecruit.recruitposition;
		 opt.salary = searchParameterRecruit.salary;
		 opt.workperiod = searchParameterRecruit.workperiod;
	
		if(opt.recruitworkcity)
		{
			$('#recruitworkcity_value').text(opt.recruitworkcity);
		}
		if(opt.recruitposition)
		{
			$('#recruitposition_value').text(opt.recruitposition);
		}
		if(opt.salary)
		{
			$('#salary_value').text(opt.salary);
		}
		if(opt.workperiod)
		{
			$('#workperiod_value').text(opt.workperiod);
		}

		
	 	//initstartSn = searchParameter.start;
	 		//getRequirementList(0,'',initstartSn);//获取需求列表
	 		console.log('sessionStorage works')
	 }
	initCityPicker();
	listJson();
});
	// opt.location = '平壤';
	// opt.recruitposition = '军委主席'
	// opt.salary = '80000'
	// opt.workperiod = '30年'
var $a = ['recruitworkcity','recruitposition','salary','workperiod'];
for(i in $a){
	$("."+$a[i]+"_list li").on("tap",{'par':$a[i]},bind)
}
function bind(e){
	$data=$(this).attr('data');
	$("#"+e.data.par+"_value").text($(this).text());
	startSn = 0;
	mui('#pullrefresh').pullRefresh().scrollTo(0,0,0);
	opt[e.data.par] = $data
	listJson()
	mask.close();
}
/**
 * 上拉加载具体业务实现
 */
function pullupRefresh() {
	console.log('pullupRefresh');
	var self = this;
	setTimeout(function() {
		//var ul = self.element.querySelector('.mui-table-view');
		//ul.appendChild(createFragment(ul, 0, 5));
		listJson(startSn);
		self.endPullupToRefresh(false); 
	}, 1000);
}

var index = '';
$('.mui-i-selectBtn').on('tap',function(){
	if(index === $(this).index()){
		index = '';
		mask.close();
	}else{
		index = $(this).index();
		$('.content .filter_item').removeClass('active');
		$('.content .filter_item:eq('+index+')').addClass('active');
		document.body.style.overflow='hidden';
		mask.show();//显示遮罩
	}
});

function callback(){
	$('.content .filter_item').removeClass('active');
	document.body.style.overflow='';
}

function listJson(start,count){
	opt.start = arguments[0] ? arguments[0] : 0;
	opt.count = arguments[1] ? arguments[1] : globalCnt;
	if(opt.start == 0)
	{
		$('#positionUl').html('');
	}
	ajax_to_server('http://www.zmzfang.com/?r=recruit/get-recruit-list',opt,listSuccess);
}

function listSuccess(res){
	console.log('listSucess:'+JSON.stringify(res));
	if(res.length > 0){
		//var $li = ''
		var firstFrag = document.createDocumentFragment();
		for(i in res){
			firstFrag.appendChild(NewCommonPositionLi(res[i]));
		}
		startSn += res.length;
		$('#positionUl')[0].appendChild(firstFrag);
		//$('#positionUl').html($li)
		$('.position-brief').off('tap');
		$('.position-brief').on('tap',function(){
			sessionStorage.setItem('searchParameterRecruit',JSON.stringify(opt));
			window.location.href = './PositionDetail.html?id='+$(this).attr('position-id')
		})
	}else{
		$('#positionUl').html('<li class="mui-table-view-cell mui-media"><p style="text-align:center">暂无信息</p>')
	}
}

//初始化城市按钮
function initCityPicker()
{
	//级联示例
	var cityPicker = new mui.PopPicker({
		layer: 2
	});
	
	var defaultData = {
	value: '000000',
	text: '不限',
	children: [{
		value: "000000",
		text: "不限"
	}]};
	var data = cityData;
	
	for(var i in data)
	{
		if(data[i].text == '北京市' || data[i].text =='上海市' || data[i].text == '天津市' || data[i].text == '重庆市')
		{
			data[i].children.unshift({value: "000000",text: "不限"});
		}
		
	}
	data.unshift(defaultData);
	
	cityPicker.setData(data);
	
	var showCityPickerButton = document.getElementById('recruitworkcity_value');
	
	showCityPickerButton.addEventListener('tap', function(event) {
		$('#mgrLinkDiv').addClass('mui-hidden');
		cityPicker.show(function(items) {
			
			console.log("你选择的城市是:" + items[0].text + " " + items[1].text);
			if(items[1].text == "不限")
			{
				showCityPickerButton.innerText = items[0].text;
				city = items[0].text;
			}
			else
			{
				showCityPickerButton.innerText = items[1].text;
				city = items[0].text + items[1].text;
			}
			
			//返回 false 可以阻止选择框的关闭
			$('#mgrLinkDiv').removeClass('mui-hidden');
		
			{
				startSn = 0;
				mui('#pullrefresh').pullRefresh().scrollTo(0,0,0);
				if(city=="不限")
				{
					opt['recruitworkcity'] = '';
				}
				else
				{
					opt['recruitworkcity'] = city;
				}
				
				listJson()
				//mask.close();
			}
			
		}
		);
		
//		cityPicker.hide(
//			function()
//			{
//				console.log('xsss');
//			}
//		);
	}, false);
	
	//城市选择 取消事件
	$('.mui-poppicker-btn-cancel').on('tap',function(){
		$('#mgrLinkDiv').removeClass('mui-hidden');
	});
}