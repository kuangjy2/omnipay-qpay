<?php

namespace Omnipay\QPay;

use Omnipay\Common\AbstractGateway;

abstract class BaseAbstractGateway extends AbstractGateway
{
    public function setTradeType($tradeType)
    {
        $this->setParameter('trade_type', $tradeType);
    }


    public function setAppId($appId)
    {
        $this->setParameter('app_id', $appId);
    }


    public function getAppId()
    {
        return $this->getParameter('app_id');
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


    public function setApiKey($apiKey)
    {
        $this->setParameter('api_key', $apiKey);
    }


    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }


    public function setMchId($mchId)
    {
        $this->setParameter('mch_id', $mchId);
    }


    public function getMchId()
    {
        return $this->getParameter('mch_id');
    }

    /**
     * 子商户id
     *
     * @return mixed
     */
    public function getSubMchId()
    {
        return $this->getParameter('sub_mch_id');
    }


    /**
     * @param mixed $subMchId
     */
    public function setSubMchId($mchId)
    {
        $this->setParameter('sub_mch_id', $mchId);
    }


    /**
     * 子商户 app_id
     *
     * @return mixed
     */
    public function getSubAppId()
    {
        return $this->getParameter('sub_appid');
    }


    /**
     * @param mixed $subAppId
     */
    public function setSubAppId($subAppId)
    {
        $this->setParameter('sub_appid', $subAppId);
    }

    public function setNotifyUrl($url)
    {
        $this->setParameter('notify_url', $url);
    }


    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    /**
     * @return mixed
     */
    public function getCertPath()
    {
        return $this->getParameter('cert_path');
    }


    /**
     * @param mixed $certPath
     */
    public function setCertPath($certPath)
    {
        $this->setParameter('cert_path', $certPath);
    }


    /**
     * @return mixed
     */
    public function getKeyPath()
    {
        return $this->getParameter('key_path');
    }


    /**
     * @param mixed $keyPath
     */
    public function setKeyPath($keyPath)
    {
        $this->setParameter('key_path', $keyPath);
    }


    public function getTradeType()
    {
        return $this->getParameter('trade_type');
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\CreateOrderRequest
     */
    public function purchase($parameters = [])
    {
        $parameters['trade_type'] = $this->getTradeType();

        return $this->createRequest('\Omnipay\QPay\Message\CreateOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\CompletePurchaseRequest
     */
    public function completePurchase($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\CompletePurchaseRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\QueryOrderRequest
     */
    public function query($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\QueryOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\CloseOrderRequest
     */
    public function close($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\CloseOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\RefundOrderRequest
     */
    public function refund($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\RefundOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\QueryOrderRequest
     */
    public function queryRefund($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\QueryRefundRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\DownloadBillRequest
     */
    public function downloadBill($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\DownloadBillRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\CreateTransferRequest
     */
    public function transfer($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\CreateTransferRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\QueryTransferRequest
     */
    public function queryTransfer($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\QueryTransferRequest', $parameters);
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\CreateRedPacketRequest
     */
    public function redPacket($parameters = [])
    {
        return $this->createRequest('\Omnipay\QPay\Message\CreateRedPacketRequest', $parameters);
    }
}
