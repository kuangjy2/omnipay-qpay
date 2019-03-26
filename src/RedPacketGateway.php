<?php

namespace Omnipay\QPay;

/**
 * Class RedPacketGateway
 * @package Omnipay\QPay
 */
class RedPacketGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'QPay Red Packet';
    }


    public function getTradeType()
    {
        return 'REDPACKET';
    }
}
