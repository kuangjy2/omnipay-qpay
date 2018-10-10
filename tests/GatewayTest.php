<?php

namespace Omnipay\QPay\Tests;

use Omnipay\Omnipay;
use Omnipay\QPay\Gateway;
use Omnipay\QPay\Helper;
use Omnipay\QPay\Message\CompletePurchaseResponse;
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
        $this->gateway->setMchId('mchid');
        $this->gateway->setApiKey('apikey');
    }

    public function testCompletePurchase()
    {
        $options = array(
            'request_params' => array(
                'appid' => '123456',
                'mch_id' => '789456',
                'trade_state' => 'Success',
            ),
        );
        $options['request_params']['sign'] = Helper::sign($options['request_params'], $this->gateway->getApiKey());

        /**
         * @var CompletePurchaseResponse $response
         */
        $response = $this->gateway->completePurchase($options)->send();
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