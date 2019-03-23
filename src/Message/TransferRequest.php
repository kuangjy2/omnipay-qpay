<?php

namespace Omnipay\QPay\Message;

use GuzzleHttp\Client;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class TransferRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/206/1215
 * @method  TransferResponse send()
 */
class TransferRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.qpay.qq.com/cgi-bin/epay/qpay_epay_b2c.cgi';


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

        $this->validate('mch_id', 'out_trade_no', 'total_fee', 'op_user_passwd', 'cert_path', 'key_path');

        $data = array(
            'input_charset' => 'UTF-8',
            'appid' => $this->getAppId(),
            'openid' => $this->getOpenId(),
            'uin' => $this->getUin(),
            'mch_id' => $this->getMchId(),
            'out_trade_no' => $this->getOutTradeNo(),
            'fee_type' => $this->getFeeType(),
            'total_fee' => $this->getTotalFee(),
            'memo' => $this->getMemo(),
            'check_name' => $this->getCheckName(),
            're_user_name' => $this->getReUserName(),
            'check_real_name' => $this->getCheckRealName(),
            'op_user_id' => $this->getOpUserId() ?: $this->getMchId(),
            'op_user_passwd' => $this->getOpUserPasswd(),
            'spbill_create_ip' => $this->getSpbillCreateIp(),
            'notify_url' => $this->getNotifyUrl(),
            'nonce_str' => md5(uniqid()),
        );

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
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

    /**
     * @return mixed
     */
    public function getOpenId()
    {
        return $this->getParameter('openid');
    }

    /**
     * @return mixed
     */
    public function getUin()
    {
        return $this->getParameter('uin');
    }

    /**
     * @return mixed
     */
    public function getMemo()
    {
        return $this->getParameter('memo');
    }

    /**
     * @return mixed
     */
    public function getCheckName()
    {
        return $this->getParameter('check_name');
    }

    /**
     * @return mixed
     */
    public function getReUserName()
    {
        return $this->getParameter('re_user_name');
    }

    /**
     * @return mixed
     */
    public function getCheckRealName()
    {
        return $this->getParameter('getCheckRealName');
    }

    /**
     * @return mixed
     */
    public function getOpUserId()
    {
        return $this->getParameter('op_user_id');
    }

    /**
     * @return mixed
     */
    public function getOpUserPasswd()
    {
        return $this->getParameter('op_user_passwd');
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
     * @param $uin
     */
    public function setUin($uin)
    {
        $this->setParameter('uin', $uin);
    }

    /**
     * @param $openId
     */
    public function setOpenId($openId)
    {
        $this->setParameter('openid', $openId);
    }

    /**
     * @param $memo
     */
    public function setMemo($memo)
    {
        $this->setParameter('memo', $memo);
    }

    /**
     * @param $checkName
     */
    public function setCheckName($checkName)
    {
        $this->setParameter('check_name', $checkName);
    }

    /**
     * @param mixed $tradeType
     */
    public function setTradeType($tradeType)
    {
        $this->setParameter('trade_type', $tradeType);
    }

    /**
     * @param $reUserName
     */
    public function setReUserName($reUserName)
    {
        $this->setParameter('re_user_name', $reUserName);
    }

    /**
     * @param $checkRealName
     */
    public function setCheckRealName($checkRealName)
    {
        $this->setParameter('check_real_name', $checkRealName);
    }

    /**
     * @param mixed $opUserId
     */
    public function setOpUserId($opUserId)
    {
        $this->setParameter('op_user_id', $opUserId);
    }

    /**
     * @param mixed $opUserPasswd
     */
    public function setOpUserPasswd($opUserPasswd)
    {
        $this->setParameter('op_user_passwd', $opUserPasswd);
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendData($data)
    {
        $body = Helper::array2xml($data);

        $client = new Client();

        $options = [
            'body' => $body,
            'verify' => true,
            'cert' => $this->getCertPath(),
            'ssl_key' => $this->getKeyPath(),
        ];

        $result = $client->request('POST', $this->endpoint, $options)->getBody()->getContents();

        $responseData = Helper::xml2array($result);

        return $this->response = new TransferResponse($this, $responseData);
    }
}
