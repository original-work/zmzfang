<?php
/**
 * ZHIMA API: zhima.customer.certify.initial request
 *
 * @author auto create
 * @since 1.0, 2016-10-18 11:19:19
 */
class ZhimaCustomerCertifyInitialRequest
{
	/** 
	 * 业务扩展参数入参，传递方式例如{"xx":"xxxxx"};
针对KBA的认证方式需要关注，biz_params中需要传入入参：
{"verifyScene":"向芝麻申请获得的scene值"}
	 **/
	private $bizParams;
	
	/** 
	 * 与芝麻信用签订的合约外标，即使合约改签或续签该值不会发生变化。请联系技术支持
	 **/
	private $contractFlag;
	
	/** 
	 * 不同身份类型的参数列表，json字符串的key-value格式：
如：
当identity_type= "BY_CERTNO_AND_NAME";时
identity_param={"certNo":"xxx","name":"张三","certType":"IDENTITY_CARD","mobileNo":"13901234567"};
或者
当identity_type= "BY_MOBILE_NO";时
identity_param={"mobileNo":"13901234567"};
或者
当identify_type="BY_CERT_IMAGE"
identity_param={"frontCertImage":"oioiweroeworewoiho2323","backCertImage":"dsrrwerewew"}
	 **/
	private $identityParam;
	
	/** 
	 * 身份标识类型（后续可以扩展）：
BY_CERTNO_AND_NAME:按照身份证+姓名（手机号可选）进行身份识别
BY_MOBILE_NO:按照手机号进行身份识别
BY_CERT_IMAGE: 根据证件图片识别
	 **/
	private $identityType;
	
	/** 
	 * 商户页面回调地址，芝麻认证完成后通过此url地址回传给商户认证的结果；
SDK模式接入的场景为非必填项，其他渠道类型的必填项；
	 **/
	private $pageUrl;
	
	/** 
	 * 当前使用的产品码
	 **/
	private $productCode;
	
	/** 
	 * 商户App的回调地址，通过商户App发起人脸核身的芝麻认证时必传；其他场景为非必填项；
	 **/
	private $schemaUrl;
	
	/** 
	 * 请求来源类型，为比填项， 例如h5, pc , app, sdk,window；
1.h5 ：商户H5端接入芝麻应用的场景；
2.pc：商户pc端接入芝麻认证的场景；
3.app：商户app应用接入芝麻认证的场景；
4.sdk：商户调用芝麻的sdk进行芝麻认证的场景:
5.window：服务窗进行芝麻认证的场景；
	 **/
	private $sourceType;
	
	/** 
	 * 芝麻认证过程中的冗余字段，在认证申请时传入，在结果页面回调中原样透传给商户端。支持json格式。
【建议使用方式】用于商户端唯一标记发起认证的用户信息，在接收到芝麻信用认证结果回调后确定用户
	 **/
	private $state;
	
	/** 
	 * 商户传入的业务流水号。此字段由商户生成，需确保唯一性，用于定位每一次请求，后续按此流水进行对帐。生成规则: 固定30位数字串，前17位为精确到毫秒的时间yyyyMMddhhmmssSSS，后13位为自增数字。
	 **/
	private $transactionId;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setBizParams($bizParams)
	{
		$this->bizParams = $bizParams;
		$this->apiParas["biz_params"] = $bizParams;
	}

	public function getBizParams()
	{
		return $this->bizParams;
	}

	public function setContractFlag($contractFlag)
	{
		$this->contractFlag = $contractFlag;
		$this->apiParas["contract_flag"] = $contractFlag;
	}

	public function getContractFlag()
	{
		return $this->contractFlag;
	}

	public function setIdentityParam($identityParam)
	{
		$this->identityParam = $identityParam;
		$this->apiParas["identity_param"] = $identityParam;
	}

	public function getIdentityParam()
	{
		return $this->identityParam;
	}

	public function setIdentityType($identityType)
	{
		$this->identityType = $identityType;
		$this->apiParas["identity_type"] = $identityType;
	}

	public function getIdentityType()
	{
		return $this->identityType;
	}

	public function setPageUrl($pageUrl)
	{
		$this->pageUrl = $pageUrl;
		$this->apiParas["page_url"] = $pageUrl;
	}

	public function getPageUrl()
	{
		return $this->pageUrl;
	}

	public function setProductCode($productCode)
	{
		$this->productCode = $productCode;
		$this->apiParas["product_code"] = $productCode;
	}

	public function getProductCode()
	{
		return $this->productCode;
	}

	public function setSchemaUrl($schemaUrl)
	{
		$this->schemaUrl = $schemaUrl;
		$this->apiParas["schema_url"] = $schemaUrl;
	}

	public function getSchemaUrl()
	{
		return $this->schemaUrl;
	}

	public function setSourceType($sourceType)
	{
		$this->sourceType = $sourceType;
		$this->apiParas["source_type"] = $sourceType;
	}

	public function getSourceType()
	{
		return $this->sourceType;
	}

	public function setState($state)
	{
		$this->state = $state;
		$this->apiParas["state"] = $state;
	}

	public function getState()
	{
		return $this->state;
	}

	public function setTransactionId($transactionId)
	{
		$this->transactionId = $transactionId;
		$this->apiParas["transaction_id"] = $transactionId;
	}

	public function getTransactionId()
	{
		return $this->transactionId;
	}

	public function getApiMethodName()
	{
		return "zhima.customer.certify.initial";
	}

	public function setScene($scene)
	{
		$this->scene=$scene;
	}

	public function getScene()
	{
		return $this->scene;
	}
	
	public function setChannel($channel)
	{
		$this->channel=$channel;
	}

	public function getChannel()
	{
		return $this->channel;
	}
	
	public function setPlatform($platform)
	{
		$this->platform=$platform;
	}

	public function getPlatform()
	{
		return $this->platform;
	}

	public function setExtParams($extParams)
	{
		$this->extParams=$extParams;
	}

	public function getExtParams()
	{
		return $this->extParams;
	}	

	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function getFileParas()
	{
		return $this->fileParas;
	}

	public function setApiVersion($apiVersion)
	{
		$this->apiVersion=$apiVersion;
	}

	public function getApiVersion()
	{
		return $this->apiVersion;
	}

}
