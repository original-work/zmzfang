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

var baseUrl = getInterfaceUrl()+"?r=requirement/";
var baseUserUrl = getInterfaceUrl()+"?r=user/";
var basePromotionUrl = getInterfaceUrl()+"?r=promotion/";
var baseHouseUrl = getInterfaceUrl()+"?r=user/";
var baseBidUrl = getInterfaceUrl()+"?r=bid/";
var baseLoginUrl = getInterfaceUrl()+"?r=login/";
var baseAreaUrl = getInterfaceUrl()+"?r=area/";
var baseHelpUrl = getInterfaceUrl()+"?r=for-help/";
var baseToolsUrl = getInterfaceUrl()+"?r=tools/";
var baseRecruitUrl = getInterfaceUrl()+"?r=recruit/";


var addRecruitUrl = baseRecruitUrl + "add-recruit";
var getMyRecruitListUrl = baseRecruitUrl + "get-my-recruit-list";
var getRecruitDetailUrl = baseRecruitUrl + "get-recruit-detail";
var erweimaUrl = baseToolsUrl + "erweima";
var getAgentBehaviourUrl = baseUserUrl + "get-agent-behaviour";
var getNearColleagueUrl = baseUserUrl + "get-near-colleague";
var getWhoHaveSeenAgentUrl = baseUserUrl + "get-who-have-seen-agent";
var getWhoHaveSeenAgentTodayUrl = baseUserUrl + "get-who-have-seen-agent-today";

//report
var addReportUrl = baseUserUrl + "add-report";
//login
var getVerriCodeUrl = baseLoginUrl + "get-verification-code";
var verifyverificationCodeUrl = baseLoginUrl + "verify-verification-code";
var registerWeixinUrl = baseLoginUrl + "register-weixin";

//requirement
var getRequirementDetailUrl = getInterfaceUrl()+"?r=requirement&id=";
var addRequirementUrl = baseUrl + "add-requirement";
var modifyRequirementUrl = baseUrl + "modify-requirement";

var getRequirementListUrl = baseUrl + "get-requirement-list";
var getRequirementByUserIdUrl = baseUrl + "get-requirement-byuserid";
var getPublishHistoryUrl = baseUrl + "get-requirement-byuserid";

var deleteRequirementUrl = baseUrl + "del-requirement-by-requirementid";
var flushRequirementUrl = baseUrl + "update-requirement-time";
var pushRequirementUrl = baseUrl + 'push-requirement';


//house
var addHouseUrl = baseHouseUrl + "publish-house";
var modifyHouseUrl = baseHouseUrl + "modify-house";
var getHouseListUrl = getInterfaceUrl()+"?r=supplyment/get-my-house";
var getHouseDetailUrl =  getInterfaceUrl()+"?r=supplyment/get-house-detail";
var deleteHouseUrl = getInterfaceUrl()+"?r=supplyment/del-house-by-houseid";
var pushSupplymentUrl = getInterfaceUrl()+"?r=supplyment/push-supplyment";

//bid
var getBidByRequiementIdUrl = baseBidUrl + "get-bid-by-requirementid";
var getBidByHouseIdUrl = baseBidUrl + "get-bid-by-houseid";
var bidUrl = baseBidUrl + 'do-bid';
var getSpecificHouseBidUrl = baseBidUrl + 'get-specific-house-bid-info';
var getHouselistMatchRequirementUrl = getInterfaceUrl()+"?r=supplyment/get-match-house-list";
var modifyBidStatusUrl = baseBidUrl + "modify-bid-status";
//mine
var getFavoriteRequirementUrl = baseUserUrl + "get-favorite-requirement";
var addFavoriteRequirementUrl = baseUserUrl + "add-favorite-requirement";
var isFavoriteRequirementUrl = baseUrl + "is-favorite-requirement";
var deleteFavoriteRequirementUrl = baseUserUrl + "delete-favorite-requirement";
var getUserByOpenidUrl = baseUserUrl + "get-user-by-openid";
var moidfyUserInfoUrl = baseUserUrl + "modify-user-info";
var getSystemRecommendUrl = baseUserUrl + "get-system-recommend";

var submitAdviceUrl = baseUserUrl + "submit-advise";
var getAdvertisementListUrl = basePromotionUrl + "get-advertisement";
var getAdvertisementDetailUrl = basePromotionUrl + "get-advertisement-detail";

//area
var getDistrictMatchUrl = baseAreaUrl + "get-district-match";
var getUserLimitUrl= baseHouseUrl + "get-user-limit";

//help
var getHelpListUrl = baseHelpUrl + "get-help-list";
var getMyHelpListUrl = baseHelpUrl + "get-help-list-by-userid";
var getHelpDetailUrl = baseHelpUrl + "get-help-detail";
var getBestReplyUrl = baseHelpUrl + "get-best-reply";
var getReplyListUrl = baseHelpUrl + "get-help-reply-list";
var addReplyUrl = baseHelpUrl + "reply-help";
var addPraiseUrl = baseHelpUrl + "add-help-reply-praise";
var delPraiseUrl = baseHelpUrl + "del-help-reply-praise";
var addNegativeUrl = baseHelpUrl + "add-negative";
var delNegativeUrl = baseHelpUrl + "del-negative";
var acceptHelpReplyUrl = baseHelpUrl + "accept-help-reply";
var replyFeeUrl = baseHelpUrl + "reply-fee";

//agent
var getAgentDetailUrl = baseUserUrl + "get-agent-detail";

var baseTopicUrl = "http://www.zmzfang.com/?r=topic/";
var getReadTimesUrl = baseTopicUrl + "get-read-times";

var app_key = "9e304d4e8df1b74cfa009913198428ab";
var v = "v1.0";
var sign_method = "md5";
var signConstant = "4f4f8dd219bbdde0ae6bbe02be217c3a";

//获取当前时间戳
function getTimestamp() {
	return (Date.parse(new Date()) / 1000).toString();
}
//获取sign签名 
function getSign(keyOptions) {
	var sign = signConstant;
	var isFirst = false;
	for (var key in keyOptions) {
		if (!isFirst) {
			sign = sign + key + '=' + keyOptions[key];
			isFirst = true;
		} else {
			sign = sign + '&';
			sign = sign + key + '=' + keyOptions[key];
		}
	}
	sign = sign + signConstant;
	return sign;
}


function logData(data) {
	console.log(JSON.stringify(data));
}


function sendCommonAjax(options,url,sucFun,failFun)
{
	console.log('sendCommonAjax options:'+JSON.stringify(options));
	console.log('sendCommonAjax url:'+url);
	//console.log('sendCommonAjax sucFun:'+sucFun);
	//console.log('sendCommonAjax failFun:'+failFun);
	
	jQuery.ajax(url, {
		data: JSON.stringify(options),
		dataType: 'json', //服务器返回json格式数据
		type: 'post', //HTTP请求类型
		timeout: 10000, //超时时间设置为10秒；
		async: false,
		success: function(data) {
			sucFun(data);
		},
		error: function(xhr, type, errorThrown) {
			failFun(errorThrown);
		}
	});
}


(function(w) {

	

	w.ajax_get_recruit_detail = function(options,sucFun,failFun)
	{
		console.log('ajax_get_recruit_detail');
		sendCommonAjax(options,getRecruitDetailUrl,sucFun,failFun);
	}

	w.ajax_add_recruit = function(options,sucFun,failFun)
	{
		console.log('ajax_add_recruit');
		sendCommonAjax(options,addRecruitUrl,sucFun,failFun);
	}

	w.ajax_reply_fee = function(options,sucFun,failFun)
	{
		console.log('ajax_reply_fee');
		sendCommonAjax(options,replyFeeUrl,sucFun,failFun);
	}

	w.ajax_get_near_colleague = function(options,sucFun,failFun)
	{
		console.log('ajax_get_near_colleague');
		sendCommonAjax(options,getNearColleagueUrl,sucFun,failFun);
	}

	w.ajax_get_read_times = function(options,sucFun,failFun)
	{
		console.log('ajax_get_read_times');
		sendCommonAjax(options,getReadTimesUrl,sucFun,failFun);
	}

	w.ajax_get_agent_behaviour = function(options,sucFun,failFun)
	{
		console.log('ajax_get_agent_behaviour');
		sendCommonAjax(options,getAgentBehaviourUrl,sucFun,failFun);
	}

	w.ajax_who_have_seen_agent = function(options,sucFun,failFun)
	{
		console.log('ajax_who_have_seen_agent');
		sendCommonAjax(options,getWhoHaveSeenAgentUrl,sucFun,failFun);
	}

	w.ajax_who_have_seen_agent_today = function(options,sucFun,failFun)
	{
		console.log('ajax_who_have_seen_agent_today');
		sendCommonAjax(options,getWhoHaveSeenAgentTodayUrl,sucFun,failFun);
	}

	w.ajax_get_erweima = function(options,sucFun,failFun)
	{
		console.log('ajax_get_erweima');
		sendCommonAjax(options,erweimaUrl,sucFun,failFun);
	}
	
	w.ajax_get_agent_detail = function(options,sucFun,failFun)
	{
		console.log('ajax_get_agent_detail');
		sendCommonAjax(options,getAgentDetailUrl,sucFun,failFun);
	}

	w.ajax_get_my_help_list = function(options,sucFun,failFun)
	{
		console.log('ajax_get_my_help_list');
		sendCommonAjax(options,getMyHelpListUrl,sucFun,failFun);
	}

	w.ajax_accept_help_reply = function(options,sucFun,failFun)
	{
		console.log('ajax_accept_help_reply');
		sendCommonAjax(options,acceptHelpReplyUrl,sucFun,failFun);
	}

	w.ajax_get_help_list = function(options,sucFun,failFun)
	{
		console.log('ajax_get_help_list');
		sendCommonAjax(options,getHelpListUrl,sucFun,failFun);
	}

	w.ajax_get_help_detail = function(options,sucFun,failFun)
	{
		console.log('ajax_get_help_detail');
		sendCommonAjax(options,getHelpDetailUrl,sucFun,failFun);
	}

	w.ajax_get_best_reply = function(options,sucFun,failFun)
	{
		console.log('ajax_get_best_reply');
		sendCommonAjax(options,getBestReplyUrl,sucFun,failFun);
	}

	w.ajax_get_reply_list = function(options,sucFun,failFun)
	{
		console.log('ajax_get_reply_list');
		sendCommonAjax(options,getReplyListUrl,sucFun,failFun);
	}

	w.ajax_add_reply = function(options,sucFun,failFun)
	{
		console.log('ajax_add_reply');
		sendCommonAjax(options,addReplyUrl,sucFun,failFun);
	}

	w.ajax_add_praise = function(options,sucFun,failFun)
	{
		console.log('ajax_add_praise');
		sendCommonAjax(options,addPraiseUrl,sucFun,failFun);
	}

	w.ajax_del_praise = function(options,sucFun,failFun)
	{
		console.log('ajax_del_praise');
		sendCommonAjax(options,delPraiseUrl,sucFun,failFun);
	}

	w.ajax_add_negative = function(options,sucFun,failFun)
	{
		console.log('ajax_add_negative');
		sendCommonAjax(options,addNegativeUrl,sucFun,failFun);
	}

	w.ajax_del_negative = function(options,sucFun,failFun)
	{
		console.log('ajax_del_negative');
		sendCommonAjax(options,delNegativeUrl,sucFun,failFun);
	}

	//举报虚假房源
	w.ajax_add_report = function(options) {
		console.log(JSON.stringify(options));
		jQuery.ajax(addReportUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				addReportSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				addReportFailed(errorThrown);
			}
		});
	}



	//获取验证码
	w.ajax_get_verification_code = function(options) {
		console.log(JSON.stringify(options));
		jQuery.ajax(getVerriCodeUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				getVerificationCodeSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				getVerificationCodeFailed(errorThrown);
			}
		});
	}
	//验证验证码
	w.ajax_verify_verification_code = function(options) {
		jQuery.ajax(verifyverificationCodeUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				//验证通过后进行登录
				verifyverificationCodeSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				verifyverificationCodeFailed(errorThrown, options);
				//				toastMSG = '验证码不正确';
				//				mui.toast(toastMSG);
			}
		});
	}

	//用户登陆
	w.ajax_login = function(options) {
		console.log(JSON.stringify(options));
		jQuery.ajax(loginUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				//					console.log(JSON.stringify(data));
				loginSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				loginFailed(errorThrown,options);
//					console.log(JSON.stringify(errorThrown));
//					toastMSG = '用户信息获取失败';
//					mui.toast(toastMSG);
			}
		});
	}
	
	//获取轮播图片
	w.ajax_get_gallery = function(options) {
		startLoad();
		console.log("获取轮播图片");
		jQuery.ajax(getGalleryUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				if (data.length < 4) {
					console.log("首页滚动图片专辑图片数量必须大于4!");
					return;
				}
				var divs = document.body.querySelectorAll('.mui-slider-item'); //获取图片的div
				for (var i = 0; i < divs.length; i++) {
					var img = divs[i].getElementsByTagName('img')[0];
					if (i == 0) {
						img.src = 'url' + data[i].uuid + '.jpeg'; //这里url是获取的地址
					} else if (i == 8) {
						img.src = 'url' + data[i - 2].uuid + '.jpeg'; //这里url是获取的地址
					} else {
						img.src = 'url' + data[i - 1].uuid + '.jpeg'; //这里url是获取的地址
					}
				}
			},
			error: function(xhr, type, errorThrown) {
				toastMSG = '获取分类失败';
				mui.toast(toastMSG);
			}
		});
	}
    
    //获取需求列表
	w.ajax_get_requirement_list = function (options,flag) {
		//console.log(JSON.stringify(options));
		// console.log('ajax_get_requirement_list(options,flag) flag is '+flag);
		jQuery.ajax({
			url: getRequirementListUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取需求列表成功');
				// console.log(JSON.stringify(data));
				//成功后，处理应答
				getRequirementListSuccess(data,flag);
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取需求列表失败');
				toastMSG = '获取需求列表失败';
				mui.toast(toastMSG);
			}
		});
	}

	w.ajax_get_my_recruit_list = function(options)
	{
		console.log('ajax_get_my_recruit_list');
		jQuery.ajax({
			url: getMyRecruitListUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取我发布的职位列表成功');
				// console.log(JSON.stringify(data));
				//成功后，处理应答
				getMyRecruitListSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取我发布的职位列表失败');
				toastMSG = '获取我发布的职位列表失败';
				mui.toast(toastMSG);
			}
		});
	}


	//获取音频列表
	w.ajax_add_audio = function (options) {

		jQuery.ajax({
			url: getInterfaceUrl()+"?r=audio/add-audio",
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取音频成功');
				console.log(JSON.stringify(data));
				toastMSG = '获取音频成功';
				mui.toast(toastMSG);
				//成功后，处理应答
				//addAudioSuccess();
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取音频失败');
				toastMSG = '获取音频失败';
				mui.toast(toastMSG);
			}
		});
	}
	

			
    //获取我的需求列表
	w.ajax_get_requirement_byuserid = function (options) {
		console.log(JSON.stringify(options));
		
		jQuery.ajax({
			url: getRequirementByUserIdUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取需求列表成功');
				console.log(JSON.stringify(data));
				//成功后，处理应答
				getRequirementByUserIdSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取需求列表失败');
				toastMSG = '获取需求列表失败';
				mui.toast(toastMSG);
			}
		});
	}
    
	//需求详情
	w.ajax_get_requirement_detail = function(options) {
		//startLoad();
		console.log(JSON.stringify(options));
		var url = getRequirementDetailUrl+options.requirementid;
		console.log("ajax_get_requirement_detail url:"+url);
		jQuery.ajax(url, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				console.log('ajax_get_requirement_detail data:'+JSON.stringify(data));

				//保存到内存中
				fillRequiementInfo(data.data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('ajax_get_requirement_detail fail');
				fillRequiementInfo();
			}
		});
	}
	
	
	
	//提交需求详情
	w.ajax_add_requirement = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(addRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_add_requirement suc');
				addRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				addRequirementFail(errorThrown);
				//				
				//toastMSG = '网络异常，需求提交失败，请重试！';
				//mui.toast(toastMSG);
			}
		});
	}
	
	//删除我的需求
	w.ajax_delete_requirement = function(options) {
		console.log("ajax_delete_requirement data:"+JSON.stringify(options));
		jQuery.ajax(deleteRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				deleteRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//deleteRequirementFailed(errorThrown, options);
			    mui.toast("网络异常，需求删除失败，请重试！");
			}
		});
	}
	
	//刷新我的需求
	w.ajax_flush_requirement = function(options) {
		console.log("ajax_flush_requirement data:"+JSON.stringify(options));
		jQuery.ajax(flushRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				flushRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//flushRequirementFailed(errorThrown, options);
			    //mui.toast("网络异常，需求删除失败，请重试！");
			    console.log('flush requirement wrong');
			}
		});
	}
	

	//修改需求详情
	w.ajax_modify_requirement = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(modifyRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_modify_requirement suc data:'+JSON.stringify(data));
				modifyRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//modifyRequirementFail(errorThrown);
				//				
				toastMSG = '网络异常，需求修改提交失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	//获取历史发布需求
	w.ajax_get_publish_history = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(getPublishHistoryUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_publish_history suc');
				getPublishHistorySuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				getPublishHistoryFail(errorThrown);			
				toastMSG = '网络异常，获取信息失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	



	//获取订单列表
	w.ajax_get_user_orders = function(options) {
//		console.log(JSON.stringify(options));
		jQuery.ajax(getUserOrdersUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				getUserOrdersSuccess(data);

			},
			error: function(xhr, type, errorThrown) {
				getUserOrdersFailed(errorThrown, options);
			}
		});
	}

	
	//提交意见反馈
	w.ajax_submit_advice = function(options) {
		console.log(JSON.stringify(options));
		jQuery.ajax(submitAdviceUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				submitAdviceSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				toastMSG = '网络异常，提交意见反馈失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}

	
	//获取热门搜索词汇
	w.ajax_get_popular_words = function(options) {
		jQuery.ajax(getPopularWordsUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				getPopularWordsSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				toastMSG = '网络异常，获取热门搜索词汇';
				mui.toast(toastMSG);
			}
		});
	}
	
	//获取搜索商品列表
	w.ajax_get_search_goods = function(options) {
		jQuery.ajax(getSearchGoodsUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				getSearchGoodsSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				getSearchGoodsFailed(errorThrown,options);
			}
		});
	}

	
	//注册
	w.ajax_signup = function(options) {
		jQuery.ajax(getSignupUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				getSignupSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				getSignupFailed(errorThrown, options);
			}
		});
	}
	
	//微信绑定注册
	w.ajax_register_weixin = function(options) {
		console.log("ajax_register_weixin options:"+JSON.stringify(options));
		
		jQuery.ajax(registerWeixinUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				console.log("ajax_register_weixin suc .data:"+JSON.stringify(data));
				registerWeixinSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log("ajax_register_weixin failed");
				//registerWeixinFailed(errorThrown, options);
				toastMSG = '网络异常，绑定微信失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	

	
	//获取我的收藏的需求列表
	w.ajax_get_favorite_requirement = function(options) {
		console.log("ajax_get_favorite_requirement options:"+JSON.stringify(options));
		jQuery.ajax(getFavoriteRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				getFavoriteRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				getFavoriteRequirementFailed(errorThrown, options);
			}
		});
	}
	
	//增加我的收藏的需求列表
	w.ajax_add_favorite_requirement = function(options) {
		console.log(JSON.stringify(options));
		jQuery.ajax(addFavoriteRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				addFavoriteRequirementSuccess(data,options);
			},
			error: function(xhr, type, errorThrown) {
				addFavoriteRequirementFailed(errorThrown, options);
			}
		});
	}
	
	//删除我的收藏的需求列表
	w.ajax_delete_favorite_requirement = function(options) {
		jQuery.ajax(deleteFavoriteRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				removeFavoriteRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				removeFavoriteRequirementFailed(errorThrown, options);
			}
		});
	}

	//修改订单状态
	w.ajax_modi_order_status = function(options) {
		console.log(JSON.stringify(options));
		jQuery.ajax(modiOrderStatusUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			success: function(data) {
				modiOrderStatusSuccess(data, options);
			},
			error: function(xhr, type, errorThrown) {
				modiOrderStatusFailed(errorThrown, options);
			}
		});
	}

	//获取APP版本信息
	w.ajax_get_app_version = function(options) {
		jQuery.ajax(getAppVersionUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				getAppVersionSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				getAppVersionFailed(errorThrown);
			}
		});
	}
	
	//获取广告列表
	w.ajax_get_advertisement_list = function (options) {
		console.log(JSON.stringify(options));
		jQuery.ajax({
			url: getAdvertisementListUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取广告列表成功');
				console.log(JSON.stringify(data));
				//成功后，处理应答
				getAdvertisementListSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取广告列表失败');
				toastMSG = '获取广告列表失败';
				mui.toast(toastMSG);
			}
		});
    }
	
	//获取广告详情
	w.ajax_get_advertisement_detail = function (options) {
		console.log(JSON.stringify(options));
		jQuery.ajax({
			url: getAdvertisementDetailUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取广告详情成功');
				console.log(JSON.stringify(data));
				//成功后，处理应答
				getAdvertisementDetailSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取广告详情失败');
				toastMSG = '网络异常，获取广告详情失败';
				mui.toast(toastMSG);
			}
		});
    }
	
	
	//获取用户信息
	w.ajax_get_user_info = function (options) {
		console.log('ajax_get_user_info options:'+JSON.stringify(options));
		var getUserInfoUrl='http://www.zmzfang.com/index.php?r=user/get-user-info';
		jQuery.ajax({
			url: getUserInfoUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('获取用户信息成功');
				console.log(JSON.stringify(data));
				
				//成功后，处理应答,保存在本地
				
				getUserInfoSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('获取用户信息失败');
				toastMSG = '网络异常，获取用户信息失败';
				mui.toast(toastMSG);
			}
		});
	}
	
	//修改用户信息
	w.ajax_modify_user_info = function (options) {
		console.log(JSON.stringify(options));
		jQuery.ajax({
			url: moidfyUserInfoUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				// console.log('修改用户信息完成');
				// console.log(JSON.stringify(data));
				
				//成功后，处理应答,保存在本地
				modifyUserInfoSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('修改用户信息失败');
				toastMSG = '网络异常，修改用户信息失败';
				mui.toast(toastMSG);
			}
		});
	}
	
	
	//获取用户信息
	w.ajax_get_user_by_openid = function (options) {
		console.log(JSON.stringify(options));
		jQuery.ajax({
			url: getUserByOpenidUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				
				console.log(JSON.stringify(data));
				
				//成功后，处理应答,保存在本地
				if(!data)
				{
					console.log('获取用户信息失败');
					getUserByOpenidFailed(data);
				}
				else
				{
					console.log('获取用户信息成功');
					getUserByOpenidSuccess(data);	
				}
				
			},
			error: function(xhr, type, errorThrown) {
				//getUserByOpenidFailed(data);
				
				console.log('获取用户信息失败');
				toastMSG = '网络异常，获取用户信息失败';
				mui.toast(toastMSG);
			}
		});
	}
	
	//发布房源信息
	w.ajax_add_house = function(options) {
	    console.log(JSON.stringify(options));
	    //alert(JSON.stringify(options));
		jQuery.ajax(addHouseUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_add_house suc');
				//alert(JSON.stringify(data));
				addHouseSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				addHouseFail(errorThrown);				
				//toastMSG = '网络异常，信息提交失败，请重试！';
				//mui.toast(toastMSG);
			}
		});
	}
	
	//修改房源信息
	w.ajax_modify_house = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(modifyHouseUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_modify_house suc.data:'+JSON.stringify(data));
				modifyHouseSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//modifyHouseFail(errorThrown);
								
				toastMSG = '网络异常，信息提交失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	//删除我的房源
	w.ajax_delete_house = function(options) {
		console.log("ajax_delete_house data:"+JSON.stringify(options));
		jQuery.ajax(deleteHouseUrl, {
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 3000, //超时时间设置为10秒；
			success: function(data) {
				deleteHouseSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//deleteRequirementFailed(errorThrown, options);
			    mui.toast("网络异常，房源删除失败，请重试！");
			}
		});
	}
	
	//获取我的房源列表信息
	w.ajax_get_houselist = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(getHouseListUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_houselist suc');
				getHouseListSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getHouseListFail(errorThrown);
								
				toastMSG = '网络异常，信息获取失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	
	//获取房源详细信息
	w.ajax_get_house_detail = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(getHouseDetailUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_modify_house suc');
				getHouseDetailSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getHouseDetailFail(errorThrown);
								
				toastMSG = '网络异常，信息获取失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	//获取我的房源匹配需求后的列表信息
	w.ajax_get_houselist_match_requirement = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(getHouselistMatchRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_houselist_match_requirement suc data:'+JSON.stringify(data));
				getMatchHouseListSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getHouseListFail(errorThrown);
								
				toastMSG = '网络异常，信息获取失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	//投标
	w.ajax_bid = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(bidUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_bid suc .data.'+JSON.stringify(data));
				bidSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getHouseListFail(errorThrown);
								
				toastMSG = '网络异常，投标失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	w.ajax_get_bid_by_requirementid = function(options)
	{
		console.log(JSON.stringify(options));
	    
		jQuery.ajax(getBidByRequiementIdUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_bid_by_requirementid suc');
				getBidByRequiementIdSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getBidByRequiementIdFail(errorThrown);
				console.log('ajax_get_bid_by_requirementid fail');				
				// toastMSG = '网络异常，信息获取失败，请重试！';
				// mui.toast(toastMSG);
			}
		});
	}
	
	w.ajax_get_bid_by_houseid = function(options)
	{
		console.log(JSON.stringify(options));
	    
		jQuery.ajax(getBidByHouseIdUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_bid_by_houseid suc');
				getBidByHouseIdSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getBidByHouseIdFail(errorThrown);
				console.log('ajax_get_bid_by_houseid fail');				
				// toastMSG = '网络异常，信息获取失败，请重试！';
				// mui.toast(toastMSG);
			}
		});
	}
	w.ajax_get_system_recommend = function(options)
	{
		console.log(JSON.stringify(options));
	    
		jQuery.ajax(getSystemRecommendUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_system_recommend suc');
				getSystemRecommendSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getSystemRecommendFail(errorThrown);
				console.log('ajax_get_system_recommend fail');				
				toastMSG = '网络异常，信息获取失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	
	w.ajax_get_specific_house_bid = function(options)
	{
		console.log(JSON.stringify(options));
	    
		jQuery.ajax(getSpecificHouseBidUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_specific_house_bid suc .data:'+JSON.stringify(data));
				getSpecificHouseBidSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getSpecificHouseBidFail(errorThrown);
				console.log('ajax_get_specific_house_bid fail');				
				toastMSG = '网络异常，信息获取失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	//修改投标状态modify_bid_status
	w.ajax_modify_bid_status = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(modifyBidStatusUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_modify_bid_status suc .data.'+JSON.stringify(data));
				modifyBidStatusSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//modifyBidStatus(errorThrown);
				modifyBidStatusFailed();				
				toastMSG = '网络异常，处理失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	w.ajax_get_district_match = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(getDistrictMatchUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_get_district_match suc .data.'+JSON.stringify(data));
				getDistrictMathSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getDistrictMathFailed(errorThrown);
								
				toastMSG = '网络异常，处理失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
		w.ajax_get_user_limit = function(options) {
	    console.log(JSON.stringify(options));
	    
		jQuery.ajax(getUserLimitUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				getUserLimitSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				//getDistrictMathFailed(errorThrown);
								
				toastMSG = '网络异常，处理失败，请重试！';
				mui.toast(toastMSG);
			}
		});
	}
	
	w.ajax_send_template_message = function(options) {
		console.log('ajax_send_template_message options:'+JSON.stringify(options));
		var sendTplMsgUrl = "http://www.zmzfang.com/?r=wechat/send-template-message";
		jQuery.ajax({
			url: sendTplMsgUrl,
			data: JSON.stringify(options),
			dataType: 'json', //服务器返回json格式数据
			type: 'post', //HTTP请求类型
			timeout: 10000, //超时时间设置为10秒；
			async: false,
			success: function(data) {
				console.log('发送模板消息成功');
				console.log(JSON.stringify(data));
				//成功后，处理应答
				sendTplMsgSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				console.log('发送模板消息失败');
				//toastMSG = '发送模板消息失败';
				//mui.toast(toastMSG+xhr+type);
			}
		});
	}



	//获取是否是收藏的房源
	w.ajax_is_favorite_requirement = function(options) {
	    console.log(JSON.stringify(options));
	    // alert("URL is "+isFavoriteRequirementUrl);
		jQuery.ajax(isFavoriteRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_is_favorite_requirement suc');
				//alert(JSON.stringify(data));
				favoriteRequirementSuccess(data);
			},
			error: function(xhr, type, errorThrown) {
				addHouseFail(errorThrown);				
				//toastMSG = '网络异常，信息提交失败，请重试！';
				//mui.toast(toastMSG);
			}
		});
	}
	
	//向同板块的所有经纪人推送模板消息
	w.ajax_push_requirement = function(options) {
	    console.log(JSON.stringify(options));
	    // alert("URL is "+isFavoriteRequirementUrl);
		jQuery.ajax(pushRequirementUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_push_requirement suc');
				//alert(JSON.stringify(data));
			},
			error: function(xhr, type, errorThrown) {
				console.log('ajax_push_requirement failed');			
				//toastMSG = '网络异常，信息提交失败，请重试！';
				//mui.toast(toastMSG);
			}
		});
	}	
		//向同板块的所有经纪人推送模板消息
	w.ajax_push_supplyment = function(options) {
	    console.log(JSON.stringify(options));
	    console.log("pushSupplymentUrl is "+pushSupplymentUrl);
		jQuery.ajax(pushSupplymentUrl, {
			data: JSON.stringify(options),
			dataType: 'json',
			type: 'post',
			timeout: 10000,
			success: function(data) {
				console.log('ajax_push_requirement suc');
				//alert(JSON.stringify(data));
			},
			error: function(xhr, type, errorThrown) {
				console.log('ajax_push_requirement failed');			
				//toastMSG = '网络异常，信息提交失败，请重试！';
				//mui.toast(toastMSG);
			}
		});
	}
	
})(window);