(function(c) {
	c.getByteLen = function(val) 
	{
        var len = 0;
        for (var i = 0; i < val.length; i++) {
             var a = val.charAt(i);
             if (a.match(/[^\x00-\xff]/ig) != null) 
            {
                len += 2;
            }
            else
            {
                len += 1;
            }
        }
        return len;
    }
	
	c.isCardNo = function(card)  
	{  
	   // 身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X  
	   var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;  
	   if(reg.test(card) === false)  
	   {  
	       //alert("身份证输入不合法");  
	       return  false;  
	   }
	   return true;
	}
	
	c.isEmail = function(email)
	{
		//email 含有@
		var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
		if(!reg.test(email)) {
		    //alert("请输入有效的邮箱地址！");
		    return false;
		}
		return true;
		
	}
	
	c.getBidStatusStr = function(bidstatus)
    {
    	var statusStr = '无效状态';
    	switch(bidstatus)
    	{
    		case '0':
        		statusStr = '未投标';
        		break;
    		case '1':
    			statusStr = '已投标未处理';
        		break;
    		case '2':
    			statusStr = '已接受沟通中';
        		break;
    		case '3':
    			statusStr = '已拒绝';
        		break;
    		case '4':
    			statusStr = '未看中';
        		break;
    		default:
    			statusStr = '无效状态';
        		break;
    	}
    	return statusStr;
    }
    
    c.getDayStamp = function() {
		var now = new Date();
		//var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) + (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) + (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) + (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
		var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate());
		return timestamp;
	}
    
    c.formatStringyyyyMMddToTimeAgo = function(value){
    	var time = '很久以前';
		if(value && value.length == 14){
			var newTime = value.substring(0, 4) + "/" + value.substring(4, 6) + "/" + value.substring(6, 8) + ' '+value.substring(8, 10)+':'+value.substring(10, 12)+':'+value.substring(12, 14);
			//console.log('newTime1:'+ newTime);
			var date = new Date(newTime);
			//console.log('newTime2:'+ date.getTime());
			time = getTimeAgo(date.getTime());
			//console.log('time:'+time);
		}
		return time;
	}
    
    c.getTimeAgo = function(time){
		var timestamp = Date.parse(new Date());
	
		var timeago = (timestamp - time)/1000;
		// console.log(timeago);
		if (timeago < 20){
			return '刚刚';
		}
		if (timeago < 60){
			return timeago + '秒前';
		}
		if (timeago < 3600){
			return Math.floor(timeago/60) + '分钟前'
		}
		if (timeago < 86400){
			return Math.floor(timeago/3600) + '小时前'
		}
		if (timeago < 604800){
			return Math.floor(timeago/86400) + '天前'
		}
		if (timeago < 31536000){
			return Math.floor(timeago/604800) + '周前'
		}
	}
    
    c.sendSystemMsgToWildog = function(userid,content,template,category,callback)
    {
    	/*	
    	 * userid 被发送人id
    	 * content 发送内容
    	 * template 自定义template字段
    	 * category 系统通知分类
    	 * callback 回调
    	 */
    	var config = {
		  syncURL: "https://sickeeer.wilddogio.com"
		};
		wilddog.initializeApp(config);
    	var ref = wilddog.sync().ref();
    	var time = getTimeStamp();
    	//发送人的头像
    	var message = {};	
    	//模板消息内容
		message.content = content;
		message.template = template;
		message.type = "template";

    	var wilddogioRef = ref.child("system/"+category+"/" + userid +'/'+time);
		wilddogioRef.set(message);
		var childRef = ref.child('list/'+userid+'/'+category+'/');
		var unlook = 0;
		childRef.once('value', function(snapshot) 
		{
			if(snapshot.exists()){
				unlook = snapshot.val().unlook;
			}
					
		}).then(function(newRef){
			type = 
			//推送消息列表
			childRef.set({
				'time': time,
				'type':'text',
				'content':content,
				'unlook':unlook+1
			})
			.then(function(newRef){
				if(callback)
				{
				  callback();
				}
				console.info('push system list success.')
			})
			.catch(function(err){
				console.info('push system list failed', err.code, err);
			});
		}).catch(function(err){
			console.info('get system unlook failed , cannot push list', err.code, err);
		});
    }
    
    c.getTimeStamp = function() 
	{
		var now = new Date();
		var timestamp = now.getFullYear() + '' + ((now.getMonth() + 1) >= 10 ? "" + (now.getMonth() + 1) : "0" + (now.getMonth() + 1)) + (now.getDate() >= 10 ? now.getDate() : "0" + now.getDate()) + (now.getHours() >= 10 ? now.getHours() : "0" + now.getHours()) + (now.getMinutes() >= 10 ? now.getMinutes() : "0" + now.getMinutes()) + (now.getSeconds() >= 10 ? now.getSeconds() : "0" + now.getSeconds());
		return timestamp;
	}
	
	c.getQueryStrFromUrl = function(str) 
	{
		var urlString = String(window.document.location.href);
		var rs = new RegExp("(^|)" + str + "=([^&]*)(&|$)", "gi").exec(urlString), tmp;
		if (tmp = rs) {
		return tmp[2];
		}
		// parameter cannot be found
		return "";
	}
	
	c.getAgentFeeByPerson = function(data)
	{
		var price = parseInt(data);
//		if(!price)
//		{
//			return 0;
//		}
		
		if(price==0){
			$agfee= 500000 * 0.003;
		}
		else if(price==1000)
		{
			$agfee= 1000 * 10000 * 0.003;
		}
		else{
			$agfee=price*10000 * 0.003;
		}
		return $agfee;
	}
	
	c.getAgentFeeByAgent = function(data)
	{
		var price = parseInt(data);
//		if(!price)
//		{
//			return 0;
//		}
		
		if(price==0){
			$agfee= 500000 * 0.005;
		}
		else if(price==1000)
		{
			$agfee= 1000 * 10000 * 0.005;
		}
		else{
			$agfee=price*10000 * 0.005;
		}
		return $agfee;
	}
	
	c.getAreaText = function(data)
	{
		if(data.length == 6)
		{
			var r1 = data.substr(0,2);
			var r2 = data.substr(2,2);
			var r3 = data.substr(4,2);
		
			var result = getArea(r1,r2,r3);
			return result.father + result.text;
		}
		else
		{
			var cityno = data.substr(0,4);
			var r1 = data.substr(4,2);
			var r2 = data.substr(6,2);
			var r3 = data.substr(8,2);
			
			var result = getAreaByCityNo(cityno,r1,r2,r3);
			return result.father + result.text;
		}
		
	}

	c.getAreaTextOnly = function(data)
	{
		var r1 = data.substr(0,2);
		var r2 = data.substr(2,2);
		var r3 = data.substr(4,2);
		
		var result = getArea(r1,r2,r3);
		return result.text;
	}
	
	c.getArea = function(r1,r2,r3,type){
		
		r1 = pad(r1.toString(),2);
		r2 = pad(r2.toString(),2);
		r3 = pad(r3.toString(),2);
		$id = r1+r2+r3;
		var type = type ? type : 'name';
		if(r3 != "00"){
			type = 'name';
		}
		console.log(type);
		console.log($id);
		switch($id){
			case "110000":
			if(type=='list'){
				return areaData3[0]['children'];
			}else{
				return areaData3[0]['text'];
			}
			break;
			case "120000":
			if(type=='list'){
				return areaData3[1]['children'];
			}else{
				return areaData3[1]['text'];
			}
			break;
			case "130000":
			if(type=='list'){
				return areaData3[2]['children'];
			}else{
				return areaData3[2]['text'];
			}
			break;
		}
		// console.log(r1);
		switch (r1) {
			case "11":
			var $conf = areaData3[0]['children'];
			break;
			case "12":
			var $conf = areaData3[1]['children'];
			break;
			case "13":
			var $conf = areaData3[2]['children'];
			break;
		}
		// console.log(JSON.stringify($conf));
		var $father;
		for (var $i=0;$i<$conf.length;$i++) {
			if($id == $conf[$i]['value']){
				if(type == 'list'){
					return $conf[$i]['children'];
				}else{
					return $conf[$i]['text'];
				}
			}
			for (var $j=0;$j<$conf[$i]['children'].length;$j++) {
				if($id == $conf[$i]['children'][$j]['value']){
					$father = getArea(r1,r2,'00');
					console.log('father is '+$father);
					$conf[$i]['children'][$j]['father'] = $father;
					console.log("$conf[$i]['children'][$j] is "+JSON.stringify($conf[$i]['children'][$j]));
					return $conf[$i]['children'][$j];
				}
			}
		}
	}
	
	c.getAreaByCityNo = function(cityno,r1,r2,r3){
		
		r1 = pad(r1.toString(),2);
		r2 = pad(r2.toString(),2);
		r3 = pad(r3.toString(),2);
		$id = cityno+r1+r2+r3;
		
		console.log(type);
		console.log($id);
		
		var areaData = getAreaDataByCityNo(cityno);
		var type = "name";
		// console.log(r1);
		var $conf = areaData['children'];
		
		// console.log(JSON.stringify($conf));
		var $father;
		for (var $i=0;$i<$conf.length;$i++) {
			if($id == $conf[$i]['value']){
				if(type == 'list'){
					return $conf[$i]['children'];
				}else{
					return $conf[$i]['text'];
				}
			}
			for (var $j=0;$j<$conf[$i]['children'].length;$j++) {
				if($id == $conf[$i]['children'][$j]['value']){
					$father = getAreaByCityNo(cityno,r1,r2,'00');
					console.log('father is '+$father);
					$conf[$i]['children'][$j]['father'] = $father;
					console.log("$conf[$i]['children'][$j] is "+JSON.stringify($conf[$i]['children'][$j]));
					return $conf[$i]['children'][$j];
				}
			}
		}
	}
	
	
	//获取行政区域 主要是区县
	c.getDistrict  = function(regions,city)
	{
		var district = null;//所属区县
		if(city)
		{
			if('上海市' == city)
			{
				return getDistrictSh(regions);
			}
			else if('北京市' == city)
			{
				return getDistrictBj(regions);
			}
			else if('广州市' == city)
			{
				return getDistrictGz(regions);
			}
			else if('深圳市' == city)
			{
				return getDistrictSz(regions);
			}
			else if('杭州市' == city)
			{
				return getDistrictHz(regions);
			}
		}
		
		return district;
	}
	
	//获取上海 主要是区县
	c.getDistrictSh  = function(regions)
	{
		var district = null;//所属区县
		if(regions)
		{
			var head = regions.substr(0,4);
			switch(head)
			{
				case '1301':
					district = "青浦区";
					break;
				case '1302':
					district = "松江区";
					break;
				case '1303':
					district = "嘉定区";
					break;
				case '1304':
					district = "闵行区";
					break;
				case '1305':
					district = "宝山区";
					break;
				case '1306':
					district = "金山区";
					break;
				case '1307':
					district = "长宁区";
					break;
				case '1308':
					district = "普陀区";
					break;
				case '1309':
					district = "杨浦区";
					break;
				case '1310':
					district = "虹口区";
					break;
				case '1311':
					district = "黄浦区";
					break;
				case '1312':
					district = "静安区";
					break;
				case '1313':
					district = "奉贤区";
					break;
				case '1314':
					district = "徐汇区";
					break;
				case '1315':
					district = "闸北区";
					break;
				case '1316':
					district = "浦东新区";
					break;
				case '1317':
					district = "崇明县";
					break;
				default:
					break;
			}
			
		}
		
		return district;
	}
	
	//获取北京小区所属 区县
	c.getDistrictBj  = function(regions)
	{
		var district = null;//所属区县
		if(regions)
		{
			var head = regions.substr(0,4);
			switch(head)
			{
				case '1301':
					district = "朝阳";
					break;
				case '1302':
					district = "海淀";
					break;
				case '1303':
					district = "丰台";
					break;
				case '1304':
					district = "东城";
					break;
				case '1305':
					district = "西城";
					break;
				case '1306':
					district = "石景山";
					break;
				case '1307':
					district = "昌平";
					break;
				case '1308':
					district = "大兴";
					break;
				case '1309':
					district = "通州";
					break;
				case '1310':
					district = "顺义";
					break;
				case '1311':
					district = "房山";
					break;
				case '1312':
					district = "密云";
					break;
				case '1313':
					district = "门头沟";
					break;
				case '1314':
					district = "怀柔";
					break;
				case '1315':
					district = "延庆";
					break;
				case '1316':
					district = "平谷";
					break;
				case '1317':
					district = "燕郊";
					break;
				case '1318':
					district = "北京周边";
					break;
				default:
					break;
			}
			
		}
		
		return district;
	}
	
	c.getDistrictGz  = function(regions)
	{
		var district = null;//所属区县
		if(regions)
		{
			var head = regions.substr(0,4);
			switch(head)
			{
				case '1301':
					district = "天河";
					break;
				case '1302':
					district = "番禺";
					break;
				case '1303':
					district = "海珠";
					break;
				case '1304':
					district = "白云";
					break;
				case '1305':
					district = "越秀";
					break;
				case '1306':
					district = "花都";
					break;
				case '1307':
					district = "增城";
					break;
				case '1308':
					district = "荔湾";
					break;
				case '1309':
					district = "黄埔";
					break;
				case '1310':
					district = "南沙";
					break;
				case '1311':
					district = "从化";
					break;
				case '1312':
					district = "广州周边";
					break;
				default:
					break;
			}
			
		}
		
		return district;
	}
	
	c.getDistrictSz  = function(regions)
	{
		var district = null;//所属区县
		if(regions)
		{
			var head = regions.substr(0,4);
			switch(head)
			{
				case '1301':
					district = "宝安";
					break;
				case '1302':
					district = "龙岗";
					break;
				case '1303':
					district = "南山";
					break;
				case '1304':
					district = "福田";
					break;
				case '1305':
					district = "罗湖";
					break;
				case '1306':
					district = "盐田";
					break;
				case '1307':
					district = "龙华新区";
					break;
				case '1308':
					district = "光明新区";
					break;
				case '1309':
					district = "坪山新区";
					break;
				case '1310':
					district = "大鹏新区";
					break;
				case '1311':
					district = "惠州";
					break;
				case '1312':
					district = "东莞";
					break;
				case '1313':
					district = "深圳周边";
					break;
				default:
					break;
			}
			
		}
		
		return district;
	}
	
	//杭州
	c.getDistrictHz  = function(regions)
	{
		var district = null;//所属区县
		if(regions)
		{
			var head = regions.substr(0,4);
			switch(head)
			{
				case '1301':
					district = "西湖";
					break;
				case '1302':
					district = "江干";
					break;
				case '1303':
					district = "余杭";
					break;
				case '1304':
					district = "滨江";
					break;
				case '1305':
					district = "下城";
					break;
				case '1306':
					district = "上城";
					break;
				case '1307':
					district = "拱墅";
					break;
				case '1308':
					district = "萧山";
					break;
				case '1309':
					district = "富阳";
					break;
				case '1310':
					district = "临安";
					break;
				case '1311':
					district = "淳安";
					break;
				case '1312':
					district = "桐庐";
					break;
				case '1313':
					district = "建德";
					break;
				default:
					break;
			}
			
		}
		
		return district;
	}
	
	c.pad = function(num, n) {  
		    var len = num.toString().length;  
		    while(len < n) {  
		        num = "0" + num;  
		        len++;  
		    }  
		    return num; 
	}  
	
	c.initSelectElementByValue = function(id,value)
	{
		//console.log("initSelectElementByValue:id "+id+" value:"+value);
		var selectElement=byId(id);
    	for(var i=0;i<selectElement.options.length;i++)
    	{
    		//console.log('value:'+selectElement.options[i].value);
    		if(selectElement.options[i].value == value)
    		{
    		    selectElement.selectedIndex = i;
    		    break;
    		}
    	}
	}
			
	c.initSelectElementByText = function(id,text)
	{
		var selectElement=byId(id);
    	for(var i=0;i<selectElement.options.length;i++)
    	{
    		if(selectElement.options[i].text == text)
    		{
    		    selectElement.selectedIndex = i;
    		    break;
    		}
    	}
	}
			
	c.getSelectElementText = function(id)
	{
		var index = byId(id).selectedIndex;
		return byId(id).options[index].text;
	}
			
	c.getSelectElementValue = function(id)
	{
		var index = byId(id).selectedIndex;
		return byId(id).options[index].value;
	}
		
	c.initWxShareBackUrl = function()
	{
		var shareBackUrl = 'http://www.zmzfang.com/weixin/HomePage/index.html';
		//var user = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
		//console.log('info'+user.wxunionid);
		console.log('window.history.length:'+window.history.length);
		if(window.history.length <= 1){
			$('#isWechat').attr('href',shareBackUrl).removeClass('mui-action-back');
			// byId('follow').classList.remove("mui-hidden");
		}
	}
	
	c.hasNumber = function(str)
	{
		var reg = /^(?=.*\d.*\b)/;
		if(str)
		{
			return reg.test(str);
		}
		else
		{
			return false;
		}
	}
	
	c.hasSpecialChar = function(str)
	{
		var reg =  RegExp(/[(\ )(\~)(\!)(\@)(\#)(\$)(\%)(\^)(\&)(\*)(\()(\))(\-)(\_)(\+)(\=)(\[)(\])(\{)(\})(\|)(\\)(\;)(\:)(\')(\")(\,)(\.)(\/)(\<)(\>)(\?)(\)]+/);
		if(str)
		{
			return reg.test(str);
		}
		else
		{
			return false;
		}
	}
	c.getRandStr = function(n)
    {
        var strs = [0,1,2,3,4,5,6,7,8,9,'a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','r','R','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z'];
        var res = "";
		for(var i = 0; i < n ; i ++) {
            var id = Math.ceil(Math.random()*61);
            res += strs[id];
        }
        return res;
    }
	c.imgpath = function(e){
		if(e && e.trim()){
			return e;
		}else{
			return 'http://www.zmzfang.com/weixin/img/common.png'
		}
	}
})(window);