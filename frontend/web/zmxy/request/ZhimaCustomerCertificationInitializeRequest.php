<?php
/**
 * ZHIMA API: zhima.customer.certification.initialize request
 *
 * @author auto create
 * @since 1.0, 2016-12-30 15:36:18
 */
class ZhimaCustomerCertificationInitializeRequest
{
	/** 
	 * 认证场景码,常用的场景码有:
FACE:人脸认证,

签约的协议决定了可以使用那些场景
	 **/
	private $bizCode;
	
	/** 
	 * 扩展业务参数,暂时没有用到,接口预留
	 **/
	private $extBizParam;
	
	/** 
	 * 值为一个json串,必须包含身份类型identity_type,不同的身份类型需要的身份信息不同
当前支持:
身份信息为证件信息identity_type=CERT_INFO:
证件类型为身份证cert_type=IDENTITY_CARD,必要信息cert_name和cert_no

可以选填商户的用户主体principal_id,对应用户在商户端唯一标识,如果商户传了principal_id,后续会为商户提供更强大功能
	 **/
	private $identityParam;
	
	/** 
	 * 芝麻认证产品码,示例值为真实的产品码
	 **/
	private $productCode;
	
	/** 
	 * 商户请求的唯一标志，32位长度的字母数字下划线组合。该标识作为对账的关键信息，商户要保证其唯一性.建议:前面几位字符是商户自定义的简称,中间可以使用一段日期,结尾可以使用一个序列
	 **/
	private $transactionId;

	private $apiParas = array();
	private $fileParas = array();
	private $apiVersion="1.0";
	private $scene;
	private $channel;
	private $platform;
	private $extParams;

	
	public function setBizCode($bizCode)
	{
		$this->bizCode = $bizCode;
		$this->apiParas["biz_code"] = $bizCode;
	}

	public function getBizCode()
	{
		return $this->bizCode;
	}

	public function setExtBizParam($extBizParam)
	{
		$this->extBizParam = $extBizParam;
		$this->apiParas["ext_biz_param"] = $extBizParam;
	}

	public function getExtBizParam()
	{
		return $this->extBizParam;
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

	public function setProductCode($productCode)
	{
		$this->productCode = $productCode;
		$this->apiParas["product_code"] = $productCode;
	}

	public function getProductCode()
	{
		return $this->productCode;
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
		return "zhima.customer.certification.initialize";
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
