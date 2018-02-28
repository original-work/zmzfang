var loginUser;
(function($, doc) {
	mui.init({
		swipeBack: false,
		gestureConfig:{
			doubletap:true
		},
	});

	mui.ready(function() {
		var data = localStorage.getItem('zmzfangLoginUserInfo');
			console.log(JSON.stringify(data));
			if(!!data){
				loginUser = JSON.parse(data);
		}
		initCityPicker();
	
	});

//	mui('.mui-scroll-wrapper').pullRefresh({
//		up: {
//				height:50,
//				contentrefresh: '正在加载...',
//				contentnomore:'没有更多数据了',
//				// callback: window['pullupRefresh'+callback]
//				callback: pullupRefresh
//			}
//		}	
//	);
}(mui, document));
	
//查看问题详情按钮
mui('#estateSalesUl').on('tap', '.estate-pic', function() {
	var estateId = $(this).attr('estate-id');
	console.log('estateId:'+estateId);
	var dstUrl = './List/EstateDetail.html?estateId='+estateId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'EstateDetail.html'
	});
});

//查看问题详情按钮
mui('#segmentedControl').on('tap','#myEstateSalesLink', function() {
	var dstUrl = '././Mine/MyEstateSales.html';
	mui.openWindow({
		url: dstUrl,
		id: 'MyEstateSales.html'
	});
});



//初始化城市选择按钮
function initCityPicker()
{
	//级联示例
	var cityPicker = new mui.PopPicker({
		layer: 2
	});
	cityPicker.setData(cityData);
	var showCityPickerButton = document.getElementById('cityLink');
	var cityResult = document.getElementById('cityResult');
	showCityPickerButton.addEventListener('tap', function(event) {
		cityPicker.show(function(items) {
			
			console.log("你选择的城市是:" + items[0].text + " " + items[1].text);
			cityResult.innerText = items[0].text + " " + items[1].text;
			//返回 false 可以阻止选择框的关闭
			//return false;
		});
	}, false);
}
	
					


