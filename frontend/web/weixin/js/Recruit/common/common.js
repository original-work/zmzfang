//创建通用的职位li
function NewCommonPositionLi(data)
{
	//data 结构参考
	/**{
	"id":1,
	"recruitid":10001
	"publishuserid":10145,
	"publishusertype":0,
	"publishusername":"chail",
	"publishusertags":"有为青年",
	"organization":"我爱我家",
	"headpic":"http://www.zmzfang.com/weixin/img/headpic/5505.jpg",
	"organizationpic":"http://www.zmzfang.com/weixin/img/headpic/5505.jpg",
	"position":"销售总监",
	"recruitsubject":"我爱我家招聘销售精英若干",
	"location":"上海",
	"recruitcount":"10",
	"workperiod":"1-3年",
	"recruitposition":"销售精英",
	"education":"高中以上",
	"salary":"5000起"}
	**/
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var organization = '';
	//console.log('data.organization:'+data.organization);
	//console.log('data.organization.length:'+data.organization.length);
	if(data.organization)
	{
		if(data.organization.length > 12)
		{
			organization = data.organization.substr(0,12);
		}
		else
		{
			organization = data.organization;
		}
		
	}
	var position = '';
	if(data.position)
	{
        position = data.position;
	}
	
	var headpic = data.headpic;
	var liContent = '';
	
//	liContent += '<li class="mui-table-view-cell mui-media">';
	liContent += '	<div id="positionBrief" class="position-brief" publishuser-id="'+data.publishuserid+'" position-id="'+data.recruitid+'">';
	liContent += '		<div class="left-div">';
	liContent += '			<img class="mui-media-object circle-img" src="'+headpic+'" alt="个人头像" />';
	liContent += '			<div id="bottomName">'+data.publishusername+'</div>';
	liContent += '		</div>';
	liContent += '		<div class="right-div">';
	liContent += '			<p id="positionSubject">'+data.recruitsubject+'</p>';
	liContent += '			<p><span id="workperiod">'+glb.workperiod[data.workperiod]+'</span></p>';
	liContent += '			<p><span id="location">'+data.location+'</span></p>';
	liContent += '			<p><span id="publishUserName">'+data.publishusername+'</span> <span id="publishUserPosition">'+position+'</span></p>';
	liContent += '		</div>';
	liContent += '		<p id="salary" style="">'+glb.salary[data.salary]+'</p>';
	liContent += '		<p id="publishUserOrganization" style="">'+organization+'</p>';
	liContent += '		<p id="workCity" style=""><svg class="icon" aria-hidden="true" style="font-size: 14px;"><use xlink:href="#icon-location"></use></svg>'+data.recruitworkcity+'</p>';

	liContent += '	</div>';
//	liContent += '</li>';
	ele.innerHTML = liContent;
	
	return ele;
}

//创建通用的工作经历li
function NewCommonWorkInfoLi(data,moidfyflag=true)
{
	//data 结构参考
	/**
	{"workid":"3","resumeid":"4","userid":"10145","organization":"我爱我家","position":"销售经理","begindate":"2011-05","enddate":"2013-05","workdetail":"答复卡计算楼栋房间暗室逢灯","createtime":"0000-00-00 00:00:00","updatetime":"0000-00-00 00:00:00","validflag":"1"}
	**/
	
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	
//	liContent += '<li class="mui-table-view-cell mui-media">';
	liContent += '	<div class="card">';
	liContent += '		<ul class="row">';
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p>';
	liContent += '					<span id="organization" style="color: #333;">'+data.organization+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p>';
	liContent += '					<span id="begindate" style="color: #333;">'+data.begindate+'</span>-';
	liContent += '					<span id="enddate" style="color: #333;">'+data.enddate+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p>';
	liContent += '					<span id="position" style="color: #333;">'+data.position+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
			
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p><span style="color:#999;">工作简介</span></p>';
	liContent += '				<p>';
	liContent += '					<span id="workdetail" style="color: #333;">'+data.workdetail+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
	liContent += '		</ul>';
	if(moidfyflag)
	{
		liContent += '		<p>';
		liContent += '			<span id="modifyWorkInfo" workid="'+data.workid+'" class="mui-icon mui-icon-compose" style="position:absolute;top:5px;right: 5px;"></span>';
		liContent += '		</p>';
	}
	
	liContent += '	</div>';
//	liContent += '</li>';
	ele.innerHTML = liContent;
	
	return ele;
}

//创建通用的教育经历li
function NewCommonEduInfoLi(data,moidfyflag=true)
{
	//data 结构参考
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
	
//	liContent += '<li class="mui-table-view-cell mui-media">';
	liContent += '	<div class="card">';
	liContent += '		<ul class="row">';
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p>';
	liContent += '					<span id="schoolinfo" style="color: #333;">'+data.schoolinfo+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p>';
	liContent += '					<span id="begindate" style="color: #333;">'+data.begindate+'</span>-';
	liContent += '					<span id="enddate" style="color: #333;">'+data.enddate+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p>';
	liContent += '					<span id="major" style="color: #333;">'+data.major+'</span>';
	liContent += '				</p>';
	liContent += '			</li>';
			
	liContent += '			<li class="col-xs-12">';
	liContent += '				<p><span style="color:#999;">学历</span> <span id="education" style="color: #333;">'+data.education+'</span> </p>';

	liContent += '			</li>';
	liContent += '		</ul>';
	if(moidfyflag)
	{
		liContent += '		<p>';
		liContent += '			<span id="modifyEduInfo" eduid="'+data.eduid+'" class="mui-icon mui-icon-compose" style="position:absolute;top:5px;right: 5px;"></span>';
		liContent += '		</p>';
	}
	
	liContent += '	</div>';
//	liContent += '</li>';
	ele.innerHTML = liContent;
	
	return ele;
}

function NewResumeInfoLi(data)
{
	//data 结构参考
	var ele = document.createElement("li");
	ele.className = "mui-table-view-cell mui-media";
	
	var liContent = '';
//	liContent += '<li class="mui-table-view-cell mui-media question-li">';
	liContent += '					<div class="agent-info" user-id="'+data.deliveryuserid+'">';
	liContent += '						<div style="width:62px; height:62px; border-radius:50%; overflow:hidden;float:left;margin-top:10px;">';
	liContent += '							<img style="width:62px; height:62px; " src="'+data.userheadpic+'" alt="个人头像">';
	liContent += '						</div>';
	liContent += '						<div class="mui-media-body resume-brief" style="padding-left:20px;" resume-id="'+data.resumeid+'" delivery-id="'+data.deliveryid+'" recruit-id="'+data.recruitid+'">';
	liContent += '							<h4 class="mui-ellipsis bid-user-nickname" style="margin-left: 0px;overflow: visible;">';
	liContent += '								<a href="../Mine/User.html?userId='+data.deliveryuserid+'">'+data.realname+'</a>';
	liContent += '							</h4>';
	liContent += '							<h5 class="" style="margin-right: 0px;">'+data.organization+'</h5>';
	liContent += '							<h5 class="" style="margin-right: 0px;">'+data.targetposition+'</h5>';
	liContent += '							<h5 class="" style="margin-right: 0px;">从业年限'+data.workperiod+'</h5>';
	liContent += '						</div>';
	if(data.recruitposition)
	{
		liContent += '						<p style="position:absolute;right:15px;top:15px;font-size:8px;">所投职位</p>';
		liContent += '						<p class="mui-badge mui-badge-danger" style="position:absolute;right:15px;top:35px;">'+data.recruitposition+'</p>';
	}
	
	liContent += '						<div style="clear:both">';
	liContent += '						</div>';
	liContent += '					</div>';
//	liContent += '				</li>';

	ele.innerHTML = liContent;
	return ele;
}

glb = {
	'workperiod':{
		'1-3':'1-3年','3-5':'3-5年','5-8':'5-8年','8-30':'8年以上','不限':'经验不限'
	},
	'salary':{
		'0-3000':'3k以下','3000-5000':'3k-5k','5000-8000':'5k-8k','8000-10000':'8k-10k','10000-15000' :'10k-15k','15000-20000':'15k-20k','20000-25000':'20k以上','面议':'面议'
	}

}