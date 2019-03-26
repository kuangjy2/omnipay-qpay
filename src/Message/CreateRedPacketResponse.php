<?php

namespace Omnipay\QPay\Message;

/**
 * Class CreateRedPacketResponse
 *
 * @package Omnipay\QPay\Message
 * @link    https://qpay.qq.com/buss/wiki/221/1220
 */
class CreateRedPacketResponse extends BaseAbstractResponse
{

    /**
     * @var CreateRedPacketRequest
     */
    protected $request;

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $data = $this->getData();

        return isset($data['return_code']) && $data['return_code'] == 'SUCCESS';
    }

    /**
     * Return the red packet ID
     *
     * @return string|null
     */
    public function getListId()
    {
        if ($this->isSuccessful()) {
            $data = $this->getData();

            return $data['listid'];
        } else {
            return null;
        }
    }

    /**
     * Return an H5 page for opening red packet
     *
     * @return string|null
     */
    public function getRedPacketUrl()
    {
        if (!empty($this->getListId())) {
            return 'https://mqq.tenpay.com/mqq/hongbao/receive.shtml?_wv=2098179&c=2&l=' . $this->getListId();
        } else {
            return null;
        }
    }
}
