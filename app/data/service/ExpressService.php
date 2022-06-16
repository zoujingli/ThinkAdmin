<?php

namespace app\data\service;

use app\data\model\BasePostageRegion;
use app\data\model\BasePostageTemplate;
use think\admin\extend\DataExtend;
use think\admin\Service;
use think\admin\service\InterfaceService;

/**
 * 快递查询数据服务
 * Class ExpressService
 * @package app\data\service
 */
class ExpressService extends Service
{
    /**
     * 模拟计算快递费用
     * @param array $codes 模板编号
     * @param string $provName 省份名称
     * @param string $cityName 城市名称
     * @param integer $truckCount 邮费基数
     * @return array [邮费金额, 计费基数, 模板编号, 计费描述]
     */
    public static function amount(array $codes, string $provName, string $cityName, int $truckCount = 0): array
    {
        if (empty($codes)) return [0, $truckCount, '', '邮费模板编码为空！'];
        $map = [['status', '=', 1], ['deleted', '=', 0], ['code', 'in', $codes]];
        $template = BasePostageTemplate::mk()->where($map)->order('sort desc,id desc')->findOrEmpty();
        if ($template->isEmpty()) return [0, $truckCount, '', '邮费模板编码无效！'];
        $rule = json_decode($template['normal'] ?: '[]', true) ?: [];
        foreach (json_decode($template['content'] ?: '[]', true) ?: [] as $item) {
            if (isset($item['city']) && is_array($item['city'])) foreach ($item['city'] as $city) {
                if ($city['name'] === $provName && in_array($cityName, $city['subs'])) {
                    $rule = $item['rule'];
                    break 2;
                }
            }
        }
        [$firstNumber, $firstAmount] = [$rule['firstNumber'] ?: 0, $rule['firstAmount'] ?: 0];
        [$repeatNumber, $repeatAmount] = [$rule['repeatNumber'] ?: 0, $rule['repeatAmount'] ?: 0];
        if ($truckCount <= $firstNumber) {
            return [$firstAmount, $truckCount, $template['code'], "首件计费，不超过{$firstNumber}件"];
        } else {
            $amount = $repeatNumber > 0 ? $repeatAmount * ceil(($truckCount - $firstNumber) / $repeatNumber) : 0;
            return [$firstAmount + $amount, $truckCount, $template['code'], "续件计费，超出{$firstNumber}件续件{$amount}元"];
        }
    }


    /**
     * 获取快递模板数据
     * @return array
     */
    public static function templates(): array
    {
        $query = BasePostageTemplate::mk()->where(['status' => 1, 'deleted' => 0]);
        return $query->order('sort desc,id desc')->column('code,name,normal,content', 'code');
    }

    /**
     * 配送区域树型数据
     * @param integer $level 最大等级
     * @param null|integer $status 状态筛选
     * @return array
     */
    public static function region(int $level = 3, ?int $status = null): array
    {
        $query = BasePostageRegion::mk();
        if (is_numeric($level)) $query->where('level', '<=', $level);
        if (is_numeric($status)) $query->where(['status' => $status]);
        $items = DataExtend::arr2tree($query->column('id,pid,name,status', 'id'), 'id', 'pid', 'subs');
        // 排序子集为空的省份和城市
        foreach ($items as $ik => $item) {
            foreach ($item['subs'] as $ck => $city) {
                if (isset($city['subs']) && empty($city['subs'])) unset($items[$ik]['subs'][$ck]);
            }
            if (isset($item['subs']) && empty($item['subs'])) unset($items[$ik]);
        }
        return $items;
    }

    /**
     * 楚才开放平台快递查询
     * @param string $code 快递公司编号
     * @param string $number 快递配送单号
     * @return array
     * @throws \think\admin\Exception
     */
    public static function query(string $code, string $number): array
    {
        return static::getInterface()->doRequest('api.auth.express/query', [
            'type' => 'free', 'express' => $code, 'number' => $number,
        ]);
    }

    /**
     * 楚才开放平台快递公司
     * @return array
     * @throws \think\admin\Exception
     */
    public static function company(): array
    {
        return static::getInterface()->doRequest('api.auth.express/getCompany');
    }

    /**
     * 获取楚才开放平台接口实例
     * @return InterfaceService
     */
    private static function getInterface(): InterfaceService
    {
        $service = InterfaceService::instance();
        // 测试的账号及密钥随时可能会变更，请联系客服更新
        $service->getway('https://open.cuci.cc/user/');
        $service->setAuth("6998081316132228", "193fc1d9a2aac78475bc8dbeb9a5feb1");
        return $service;
    }
}