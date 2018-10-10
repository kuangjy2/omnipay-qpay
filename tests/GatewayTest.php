<?php

namespace Omnipay\QPay\Tests;

use Omnipay\Omnipay;
use Omnipay\Tests\GatewayTestCase;
use Omnipay\QPay\Gateway;
use Omnipay\QPay\Message\CompletePurchaseResponse;
use Omnipay\QPay\Message\QueryOrderResponse;

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
        $options = array (
            'request_params' => array (
                'appid'       => '123456',
                'mch_id'      => '789456',
                'result_code' => '0'
            ),
        );

        /**
         * @var CompletePurchaseResponse $response
         */
        $response = $this->gateway->completePurchase($options)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testQuery()
    {
        $options = array (
            'transaction_id' => 'transaction_id',
        );

        /**
         * @var QueryOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }
}