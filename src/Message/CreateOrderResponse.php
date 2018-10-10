<?php

namespace Omnipay\QPay\Message;

use Omnipay\QPay\Helper;

/**
 * Class CreateOrderResponse
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/38/1203
 */
class CreateOrderResponse extends BaseAbstractResponse
{

    /**
     * @var CreateOrderRequest
     */
    protected $request;


    public function getPrepayId()
    {
        if ($this->isSuccessful()) {
            $data = $this->getData();

            return $data['prepay_id'];
        } else {
            return null;
        }
    }


    public function getJsOrderData()
    {
        if ($this->isSuccessful() && $this->request->getTradeType() == 'JSAPI') {
            $data = [
                'tokenId' => 'prepay_id=' . $this->getPrepayId(),
                'appInfo' => 'appid#' . $this->request->getAppId() . '|bargainor_id#' . $this->request->getMchId() . '|channel#wallet'
            ];
        } else {
            $data = null;
        }

        return $data;
    }


    public function getCodeUrl()
    {
        if ($this->isSuccessful() && $this->request->getTradeType() == 'NATIVE') {
            $data = $this->getData();

            return $data['code_url'];
        } else {
            return null;
        }
    }


    public function getAppData()
    {
        if ($this->isSuccessful() && $this->request->getTradeType() == 'APP') {
            $signData = [
                'appId' => $this->request->getAppId(),
                'tokenId' => $this->getPrepayId(),
                'pubAcc' => '',
                'bargainorId' => $this->request->getMchId(),
                'nonce' => md5(uniqid()),
            ];
            $signStr = Helper::appSign($signData, $this->request->getAppKey());
            $data = array_merge($signData, [
                'timeStamp' => time(),
                'sigType' => 'HMAC-SHA1',
                'sig' => $signStr
            ]);
        } else {
            $data = null;
        }

        return $data;
    }
}
