<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户转账服务
 * Class UserTransferService
 * @package app\data\service
 */
class UserTransferService extends Service
{

    protected $types = [
        'wechat_wallet'  => '转账到我的微信零钱',
        'wechat_qrcode'  => '线下微信收款码转账',
        'alipay_qrcode'  => '线下支付宝收款码转账',
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
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config(): array
    {
        return sysdata('TransferRule');
    }

}