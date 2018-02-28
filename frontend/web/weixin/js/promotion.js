(function(p) {
	
	//获取广告列表成功后的处理方法，新建li元素
	p.getAdvertisementListSuccess = function(data)
	{
		var slider=document.getElementById('slider');
		var firstFrag = document.createDocumentFragment();
		firstFrag.appendChild(fillAdvertisementSliderGroup(data));
		firstFrag.appendChild(fillAdvertisementSliderIndicator(data));
		
		slider.innerHTML = "";
		slider.appendChild(firstFrag);
		
		var slider = mui("#slider");
			slider.slider({
				interval: 5000
			});
	}
	
	//获取广告列表成功后的处理方法，新建li元素
	p.getAdvertisementDetailSuccess = function(data)
	{
		var promotionDetail=document.getElementById('promotionDetail');
		var firstFrag = document.createDocumentFragment();
		
		for(var i in data)
		{
			firstFrag.appendChild(fillAdvertisementDetailDiv(data[i]));
		}
		
		promotionDetail.innerHTML = "";
		promotionDetail.appendChild(firstFrag);
		
	}
	
	
	//创建滑动广告slidergroup
	p.fillAdvertisementSliderGroup = function(data) {
		var ele = document.createElement("div");
		ele.className = "mui-slider-group mui-slider-loop";
		
		var liContent = '';
		console.log("data.length:"+data.length);
		for(var i in data)
		{
			var id=data[i].id;
			
			if(i == 0)
			{
				liContent += '<div class="mui-slider-item mui-slider-item-duplicate" promotion-id="'+data[i].id+'" sn="'+data[i].sn+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
				liContent += '<div class="mui-slider-item" promotion-id="'+data[i].id+'" sn="'+data[i].sn+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
			}
			else if(i == data.length-1)
			{
				liContent += '<div class="mui-slider-item" promotion-id="'+data[i].id+'" sn="'+data[i].sn+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
				liContent += '<div class="mui-slider-item mui-slider-item-duplicate" promotion-id="'+data[i].id+'" sn="'+data[i].sn+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
			}
			else
			{
				liContent += '<div class="mui-slider-item" promotion-id="'+data[i].id+'" sn="'+data[i].sn+'">';
				liContent += '<img src="'+data[i].picture+'">';
				liContent += '</div>';
			}
		}
		ele.innerHTML = liContent;
		return ele;
	}
	
    //创建滑动广告Indicator
	p.fillAdvertisementSliderIndicator = function(data) {
	    var ele = document.createElement("div");
		ele.className = "mui-slider-indicator";
			
		var liContent = '';
		console.log("data.length:"+data.length);
		for(var i in data)
		{
			var id=data[i].id;
			console.log('\n id:'+id);
			console.log('\n i:'+i);
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
	
	//创建广告详情图片元素
	p.fillAdvertisementDetailDiv = function(data) {
	    var ele = document.createElement("div");
		ele.className = "mui-slider-item";
		
		var liContent = '';
	    liContent += '<img src="'+data.picture+'" width="100%" height="100%">';
		 
		ele.innerHTML = liContent;
		return ele;
	}
	
})(window);