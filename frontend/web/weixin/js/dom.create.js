function getTimeAgo(time){
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
	}else{
		return '1年前';
	}
	
}
(function(dom) {
	//创建需求列表li元素
	dom.fillRequirementListLi = function(data) {
		// var ele = document.createElement("li");
		// ele.className = "mui-table-view-cell mui-media";
		// ele.id = "requirementid-" + data.id;
		var loginUserInfo = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));

		// console.log(data);
		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());

		var feeDom ='';

		var rate = data.dividerate.length >1?"分":"";
		if(data.agentfee>0){
			feeDom = '<p class="mui-badge mui-badge-danger" style="position:absolute;right:3px;top:38px;">'+rate+'佣&nbsp;'+data.agentfee+'</p>';
		}

		var subject = data.subject;
		
		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="requirementid-' + data.id+'">';
		liContent += '<div id="requirementBrief" class="requirement-brief" publishuser-id="'+data.publishuserid+'" requirement-id="'+data.id+'" city="'+data.city+'">';
		liContent += '<div style="width:42px; height:60px;position:relative;overflow:hidden;float:left;">';
		liContent += '<img class="mui-media-object circle-img" src="'+data.picture+'" alt="个人头像" />';
		liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
		liContent += '</div>';
		liContent += '<div style="margin-left: 50px;overflow:hidden;">';
		liContent += '<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+subject+'</p>';
		liContent += '<p><span>'+data.housetype+'室</span> - <span>'+data.budget+'万</span></p>';
		liContent += '<p style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;">'+data.detail+'</p>';
		liContent += '</div>';
		liContent += feeDom+'<p class="publish-date" style="position:absolute;right:3px;top:12px">'+time+'</p>';
		liContent += '</div><div class="flag bflag"></div></li>';

		// ele.innerHTML = liContent;
		return liContent;
	}
	
	//创建新首页中求购序曲li元素
	dom.fillNewRequirementListLi = function(data) {
		// var ele = document.createElement("li");
		// ele.className = "mui-table-view-cell mui-media";
		// ele.id = "requirementid-" + data.id;
		var loginUserInfo = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));

		// console.log(data);
		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());

		var feeDom ='';
		// if(loginUserInfo){
			// if(data.agentfee>0 && loginUserInfo.agentflag==1){
			// }
		// }

		var rate = data.dividerate.length >1?"分":"";
		if(data.agentfee>0){
			feeDom = '<p class="mui-badge mui-badge-danger" style="position:absolute;right:15px;top:62px;">'+rate+'佣&nbsp;'+data.agentfee+'</p>';
		}

		var subject = data.city + data.subject;
		
		var nickName = data.nickname;
//		if('1' === data.agentflag)
//		{
//			nickName = data.realname;
//		}

		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="requirementid-' + data.requirementid+'">';
			liContent += '<div>';
		liContent += '	<div style="width:42px; height:42px;position:relative;overflow:hidden;float:left;">';
		liContent += '		<img class="mui-media-object circle-img" src="'+imgpath(data.picture)+'" alt="个人头像">';
		liContent += '	</div>';
		liContent += '	<div style="margin-left: 50px;overflow:hidden;">';
		liContent += '		<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+nickName+'</p>';
		liContent += '		<p><span>发布一条求购信息</span></p>';
				
		liContent += '	</div>';
		liContent += '</div>';
		
		liContent += '<div id="requirementBrief" class="requirement-brief quote-brief" publishuser-id="'+data.publishuserid+'" city="'+data.city+'" requirement-id="'+data.requirementid+'">';
//		liContent += '<div style="width:42px; height:60px;position:relative;overflow:hidden;float:left;">';
//		liContent += '<img class="mui-media-object" src="'+data.picture+'" alt="个人头像" />';
//		liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
//		liContent += '</div>';
		liContent += '<div style="overflow:hidden;">';
		liContent += '<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+subject+'</p>';
		liContent += '<p><span>'+data.housetype+'室</span> - <span>'+data.budget+'万</span></p>';
		liContent += '<p style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;">'+data.detail+'</p>';
		liContent += '</div>';
		liContent += feeDom+'<p class="publish-date" style="position:absolute;right:3px;top:12px">'+time+'</p>';
		liContent += '</div><div class="flag bflag"></div></li>';

		// ele.innerHTML = liContent;
		return liContent;
	}
	
	//创建首页需求列表li元素
	dom.fillRequirementListLiForIndex = function(data) {
		// var ele = document.createElement("li");
		// ele.className = "mui-table-view-cell mui-media";
		// ele.id = "requirementid-" + data.id;

		var loginUserInfo = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));


		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = date.getTime();

		var subject = data.subject;

		var feeDom ='';
		// if(loginUserInfo){
			// if(data.agentfee>0 && loginUserInfo.agentflag==1){
				feeDom = '<span class="mui-badge mui-badge-danger" style="position:absolute;right:3px;top:38px;">佣&nbsp;'+data.agentfee+'</span>';
			// }
		// }
		
		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="requirementid-' + data.id+'">';
		liContent += '<div id="requirementBrief" class="requirement-brief" publishuser-id="'+data.publishuserid+'" requirement-id="'+data.id+'">';
		liContent += '<div style="width:42px; height:42px;overflow:hidden;float:left;margin-right:8px;">';
		liContent += '<img class="mui-media-object circle-img" src="'+data.picture+'" alt="个人头像" />';
		liContent += '</div>';
		liContent += '<div class="mui-media-body" style="padding-left: 10px;">';
		liContent += '<div style="float: left;">';
		liContent += '<p class="requirement-subject" style="margin-left: 0px;">'+subject+'</p>';
		liContent += '<h5><span>'+data.housetype+'室</span> - <span>'+data.budget+'万</span>'+feeDom+'</h5>';
		liContent += '</div>';
		liContent += '<div>';
		liContent += '<h5 class="publish-date" style="position:absolute;right:3px;">'+getTimeAgo(time)+'</h5>';
		liContent += '</div>';
		liContent += '</div>';
		liContent += '</div></li>';
		
		// ele.innerHTML = liContent;
		return liContent;
	}
	//创建我的需求列表li元素
	dom.fillMyRequirementListLi = function(data) {
		
		console.log(JSON.stringify(data));
		
		var userStr = localStorage.getItem('zmzfangLoginUserInfo');
		var user = JSON.parse(userStr);
		
		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media";
		ele.id = "requirementid-" + data.requirementid;
		
		console.log('date:'+data.publishdate);
		var updatetime = data.publishdate;
		var timearray=updatetime.split(" ");
		var newupdatetime=timearray[0];
		timearray=data.createdate.split(" ");
		var createtime=timearray[0];
		
		var subject = '求购' +data.city +data.subject + data.housetype + '室';
		
		var liContent = '';
		liContent += '<div >';
		liContent += '<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;float:left;">';
		liContent += '<img style="width:42px; height:42px; " src="'+user.picture+'" alt="个人头像" />';
		liContent += '</div>';
		liContent += '<div class="mui-media-body" style="padding-left: 10px;">';
		liContent += '<div id="requirementBrief" class="requirement-brief" requirement-id="'+data.requirementid+'" city="'+data.city+'" style="float: left;width: 70%;">';
		liContent += '<h5 class="requirement-subject" style="margin-left: 0px;">'+subject+'</h5>';
		liContent += '<h5><span>价格：'+data.price+'万</span> <span>'+data.bidcnt+'人感兴趣</span> </h5>';
		liContent += '<h5><span>发布时间：'+createtime+'</span></h5>';
		liContent += '<h5><span>最近更新时间：'+newupdatetime+'</span></h5>';
		
		liContent += '</div>';
		liContent += '<div style="width: 30%;float: right;">';
		/*
		liContent += '<h5 class="publish-date" style="float:left;font-size:12px">'+newupdatetime+'</h5>';	
		*/
		liContent += '<button id="flushRequirement" class="mui-btn mui-btn-block flush-requirement" type="button" requirement-id="'+data.requirementid+'">刷新</button>';
		liContent += '</div>';
		liContent += '</div>';
		liContent += '</div>';
		
		ele.innerHTML = liContent;
		return ele;
	}
	
	//创建个人信息页中，历史发布的需求列表li
	dom.fillHistoryRequirementListLi = function(data,userInfo) {
		
		//var str=localStorage.getItem("requirementPublishUserInfo");
	    //var userInfo=JSON.parse(str);
	    
	    var picture = userInfo.picture;
	    var nickname = userInfo.nickname;
	    
		console.log(JSON.stringify(data));
		
		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media";
		ele.id = "requirementid-" + data.requirementid;
		
		console.log('date:'+data.publishdate);
		var updatetime = data.publishdate;
		var timearray=updatetime.split(" ");
		var newupdatetime=timearray[0];
		
		var subject='求购';
		subject += data.subject;
		subject += data.housetype + '室';
		
		
		var liContent = '';
		liContent += '<div id="requirementBrief" class="requirement-brief" requirement-id="'+data.requirementid+'">';
		liContent += '<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;float:left;">';
		liContent += '<img style="width:42px; height:42px; " src="'+picture+'" alt="个人头像" />';
		liContent += '</div>';
		liContent += '<div class="mui-media-body" style="padding-left: 10px;">';
		liContent += '<div style="float: left;">';
		liContent += '<h4 class="mui-ellipsis requirement-user-nickname" style="margin-left: 0px;overflow: visible;">'+nickname+'</h4>';
		liContent += '<h5 class="requirement-subject" style="margin-left: 0px;">'+subject+'</h5>';
		liContent += '<h5><span>价格：'+data.price+'万</span>  </h5>';
		liContent += '</div>';
		liContent += '<div>';
		liContent += '<h5 class="publish-date" style="float:right;font-size:12px">'+newupdatetime+'</h5>';
		liContent += '</div>';
		liContent += '</div>';
		liContent += '</div>';
		
		ele.innerHTML = liContent;
		return ele;
	}
	
	
	//创建我的房源列表li元素
	dom.fillHouseListLi = function(data) {
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
	
	
	//创建投标简要信息li
	dom.fillBidBriefListLi = function(data) {
		var ele = document.createElement("li");
		ele.className = "mui-table-view-cell mui-media";
		ele.id = "requirementid-" + data.id;
		
		console.log('date:'+data.updatetime);
		var updatetime = data.updatetime;
		var timearray=updatetime.split(" ");
		var newupdatetime=timearray[0];
		
		var subject='求购';
		if(data.region1 != '')
		{
			console.log('region1:'+data.region1);
			subject += data.region2;
			subject += data.region3;
			subject += data.housetype;
		}
		else
		{
			subject += data.districtname;
			subject += data.housetype;
		}
		
		var liContent = '';
		liContent += '<div id="requirementBrief" class="requirement-brief" requirement-id="3">';
		liContent += '<div style="width:42px; height:42px; border-radius:50%; overflow:hidden;float:left;">';
		liContent += '<img style="width:42px; height:42px; " src="./img/shuijiao.jpg" alt="个人头像" />';
		liContent += '</div>';
		liContent += '<div class="mui-media-body" style="padding-left: 10px;">';
		liContent += '<div style="float: left;">';
		liContent += '<h4 class="mui-ellipsis requirement-user-nickname" style="margin-left: 0px;overflow: visible;">'+data.publishuserid+'</h4>';
		liContent += '<h5 class="requirement-subject" style="margin-left: 0px;">'+subject+'</h5>';
		liContent += '<h5><span>价格：'+data.budget+'万</span> <span>佣金：'+data.agentfee+'元</span> </h5>';
		liContent += '</div>';
		liContent += '<div>';
		liContent += '<h5 class="publish-date" style="float:right;font-size:12px">'+newupdatetime+'</h5>';
		liContent += '</div>';
		liContent += '</div>';
		liContent += '</div>';
		
		ele.innerHTML = liContent;
		return ele;
	}
	
	//创建需求列表li元素
	dom.fillRentRequirementListLi = function(data) {

		var loginUserInfo = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));

		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());

		var feeDom ='';
		
		var subject = data.subject;
		
		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="requirementid-' + data.id+'">';
		liContent += '<div id="requirementBrief" class="rent-requirement-brief" publishuser-id="'+data.publishuserid+'" requirement-id="'+data.id+'">';
		liContent += '<div style="width:42px; height:60px;position:relative;overflow:hidden;float:left;">';
		liContent += '<img class="mui-media-object circle-img" src="'+data.publishuserpicture+'" alt="个人头像" />';
		liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.publishusername+'</div>';
		liContent += '</div>';
		liContent += '<div style="margin-left: 50px;overflow:hidden;">';
		liContent += '<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+subject+'</p>';
		liContent += '<p><span>'+data.housetype+'室</span> - <span>'+data.budget+'</span>元/月</p>';
		liContent += '<p style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;">'+data.detail+'</p>';
		liContent += '</div>';
		liContent += feeDom+'<p class="publish-date" style="position:absolute;right:3px;top:12px">'+time+'</p>';
		liContent += '</div><div class="flag rflag"></div></li>';

		// ele.innerHTML = liContent;
		return liContent;
	}

	//创建新首页求租需求列表li元素
	dom.fillNewRentRequirementListLi = function(data) {

		var loginUserInfo = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));

		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());

		var feeDom ='';
		
		var subject = data.city + data.subject;
		var nickName = data.nickname;
//		if('1' === data.agentflag)
//		{
//			nickName = data.realname;
//		}
		
		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="requirementid-' + data.requirementid+'">';
		liContent += '<div>';
		liContent += '	<div style="width:42px; height:42px;position:relative;overflow:hidden;float:left;">';
		liContent += '		<img class="mui-media-object circle-img" src="'+imgpath(data.picture)+'" alt="个人头像">';
		liContent += '	</div>';
		liContent += '	<div style="margin-left: 50px;overflow:hidden;">';
		liContent += '		<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+nickName+'</p>';
		liContent += '		<p><span>发布一条求租信息</span></p>';
				
		liContent += '	</div>';
			
		liContent += '</div>';
		
		liContent += '<div id="requirementBrief" class="rent-requirement-brief quote-brief" publishuser-id="'+data.publishuserid+'" city="'+data.city+'" requirement-id="'+data.requirementid+'">';
//		liContent += '<div style="width:42px; height:60px;position:relative;overflow:hidden;float:left;">';
//		liContent += '<img class="mui-media-object" src="'+data.publishuserpicture+'" alt="个人头像" />';
//		liContent += '<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.publishusername+'</div>';
//		liContent += '</div>';
		liContent += '<div style="overflow:hidden;">';
		liContent += '<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+subject+'</p>';
		liContent += '<p><span>'+data.housetype+'室</span> - <span>'+data.budget+'</span>元/月</p>';
		liContent += '<p style="text-overflow: ellipsis;white-space:nowrap;overflow:hidden;">'+data.detail+'</p>';
		liContent += '</div>';
		liContent += feeDom+'<p class="publish-date" style="position:absolute;right:3px;top:12px">'+time+'</p>';
		liContent += '</div><div class="flag rflag"></div></li>';

		// ele.innerHTML = liContent;
		return liContent;
	}

	//创建求助列表li元素
	dom.fillHelpListLi = function(data) {
		console.log(data);
		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());
		var subject = data.subject;
		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="helpid-' + data.helpid+'">';
		liContent += 	'<div id="helpBrief" class="help-brief" contactor="'+data.nickname+'" help-id="'+data.helpid+'">';
		liContent += 		'<div style="width:42px; height:60px; position:relative; overflow:hidden;float:left;">';
		liContent += 			'<img class="mui-media-object circle-img" src="'+data.picture+'" alt="个人头像">';
		liContent += 			'<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
		liContent += 		'</div>';
		reward = parseInt(data.rewardfee)?'<span>悬赏</span> - <span>红包'+data.rewardfee+'元</span>':'<span>求助</span>';
		liContent += 		'<div style="margin-left:50px;overflow:hidden;">';
		liContent += 			'<p style="margin-left: 0px;color:#000;">'+reward+'</p>';
		liContent += 			'<p><span>求助</span> - <span>'+data.forhelpsubject+'</span></p>';
		liContent += 			'<p class="publish-date"  style="position:absolute;right:3px;top:12px">'+time+'</p>';
		liContent += 			'<p class="reply-times" style="position:absolute;right:3px;top:38px;">'+data.replycnt+'条回复</p>';
		liContent += 		'</div>';			
		liContent += 	'</div><div class="flag hflag"></div>';
		liContent += '</li>';
						
		return liContent;
	}

	//创建新首页求助列表li元素
	dom.fillNewHelpListLi = function(data) {
		// console.log(data);
		var updatetime = data.updatetime;
		updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(updatetime);
		var time = getTimeAgo(date.getTime());
		var subject = data.subject;
		var nickName = data.nickname;
//		if('1' === data.agentflag)
//		{
//			nickName = data.realname;
//		}
		
		var liContent = '';
		liContent += '<li class="mui-table-view-cell mui-media" id="helpid-' + data.helpid+'">';
		
		liContent += '<div>';
		liContent += '	<div style="width:42px; height:42px;position:relative;overflow:hidden;float:left;">';
		liContent += '		<img class="mui-media-object circle-img" src="'+imgpath(data.picture)+'" alt="个人头像">';
		liContent += '	</div>';
		liContent += '	<div style="margin-left: 50px;overflow:hidden;">';
		liContent += '		<p class="requirement-subject" style="margin-left: 0px;color:#000;">'+nickName+'</p>';
		liContent += '		<p><span>发布一条求助信息</span></p>';
				
		liContent += '	</div>';
			
		liContent += '</div>';
							
		liContent += 	'<div id="helpBrief" class="help-brief quote-brief" contactor="'+data.nickname+'" help-id="'+data.helpid+'">';
//		liContent += 		'<div style="width:42px; height:60px; position:relative; overflow:hidden;float:left;">';
//		liContent += 			'<img class="mui-media-object" src="'+data.picture+'" alt="个人头像">';
//		liContent += 			'<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
//		liContent += 		'</div>';
		reward = parseInt(data.rewardfee)?'<span>悬赏</span> - <span>红包'+data.rewardfee+'元</span>':'<span>求助信息：</span>';
		liContent += 		'<div style="overflow:hidden;">';
		liContent += 			'<p style="margin-left: 0px;color:#000;">'+reward+'</p>';
		liContent += 			'<p><span>'+data.forhelpsubject+'</span></p>';
		liContent += 			'<p class="publish-date"  style="position:absolute;right:3px;top:12px">'+time+'</p>';
		liContent += 			'<p class="reply-times" style="position:absolute;right:15px;top:62px;">'+data.replycnt+'条回复</p>';
		liContent += 		'</div>';			
		liContent += 	'</div><div class="flag hflag"></div>';
		liContent += '</li>';
						
		return liContent;
	}



	//创建最佳回答li元素
	dom.fillBestReplyLi = function(data) {
		console.log(data);
		var updatetime = data.updatetime;
		if(updatetime == '刚刚'){
			var time = '刚刚' 
		}else{
			updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
			var date = new Date(updatetime);
			var time = getTimeAgo(date.getTime());
		}

		var subject = data.subject;
		var liContent = '';

		liContent += 	'<li id="sss" class="col-xs-12">';
		liContent +=        '<div style="padding-bottom:15px">';
		liContent +=    		'<div style="width:40px; height:60px;overflow:hidden;position:absolute;margin-left:10px">';
		liContent += 				'<img id="answer" class="content" userId='+data.replyuserid+' agentFlag='+data.agentflag+' style="width:40px; height:40px; border-radius:100%;" src="'+data.picture+'" alt="个人头像">';
		liContent += 				'<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
		liContent += 			'</div>';
		liContent += 			'<div class="user-info-content" style="float:left;margin-left: 70px;padding: 8px 10px;">';
		liContent += 				'<p style="">'+data.replydetail+'</p>';
		liContent +=			'</div><div style="clear:both"></div>';
		liContent += 		'</div>';
		liContent += 		'<div class="mui-card-footer" style="border-bottom:1px solid #ddd;"><a class="mui-card-link">'+time+'</a>'
		liContent +=			'<a class="mui-card-link zan" replyid="'+data.replyid+'"><svg class="icon" aria-hidden="true" style="padding-bottom: 1px"><use xlink:href="#icon-zan"></use></svg><span>'+data.praisecnt+'</span></a>'
		liContent +=			'<a class="mui-card-link cai" replyid="'+data.replyid+'"><svg class="icon" aria-hidden="true" padding-top: 1px><use xlink:href="#icon-cai"></use></svg><span>'+data.negativecnt+'</span></a>'
		liContent += 		'</div>';
		liContent += 	'</li>';

		return liContent;
	}

	//选取最佳回答li元素
	dom.fillGetBestReplyLi = function(data) {
		console.log(data);
		var updatetime = data.updatetime;
		if(updatetime == '刚刚'){
			var time = '刚刚' 
		}else{
			updatetime = updatetime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
			var date = new Date(updatetime);
			var time = getTimeAgo(date.getTime());
		}

		var subject = data.subject;
		var liContent = '';

		liContent += 	'<li class="col-xs-12">';
		liContent +=        '<div style="padding-bottom:15px">';
		liContent +=    		'<div style="width:40px; height:60px;overflow:hidden;position:absolute;margin-left:10px">';
		liContent += 				'<img style="width:40px; height:40px; border-radius:100%;" src="'+data.picture+'" alt="个人头像">';
		liContent += 				'<div style="text-overflow: ellipsis;white-space: nowrap;text-align:center;margin-top:-4px;font-size:.5rem;overflow: hidden;">'+data.nickname+'</div>';
		liContent += 			'</div>';
		liContent += 			'<div class="user-info-content" style="float:left;margin-left: 70px;padding: 8px 10px;">';
		liContent += 				'<p style="">'+data.replydetail+'</p>';
		liContent +=			'</div><div style="clear:both"></div>';
		liContent += 		'</div>';
		liContent += 		'<div class="mui-card-footer" style="border-bottom:1px solid #ddd;"><a class="mui-card-link">'+time+'</a>'
		liContent +=			'<a class="mui-card-link good" replyid="'+data.replyid+'" replyuserid="'+data.replyuserid+'">采纳为最佳答案</a>'
		liContent += 		'</div>';
		liContent += 	'</li>';

		return liContent;
	}

	//创建经纪人动态列表li元素
	dom.fillBehaviourListLi = function(data) {
		console.log(data);
		var createtime = data.createtime;
		createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(createtime);
		var time = getTimeAgo(date.getTime());
		var beh = '';
		console.log('data.type is '+data.type);
		switch(data.type){
			case '10':
				beh='评级变化';
				break;
			case '20':
				beh='发布一个动态';
				break;
			case '30':
				beh='发布一个房源';
				break;
			case '31':
				beh='更新一个房源';
				break;
			case '32':
				beh='联系一个房源';
				break;
			case '33':
				beh='查看一个房源';
				break;
			case '40':
				beh='发布一个求购需求';
				break;
			case '41':
				beh='更新一个求购需求';
				break;
			case '42':
				beh='联系一个求购需求';
				break;
			case '43':
				beh='查看一个求购需求';
				break;
			case '50':
				beh='发布一个求租需求';
				break;
			case '51':
				beh='更新一个求租需求';
				break;
			case '52':
				beh='联系一个求租需求';
				break;
			case '53':
				beh='查看一个求租需求';
				break;
			case '60':
				beh='发布一个求助需求';
				break;
			case '61':
				beh='更新一个求助需求';
				break;
			case '62':
				beh='回复一个求助信息';
				break;
			case '63':
				beh='查看一个求助需求';
				break;
			case '70':
				beh='注册用户';
				break;
			case '71':
				beh='更新用户信息';
				break;
			case '73':
				beh='查看其他用户信息';
				break;
			case '80':
				beh='联系用户';
				break;
		}

		var liContent = '';
		liContent += '<div>';
		liContent += 	'<p class="big">';
		liContent += 		'<span>'+beh+'</span>';
		liContent += 		'<span class="mui-pull-right">'+time+'</span>';
		liContent += 	'</p>';
		liContent += '</div>';
						
		return liContent;
	}

	dom.fillWhoHaveSeenAgentLi = function(data) {
		console.log(data);
		var createtime = data.updatetime;
		createtime = createtime.replace(/-/g,'/'); // 将-替换成/，因为下面这个构造函数只支持/分隔的日期字符串
		var date = new Date(createtime);
		var time = getTimeAgo(date.getTime());
		var organization = data.organization?data.organization:'未知公司';
		var position = data.position?data.position:'未知职位';
		var liContent = '';
		liContent += 	'<li class="mui-table-view-cell" user-id="'+data.userid+'" agent-flag="'+data.agentflag+'" id="follow-user">';
		liContent +=	'<div class="mydiv" style="top:10px; float:left; width:42px; height:42px; border-radius:50%; overflow:hidden;margin-left: auto;margin-right: auto;margin-top:0px;">';
		liContent +=	'<img id="headPic" width="42px" height="42px" style="margin-right: 10px; " src="'+data.picture+'" alt="个人头像" />';
		liContent +=	'</div>';
		liContent +=	'<div style="float:left; margin-left:10px;">';
		liContent +=	'<p>';
		liContent +=	'<span id="nickname">'+data.nickname+'</span>';
		liContent +=    '<p class="publish-date" style="position:absolute;right:3px;top:12px">'+time+'</p>';
		// liContent +=	'<span id="Authenticate" class="mui-hidden">';
		// liContent +=	'<svg class="icon" aria-hidden="true">';
		// liContent +=	'<use xlink:href="#xicon-renzheng"></use>';
		// liContent +=	'</svg>';
		// liContent +=	'</span>';
		liContent +=	'</p>';
		liContent +=	'<p>';
		if(data.agentflag == 1)
		{
			liContent +=	'<span id="company">'+organization+'</span>';
			liContent +=	'<span id="position">'+position+'</span>';
		}
		else
		{
			liContent +=	'<span id="position">个人用户</span>';
		}
		
		liContent +=	'</p>';
		liContent +=	'</div>';
		liContent +=	'<p class="publish-date" style="position:absolute;right:3px;bottom:12px"></p>';
		liContent +=	'</li>';
		return liContent;
	}

})(window);