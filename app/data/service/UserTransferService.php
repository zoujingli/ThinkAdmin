<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户提现数据服务
 * Class UserTransferService
 * @package app\data\service
 */
class UserTransferService extends Service
{
    /**
     * 提现方式配置
     * @var array
     */
    protected $types = [
        'wechat_wallet'  => '转账到我的微信零钱',
        'wechat_banks'   => '转账到我的银行卡账户',
        'wechat_qrcode'  => '线下转账到微信收款码',
        'alipay_qrcode'  => '线下转账到支付宝收款码',
        'alipay_account' => '线下转账到支付宝账户',
        'transfer_banks' => '线下转账到银行卡账户',
    ];

    /**
     * 获取转账类型
     * @return array
     */
    public function types(): array
    {
        return $this->types;
    }

    /**
     * 获取提现配置
     * @param ?string $name
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config(?string $name = null)
    {
        static $data = [];
        if (empty($data)) $data = sysdata('TransferRule');
        return is_null($name) ? $data : ($data[$name] ?? '');
    }

}