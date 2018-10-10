<?php

namespace Omnipay\QPay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class CreateMicroPayOrderRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/1/1122
 * @method  CreateMicroPayOrderResponse send()
 */
class CreateMicroPayOrderRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://qpay.qq.com/cgi-bin/pay/qpay_micro_pay.cgi';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @return mixed
     */
    public function getData()
    {
        if (empty($this->getFeeType())) {
            $this->setFeeType('CNY');
        }

        $this->validate(
            'mch_id',
            'api_key',
            'body',
            'out_trade_no',
            'total_fee',
            'notify_url',
            'trade_type',
            'spbill_create_ip',
            'device_info',
            'auth_code'
        );

        $data = array(
            'appid' => $this->getAppId(),//*
            'mch_id' => $this->getMchId(),
            'sub_appid' => $this->getSubAppId(),
            'sub_mch_id' => $this->getSubMchId(),
            'device_info' => $this->getDeviceInfo(),//*
            'body' => $this->getBody(),//*
            'attach' => $this->getAttach(),
            'out_trade_no' => $this->getOutTradeNo(),//*
            'fee_type' => $this->getFeeType(),
            'total_fee' => $this->getTotalFee(),//*
            'spbill_create_ip' => $this->getSpbillCreateIp(),//*
            'notify_url' => $this->getNotifyUrl(), //*
            'trade_type' => $this->getTradeType(), //*
            'limit_pay' => $this->getLimitPay(),
            'promotion_tag' => $this->getPromotionTag(),
            'nonce_str' => md5(uniqid()),//*
            'auth_code'=>$this->getAuthCode()
        );

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return mixed
     */
    public function getTradeType()
    {
        return $this->getParameter('trade_type');
    }


    /**
     * @return mixed
     */
    public function getDeviceInfo()
    {
        return $this->getParameter('device_Info');
    }


    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->getParameter('body');
    }


    /**
     * @return mixed
     */
    public function getAttach()
    {
        return $this->getParameter('attach');
    }


    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }


    /**
     * @return mixed
     */
    public function getFeeType()
    {
        return $this->getParameter('fee_type');
    }


    /**
     * @return mixed
     */
    public function getTotalFee()
    {
        return $this->getParameter('total_fee');
    }


    /**
     * @return mixed
     */
    public function getSpbillCreateIp()
    {
        return $this->getParameter('spbill_create_ip');
    }


    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    /**
     * @return mixed
     */
    public function getLimitPay()
    {
        return $this->getParameter('limit_pay');
    }


    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->getParameter('Auth_code');
    }


    /**
     * @return mixed
     */
    public function getPromotionTag()
    {
        return $this->getParameter('promotion_tag');
    }


    /**
     * @param mixed $deviceInfo
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->setParameter('device_Info', $deviceInfo);
    }


    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->setParameter('body', $body);
    }


    /**
     * @param mixed $attach
     */
    public function setAttach($attach)
    {
        $this->setParameter('attach', $attach);
    }


    /**
     * @param mixed $outTradeNo
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }


    /**
     * @param mixed $feeType
     */
    public function setFeeType($feeType)
    {
        $this->setParameter('fee_type', $feeType);
    }


    /**
     * @param mixed $totalFee
     */
    public function setTotalFee($totalFee)
    {
        $this->setParameter('total_fee', $totalFee);
    }


    /**
     * @param mixed $spbillCreateIp
     */
    public function setSpbillCreateIp($spbillCreateIp)
    {
        $this->setParameter('spbill_create_ip', $spbillCreateIp);
    }


    /**
     * @param string $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->setParameter('notify_url', $notifyUrl);
    }


    /**
     * @param mixed $tradeType
     */
    public function setTradeType($tradeType)
    {
        $this->setParameter('trade_type', $tradeType);
    }


    /**
     * @param mixed $limitPay
     */
    public function setLimitPay($limitPay)
    {
        $this->setParameter('limit_pay', $limitPay);
    }


    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->setParameter('auth_code', $authCode);
    }


    /**
     * @param mixed $promotionTag
     */
    public function setPromotionTag($promotionTag)
    {
        $this->setParameter('promotion_tag', $promotionTag);
    }


    /**
     * 开放平台APP密钥
     * @param $appKey
     */
    public function setAppKey($appKey)
    {
        $this->setParameter('app_key', $appKey);
    }


    /**
     * 开放平台APP密钥
     * @return mixed
     */
    public function getAppKey()
    {
        return $this->getParameter('app_key');
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws \Omnipay\Common\Http\Exception\NetworkException
     * @throws \Omnipay\Common\Http\Exception\RequestException
     */
    public function sendData($data)
    {
        $body = Helper::array2xml($data);
        $response = $this->httpClient->request('POST', $this->endpoint, [], $body)->getBody();
        $payload = Helper::xml2array($response);

        return $this->response = new CreateMicroPayOrderResponse($this, $payload);
    }
}
