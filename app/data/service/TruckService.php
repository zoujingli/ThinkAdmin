<?php

namespace app\data\service;

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
     * 楚才开放平台接口账号
     * 测试的账号及密钥，随时可能会变更，请联系客服获取自己的账号和密钥
     * @var string
     */
    protected $appid = '6998081316132228';

    /**
     * 楚才开放平台接口密钥
     * 测试的账号及密钥，随时可能会变更，请联系客服获取自己的账号和密钥
     * @var string
     */
    protected $appkey = '193fc1d9a2aac78475bc8dbeb9a5feb1';

    public function amount()
    {

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
        $service = InterfaceService::instance();
        $service->setAuth($this->appid, $this->appkey);
        return $service->doRequest('https://open.cuci.cc/user/api.auth.express/query', [
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
        $service = InterfaceService::instance();
        $service->setAuth($this->appid, $this->appkey);
        return $service->doRequest('https://open.cuci.cc/user/api.auth.express/getCompany');
    }

}