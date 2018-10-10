<?php

namespace Omnipay\QPay\Message;

/**
 * Class CreateMicroPayOrderResponse
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/1/1122
 */
class CreateMicroPayOrderResponse extends BaseAbstractResponse
{

    /**
     * @var CreateMicroPayOrderRequest
     */
    protected $request;

    /**
     * @return string|null
     */
    public function getTradeState()
    {
        $data = $this->getData();
        if (isset($data['trade_state'])) {
            return $data['trade_state'];
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        $parentResult = parent::isSuccessful();
        return $parentResult && $this->getTradeState() == 'SUCCESS';
    }

}
