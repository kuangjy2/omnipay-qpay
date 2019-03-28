<?php

namespace Omnipay\QPay\Tests;

use Omnipay\Omnipay;
use Omnipay\QPay\Gateway;
use Omnipay\QPay\Message\CompletePurchaseResponse;
use Omnipay\QPay\Message\CompleteRedPacketResponse;
use Omnipay\QPay\Message\CompleteTransferResponse;
use Omnipay\QPay\Message\QueryOrderResponse;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{

    /**
     * @var Gateway $gateway
     */
    protected $gateway;

    protected $options;

    public function setUp()
    {
        parent::setUp();
        $this->gateway = Omnipay::create('QPay');
        $this->gateway->setMchId('12345678');
        $this->gateway->setApiKey('1234567890abcdef1234567890abcdef');
    }

    public function testCompletePurchase()
    {
        $options = [
            'request_params' => '<xml><appid><![CDATA[12345678]]></appid>
    <bank_type><![CDATA[BALANCE]]></bank_type>
    <cash_fee><![CDATA[1]]></cash_fee>
    <fee_type><![CDATA[CNY]]></fee_type>
    <mch_id><![CDATA[12345678]]></mch_id>
    <nonce_str><![CDATA[7b14db232445d79c5c86d22bbd8898d3]]></nonce_str>
    <out_trade_no><![CDATA[20161025_qpay_unified_order_A]]></out_trade_no>
    <sign><![CDATA[5F30A60C8F27FE28B5218B0DC430B8D9]]></sign>
    <time_end><![CDATA[20161025094946]]></time_end>
    <total_fee><![CDATA[1]]></total_fee>
    <trade_state><![CDATA[SUCCESS]]></trade_state>
    <trade_type><![CDATA[NATIVE]]></trade_type>
    <transaction_id><![CDATA[1900000109471610251307259064]]></transaction_id></xml>'
        ];

        /**
         * @var CompletePurchaseResponse $response
         */
        $response = $this->gateway->completePurchase($options)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCompleteTransfer()
    {
        $options = [
            'request_params' => '<xml><mch_id><![CDATA[12345678]]></mch_id>
    <mch_billno><![CDATA[29840058602]]></mch_billno>
    <listid><![CDATA[10000436560988432048]]></listid>
    <recv_uin><![CDATA[2344546]]></recv_uin>
    <total_fee><![CDATA[10]]></total_fee>
    <time_end><![CDATA[20161025094946]]></time_end>
    <state><![CDATA[RECEIVED]]></state>
    <refund_reason><![CDATA[transfer fail]]></refund_reason>
    <sign><![CDATA[E7F7C83D156B624D21C4D48BF11AA507]]></sign>
    <sign_type><![CDATA[MD5]]></sign_type></xml>'
        ];

        /**
         * @var CompleteTransferResponse $response
         */

        $response = $this->gateway->completeTransfer($options)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCompleteRedPacket()
    {
        $options = [
            'request_params' => '<xml><mch_id><![CDATA[12345678]]></mch_id>
    <mch_billno><![CDATA[29840058602]]></mch_billno>
    <listid><![CDATA[10000436560988432048]]></listid>
    <recv_uin><![CDATA[2344546]]></recv_uin>
    <total_fee><![CDATA[10]]></total_fee>
    <time_end><![CDATA[20161025094946]]></time_end>
    <state><![CDATA[RECEIVED]]></state>
    <refund_reason><![CDATA[transferfail]]></refund_reason>
   <sign><![CDATA[E78B942C7BB9CDD2C47D7D18CC52F577]]></sign>
   <sign_type><![CDATA[MD5]]></sign_type></xml>'
        ];

        /**
         * @var CompleteRedPacketResponse $response
         */
        $response = $this->gateway->completeRedPacket($options)->send();
        var_dump($response->isSignMatch());
        $this->assertTrue($response->isSuccessful());
    }

    public function testQuery()
    {
        $options = array(
            'transaction_id' => 'transaction_id',
        );

        /**
         * @var QueryOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }
}