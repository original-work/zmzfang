//Expert
var baseUrl = "http://www.zmzfang.com/index.php?";
var baseExpertUrl = baseUrl + "r=expert/";
var addExpertUrl = baseExpertUrl + "add-expert";
var modifyExpertUrl = baseExpertUrl + "modify-expert";
var getExpertUrl = baseExpertUrl + "get-expert";
var getExpertListUrl = baseExpertUrl + "get-expert-list";
var getExpertDetailUrl = baseExpertUrl + "get-expert-detail";
var addExpertPraiseCntUrl = baseExpertUrl + "add-praise";


var addFavoriteExpertUrl = baseExpertUrl + "add-favorite-expert";
var getFavoriteExpertUrl = baseExpertUrl + "get-favorite-expert";
var deleteFavoriteExpertUrl = baseExpertUrl + "delete-favorite-expert";
var isFavoriteExpertUrl = baseExpertUrl + "is-favorite-expert";

//comment
var getCommentUrl = baseUrl + "r=comment/get-comment";
var addCommentUrl = baseUrl + "r=comment/add-comment";

//answer
var baseAnswerUrl = baseUrl + "r=answer/";
var getAnswerUrl = baseAnswerUrl + "get-answer";
var getAnswerListUrl = baseAnswerUrl + "get-answer-list";
var getAnswerDetailUrl = baseAnswerUrl + "get-answer-detail";
var listenAnswerUrl = baseAnswerUrl + "listen-answer";
var modifyPayQuestionOrderStatusUrl = baseAnswerUrl + "modify-pay-question-order-status";
var modifyListenCntUrl = baseAnswerUrl + "modify-listen-cnt";
var askQuestionOnlineUrl = baseAnswerUrl + "ask-question-online";
var getQuestionByIdUrl = baseAnswerUrl + "get-question-by-id";
var updateQuestionAnswerUrl = baseAnswerUrl + "update-question-answer";
var getPayQuestionUrl = baseAnswerUrl + "get-pay-question";

//appointment
var baseAppointmentUrl = baseUrl + "r=appointment/";
var appointmentOfflineUrl = baseAppointmentUrl + "appointment-offline";
var getAppointmentUrl = baseAppointmentUrl + "get-appointment";

var getAppointmentDetailUrl = baseAppointmentUrl + "get-appointment-detail";

var getAppointmentStatusUrl = baseAppointmentUrl + "get-appointment-status";
var deleteAppointmentUrl = baseAppointmentUrl + "delete-appointment";
var getAppointmentAsExpertUrl = baseAppointmentUrl + "get-appointment-as-expert";
var modifyOrderStatusUrl = baseAppointmentUrl + "modify-order-status";

//audio
var addAudioUrl =   baseUrl + "r=audio/add-audio";
//
//account
var getAccountUrl = baseUrl + "r=account/get-account";
var getAccountDetailUrl = baseUrl + "r=account/get-account-detail";
var applyDrawedUrl = baseUrl + "r=account/apply-drawed";
var getDrawedListUrl = baseUrl + "r=account/get-apply-drawed-list";
var payUseAccountUrl = baseUrl + "r=account/pay-use-zmzfangaccount";

var addWeixinPicUrl = "http://www.zmzfang.com/index.php?r=user/add-wx-pic";

//advertisement
var getAdvertListUrl = baseUrl + "r=promotion/get-advertisement";
//search
var searchExpertAndQuestionUrl = baseUrl + "r=expert/search-expert-and-question";

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
			sucFun(data);
		},
		error: function(xhr, type, errorThrown) {
			//addReportFailed(errorThrown);
			failFun(errorThrown);
		}
	});
}

(function(w) {
    //专家申请
	w.ajax_add_expert = function(options,sucFun,failFun) {
		console.log('ajax_add_expert');
		sendCommonAjax(options,addExpertUrl,sucFun,failFun);
	}
	
	w.ajax_modify_expert = function(options,sucFun,failFun) {
		console.log('ajax_modify_expert');
		sendCommonAjax(options,modifyExpertUrl,sucFun,failFun);
	}
	
	w.ajax_get_expert = function(options,sucFun,failFun) {
		console.log('ajax_get_expert');
		sendCommonAjax(options,getExpertUrl,sucFun,failFun);
	}
	
	w.ajax_get_expert_list = function(options,sucFun,failFun) {
		console.log('ajax_get_expert_list');
		sendCommonAjax(options,getExpertListUrl,sucFun,failFun);
	}
	
	w.ajax_get_expert_detail = function(options,sucFun,failFun) {
		console.log('ajax_get_expert_detail');
		sendCommonAjax(options,getExpertDetailUrl,sucFun,failFun);
	}
	
	w.ajax_get_comment = function(options,sucFun,failFun) {
		console.log('ajax_get_comment');
		sendCommonAjax(options,getCommentUrl,sucFun,failFun);
	}
	
	w.ajax_add_comment = function(options,sucFun,failFun) {
		console.log('ajax_add_comment');
		sendCommonAjax(options,addCommentUrl,sucFun,failFun);
	}
		
	
	w.ajax_get_answer = function(options,sucFun,failFun) {
		console.log('ajax_get_answer');
		sendCommonAjax(options,getAnswerUrl,sucFun,failFun);
	}
	
	w.ajax_get_answer_list = function(options,sucFun,failFun) {
		console.log('ajax_get_answer_list');
		sendCommonAjax(options,getAnswerListUrl,sucFun,failFun);
	}
	
	w.ajax_get_answer_detail = function(options,sucFun,failFun) {
		console.log('ajax_get_answer_detail');
		sendCommonAjax(options,getAnswerDetailUrl,sucFun,failFun);
	}
	
	w.ajax_listen_answer = function(options,sucFun,failFun) {
		console.log('ajax_listen_answer');
		sendCommonAjax(options,listenAnswerUrl,sucFun,failFun);
	}

	w.ajax_modify_pay_question_order_status = function(options,sucFun,failFun) {
		console.log('ajax_modify_pay_question_order_status');
		sendCommonAjax(options,modifyPayQuestionOrderStatusUrl,sucFun,failFun);
	}
	
	w.ajax_modify_listen_cnt = function(options,sucFun,failFun) {
		console.log('ajax_modify_listen_cnt');
		sendCommonAjax(options,modifyListenCntUrl,sucFun,failFun);
	}
	
	w.ajax_ask_question_online = function(options,sucFun,failFun) {
		console.log('ajax_ask_question_online');
		sendCommonAjax(options,askQuestionOnlineUrl,sucFun,failFun);
	}
	
	w.ajax_get_question_by_id = function(options,sucFun,failFun) {
		console.log('ajax_get_question_by_id');
		sendCommonAjax(options,getQuestionByIdUrl,sucFun,failFun);
	}
	
	w.ajax_update_question_answer = function(options,sucFun,failFun) {
		console.log('ajax_update_question_answer');
		sendCommonAjax(options,updateQuestionAnswerUrl,sucFun,failFun);
	}
	
	w.ajax_get_pay_question = function(options,sucFun,failFun) {
		console.log('ajax_get_pay_question');
		sendCommonAjax(options,getPayQuestionUrl,sucFun,failFun);
	}

	w.ajax_appointment_offline = function(options,sucFun,failFun) {
		console.log('ajax_appointment_offline');
		sendCommonAjax(options,appointmentOfflineUrl,sucFun,failFun);
	}
	
	w.ajax_get_appointment = function(options,sucFun,failFun) {
		console.log('ajax_get_appointment');
		sendCommonAjax(options,getAppointmentUrl,sucFun,failFun);
	}
	
	w.ajax_get_appointment_detail = function(options,sucFun,failFun) {
		console.log('ajax_get_appointment_detail');
		sendCommonAjax(options,getAppointmentDetailUrl,sucFun,failFun);
	}
	
	w.ajax_get_appointment_status = function(options,sucFun,failFun) {
		console.log('ajax_get_appointment_status');
		sendCommonAjax(options,getAppointmentStatusUrl,sucFun,failFun);
	}
	
	w.ajax_delete_appointment = function(options,sucFun,failFun) {
		console.log('ajax_delete_appointment');
		sendCommonAjax(options,deleteAppointmentUrl,sucFun,failFun);
	}
	
	w.ajax_get_appointment_as_expert = function(options,sucFun,failFun) {
		console.log('ajax_get_appointment_as_expert');
		sendCommonAjax(options,getAppointmentAsExpertUrl,sucFun,failFun);
	}
	
	w.ajax_modify_order_status = function(options,sucFun,failFun) {
		console.log('ajax_modify_order_status');
		sendCommonAjax(options,modifyOrderStatusUrl,sucFun,failFun);
	}
	
	w.ajax_add_weixin_pic = function(options,sucFun,failFun) {
		console.log('ajax_add_weixin_pic');
		sendCommonAjax(options,addWeixinPicUrl,sucFun,failFun);
	}
	
	
	w.ajax_add_audio_new = function(options,sucFun,failFun) {
		console.log('ajax_add_weixin_pic');
		sendCommonAjax(options,addAudioUrl,sucFun,failFun);
	}

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