# Omnipay: QPay

**QPay(QQ Wallet) driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/kuangjy2/omnipay-qpay.svg?branch=master)](https://travis-ci.org/kuangjy2/omnipay-qpay)
[![Latest Stable Version](https://poser.pugx.org/kuangjy/omnipay-qpay/v/stable)](https://packagist.org/packages/kuangjy/omnipay-qpay)
[![Latest Unstable Version](https://poser.pugx.org/kuangjy/omnipay-qpay/v/unstable)](https://packagist.org/packages/kuangjy/omnipay-qpay)
[![License](https://poser.pugx.org/kuangjy/omnipay-qpay/license)](https://packagist.org/packages/kuangjy/omnipay-qpay)

[Omnipay](https://github.com/omnipay/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements QPay support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install:

    composer require kuangjy/omnipay-qpay

## Basic Usage

The following gateways are provided by this package:


* QPay (QPay Common Gateway) QQ钱包支付通用网关
* QPay_App (QPay App Gateway) QQ钱包APP支付网关
* QPay_Native (QPay Native Gateway) QQ钱包原生扫码支付网关
* QPay_Js (QPay Js API/MP Gateway) QQ钱包公众号支付网关
* QPay_MicroPay (QPay Micro/POS Gateway) QQ钱包付款码支付网关
* QPay_RedPacket (QPay Red Packet) QQ钱包现金红包网关
* QPay_Transfer (QPay Transfer) QQ钱包企业付款到余额网关

## Usage

### Create Order [doc](https://qpay.qq.com/buss/wiki/38/1203)

```php
//gateways: QPay_App, QPay_Native, QPay_Js
$gateway = Omnipay::create('QPay_Native');
$gateway->setAppId('app_id'); //required for QPay_App only
$gateway->setAppKey('app_key'); //required for QPay_App only
$gateway->setMchId('mch_id');
$gateway->setApiKey('api_key');

$order = [
    'out_trade_no' => time() . mt_rand(1000, 9999),
    'body' => 'order information',
    'attach' => 'attached information',
    'total_fee' => '100',
    'spbill_create_ip' => '127.0.0.1',
    'notify_url' => 'http://example.com/notify.php',
];

/**
 * @var Omnipay\QPay\Message\CreateOrderRequest $request
 * @var Omnipay\QPay\Message\CreateOrderResponse $response
 */
$request  = $gateway->purchase($order);
$response = $request->send();

//available methods
$response->isSuccessful();
$response->getData(); //For debug
$response->getPrepayId(); //Prepay ID
$response->getAppData(); //For QPay_App
$response->getJsOrderData(); //For QPay_Js
$response->getCodeUrl(); //For QPay_Native
```

### Create MicroPay Order [doc](https://qpay.qq.com/buss/wiki/1/1122)

```php
//gateways: QPay_MicroPay
$gateway = Omnipay::create('QPay_MicroPay');
$gateway->setMchId('mch_id');
$gateway->setApiKey('api_key');

$order = [
    'out_trade_no' => time() . mt_rand(1000, 9999),
    'body' => '商品描述',
    'attach' => '附加信息',
    'total_fee' => '100',
    'spbill_create_ip' => '127.0.0.1',
    'notify_url' => 'http://example.com/notify.php',
    'device_info' => '001',
    'auth_code' => '910783818928826810'
];

/**
 * @var Omnipay\QPay\Message\CreateMicroPayOrderRequest $request
 * @var Omnipay\QPay\Message\CreateMicroPayOrderResponse $response
 */
$request  = $gateway->purchase($order);
$response = $request->send();

//available methods
$response->isSuccessful(); //Get result
$response->getData(); //For debug
```

### Create Transfer [doc](https://qpay.qq.com/buss/wiki/206/1215)

```php
//gateways: QPay_Transfer
$gateway = Omnipay::create('QPay_Transfer');
$gateway->setMchId('mch_id');
$gateway->setApiKey('api_key');
$gateway->setCertPath($certPath);//证书cert路径
$gateway->setKeyPath($keyPath);//证书key路径

$order = [
    'out_trade_no' => time() . mt_rand(1000, 9999),
    'uin' => '123456789',
    'memo' => '转账描述',
    'total_fee' => '100',
    'spbill_create_ip' => '127.0.0.1',
];

/**
 * @var Omnipay\QPay\Message\CreateTransferRequest $request
 * @var Omnipay\QPay\Message\CreateTransferResponse $response
 */
$request  = $gateway->transfer($order);
$response = $request->send();

//available methods
$response->isSuccessful(); //Get result
$response->getData(); //For debug
```

```php
//gateways: QPay_RedPacket
$gateway = Omnipay::create('QPay_RedPacket');
$gateway->setMchId('mch_id');
$gateway->setApiKey('api_key');
$gateway->setCertPath($certPath);//证书cert路径
$gateway->setKeyPath($keyPath);//证书key路径

$order = [
    'mch_billno' => '1441246101201610101234567890',//组成:mch_id+yyyymmdd+10位一天内不能重复的的数字
    'mch_name' => '测试商户',
    're_openid' => '123456789',
    'total_amount' => '100',
    'total_num' => '10',
    'wishing' => '红包祝福语',
    'act_name' => '活动名称',
    'icon_id' => '23',
    'min_value' => '1',
    'max_value' => '100'
];

/**
 * @var Omnipay\QPay\Message\CreateRedPacketRequest $request
 * @var Omnipay\QPay\Message\CreateRedPacketResponse $response
 */
$request  = $gateway->redPacket($order);
$response = $request->send();

//available methods
$response->isSuccessful(); //Get result
$response->getData(); //For debug
```

### Notify [doc](https://qpay.qq.com/buss/wiki/38/1204)
```php
$gateway = Omnipay::create('QPay');
$gateway->setAppId('app_id');
$gateway->setMchId('mch_id');
$gateway->setApiKey('api_key');

$response = $gateway->completePurchase([
    'request_params' => file_get_contents('php://input')
])->send();

if ($response->isPaid()) {
    //pay success
    var_dump($response->getRequestData());
}else{
    //pay fail
}
```

### Query Order [doc](https://qpay.qq.com/buss/wiki/38/1205)
```php
$response = $gateway->query([
    'transaction_id' => '1217752501201407033233368018',
])->send();

var_dump($response->isSuccessful());
var_dump($response->getData());
```


### Close Order [doc](https://qpay.qq.com/buss/wiki/38/1206)
```php
$response = $gateway->close([
    'out_trade_no' => '20150806125346',
])->send();

var_dump($response->isSuccessful());
var_dump($response->getData());
```

### Refund [doc](https://qpay.qq.com/buss/wiki/38/1207)
```php
$gateway->setCertPath($certPath);
$gateway->setKeyPath($keyPath);

$response = $gateway->refund([
    'transaction_id' => '1353933301461607211903715555',
    'out_refund_no' => $outRefundNo,
    'refund_fee' => 100,
    'op_user_id' => '1900000109',
    'op_user_passwd' => 'e47fefadd66e024bb2b85dfeb5fe86ba'
])->send();

var_dump($response->isSuccessful());
var_dump($response->getData());
```

### QueryRefund [doc](https://qpay.qq.com/buss/wiki/38/1208)
```php
$response = $gateway->queryRefund([
    'refund_id' => '1121218133801201611098791376',
])->send();

var_dump($response->isSuccessful());
var_dump($response->getData());
```

For general usage instructions, please see the main [Omnipay](https://github.com/omnipay/omnipay)
repository.

## Related

This project is based on [lokielse/omnipay-wechatpay](https://github.com/lokielse/omnipay-wechatpay).
Thanks for [Loki Else's](https://github.com/lokielse) wonderful works.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/lokielse/omnipay-wechatpay/issues),
or better yet, fork the library and submit a pull request.