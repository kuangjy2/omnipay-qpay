<?php

namespace Omnipay\QPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\QPay\Helper;

/**
 * Class DownloadTransferBillRequest
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/206/1218
 * @method  DownloadTransferBillResponse send()
 */
class DownloadTransferBillRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://qpay.qq.com/cgi-bin/pay/qpay_epay_statement_down.cgi';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return mixed
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('mch_id', 'bill_date');

        $data = array(
            'mch_id' => $this->getMchId(),
            'bill_date' => $this->getBillDate(),
            'nonce_str' => md5(uniqid()),
        );

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return mixed
     */
    public function getDeviceInfo()
    {
        return $this->getParameter('device_Info');
    }


    /**
     * @param mixed $deviceInfo
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->setParameter('device_Info', $deviceInfo);
    }


    /**
     * @return mixed
     */
    public function getBillDate()
    {
        return $this->getParameter('bill_date');
    }


    /**
     * @param mixed $billDate
     */
    public function setBillDate($billDate)
    {
        $this->setParameter('bill_date', $billDate);
    }


    /**
     * @return mixed
     */
    public function getBillType()
    {
        return $this->getParameter('bill_type');
    }


    /**
     * @param mixed $billType
     */
    public function setBillType($billType)
    {
        $this->setParameter('bill_type', $billType);
    }


    /**
     * @return mixed
     */
    public function getTarType()
    {
        return $this->getParameter('tar_type');
    }


    /**
     * @param mixed $tarType
     */
    public function setTarType($tarType)
    {
        $this->setParameter('tar_type', $tarType);
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
        $request = $this->httpClient->post($this->endpoint)->setBody(Helper::array2xml($data));
        $response = $request->send()->getBody();

        if (preg_match('#retcode#', $response)) {
            $responseData = Helper::xml2array($response);
            $responseData['return_code'] = 'FAIL';
        } else {
            $responseData = ['return_code' => 'SUCCESS', 'result_code' => 'SUCCESS', 'raw' => $response];
        }

        return $this->response = new DownloadTransferBillResponse($this, $responseData);
    }
}
