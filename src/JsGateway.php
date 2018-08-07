<?php

namespace Omnipay\QPay;

/**
 * Class JsGateway
 * @package Omnipay\QPay
 */
class JsGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'QPay JS API/MP';
    }


    public function getTradeType()
    {
        return 'JSAPI';
    }
}
