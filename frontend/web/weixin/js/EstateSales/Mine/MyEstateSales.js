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
		//initCityPicker();
	
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
	var dstUrl = './Mine/MyEstateDetail.html?estateId='+estateId;
	
	mui.openWindow({
		url: dstUrl,
		id: 'MyEstateDetail.html'
	});
});

	

