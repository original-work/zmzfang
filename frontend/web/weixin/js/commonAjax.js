//getInterfaceUrl
function getInterfaceUrl()
{
	var url = "http://www.zmzfang.com/index.php";
	var loginUser = JSON.parse(localStorage.getItem('zmzfangLoginUserInfo'));
	if(loginUser && loginUser.city)
	{
		url = getInterfaceUrlByCity(loginUser.city);
	}
	return url;
}

function getInterfaceUrlByCity(city)
{
	var url = "http://www.zmzfang.com/index.php";
	switch(city)
	{
		case '北京市':
			url = "http://www.zmzfang.com/index_0010.php";
			break;
		case '广州市':
			url = "http://www.zmzfang.com/index_0020.php";
			break;
		case '深圳市':
			url = "http://www.zmzfang.com/index_0755.php";
			break;
		case '杭州市':
			url = "http://www.zmzfang.com/index_0571.php";
			break;
		default:
			break;
	}
	
	return url;
}

//requirement
var addRequirementByCityUrl = getInterfaceUrl() + "?r=requirement/add-requirement";
var getRequirementDetailByCityUrl = getInterfaceUrl() + "?r=requirement&id=";
var deleteRequirementByCityUrl = getInterfaceUrl() + "?r=requirement/del-requirement-by-requirementid";
var modifyRequirementByCityUrl = getInterfaceUrl() + "?r=requirement/modify-requirement";
var getRequirementByUserIdByCityUrl = getInterfaceUrl() + "?r=requirement/get-requirement-byuserid";

//area
var getDistrictMatchByCityUrl = getInterfaceUrl() + "?r=area/get-district-match";

//rent by city
var addRentByCityUrl = getInterfaceUrl() + "?r=rent/add-rent";
var getRentListByUseridByCityUrl = getInterfaceUrl() + "?r=rent/get-rent-list-by-userid";



//rent
var baseUrl = "http://www.zmzfang.com/index.php?";

var addRentUrl = baseUrl + "r=rent/add-rent";
var getRentListUrl = baseUrl + "r=rent/get-rent-list";
var getRentListByUseridUrl = baseUrl + "r=rent/get-rent-list-by-userid";
var getRentDetailUrl = baseUrl + "r=rent/get-rent-detail";
var updateRentUrl = baseUrl + "r=rent/update-rent";
var deleteRentUrl = baseUrl + "r=rent/delete-rent";
var getBidinfoByRentidUrl = baseUrl + "r=rent/get-bidinfo-by-rentid";
var bidRentUrl = baseUrl + "r=rent/bid-rent";
var flushRentUrl = baseUrl + "r=rent/flush-rent-requirement";
var pushRentUrl = baseUrl + "r=rent/push-rent";


//help
var AddHelpUrl = baseUrl + "r=for-help/add-help";
var getHelpListByUseridUrl = baseUrl + "r=for-help/get-help-list-by-userid";
var pushHelpUrl = baseUrl + "r=for-help/push-help";

//house
var addHouseByCityUrl = getInterfaceUrl() + "?r=user/publish-house";
var getHouseDetailByCityUrl =  getInterfaceUrl() + "?r=supplyment/get-house-detail";
var deleteHouseByCityUrl = getInterfaceUrl() + "?r=supplyment/del-house-by-houseid";
var modifyHouseByCityUrl = getInterfaceUrl() + "?r=user/modify-house";
var getHouseListByCityUrl = getInterfaceUrl() + "?r=supplyment/get-my-house";

//search
var searchRequirementIndexUrl = baseUrl + "r=search/search-requirement-index";

//agent
var getColleagueUrl = baseUrl + "r=user/get-colleague";
var getCompetitorUrl = baseUrl + "r=user/get-competitor";

var getAgentDetailUrl = baseUrl + "r=user/get-agent-detail";
var getAgentExtraUrl = baseUrl + "r=user/get-agent-extra";

var modifyAgentUrl = baseUrl + "r=user/modify-agent";

//school
var getSchoolMatchUrl = 'http://www.zmzfang.com/index.php?r=area/get-school-match';


//resume
var addResumeBasicInfoUrl = baseUrl + "r=resume/add-resume";
var modifyResumeBasicInfoUrl = baseUrl + "r=resume/modify-resume";
var getResumeBasicInfoUrl = baseUrl + "r=resume/get-resume";
var getResumeBasicInfoByUserIdUrl = baseUrl + "r=resume/get-resume-by-user-id";
var deleteResumeBasicInfoUrl = baseUrl + "r=resume/delete-resume";
var getRecruitListByResumeidUrl = baseUrl + "r=resume/get-recruit-list-by-resumeid";
var getRecruitListByRecommendUrl = baseUrl + "r=recruit/get-recruit-list-by-recommend";
var getResumeListUnhandledUrl = baseUrl + "r=resume/get-resume-list-unhandled";
var getResumeListAllUrl = baseUrl + "r=resume/get-resume-list-all";

var addResumeWorkInfoUrl = baseUrl + "r=resume-work/add-resume-work";
var modifyResumeWorkInfoUrl = baseUrl + "r=resume-work/modify-resume-work";
var getResumeWorkInfoUrl = baseUrl + "r=resume-work/get-resume-work";
var getResumeWorkInfoListUrl = baseUrl + "r=resume-work/get-resume-work-list";
var deleteResumeWorkInfoUrl = baseUrl + "r=resume-work/delete-resume-work";

var addResumeEduInfoUrl = baseUrl + "r=resume-edu/add-resume-edu";
var modifyResumeEduInfoUrl = baseUrl + "r=resume-edu/modify-resume-edu";
var getResumeEduInfoUrl = baseUrl + "r=resume-edu/get-resume-edu";
var getResumeEduInfoListUrl = baseUrl + "r=resume-edu/get-resume-edu-list";
var deleteResumeEduInfoUrl = baseUrl + "r=resume-edu/delete-resume-edu";

var getFavoritePositionUrl = baseUrl + "r=favorite-position/get-favorite-position";

//recruit
var addRecruitUrl = baseUrl + "r=recruit/add-recruit";
var modifyRecruitUrl = baseUrl + "r=recruit/modify-recruit";
var getRecruitUrl = baseUrl + "r=recruit/get-recruit";
var getRecruitListUrl = baseUrl + "r=recruit/get-recruit-list";
var getRecruitListByUserIdUrl = baseUrl + "r=recruit/get-recruit-list-by-userid";
var getRecruitCountByUserIdUrl = baseUrl + "r=recruit/get-recruit-count-by-userid";
var getMyRecruitListUrl = baseUrl + "r=recruit/get-my-recruit-list";
var getRecruitDetailUrl = baseUrl + "r=recruit/get-recruit-detail";

var deleteRecruitUrl = baseUrl + "r=recruit/delete-recruit";

//position favorite
var addFavoritePositionUrl = baseUrl + "r=favorite-position/add-favorite-position";
var getFavoritePositionUrl = baseUrl + "r=favorite-position/get-favorite-position";
var deleteFavoritePositionUrl = baseUrl + "r=favorite-position/delete-favorite-position";
var isFavoritePositionUrl = baseUrl + "r=favorite-position/is-favorite-position";

//delivery
var addDeliveryUrl = baseUrl + "r=resume-delivery/add-delivery";
var getDeliveryUrl = baseUrl + "r=resume-delivery/get-delivery";
var isDeliveryUrl = baseUrl + "r=resume-delivery/is-delivery";
var modifyDeliveryUrl = baseUrl + "r=resume-delivery/modify-delivery";

//activity 活动相关
var addActivityUrl = baseUrl + "r=activity/add-activity";
var modifyActivityUrl = baseUrl + "r=activity/modify-activity";
var deleteActivityUrl = baseUrl + "r=activity/delete-activity";
var getActivityListUrl = baseUrl + "r=activity/get-activity-list";
var getActivityListByUseridUrl = baseUrl + "r=activity/get-activity-list-by-userid";
var getActivityDetailUrl = baseUrl + "r=activity/get-activity-detail";

//活动报名相关
var addActivityApplyUrl = baseUrl + "r=activity/add-activity-apply";
var deleteActivityApplyUrl = baseUrl + "r=activity/delete-activity-apply";
var getActivityListByApplyUseridUrl = baseUrl + "r=activity/get-activity-list-by-apply-userid";
var getApplyUserlistByActivityidUrl = baseUrl + "r=activity/get-apply-userlist-by-activityid";
var isActivityApplyUrl = baseUrl + "r=activity/is-activity-apply";

//活动收藏相关
var addFavoriteActivityUrl = baseUrl + "r=activity/add-favorite-activity";
var getFavoriteActivityUrl = baseUrl + "r=activity/get-favorite-activity";
var deleteFavoriteActivityUrl = baseUrl + "r=activity/delete-favorite-activity";
var isFavoriteActivityUrl = baseUrl + "r=activity/is-favorite-activity";

//活动评论相关
var getActivityCommentUrl = baseUrl + "r=activity/get-activity-comment";
var addActivityCommentUrl = baseUrl + "r=activity/add-activity-comment";
var deleteActivityCommentUrl = baseUrl + "r=activity/delete-activity-comment";

//活动组织相关
var getActivityOrgUrl = baseUrl + "r=activity/get-activity-org";
var addActivityOrgUrl = baseUrl + "r=activity/add-activity-org";
var modifyActivityOrgUrl = baseUrl + "r=activity/modify-activity-org";
var deleteActivityOrgUrl = baseUrl + "r=activity/delete-activity-org";


//转介相关
var addRequirementReferralUrl = baseUrl + "r=requirement/yd-set";
var getRequirementDetailReferralUrl = baseUrl + "r=requirement/yd-detail";
var deleteRequirementReferralUrl = baseUrl + "r=requirement/yd-delete";
var modifyRequirementReferralUrl = baseUrl + "r=requirement/yd-set";
var getRequirementReferralListByUseridUrl = baseUrl + "r=requirement/yd-get-list-by-userid";

var addHouseReferralUrl = baseUrl + "r=supplyment/yd-set";
var getHouseDetailReferralUrl = baseUrl + "r=supplyment/yd-detail";
var deleteHouseReferralUrl = baseUrl + "r=supplyment/yd-delete";
var modifyHouseReferralUrl = baseUrl + "r=supplyment/yd-set";
var getHouseReferralListByUseridUrl = baseUrl + "r=supplyment/yd-get-list-by-userid";

function sendCommonAjax(options,url,sucFun,failFun,bool)
{
	console.log('sendCommonAjax options:'+JSON.stringify(options));
	console.log('sendCommonAjax url:'+url);
	//console.log('sendCommonAjax sucFun:'+sucFun);
	//console.log('sendCommonAjax failFun:'+failFun);
	
	jQuery.ajax(url, {
		data: JSON.stringify(options),
		dataType: 'json', //服务器返回json格式数据
		type: bool?'get':'post', //HTTP请求类型
		timeout: 3000, //超时时间设置为10秒；
		async: false,
		success: function(data) {
			if(sucFun)
			{
				sucFun(data);
			}
			
		},
		error: function(xhr, type, errorThrown) {
			//addReportFailed(errorThrown);
			if(failFun)
			{
				failFun(errorThrown);
			}
			
		}
	});
}

(function(w) {
	w.ajax_to_server = function(url,options,sucFun,failFun,getflag) {
		if(getflag)
		{
			sendCommonAjax(options,url,sucFun,failFun,1);
		}
		else
		{
			sendCommonAjax(options,url,sucFun,failFun);
		}
		
	}
	
})(window);