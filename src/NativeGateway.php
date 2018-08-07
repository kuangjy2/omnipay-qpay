<?php

namespace Omnipay\QPay;

/**
 * Class NativeGateway
 * @package Omnipay\QPay
 */
class NativeGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'QPay Native';
    }


    public function getTradeType()
    {
        return 'NATIVE';
    }


    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\ShortenUrlRequest
     */
    public function shortenUrl($parameters = array())
    {
        return $this->createRequest('\Omnipay\QPay\Message\ShortenUrlRequest', $parameters);
    }
}
