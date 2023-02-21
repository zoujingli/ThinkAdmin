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

use app\data\model\BasePostageTemplate;
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
     * @param ?integer $status 状态筛选
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function region(int $level = 3, ?int $status = null): array
    {
        [$items, $ncodes] = [[], sysdata('data.NotRegion')];
        foreach (json_decode(file_get_contents(syspath('public/static/plugs/jquery/area/data.json')), true) as $prov) {
            $pstat = intval(!in_array($prov['code'], $ncodes));
            if (is_null($status) || is_numeric($status) && $status === $pstat) {
                $mprov = ['id' => $prov['code'], 'pid' => 0, 'name' => $prov['name'], 'status' => $pstat, 'subs' => []];
                if ($level > 1) foreach ($prov['list'] as $city) {
                    $cstat = intval(!in_array($city['code'], $ncodes));
                    if (is_null($status) || is_numeric($status) && $status === $cstat) {
                        $mcity = ['id' => $city['code'], 'pid' => $prov['code'], 'name' => $city['name'], 'status' => $cstat, 'subs' => []];
                        if ($level > 2) foreach ($city['list'] as $area) {
                            $astat = intval(!in_array($area['code'], $ncodes));
                            if (is_null($status) || is_numeric($status) && $status === $astat) {
                                $mcity['subs'][] = ['id' => $area['code'], 'pid' => $city['code'], 'status' => $astat, 'name' => $area['name']];
                            }
                        }
                        $mprov['subs'][] = $mcity;
                    }
                }
                $items[] = $mprov;
            }
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