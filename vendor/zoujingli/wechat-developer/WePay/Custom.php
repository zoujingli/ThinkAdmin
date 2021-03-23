<?php

namespace WePay;

use WeChat\Contracts\BasicWePay;

/**
 * 商户提交订单到海关
 * Class Custom
 * @package WePay
 */
class Custom extends BasicWePay
{

    /**
     * 订单附加信息提交接口
     * @param array $options
     * @return mixed
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function add(array $options = [])
    {
        $url = 'https://api.mch.weixin.qq.com/cgi-bin/mch/customs/customdeclareorder';
        return $this->callPostApi($url, $options, false, 'MD5');
    }

    /**
     * 订单附加信息查询接口
     * @param array $options
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function get(array $options = [])
    {
        $url = 'https://api.mch.weixin.qq.com/cgi-bin/mch/customs/customdeclarequery';
        return $this->callPostApi($url, $options, false, 'MD5');
    }


    /**
     * 订单附加信息重推接口
     * @param array $options
     * @return array
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function reset(array $options = [])
    {
        $url = 'https://api.mch.weixin.qq.com/cgi-bin/mch/newcustoms/customdeclareredeclare';
        return $this->callPostApi($url, $options, false, 'MD5');
    }

}