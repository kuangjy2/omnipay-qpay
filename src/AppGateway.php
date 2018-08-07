<?php

namespace Omnipay\QPay;

/**
 * Class AppGateway
 * @package Omnipay\QPay
 */
class AppGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'QPay App';
    }


    public function getTradeType()
    {
        return 'APP';
    }
}
