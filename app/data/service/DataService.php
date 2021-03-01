<?php

namespace app\data\service;

use think\admin\Exception;
use think\admin\Service;
use think\admin\storage\LocalStorage;

/**
 * 基础数据服务
 * Class DataService
 * @package app\agent\service
 */
class DataService extends Service
{
    /**
     * 获取支付配置
     * @return array|void
     * @throws Exception
     */
    public function payment(): array
    {
        try {
            $map = ['type' => PaymentService::PAYMENT_WECHAT_GZH, 'status' => 1, 'deleted' => 0];
            $payment = $this->app->db->name('ShopPayment')->where($map)->order('sort desc,id desc')->find();
            if (empty($payment)) throw new Exception('读取有效的支付参数失败');
            // 解析服务号支付参数
            [, , $params] = PaymentService::config('', $payment);
            if (empty($params)) throw new Exception('读取有效的支付参数失败');
            if (empty($params['wechat_mch_key_text']) || empty($params['wechat_mch_cert_text'])) {
                throw new Exception('微信商户支付证书内容不能为空');
            }
            $k1 = LocalStorage::instance()->set("{$params['code']}_key.pem", $params['wechat_mch_key_text'], true);
            $k2 = LocalStorage::instance()->set("{$params['code']}_cert.pem", $params['wechat_mch_cert_text'], true);
            return [
                'appid'      => $params['wechat_appid'],
                'mch_id'     => $params['wechat_mch_id'],
                'mch_key'    => $params['wechat_mch_key'],
                'ssl_key'    => $k1['file'],
                'ssl_cer'    => $k2['file'],
                'cache_path' => $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . 'wechat',
            ];
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}