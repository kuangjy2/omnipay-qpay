<?php

namespace Omnipay\QPay;

/**
 * Class TransferGateway
 * @package Omnipay\QPay
 */
class TransferGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'QPay Transfer';
    }


    public function getTradeType()
    {
        return 'TRANSFER';
    }
}
