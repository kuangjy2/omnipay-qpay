<?php

namespace Omnipay\QPay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CompleteRedPacketResponse
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/221/1223
 */
class CompleteRedPacketResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->isReceived();
    }


    public function isReceived()
    {
        $data = $this->getData();

        return $data['received'];
    }


    public function isSignMatch()
    {
        $data = $this->getData();

        return $data['sign_match'];
    }


    public function getRequestData()
    {
        return $this->request->getData();
    }
}
