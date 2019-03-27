<?php

namespace Omnipay\QPay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class CompleteRedPacketRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/221/1223
 * @method  CompletePurchaseResponse send()
 */
class CompleteRedPacketRequest extends BaseAbstractRequest
{
    public function setRequestParams($requestParams)
    {
        $this->setParameter('request_params', $requestParams);
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $data = $this->getData();
        $sign = Helper::sign($data, $this->getApiKey());

        $responseData = array();

        if (!empty($data['sign']) && $sign === $data['sign']) {
            $responseData['sign_match'] = true;
        } else {
            $responseData['sign_match'] = false;
        }

        if ($responseData['sign_match'] && isset($data['state']) && intval($data['state']) == 1) {
            $responseData['received'] = true;
        } else {
            $responseData['received'] = false;
        }

        return $this->response = new CompleteRedPacketResponse($this, $responseData);
    }


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $data = $this->getRequestParams();

        if (is_string($data)) {
            $data = Helper::xml2array($data);
        }

        return $data;
    }


    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }
}
