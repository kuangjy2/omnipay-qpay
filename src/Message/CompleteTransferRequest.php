<?php

namespace Omnipay\QPay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class CompleteTransferRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/206/1217
 * @method  CompleteTransferResponse send()
 */
class CompleteTransferRequest extends BaseAbstractRequest
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

        if ($responseData['sign_match'] && isset($data['state']) && $data['state'] == 'RECEIVED') {
            $responseData['received'] = true;
        } else {
            $responseData['received'] = false;
        }

        return $this->response = new CompleteTransferResponse($this, $responseData);
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
