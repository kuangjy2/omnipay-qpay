<?php

namespace Omnipay\QPay;

/**
 * Class MicroPayGateway
 * @package Omnipay\QPay
 */
class MicroPayGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'QPay MicroPay';
    }


    public function getTradeType()
    {
        return 'MICROPAY';
    }

    /**
     * @param array $parameters
     *
     * @return \Omnipay\QPay\Message\CreateMicroPayOrderRequest
     */
    public function purchase($parameters = array())
    {
        $parameters['trade_type'] = $this->getTradeType();

        return $this->createRequest('\Omnipay\QPay\Message\CreateMicroPayOrderRequest', $parameters);
    }
}
