function NewCommonActivityLi(data)
{
	
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	/**
	 * 
	 {"activityid":"1","publishuserid":"10145","publishusertype":"1","publishusername":"柴磊","publishusertags":"无","organization":"我爱我家","headpic":"http://www.zmzfang.com/weixin/img/headpic/201706141742429470.jpg","organizationpic":"http://www.zmzfang.com/assets/topic/170618102457.jpg","position":"销售总监","activitysubject":"上海房地产行情分析","activitytype":"1","activitypic":"http://www.zmzfang.com/assets/topic/170618102457.jpg","begintime":"2017-06-18 13:22:35","endtime":"2017-06-18 13:22:40","activitycity":"上海市","location":"张江路001号","personcount":"10-20","activitydetail":"上海市房地长市场交流","createtime":"2017-06-18 13:23:31","updatetime":"2017-06-18 13:23:34","validflag":"1"}
	 */
//	var position = null;
//	if(data.organization && data.position)
//	{
//		position = data.organization + data.position;
//	}
	var count = data.personcount == 0 ? "不限":data.personcount+'人';
	var liContent = '';
	
	liContent += '<div id="activityBrief" class="activity-brief" publishuser-id="'+data.publishuserid+'" activity-id="'+data.activityid+'">';
	liContent += '	<div class="left-div">';
	liContent += '		<img id="activityPic" class="mui-media-object" src="'+data.activitypic+'" alt="活动背景头像" />';
	liContent += '	</div>';
	liContent += '	<div class="right-div">';
	liContent += '		<p>主题：<span id="activitySubject">'+data.activitysubject+'</span></p>';
	liContent += '		<p>发布人：<span id="publishUserName">'+data.publishusername+'</span></p>';
	if(data.organization)
	{
		liContent += '		<p>主办方：<span id="organizationName">'+data.organization+'</span></p>';
	}
	liContent += '		<p>时间：<span id="activityDate">'+data.begintime.substring(0,10)+'</span></p>';
	liContent += '		<p>人数：<span id="personCnt">'+count+'</span></p>';
	liContent += '	</div>';
		
	liContent += '</div>';

	ele.innerHTML = liContent;
	
	return ele;
}

function NewBigPicActivityLi(data)
{
	
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var count = data.personcount == 0 ? "不限":data.personcount+'人';
	var subject = data.activitysubject.length > 10?data.activitysubject.substr(0,10)+'...':data.activitysubject;
	 
	var liContent = '';
	
	liContent += '	<div id="activityBrief" class="activity-brief" publishuser-id="'+data.publishuserid+'" activity-id="'+data.activityid+'">';
	liContent += '		<div>';
	liContent += '			<img id="activityPic1" style="height: 140px; width:100%" src="'+data.activitypic+'" alt="活动背景头像" />';
	liContent += '		</div>';
	liContent += '		<div style="position: relative;">';
	liContent += '			<p>主题：<span id="activitySubject">'+subject+'</span></p>';
	liContent += '			<p style="position:absolute;top:0px;right: 10px;">参与人数：<span id="personCnt">'+count+'</span></p>';
	liContent += '		</div>';
			
	liContent += '	</div>';

	ele.innerHTML = liContent;
	
	return ele;
}
