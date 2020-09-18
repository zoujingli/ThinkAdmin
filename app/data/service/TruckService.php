<?php

namespace app\data\service;

use think\admin\extend\DataExtend;
use think\admin\Service;
use think\admin\service\InterfaceService;

/**
 * 快递运输服务
 * Class TruckService
 * @package app\data\service
 */
class TruckService extends Service
{
    /**
     * 模拟计算快递费用
     * @return string
     */
    public function amount()
    {
        return '0.00';
    }

    /**
     * 配送区域树型数据
     * @param integer $level 最大级别
     * @param integer $status 状态筛选
     * @return array
     */
    public function region($level = 3, $status = null)
    {
        $query = $this->app->db->name('ShopTruckRegion');
        if (is_numeric($level)) $query->where('level', '<=', $level);
        if (is_numeric($status)) $query->where(['status' => $status]);
        $items = DataExtend::arr2tree($query->column('id,pid,name,status', 'id'), 'id', 'pid', 'subs');
        // 排序子集为空的省份和城市
        foreach ($items as $ik => $item) {
            foreach ($item['subs'] as $ck => $city) {
                if (isset($city['subs']) && empty($city['subs'])) {
                    unset($items[$ik]['subs'][$ck]);
                }
            }
            if (isset($item['subs']) && empty($item['subs'])) {
                unset($items[$ik]);
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
    public function query($code, $number)
    {
        return $this->_getInterface()->doRequest('https://open.cuci.cc/user/api.auth.express/query', [
            'type' => 'free', 'express' => $code, 'number' => $number,
        ]);
    }

    /**
     * 楚才开放平台快递公司
     * @return array
     * @throws \think\admin\Exception
     */
    public function company()
    {
        return $this->_getInterface()->doRequest('https://open.cuci.cc/user/api.auth.express/getCompany');
    }

    /**
     * 获取楚才开放平台接口实例
     * @return InterfaceService
     */
    private function _getInterface(): InterfaceService
    {
        $service = InterfaceService::instance();
        // 测试的账号及密钥，随时可能会变更，请联系客服获取自己的账号和密钥
        $service->setAuth("6998081316132228", "193fc1d9a2aac78475bc8dbeb9a5feb1");
        return $service;
    }

}