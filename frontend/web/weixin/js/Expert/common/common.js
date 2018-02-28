function getDomainStr(domain)
{
	var domainarray=domain.split(",");
	console.log(domainarray.length);
	var str = '';
	for(var i=0;i<domainarray.length;i++)
	{
		str += '<span class="badge"> ';
		switch(domainarray[i])
		{
			case '1':
				str += '政策';
	    		break;
			case '2':
				str += '贷款';
	    		break;
			case '3':
				str += '交易';
	    		break;
	    	case '4':
				str += '法律';
	    		break;
	    	case '5':
				str += '市场';
	    		break;
			default:
				str += '';
	    		break;
		}
		str += '</span>';
	}
	
	return str;
}

function getDomainBadge(domain)
{
	var domainarray=domain.split(" ");
	console.log(domainarray.length);
	var str = '';
	for(i in domainarray)
	{
		str += '<span class="mui-badge mui-badge-danger"> ';
		str += domainarray[i];
		str += '</span>';
	}
	
	return str;
}

function hasDomain(domains,domain)
{
	var result = domains.indexOf(domain);
	if(result >= 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function getAppointmentTypeStr(data)
{
	var type = '';
	if(data == '1')
	{
		type = '提问';
	}
	else if(data == '2')
	{
		type = "约见";
	}
	else
	{
		type = "未知";
	}
	return type;
}

function getAppointmentStatusStr(appointmentType,status)
{
	if(appointmentType == "1")
	{
		return getOnlineStatus(status);
	}
	else
	{
		return getOfflineStatus(status);
	}
}

//线上提问状态：0--问题提交（等待支付），1--客户支付（等待专家答复），2--专家答复
function getOnlineStatus(data)
{
	var str = '';
	switch(data)
	{
		case '0':
			str += '问题提交';
    		break;
		case '1':
			str += '已支付';
    		break;
		case '2':
			str += '专家答复';
    		break;
    	case '3':
			str += '专家拒绝';
    		break;
    	case '4':
			str += '超时';
    		break;
		default:
			str += '未知状态';
    		break;
	}
	return str;
}

//线下预约状态：0--已提交预约申请（等待专家确认），1--专家确认（等待客户支付），2--客户支付完成（线下沟通），
//3--专家确认流程结束，4--客户确认流程结束，5--平台打款，6--已完成
function getOfflineStatus(data)
{
	var str = '';
	switch(data)
	{
		case '0':
			str += '已提交预约申请';
    		break;
		case '1':
			str += '专家已确认';
    		break;
		case '2':
			str += '客户支付完成';
    		break;
    	case '3':
			str += '专家确认流程结束';
    		break;
    	case '4':
			str += '客户确认流程结束';
    		break;
    	case '5':
			str += '平台打款';
    		break;
    	case '6':
			str += '已完成';
    		break;
    	case '7':
			str += '专家拒绝';
    		break;
    	case '8':
			str += '超时';
			break;
		case '9':
			str += '其他情况退款';
    		break;
		default:
			str += '';
    		break;
	}
	return str;
}

var OfflineStatus = (function() {  
  // Private static attributes.
  var constants = {//定义了两个常量
  	OFFLINE_SUBMIT: '0',//用户刚提交
    OFFLINE_EXPERT_AFFIRM: '1',//专家确认
    OFFLINE_EXPERT_REJECT: '7',//专家拒绝
    OFFLINE_PAY: '2',//用户支付完成,沟通中
    OFFLINE_EXPERT_CLOSE: '3',//专家确认流程完成
    OFFLINE_USER_CLOSE: '4',//用户确认流程完成
     OFFLINE_SYSTEM_PAY: '5',//平台打款
    OFFLINE_SYSTEM_CLOSE: '6',//系统完成
  }
  var Obj={};
  // 定义了一个静态方法
  Obj.getStatus=function(name){//获取常量的方法
    return constants[name];
  }
  return Obj
})();

function getServiceTypeStr(data)
{
	var type = '';
	switch(data)
	{
		case '1001':
			type = '线上提问收入';
			break;
		case '1002':
			type = '线下约见收入';
			break;
		case '1003':
			type = '收听分成收入';
			break;
		case '1004':
			type = '线上提问退款';
			break;
		case '1005':
			type = '线下约见退款';
			break;
		case '2001':
			type = '线上提问支出';
			break;
		case '2002':
			type = '线下约见支出';
			break;
		case '2003':
			type = '收听支出';
			break;
		case '2004':
			type = '提现支出';
			break;
		case '3001':
			type = '任务红包';
		default:
			break;
	}
	
	return type;
}

var DrawedStatus = (function() {  
  // Private static attributes.
  var constants = {//定义了两个常量
  	'1': '提交申请',
    '2': '审核后同意',
    '3': '审核后拒绝',
    '4': '转账成功',
    '5': '转账失败',
  }
  var Obj={};
  // 定义了一个静态方法
  Obj.getStatus=function(name){//获取常量的方法
    return constants[name];
  }
  return Obj
})();

var OrderType = (function() {  
  // Private static attributes.
  //1线上提问，2线下约见，3收听，4提现
  var constants = {//定义了两个常量
  	QUESTION_ONLINE: '1',//线上提问
  	APPOINTMENT_OFFLINE: '2',//线下约见
 	LISTEN: '3',//收听
 	DRAWED: '4',//提现
  }
  var Obj={};
  // 定义了一个静态方法
  Obj.getType=function(name){//获取常量的方法
    return constants[name];
  }
  return Obj
})();

function initSelectElementByValue(id,data)
{
	var selectElement=byId(id);
	for(var i=0;i<selectElement.options.length;i++)
	{
		if(selectElement.options[i].value == data)
		{
		    selectElement.selectedIndex = i;
		    break;
		}
	}
}

function initSelectElementByText(id,data)
{
	var selectElement=byId(id);
	for(var i=0;i<selectElement.options.length;i++)
	{
		if(selectElement.options[i].text == data)
		{
		    selectElement.selectedIndex = i;
		    break;
		}
	}
}

function initNavUi()
{
	var length = window.history.length;
	console.log('window.history.length '+window.history.length);
	if(length <= 2)
	{
		//分享或者模板消息中第一次打开
		$('#backLink').addClass('mui-hidden');
		$('#homeLink').removeClass('mui-hidden');
	}
	
}
