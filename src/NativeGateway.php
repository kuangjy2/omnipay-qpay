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
}
