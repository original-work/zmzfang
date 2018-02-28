(function(h) {
	//创建我的房源列表li元素
	h.fillHouseListLi = function(data) {
		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media ";
	
		console.log('date:'+data.publishdate);
		var publishdate = data.publishdate;
		var timearray=publishdate.split(" ");
		var newupdatetime=timearray[0];
		
		var housetype = data.roomcnt + '室'+ data.hallcnt + '厅' + data.bathroomcnt + '卫';
		
		var liContent = '';
		
		liContent += '<div id="houseBrief" class="house-brief" house-id="'+data.houseid+'">';
		liContent += '<img id="housePic" class="mui-media-object mui-media-large  mui-pull-left" style="margin-top: 5px;" data-lazyload-id="0" src="../img/muwu.jpg">';
		liContent += '<div class="mui-media-body">';
		liContent += '<h4 id="districtName" class="mui-ellipsis" style="margin-left: 0px;overflow: visible;">'+data.districtname+'</h4>';
		liContent += '<h5 style="margin-left: 0px;"> <span id="houseType">'+housetype+'</span> <span id="price" style="margin-left:10px;">'+data.expectsaleprice+'万</span></h5>';
		liContent += '<h5>面积:<span id="buildingArea">'+data.buildingarea+' 平米</span>  <span style="float:right;margin-right: 0px;">'+newupdatetime+'</span> </h5>	';
		liContent += '</div>';
		liContent += '</div>';
		
		
		
		ele.innerHTML = liContent;
		return ele;
	}
	
	//获取房源详情成功后的处理方法，新建li元素
	h.getHouseDetailListSuccess = function(data)
	{
		var slider=document.getElementById('slider');
		var firstFrag = document.createDocumentFragment();
		firstFrag.appendChild(fillHouseDetailSliderGroup(data));
		firstFrag.appendChild(fillHouseDetailSliderIndicator(data));
		
		slider.innerHTML = "";
		slider.appendChild(firstFrag);
		
		var slider = mui("#slider");
			slider.slider({
				interval: 5000
			});
	}
	
	//创建房源详情slidergroup
	h.fillHouseDetailSliderGroup = function(data) {
		var ele = document.createElement("div");
		ele.className = "mui-slider-group mui-slider-loop";
		
		var liContent = '';
		console.log("data.length:"+data.length);
		for(var i in data)
		{
			var id=data[i].id;
			
			if(i == 0)
			{
				liContent += '<div class="mui-slider-item mui-slider-item-duplicate" promotion-id="'+data[i].id+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
				liContent += '<div class="mui-slider-item" promotion-id="'+data[i].id+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
			}
			else if(i == data.length-1)
			{
				liContent += '<div class="mui-slider-item" promotion-id="'+data[i].id+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
				liContent += '<div class="mui-slider-item mui-slider-item-duplicate" promotion-id="'+data[i].id+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
			}
			else
			{
				liContent += '<div class="mui-slider-item" promotion-id="'+data[i].id+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
			}
		}
		ele.innerHTML = liContent;
		return ele;
	}
	
	 //创建房源图片Indicator
	h.fillHouseDetailSliderIndicator = function(data) {
	    var ele = document.createElement("div");
		ele.className = "mui-slider-indicator";
			
		var liContent = '';
		console.log("data.length:"+data.length);
		for(var i in data)
		{
			var id=data[i].id;
			if(i==0)
			{
			    liContent += '<div class="mui-indicator mui-active"></div>';
		    }
			else
			{
				liContent += '<div class="mui-indicator"></div>';
			}
		}
		ele.innerHTML = liContent;
		return ele;
	}
	
	//创建匹配房源li元素
	h.fillMatchHouseListLi = function(data) {
		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media ";
		//var publishdate = data.publishdate;
		//var timearray=publishdate.split(" ");
		//var newupdatetime=timearray[0];
		
		var housetype = data.roomcnt + '室'+ data.hallcnt + '厅' + data.bathroomcnt + '卫';
		
		var liContent = '';
		liContent += '<label>';
		liContent += '<div id="houseBrief" class="house-brief" house-id="'+data.houseid+'">';
		liContent += '<img id="housePic" class="mui-media-object mui-media-large  mui-pull-left" style="margin-top: 5px;" data-lazyload-id="0" src="../img/muwu.jpg">';
		liContent += '<div class="mui-media-body">';
		liContent += '<h4 id="districtName" class="mui-ellipsis" style="margin-left: 0px;overflow: visible;"> <span>'+data.districtname;
		
		if(data.status != 0)
		{
			//已经投过标了，radio 选中，且不可修改；
			liContent += '</span> <input id="bidFlag" class="bid-flag" name="radio" value="Item 1" house-id="'+data.houseid+'" bid-status="'+data.status+'" type="radio" checked="checked" disabled="disabled"> </h4>';
		    ele.className += "house-bided";
		}
		else
		{
			//datastatus == 0
			//没有投过标，且匹配度小于51，radio 不选中，且不可修改；
			if(51 > parseInt(data.matchrate))
			{
				liContent += '</span> <input id="bidFlag" class="bid-flag" name="radio" value="Item 1" house-id="'+data.houseid+'" bid-status="'+data.status+'" type="radio" disabled="disabled"> </h4>';
				ele.className += "house-not-match";
			}
			else
			{
				liContent += '</span> <input id="bidFlag" class="bid-flag" name="radio" value="Item 1" house-id="'+data.houseid+'" bid-status="'+data.status+'" type="radio"> </h4>';
			}
		}
		
		//liContent += '<h4 id="districtName" class="mui-ellipsis" style="margin-left: 0px;overflow: visible;"> <span>'+data.districtname+'<span> <input id="bidFlag" class="bid-flag" name="radio" value="Item 1" house-id="'+data.houseid+'" type="radio"> </h4>';
		liContent += '<h5 style="margin-left: 0px;"> <span id="houseType">'+housetype+'</span> <span id="price" style="margin-left:10px;">'+data.expectsaleprice+'万</span> <span id="matchRate">匹配度:'+data.matchrate+'%</span> </h5>';
		//liContent += '<h5>面积:<span id="buildingArea">'+data.buildingarea+' 平米</span>  <span style="float:right;margin-right: 0px;">'+newupdatetime+'</span> </h5>	';
		
		liContent += '<h5>面积:<span id="buildingArea">'+data.buildingarea+' 平米</span> </h5>	';
		
		liContent += '</div>';
		liContent += '</div>';
		liContent += '</label>';
		
		ele.innerHTML = liContent;
		return ele;
	}
	
	
	
	
	//创建我的房源详情页中 已投标的需求列表li元素
	h.fillBidRequirementListLi = function(data) {
		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media";
		ele.id = "requirementid-" + data.id;
		
		console.log('date:'+data.biddate);
		var updatetime = data.biddate;
		var timearray = updatetime.split(" ");
		var newupdatetime=timearray[0];
		
		var subject = '求购'+data.subject;
		if(data.housetype != '5-10')
		{
			subject += data.housetype+'房';
		}
		
		var bidstatus = data.bidstatus;
		var statusstr = '';
		console.log('bidstatus:'+data.bidstatus);
		if(bidstatus == 1)
		{
			statusstr = '已投标';
		}
		else if(bidstatus == 2)
		{
			statusstr = '已中标';
		}
		else if(bidstatus == 3)
		{
			statusstr = '被拒绝';
		}
		
		var liContent = '';
		liContent += '<div id="requirementBrief" class="requirement-brief" publishuser-id="'+data.userid+'" requirement-id="'+data.requirementid+'">';
		liContent += '<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;float:left;">';
		liContent += '<img style="width:42px; height:42px; " src="'+data.userpicture+'" alt="个人头像" />';
		liContent += '</div>';
		liContent += '<div class="mui-media-body" style="padding-left: 10px;width=70%;float:left;">';
		liContent += '<div style="">';
		liContent += '<h4 class="mui-ellipsis requirement-user-nickname" style="margin-left: 0px;overflow: visible;">'+data.nickname+'</h4>';
		liContent += '<h5 class="requirement-subject" style="margin-left: 0px;">'+subject+'</h5>';
		liContent += '<h5><span>价格：'+data.price+'万</span> <span>佣金：'+data.agentfee+'元</span> </h5>';
		liContent += '<h5>状态：<span id="status">'+statusstr+' <span> <span class="publish-date" style="float:right;font-size:12px">'+newupdatetime+'<span></h5>';
		liContent += '</div>';

		liContent += '</div>';	
		liContent += '</div>';
		liContent += '<div id="eventInfo" class="event-info">';
		if(bidstatus == 2)
		{
			liContent += '<span id="sendMsgBnt" class="mui-icon iconfont icon-wx-b send-msg" requirement-publish-user-id="'+data.userid+'" requirement-publish-nickname="'+data.nickname+'"></span>';		
		}
		
		liContent += '</div>';	
		
		ele.innerHTML = liContent;
		return ele;
	}
	
	
})(window);
