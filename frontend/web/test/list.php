<body>  
<?php 
$interfaces=[
[
'name'=>'GetAdvertisement',
'url'=>'promotion/get-advertisement',
'params'=>'locationid'
],
[
'name'=>'GetRequirementList',
'url'=>'requirement/get-requirement-list',
'params'=>'region,housetype,start,count,pricestart,pricesend'
],
[
'name'=>'GetUserInfo',
'url'=>'user/get-user-info',
'params'=>'userid'
],
[
'name'=>'GetAdvertisementDetail',
'url'=>'promotion/get-advertisement-detail',
'params'=>'advertisementid'
],
[
'name'=>'AddRequirement',
'url'=>'requirement/add-requirement',
'params'=>'publishuserid,publishusertype,requirementtype,region1,region2,region3,districtid,districtname,budget,housetype,storey,buildingtype,detail,acceptagentflag,agentfee,dividerate,expectdividefee,dividefeedescribe'
],
[
'name'=>'ModifyUserInfo',
'url'=>'user/modify-user-info',
'params'=>'userid,nickname,phone,picture,email,sex,realname,identitycard,tags'
],
[
'name'=>'GetRequirementByuserid',
'url'=>'requirement/get-requirement-byuserid',
'params'=>'userid'
],
[
'name'=>'GetBidByRequirementid',
'url'=>'bid/get-bid-by-requirementid',
'params'=>'requirementid'
],
[
'name'=>'ModifyBidStatus',
'url'=>'bid/modify-bid-status',
'params'=>'bidid,oprtype'
],
[
'name'=>'GetFavoriteRequirement',
'url'=>'user/get-favorite-requirement',
'params'=>'userid'
],
[
'name'=>'DeleteFavoriteRequirement',
'url'=>'user/delete-favorite-requirement',
'params'=>'userid,requirementid'
],
[
'name'=>'SubmitAdvise',
'url'=>'user/submit-advise',
'params'=>'userid,advisetheme,advisedetail'
],
[
'name'=>'PublishHouse(这个测试接口不好用，找王欣鑫要java测试代码)',
'url'=>'user/publish-house',
'params'=>'userid,districtid,districtname,housenumber,roomnumber,buildingarea,expectsaleprice,storey,totalstorey,roomcnt,hallcnt,bathroomcnt,houseage,buildingtype,decorationtype,orientation,detail,schooldistrictflag,metroflag,owneronlyflag,overfiveonlyflag,picture'
],
[
'name'=>'AddFavoriteRequirement',
'url'=>'user/add-favorite-requirement',
'params'=>'userid,requirementid'
],
[
'name'=>'ModifyRequirement',
'url'=>'requirement/modify-requirement',
'params'=>'requirementid,publishuserid,publishusertype,requirementtype,region1,region2,region3,districtid,districtname,budget,housetype,storey,buildingtype,detail,acceptagentflag,agentfee,dividerate,expectdividefee,dividefeedescribe'
],
[
'name'=>'GetUserByOpenid',
'url'=>'user/get-user-by-openid',
'params'=>'openid'
],
[
'name'=>'Register',
'url'=>'login/register',
'params'=>'phone,passwd'
],
[
'name'=>'Login',
'url'=>'login/login',
'params'=>'phone,passwd'
],
[
'name'=>'GetVerificationCode',
'url'=>'login/get-verification-code',
'params'=>'phone'
],
[
'name'=>'VerifyVerificationCode',
'url'=>'login/verify-verification-code',
'params'=>'vcode,vcodeseq'
],
[
'name'=>'RegisterWeixin',
'url'=>'login/register-weixin',
'params'=>'nickname,phone,picture,password,confirmpasswd,email,sex,city,realname,agentflag,identitycard,expertflag,srcflag,wxopenid,wxunionid,tags'
],
[
'name'=>'ModifyHouse(这个测试接口不好用，找王欣鑫要java测试代码)',
'url'=>'user/modify-house',
'params'=>'houseid,userid,districtid,districtname,housenumber,roomnumber,buildingarea,expectsaleprice,storey,totalstorey,roomcnt,hallcnt,bathroomcnt,houseage,buildingtype,decorationtype,orientation,detail,schooldistrictflag,metroflag,owneronlyflag,overfiveonlyflag,picture'
],
[
'name'=>'GetMyHouse',
'url'=>'supplyment/get-my-house',
'params'=>'userid'
],
[
'name'=>'GetSpecificHouseBidInfo',
'url'=>'bid/get-specific-house-bid-info',
'params'=>'houseid'
],
[
'name'=>'GetHouseDetail',
'url'=>'supplyment/get-house-detail',
'params'=>'houseid'
],
[
'name'=>'GetAreaInfo',
'url'=>'area/get-area-info',
'params'=>'city'
],
[
'name'=>'GetMetroInfo',
'url'=>'area/get-metro-info',
'params'=>'city'
],
[
'name'=>'GetSchoolInfo',
'url'=>'area/get-school-info',
'params'=>'city'
],
[
'name'=>'DoBid(这个测试接口不好用，找王欣鑫要java测试代码)',
'url'=>'bid/do-bid',
'params'=>'requirementid, biduserid, houseids'
],
[
'name'=>'GetMatchHouseList',
'url'=>'supplyment/get-match-house-list',
'params'=>'requirementid,supplyuserid'
],
[
'name'=>'GetDistrictMatch',
'url'=>'area/get-district-match',
'params'=>'keys'
],
[
'name'=>'GetSearchHotKey',
'url'=>'user/get-search-hot-key',
'params'=>'keytype'
],
[
'name'=>'Search',
'url'=>'requirement/search',
'params'=>'key'
],
[
'name'=>'AddWxPic',
'url'=>'user/add-wx-pic',
'params'=>'type,userid,houseid,housepicsn,serverid,localid,url,status'
],
[
'name'=>'GetSystemRecommend',
'url'=>'user/get-system-recommend',
'params'=>'requirementid,start,count'
],
[
'name'=>'GetRequirementByDistrictid',
'url'=>'requirement/get-requirement-by-districtid',
'params'=>'districtid'
],
[
'name'=>'DelRequirementByRequirementid',
'url'=>'requirement/del-requirement-by-requirementid',
'params'=>'requirementid'
],
[
'name'=>'DelHouseByHouseid',
'url'=>'supplyment/del-house-by-houseid',
'params'=>'houseid'
],
[
'name'=>'AddReport',
'url'=>'report/add-report',
'params'=>'userid,nickname,reporttype,publishuserid,publishnickname,requirementid,houseid,reportdetail'
],
[
'name'=>'GetUserLimit',
'url'=>'user/get-user-limit',
'params'=>'userid'
],
[
'name'=>'UpdateRequirementTime',
'url'=>'requirement/update-requirement-time',
'params'=>'requirementid'
],
[
'name'=>'isFavoriteRequirement',
'url'=>'requirement/is-favorite-requirement',
'params'=>'userid,requirementid'
],
[
'name'=>'AddExpert',
'url'=>'expert/add-expert',
'params'=>'userid,name,organization,workperiod,position,email,activeregion,businesscard,headpicture,introduction,expertisen,onlinecharge,offlinetime,offlinecharge'
],
[
'name'=>'ModifyExpert',
'url'=>'expert/modify-expert',
'params'=>'expertid,userid,name,organization,workperiod,position,email,activeregion,businesscard,headpicture,introduction,expertisen,onlinecharge,offlinetime,offlinecharge'
],
[
'name'=>'GetExpert',
'url'=>'expert/get-expert',
'params'=>'id,userid'
],
[
'name'=>'GetExpertDetail',
'url'=>'expert/get-expert-detail',
'params'=>'id,userid'
],
[
'name'=>'GetExpertList',
'url'=>'expert/get-expert-list',
'params'=>'activeregion,domain,start,count'
],
[
'name'=>'GetAnswer',
'url'=>'answer/get-answer',
'params'=>'userid,expertid,start,count'
],
[
'name'=>'GetAnswerList',
'url'=>'answer/get-answer-list',
'params'=>'start,count'
],
[
'name'=>'ListenAnswer',
'url'=>'answer/listen-answer',
'params'=>'userid,questionuserid,questionexpertid,questionid'
],
[
'name'=>'ModifyPayQuestionOrderStatus',
'url'=>'answer/modify-pay-question-order-status',
'params'=>'userid,orderid,status'
],
[
'name'=>'ModifyListenCnt',
'url'=>'answer/modify-listen-cnt',
'params'=>'userid,questionid'
],
[
'name'=>'AskQuestionOnline',
'url'=>'answer/ask-question-online',
'params'=>'userid,questionsubject,questiondetail,expertid'
],
[
'name'=>'AppointmentOffline',
'url'=>'appointment/appointment-offline',
'params'=>'userid,appointmentsubject,expertid'
],
[
'name'=>'GetAppointment',
'url'=>'appointment/get-appointment',
'params'=>'userid,start,count'
],
[
'name'=>'GetAppointmentStatus',
'url'=>'appointment/get-appointment-status',
'params'=>'userid,orderid'
],
[
'name'=>'GetQuestionById',
'url'=>'answer/get-question-by-id',
'params'=>'userid,questionid'
],
[
'name'=>'DeleteAppointment',
'url'=>'appointment/delete-appointment',
'params'=>'userid,orderid'
],
[
'name'=>'GetAppointmentAsExpert',
'url'=>'appointment/get-appointment-as-expert',
'params'=>'expertid,start,count'
],
[
'name'=>'UpdateQuestionAnswer',
'url'=>'answer/update-question-answer',
'params'=>'expertid,questionid,answerid,answerfile'
],
[
'name'=>'ModifyOrderStatus',
'url'=>'appointment/modify-order-status',
'params'=>'expertid,orderid,status'
],
[
'name'=>'GetPayQuestion',
'url'=>'answer/get-pay-question',
'params'=>'userid,start,count'
],
[
'name'=>'GetComment',
'url'=>'comment/get-comment',
'params'=>'expertid,start,count'
],
[
'name'=>'AddComment',
'url'=>'comment/add-comment',
'params'=>'expertid,userid,comment,praisecnt'
],
[
'name'=>'DeleteComment',
'url'=>'comment/delete-comment',
'params'=>'expertid,commentids'
],
[
'name'=>'GetAppointmentDetail',
'url'=>'appointment/get-appointment-detail',
'params'=>'orderid'
],
[
'name'=>'AddAudio',
'url'=>'audio/add-audio',
'params'=>'questionid,expertid,serverid,localid,status,orderid'
],
[
'name'=>'GetAccount',
'url'=>'account/get-account',
'params'=>'userid,usertype'
],
[
'name'=>'GetAccountDetail',
'url'=>'account/get-account-detail',
'params'=>'userid,usertype,start,count'
],
[
'name'=>'ApplyDrawed',
'url'=>'account/apply-drawed',
'params'=>'userid,usertype,account'
],
[
'name'=>'PayUseZmzfangaccount',
'url'=>'account/pay-use-zmzfangaccount',
'params'=>'userid,usertype,servicetype,ordertype,orderid,fee,subject'
],
[
'name'=>'GetApplyDrawedList',
'url'=>'account/get-apply-drawed-list',
'params'=>'userid,usertype,start,count'
],
[
'name'=>'AudioLen',
'url'=>'audio/audio-len',
'params'=>'path'
],
[
'name'=>'AudioTest',
'url'=>'audio/audio-test',
'params'=>'orderid,expertid'
],
[
'name'=>'AddFavoriteExpert',
'url'=>'expert/add-favorite-expert',
'params'=>'userid,expertid'
],
[
'name'=>'GetFavoriteExpert',
'url'=>'expert/get-favorite-expert',
'params'=>'userid,start,count'
],
[
'name'=>'DeleteFavoriteExpert',
'url'=>'expert/delete-favorite-expert',
'params'=>'userid,expertid'
],
[
'name'=>'IsFavoriteExpert',
'url'=>'expert/is-favorite-expert',
'params'=>'userid,expertid'
],
[
'name'=>'TestTemplateMessage',
'url'=>'appointment/test-template-message',
'params'=>'type,userid,expertid,content,orderid,appointmenttype'
],
[
'name'=>'PushRequirement',
'url'=>'requirement/push-requirement',
'params'=>'requirementid'
],
[
'name'=>'PushSupplyment',
'url'=>'supplyment/push-supplyment',
'params'=>'supplymentid'
],
[
'name'=>'add_help',
'url'=>'for-help/add-help',
'params'=>'publishuserid,publishusertype,requirementtype,region,forhelpsubject,level,forhelpdetail,rewardflag,rewardfee'
],
[
'name'=>'modify_help',
'url'=>'for-help/modify-help',
'params'=>'helpid,region,forhelpsubject,level,forhelpdetail,rewardflag,rewardfee'
],[
'name'=>'get_help_list',
'url'=>'for-help/get-help-list',
'params'=>'region,start,count'
],[
'name'=>'get_help_list_by_userid',
'url'=>'for-help/get-help-list-by-userid',
'params'=>'userid,start,count'
],[
'name'=>'get_help_detail',
'url'=>'for-help/get-help-detail',
'params'=>'helpid'
],[
'name'=>'get_help_reply_list',
'url'=>'for-help/get-help-reply-list',
'params'=>'helpid'
],[
'name'=>'reply_help',
'url'=>'for-help/reply-help',
'params'=>'helpid,helpuserid,replyuserid,replydetail'
],[
'name'=>'add_help_reply_praise',
'url'=>'for-help/add-help-reply-praise',
'params'=>'replyid,userid'
],[
'name'=>'delete_help',
'url'=>'for-help/delete-help',
'params'=>'helpid,userid'
],[
'name'=>'accept_help_reply',
'url'=>'for-help/accept-help-reply',
'params'=>'helpid,userid,replyid,adoptuserid'
],[
'name'=>'add_rent',
'url'=>'rent/add-rent',
'params'=>'publishuserid,publishusertype,requirementtype,region1,region2,region3,districtid,districtname,budget,housetype,storey,buildingtype,detail'
],[
'name'=>'get_rent_list',
'url'=>'rent/get-rent-list',
'params'=>'region,pricerange,housetype,start,count'
],[
'name'=>'get_rent_list_by_userid',
'url'=>'rent/get-rent-list-by-userid',
'params'=>'userid,start,count'
],[
'name'=>'get_rent_detail',
'url'=>'rent/get-rent-detail',
'params'=>'rentid'
],[
'name'=>'update_rent',
'url'=>'rent/update-rent',
'params'=>'rentid,publishuserid,publishusertype,requirementtype,region1,region2,
region3,districtid,districtname,budget,housetype,storey,buildingtype,detail'
],[
'name'=>'delete_rent',
'url'=>'rent/delete-rent',
'params'=>'rentid,userid'
],[
'name'=>'get_bidinfo_by_rentid',
'url'=>'rent/get-bidinfo-by-rentid',
'params'=>'rentid'
],[
'name'=>'bid_rent',
'url'=>'rent/bid-rent',
'params'=>'rentid,publishuserid,biduserid'
],[
'name'=>'search_requirement',
'url'=>'search/search-requirement',
'params'=>'type,keys,start,count'
],[
'name'=>'searchRequirementIndex',
'url'=>'search/search-requirement-index',
'params'=>'start,reqirementCount,rentCount,helpCount'
],[
'name'=>'getBestReply',
'url'=>'for-help/get-best-reply',
'params'=>'helpid'
],[
'name'=>'get_agent_behaviour',
'url'=>'user/get-agent-behaviour',
'params'=>'userid'
],[
'name'=>'get_erweima',
'url'=>'tools/erweima',
'params'=>'url,pic'
],[
'name'=>'getNearColleague',
'url'=>'user/get-near-colleague',
'params'=>'userid'
],[
'name'=>'getWhoHaveSeenAgent',
'url'=>'user/get-who-have-seen-agent',
'params'=>'dstid,start,count'
],[
'name'=>'search-agent',
'url'=>'search/search-agent',
'params'=>'keys,start,count,type',
],[
'name'=>'get-search-params',
'url'=>'sql-config/get-search-params',
'params'=>'keytype',
],[
'name'=>'get-read-times',
'url'=>'topic/get-read-times',
'params'=>'id',
],[
'name'=>'reply-fee',
'url'=>'for-help/reply-fee',
'params'=>'helpid,adoptuserid',
],[
'name'=>'update-all-agent-data-completerate',
'url'=>'user/update-all-agent-data-completerate',
'params'=>'',
],[
'name'=>'add-recruit',
'url'=>'recruit/add-recruit',
'params'=>'publishuserid,usertype,publishusername,publishusertags,organization,headpic,organizationpic,position,recruitsubject,location,recruitcount,workperiod,recruitposition,education,salary,positiondetail,organizationinfo,expiretime',
],[
'name'=>'modify-recruit',
'url'=>'recruit/modify-recruit',
'params'=>'recruitid,publishuserid,usertype,publishusername,publishusertags,organization,headpic,organizationpic,recruitsubject,position,location,recruitcount,workperiod,recruitposition,education,salary,positiondetail,organizationinfo,expiretime',
],[
'name'=>'delete-recruit',
'url'=>'recruit/delete-recruit',
'params'=>'recruitid,userid',
],[
'name'=>'get-recruit-list',
'url'=>'recruit/get-recruit-list',
'params'=>'location,recruitposition,salary,workperiod,start,count',
],[
'name'=>'get-recruit-list-by-userid',
'url'=>'recruit/get-recruit-list-by-userid',
'params'=>'userid,start,count',
],[
'name'=>'get-my-recruit-list',
'url'=>'recruit/get-my-recruit-list',
'params'=>'userid,start,count',
],[
'name'=>'get-recruit-detail',
'url'=>'recruit/get-recruit-detail',
'params'=>'recruitid,publishuserid',
],[
'name'=>'add-resume',
'url'=>'resume/add-resume',
'params'=>'userid,usertype,userheadpic,realname,organization,city,workperiod,homecity,age,phone,resumedetail,position',
],[
'name'=>'modify-resume',
'url'=>'resume/modify-resume',
'params'=>'resumeid,userid,usertype,userheadpic,realname,organization,city,workperiod,homecity,age,phone,resumedetail,position',
],[
'name'=>'delete-resume',
'url'=>'resume/delete-resume',
'params'=>'resumeid,userid',
],[
'name'=>'get-resume',
'url'=>'resume/get-resume',
'params'=>'resumeid,userid',
],[
'name'=>'add-resume-work',
'url'=>'resume-work/add-resume-work',
'params'=>'resumeid,userid,organization,position,begindate,enddate,workdetail',
],[
'name'=>'modify-resume-work',
'url'=>'resume-work/modify-resume-work',
'params'=>'workid,resumeid,userid,organization,position,begindate,enddate,workdetail',
],[
'name'=>'delete-resume-work',
'url'=>'resume-work/delete-resume-work',
'params'=>'workid,userid',
],[
'name'=>'get-resume-work',
'url'=>'resume-work/get-resume-work',
'params'=>'workid',
],[
'name'=>'get-resume-work-list',
'url'=>'resume-work/get-resume-work-list',
'params'=>'resumeid,userid',
],[
'name'=>'add-resume-edu',
'url'=>'resume-edu/add-resume-edu',
'params'=>'resumeid,userid,schoolinfo,major,education,begindate,enddate',
],[
'name'=>'modify-resume-edu',
'url'=>'resume-edu/modify-resume-edu',
'params'=>'eduid,resumeid,userid,schoolinfo,major,education,begindate,enddate',
],[
'name'=>'delete-resume-edu',
'url'=>'resume-edu/delete-resume-edu',
'params'=>'eduid,userid',
],[
'name'=>'get-resume-edu',
'url'=>'resume-edu/get-resume-edu',
'params'=>'eduid',
],[
'name'=>'get-resume-edu-list',
'url'=>'resume-edu/get-resume-edu-list',
'params'=>'resumeid,userid',
],[
'name'=>'get-resume-detail',
'url'=>'resume/get-resume-detail',
'params'=>'resumeid,userid',
],[
'name'=>'get-resume-list-by-recruitid',
'url'=>'resume/get-resume-list-by-recruitid',
'params'=>'userid,recruitid,start,count',
],[
'name'=>'add-delivery',
'url'=>'resume-delivery/add-delivery',
'params'=>'userid,resumeid,recruitid,recruituserid',
],[
'name'=>'modify-delivery',
'url'=>'resume-delivery/modify-delivery',
'params'=>'recruitid,recruituserid,deliveryid,status,result',
],[
'name'=>'is-delivery',
'url'=>'resume-delivery/is-delivery',
'params'=>'userid,recruitid',
],[
'name'=>'get-recruit-list-by-resumeid',
'url'=>'resume/get-recruit-list-by-resumeid',
'params'=>'userid,resumeid,start,count',
],[
'name'=>'get-recruit-list-by-recommend',
'url'=>'recruit/get-recruit-list-by-recommend',
'params'=>'userid,resumeid,start,count',
],[
'name'=>'add-favorite-position',
'url'=>'favorite-position/add-favorite-position',
'params'=>'userid,recruitid',
],[
'name'=>'get-favorite-position',
'url'=>'favorite-position/get-favorite-position',
'params'=>'userid,start,count',
],[
'name'=>'delete-favorite-position',
'url'=>'favorite-position/delete-favorite-position',
'params'=>'userid,recruitid',
],[
'name'=>'is-favorite-position',
'url'=>'favorite-position/is-favorite-position',
'params'=>'userid,recruitid',
],[
'name'=>'get-activity-list-by-userid',
'url'=>'activity/get-activity-list-by-userid',
'params'=>'userid,start,count',
],[
'name'=>'get-activity-detail',
'url'=>'activity/get-activity-detail',
'params'=>'activityid,publishuserid',
],[
'name'=>'actionAddActivityOrg',
'url'=>'activity/add-activity-org',
'params'=>'userid,organization,organizationpic,organizationdetail,organizationlocation,contactname,contactphone',],
[
'name'=>'actionModifyActivityOrg',
'url'=>'activity/modify-activity-org',
'params'=>'organizationid,userid,organization,organizationpic,organizationdetail,organizationlocation,contactname,contactphone',],
[
'name'=>'actionDeleteActivityOrg',
'url'=>'activity/delete-activity-org',
'params'=>'organizationid',],
[
'name'=>'actionGetActivityOrg',
'url'=>'activity/get-activity-org',
'params'=>'userid']
];
						
foreach($interfaces as $interface){
?>
<a href = "interfaces/simpleinterface.php?name=<?=$interface['name']?>&url=<?=$interface['url']?>&params=<?=$interface['params']?>" target = "frame2"><?=$interface['name']?></a><br/>
<?php 
}
?>

</body>  
