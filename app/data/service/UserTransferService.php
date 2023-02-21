<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\data\service;

use app\data\model\DataUserTransfer;
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
     * 微信提现银行
     * @var array
     */
    protected $banks = [
        ['wseq' => '1002', 'name' => '工商银行'],
        ['wseq' => '1005', 'name' => '农业银行'],
        ['wseq' => '1003', 'name' => '建设银行'],
        ['wseq' => '1026', 'name' => '中国银行'],
        ['wseq' => '1020', 'name' => '交通银行'],
        ['wseq' => '1001', 'name' => '招商银行'],
        ['wseq' => '1066', 'name' => '邮储银行'],
        ['wseq' => '1006', 'name' => '民生银行'],
        ['wseq' => '1010', 'name' => '平安银行'],
        ['wseq' => '1021', 'name' => '中信银行'],
        ['wseq' => '1004', 'name' => '浦发银行'],
        ['wseq' => '1009', 'name' => '兴业银行'],
        ['wseq' => '1022', 'name' => '光大银行'],
        ['wseq' => '1027', 'name' => '广发银行'],
        ['wseq' => '1025', 'name' => '华夏银行'],
        ['wseq' => '1056', 'name' => '宁波银行'],
        ['wseq' => '4836', 'name' => '北京银行'],
        ['wseq' => '1024', 'name' => '上海银行'],
        ['wseq' => '1054', 'name' => '南京银行'],

        // '4755' => '长子县融汇村镇银行',
        // '4216' => '长沙银行',
        // '4051' => '浙江泰隆商业银行',
        // '4753' => '中原银行',
        // '4761' => '企业银行（中国）',
        // '4036' => '顺德农商银行',
        // '4752' => '衡水银行',
        // '4756' => '长治银行',
        // '4767' => '大同银行',
        // '4115' => '河南省农村信用社',
        // '4150' => '宁夏黄河农村商业银行',
        // '4156' => '山西省农村信用社',
        // '4166' => '安徽省农村信用社',
        // '4157' => '甘肃省农村信用社',
        // '4153' => '天津农村商业银行',
        // '4113' => '广西壮族自治区农村信用社',
        // '4108' => '陕西省农村信用社',
        // '4076' => '深圳农村商业银行',
        // '4052' => '宁波鄞州农村商业银行',
        // '4764' => '浙江省农村信用社联合社',
        // '4217' => '江苏省农村信用社联合社',
        // '4072' => '江苏紫金农村商业银行股份有限公司',
        // '4769' => '北京中关村银行股份有限公司',
        // '4778' => '星展银行（中国）有限公司',
        // '4766' => '枣庄银行股份有限公司',
        // '4758' => '海口联合农村商业银行股份有限公司',
        // '4763' => '南洋商业银行（中国）有限公司',
    ];

    /**
     * 获取微信提现银行
     * @param string|null $wsea
     * @return array|string
     */
    public function banks(?string $wsea = null)
    {
        if (is_null($wsea)) return $this->banks;
        foreach ($this->banks as $bank) if ($bank['wseq'] === $wsea) {
            return $bank['name'];
        }
        return $wsea;
    }

    /**
     * 获取转账类型
     * @param string|null $name
     * @return array|string
     */
    public function types(?string $name = null)
    {
        return is_null($name) ? $this->types : ($this->types[$name] ?? $name);
    }

    /**
     * 同步刷新用户返利
     * @param integer $uuid
     * @return array [total, count, audit, locks]
     */
    public static function amount(int $uuid): array
    {
        if ($uuid > 0) {
            $locks = abs(DataUserTransfer::mk()->whereRaw("uuid='{$uuid}' and status=3")->sum('amount'));
            $total = abs(DataUserTransfer::mk()->whereRaw("uuid='{$uuid}' and status>=1")->sum('amount'));
            $count = abs(DataUserTransfer::mk()->whereRaw("uuid='{$uuid}' and status>=4")->sum('amount'));
            $audit = abs(DataUserTransfer::mk()->whereRaw("uuid='{$uuid}' and status>=1 and status<3")->sum('amount'));
        } else {
            $locks = abs(DataUserTransfer::mk()->whereRaw("status=3")->sum('amount'));
            $total = abs(DataUserTransfer::mk()->whereRaw("status>=1")->sum('amount'));
            $count = abs(DataUserTransfer::mk()->whereRaw("status>=4")->sum('amount'));
            $audit = abs(DataUserTransfer::mk()->whereRaw("status>=1 and status<3")->sum('amount'));
        }
        return [$total, $count, $audit, $locks];
    }

    /**
     * 获取提现配置
     * @param ?string $name
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function config(?string $name = null)
    {
        static $data = [];
        if (empty($data)) $data = sysdata('TransferRule');
        return is_null($name) ? $data : ($data[$name] ?? '');
    }

    /**
     * 获取转账配置
     * @param ?string $name
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function payment(?string $name = null)
    {
        static $data = [];
        if (empty($data)) $data = sysdata('TransferWxpay');
        return is_null($name) ? $data : ($data[$name] ?? '');
    }
}