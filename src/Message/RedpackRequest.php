<?php

namespace Omnipay\QPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class RedpackRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/221/1220
 * @method  QueryTransferResponse send()
 */
class RedpackRequest extends BaseAbstractRequest
{
    protected $endpoint = 'htttps://api.qpay.qq.com/cgi-bin/hongbao/qpay_hb_mch_send.cgi';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     * @return mixed
     */
    public function getData()
    {
        $this->validate('mch_id', 'mch_billno', 'total_fee', 'op_user_passwd', 'cert_path', 'key_path');

        $data = array(
            'charset' => 'UTF-8',
            'mch_billno' => $this->getMchBillno(),
            'mch_id' => $this->getMchId(),
            'mch_name' => $this->getMchName(),

            'qqappid' => $this->getQqAppId(),
            're_openid' => $this->getReOpenId(),

            'total_amount' => $this->getTotalAmount(),
            'total_num' => $this->getTotalNum(),

            'wishing' => $this->getWishing(),
            'act_name' => $this->getActName(),

            'icon_id' => $this->getIconId(),
            'banner_id' => $this->getBannerId(),

            'notify_url' => $this->getNotifyUrl(),
            'not_send_msg' => $this->getNotSendMsg(),

            'min_value' => $this->getMinValue(),
            'max_value' => $this->getMaxValue(),
            'nonce_str' => md5(uniqid()),
        );

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }

    /**
     * @return mixed
     */
    public function getMchBillno()
    {
        return $this->getParameter('mch_billno');
    }

    /**
     * @return mixed
     */
    public function getMchName()
    {
        return $this->getParameter('mch_name');
    }

    /**
     * @return mixed
     */
    public function getQqAppId()
    {
        return $this->getParameter('qqappid');
    }

    /**
     * @return mixed
     */
    public function getReOpenId()
    {
        return $this->getParameter('re_openid');
    }

    /**
     * @return mixed
     */
    public function getTotalAmount()
    {
        return $this->getParameter('total_amount');
    }

    /**
     * @return mixed
     */
    public function getTotalNum()
    {
        return $this->getParameter('total_num');
    }

    /**
     * @return mixed
     */
    public function getWishing()
    {
        return $this->getParameter('wishing');
    }

    /**
     * @return mixed
     */
    public function getActName()
    {
        return $this->getParameter('act_name');
    }

    /**
     * @return mixed
     */
    public function getIconId()
    {
        return $this->getParameter('icon_id');
    }

    /**
     * @return mixed
     */
    public function getBannerId()
    {
        return $this->getParameter('banner_id');
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
    public function getNotSendMsg()
    {
        return $this->getParameter('not_send_msg');
    }

    /**
     * @return mixed
     */
    public function getMinValue()
    {
        return $this->getParameter('min_value');
    }

    /**
     * @return mixed
     */
    public function getMaxValue()
    {
        return $this->getParameter('max_value');
    }

    /**
     * @param $mchBillno
     */
    public function setMchBillno($mchBillno)
    {
        $this->setParameter('mch_billno', $mchBillno);
    }

    /**
     * @param $mchName
     */
    public function setMchName($mchName)
    {
        $this->setParameter('mch_name', $mchName);
    }

    /**
     * @param $qqAppId
     */
    public function setQqAppId($qqAppId)
    {
        $this->setParameter('qqappid', $qqAppId);
    }

    /**
     * @param $reOpenId
     * @return RedpackRequest
     */
    public function setReOpenId($reOpenId)
    {
        return $this->setParameter('re_openid', $reOpenId);
    }

    /**
     * @param $totalAmount
     * @return RedpackRequest
     */
    public function setTotalAmount($totalAmount)
    {
        return $this->setParameter('total_amount', $totalAmount);
    }

    /**
     * @param $totalNum
     * @return RedpackRequest
     */
    public function setTotalNum($totalNum)
    {
        return $this->setParameter('total_num', $totalNum);
    }

    /**
     * @param $wishing
     * @return RedpackRequest
     */
    public function setWishing($wishing)
    {
        return $this->setParameter('wishing', $wishing);
    }

    /**
     * @param $actName
     * @return RedpackRequest
     */
    public function setActName($actName)
    {
        return $this->setParameter('act_name', $actName);
    }

    /**
     * @param $iconId
     * @return RedpackRequest
     */
    public function setIconId($iconId)
    {
        return $this->setParameter('icon_id', $iconId);
    }

    /**
     * @param $bannerId
     * @return RedpackRequest
     */
    public function setBannerId($bannerId)
    {
        return $this->setParameter('banner_id', $bannerId);
    }

    /**
     * @param string $notifyUrl
     * @return BaseAbstractRequest|RedpackRequest
     */
    public function setNotifyUrl($notifyUrl)
    {
        return $this->setParameter('notify_url', $notifyUrl);
    }

    /**
     * @param $notSendMsg
     * @return RedpackRequest
     */
    public function setNotSendMsg($notSendMsg)
    {
        return $this->setParameter('not_send_msg', $notSendMsg);
    }

    /**
     * @param $minValue
     * @return RedpackRequest
     */
    public function setMinValue($minValue)
    {
        return $this->setParameter('min_value', $minValue);
    }

    /**
     * @param $maxValue
     * @return mixed
     */
    public function setMaxValue($maxValue)
    {
        return $this->setParameter('max_value', $maxValue);
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

        return $this->response = new RedpackResponse($this, $payload);
    }
}
