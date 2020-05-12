<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\admin\Controller;
use think\admin\service\SystemService;

/**
 * 系统参数配置
 * Class Config
 * @package app\admin\controller
 */
class Config extends Controller
{

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'SystemConfig';

    /**
     * 阿里数据中心
     * @var array
     */
    protected $points = [
        'oss-cn-hangzhou.aliyuncs.com'    => '华东 1（杭州）',
        'oss-cn-shanghai.aliyuncs.com'    => '华东 2（上海）',
        'oss-cn-qingdao.aliyuncs.com'     => '华北 1（青岛）',
        'oss-cn-beijing.aliyuncs.com'     => '华北 2（北京）',
        'oss-cn-zhangjiakou.aliyuncs.com' => '华北 3（张家口）',
        'oss-cn-huhehaote.aliyuncs.com'   => '华北 5（呼和浩特）',
        'oss-cn-shenzhen.aliyuncs.com'    => '华南 1（深圳）',
        'oss-cn-chengdu.aliyuncs.com'     => '西南 1（成都）',
        'oss-cn-hongkong.aliyuncs.com'    => '中国（香港）',
        'oss-us-west-1.aliyuncs.com'      => '美国西部 1（硅谷）',
        'oss-us-east-1.aliyuncs.com'      => '美国东部 1（弗吉尼亚）',
        'oss-ap-southeast-1.aliyuncs.com' => '亚太东南 1（新加坡）',
        'oss-ap-southeast-2.aliyuncs.com' => '亚太东南 2（悉尼）',
        'oss-ap-southeast-3.aliyuncs.com' => '亚太东南 3（吉隆坡）',
        'oss-ap-southeast-5.aliyuncs.com' => '亚太东南 5（雅加达）',
        'oss-ap-northeast-1.aliyuncs.com' => '亚太东北 1（日本）',
        'oss-ap-south-1.aliyuncs.com'     => '亚太南部 1（孟买）',
        'oss-eu-central-1.aliyuncs.com'   => '欧洲中部 1（法兰克福）',
        'oss-eu-west-1.aliyuncs.com'      => '英国（伦敦）',
        'oss-me-east-1.aliyuncs.com'      => '中东东部 1（迪拜）'
    ];

    /**
     * 系统参数配置
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '系统参数配置';
        $this->fetch();
    }

    /**
     * 修改系统参数
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function system()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->title = '修改系统参数';
            $this->fetch();
        } else {
            if ($xpath = $this->request->post('xpath')) {
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]+$/', $xpath)) {
                    $this->error('后台入口名称需要是由英文字母开头！');
                }
                if ($xpath !== 'admin' && file_exists($this->app->getBasePath() . $xpath)) {
                    $this->error("后台入口名称{$xpath}已经存在应用！");
                }
                SystemService::instance()->setRuntime([$xpath => 'admin']);
            }
            foreach ($this->request->post() as $name => $value) sysconf($name, $value);
            $this->success('修改系统参数成功！', sysuri("{$xpath}/index/index") . '#' . url("{$xpath}/config/index"));
        }
    }

    /**
     * 修改文件存储
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function storage()
    {
        $this->_applyFormToken();
        if ($this->request->isGet()) {
            $this->type = input('type', 'local');
            $this->fetch("storage-{$this->type}");
        }
        $post = $this->request->post();
        if (!empty($post['storage']['allow_exts'])) {
            $exts = array_unique(explode(',', strtolower($post['storage']['allow_exts'])));
            if (in_array('php', $exts)) $this->error('禁止上传可执行文件到本地服务器！');
            sort($exts);
            $post['storage']['allow_exts'] = join(',', $exts);
        }
        foreach ($post as $name => $value) sysconf($name, $value);
        $this->success('修改文件存储成功！');
    }

}
