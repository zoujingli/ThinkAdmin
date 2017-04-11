<?php
// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\wechat\controller;

use controller\BasicAdmin;
use service\DataService;

/**
 * 微信配置管理
 * Class Config
 * @package app\wechat\controller
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/27 14:43
 */
class Config extends BasicAdmin {

    /**
     * 定义当前操作表名
     * @var string
     */
    protected $table = 'SystemConfig';

    /**
     * 微信基础参数配置
     * @return \think\response\View
     */
    public function index() {
        if ($this->request->isGet()) {
            $this->assign('title', '微信接口配置');
            return view();

        }
        $data = $this->request->post();
        foreach ($data as $key => $vo) {
            DataService::save($this->table, ['name' => $key, 'value' => $vo], 'name');
        }
        $this->success('数据修改成功！', '');
    }

    /**
     * 微信商户参数配置
     * @return \think\response\View
     */
    public function pay() {
        if ($this->request->isGet()) {
            $this->assign('title', '微信支付配置');
            return view();
        }
        $data = $this->request->post();
        if (!empty($data['cert_zip_md5'])) {
            $filename = ROOT_PATH . 'public/upload/' . join('/', str_split($data['cert_zip_md5'], 16)) . '.zip';
            if (file_exists($filename)) {
                $zip = new \PclZip($filename);
                $dirpath = APP_PATH . 'extra/wechat/cert';
                !file_exists($dirpath) && mkdir($dirpath, 0755, true);
                $result = $zip->extract(PCLZIP_OPT_PATH, $dirpath);
                dump($result);
            }
        }
        foreach ($data as $key => $vo) {
            DataService::save($this->table, ['name' => $key, 'value' => $vo], 'name');
        }
        $this->success('数据修改成功！', '');
    }
}
