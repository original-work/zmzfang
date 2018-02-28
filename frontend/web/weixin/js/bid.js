(function(b) {
	
						
	//创建需求详情页中的投标信息
	b.fillBidListLi = function(data) {
//		var ele = document.createElement("li");
//		var housetype = data.roomcnt+'室'+data.roomcnt+'厅'+data.bathroomcnt+'卫';
//		
//		var liContent = '';
//		liContent += '<div>';
//		liContent += '<h5><span>'+data.nickname+'</span>&nbsp<span>'+data.districtname+'</span>&nbsp<span>'+housetype+' </span> &nbsp <span>'+data.biddate+'</span>投标</h5>';
//		liContent += '<div>';
//		
//		ele.innerHTML = liContent;

		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media ";
	
		console.log('date:'+data.biddate);
		var publishdate = data.biddate;
		var timearray=publishdate.split(" ");
		var newupdatetime=timearray[0];
		
		var housetype = data.roomcnt + '室'+ data.hallcnt + '厅' + data.bathroomcnt + '卫';
		//console.log('bidstatus:'+data.bidstatus);
		var statusStr = getBidStatusStr(data.bidstatus);
		//console.log('statusStr:'+statusStr);
		console.log('refusereason'+data.refusereason);
		
		
		var liContent = '';
		liContent += '<div id="houseBrief" class="house-brief" house-id="'+data.houseid+'">';
		liContent += '<div style="width:42px; height:60px;overflow:hidden;float:left;margin-right:8px;">';
		liContent += '<img id="housePic" class="mui-media-object mui-media-large  mui-pull-left" style="" data-lazyload-id="0" src="'+data.picture+'">';
		liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
		liContent += '</div>';
		liContent += '<div class="mui-media-body">';
		liContent += '<h4 id="districtName" class="mui-ellipsis" style="margin-left: 0px;overflow: visible;">'+data.districtname+'</h4>';
		liContent += '<h5 style="margin-left: 0px;"> <span id="houseType">'+housetype+'</span> <span id="price" style="margin-left:10px;">'+data.expectsaleprice+'万</span> <span id="buildingArea">'+data.buildingarea+' 平米</span></h5>';
		liContent += '<h5> 状态:<span id="bidStatus">'+statusStr+'</span> <span style="float:right;margin-right: 0px;">'+newupdatetime+'</span> </h5>	';
		if(data.refusereason !== null && data.refusereason !== '')
		{
			liContent += '<h5> 原因:<span id="reason">'+data.refusereason+'</span></h5>	';
		}
		liContent += '</div>';
		liContent += '</div>';
		
		
		ele.innerHTML = liContent;
	
		return ele;
	}
	
	//投标成功
	b.bidSuccess = function (data)
	{
		console.log('bidSuccess data'+JSON.stringify(data));
		//alert(JSON.stringify(data));
		mui.back();
	}
	
	b.checkBidLimit = function()
	{
		var nowtime = getDayStamp();
		console.log('nowtime:'+nowtime);
		var bidLimitInfo = JSON.parse(localStorage.getItem('zmzfangBidLimitInfo'));
		if(!bidLimitInfo)
		{
			//不存在
			var limitInfo = new Object();
			limitInfo.bidCnt = 0;
			limitInfo.lastBidTime = nowtime;
			localStorage.setItem('zmzfangBidLimitInfo',JSON.stringify(limitInfo));
			//return true;
		}
		else
		{
			//存在
			if(nowtime == bidLimitInfo.lastBidTime)
			{
				//当前天 判断有没有超过5次
				if(parseInt(bidLimitInfo.bidCnt) >= 5)
				{
					mui.toast('您今天已经投标5次');
					return false;
				}
			}
			else
			{
				//新的一天
				bidLimitInfo.bidCnt = 0;
			    bidLimitInfo.lastBidTime = nowtime;
			    localStorage.setItem('zmzfangBidLimitInfo',JSON.stringify(bidLimitInfo));
			}
			//alert('bidCnt:'+bidLimitInfo.bidCnt);
		}
		return true;
	}
	
	b.updateBidLimitInfo = function()
	{
		var nowtime = getDayStamp();
		var bidLimitInfo = JSON.parse(localStorage.getItem('zmzfangBidLimitInfo'));
		bidLimitInfo.bidCnt = parseInt(bidLimitInfo.bidCnt)+1;
		bidLimitInfo.lastBidTime = nowtime;
		localStorage.setItem('zmzfangBidLimitInfo',JSON.stringify(bidLimitInfo));
	}
	
	b.getDayStamp = function() {
		var now = new Date();
		//var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) + (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) + (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) + (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
		var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate());
		return timestamp;
	}
	
})(window);