<?php

namespace Omnipay\QPay\Message;

use GuzzleHttp\Client;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class RefundOrderRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/38/1207
 * @method  RefundOrderResponse send()
 */
class RefundOrderRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.qpay.qq.com/cgi-bin/pay/qpay_refund.cgi';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('mch_id', 'out_refund_no', 'refund_fee', 'op_user_passwd', 'cert_path', 'key_path');

        if (empty($this->getTransactionId()) && empty($this->getOutTradeNo())) {
            throw new InvalidRequestException("The 'transaction_id' or 'out_trade_no' parameter is required");
        }

        $data = [
            'appid' => $this->getAppId(),
            'mch_id' => $this->getMchId(),
            'sub_appid' => $this->getSubAppId(),
            'sub_mch_id' => $this->getSubMchId(),
            'transaction_id' => $this->getTransactionId(),
            'out_trade_no' => $this->getOutTradeNo(),
            'out_refund_no' => $this->getOutRefundNo(),
            'refund_fee' => $this->getRefundFee(),
            'op_user_id' => $this->getOpUserId() ?: $this->getMchId(),
            'op_user_passwd' => $this->getOpUserPasswd(),
            'refund_account' => $this->getRefundAccount(),
            'nonce_str' => md5(uniqid()),
        ];

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return mixed
     */
    public function getOutTradeNo()
    {
        return $this->getParameter('out_trade_no');
    }


    /**
     * @param mixed $outTradeNo
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }


    /**
     * @return mixed
     */
    public function getOpUserId()
    {
        return $this->getParameter('op_user_id');
    }


    /**
     * @param mixed $opUserId
     */
    public function setOpUserId($opUserId)
    {
        $this->setParameter('op_user_id', $opUserId);
    }


    /**
     * @return mixed
     */
    public function getOutRefundNo()
    {
        return $this->getParameter('out_refund_no');
    }


    /**
     * @param mixed $outRefundNo
     */
    public function setOutRefundNo($outRefundNo)
    {
        $this->setParameter('out_refund_no', $outRefundNo);
    }


    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->getParameter('transaction_id');
    }


    /**
     * @param mixed $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }


    /**
     * @return mixed
     */
    public function getRefundFee()
    {
        return $this->getParameter('refund_fee');
    }


    /**
     * @param mixed $refundFee
     */
    public function setRefundFee($refundFee)
    {
        $this->setParameter('refund_fee', $refundFee);
    }


    /**
     * @return mixed
     */
    public function getOpUserPasswd()
    {
        return $this->getParameter('op_user_passwd');
    }


    /**
     * @param mixed $opUserPasswd
     */
    public function setOpUserPasswd($opUserPasswd)
    {
        $this->setParameter('op_user_passwd', $opUserPasswd);
    }


    /**
     * @return mixed
     */
    public function getRefundAccount()
    {
        return $this->getParameter('refund_account');
    }


    /**
     * @param mixed $refundAccount
     */
    public function setRefundAccount($refundAccount)
    {
        $this->setParameter('refund_account', $refundAccount);
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

        return $this->response = new RefundOrderResponse($this, $responseData);
    }
}
