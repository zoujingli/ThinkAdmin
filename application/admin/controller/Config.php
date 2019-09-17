<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use library\Controller;
use think\exception\HttpResponseException;
use think\facade\Request;

/**
 * 系统参数配置
 * Class Config
 * @package app\admin\controller
 */
class Config extends Controller
{
    /**
     * 默认数据模型
     * @var string
     */
    protected $table = 'SystemConfig';

    /**
     * 阿里云OSS上传点
     * @var array
     */
    protected $ossPoints = [
        'oss-cn-hangzhou.aliyuncs.com'    => '华东 1 杭州',
        'oss-cn-shanghai.aliyuncs.com'    => '华东 2 上海',
        'oss-cn-qingdao.aliyuncs.com'     => '华北 1 青岛',
        'oss-cn-beijing.aliyuncs.com'     => '华北 2 北京',
        'oss-cn-zhangjiakou.aliyuncs.com' => '华北 3 张家口',
        'oss-cn-huhehaote.aliyuncs.com'   => '华北 5 呼和浩特',
        'oss-cn-shenzhen.aliyuncs.com'    => '华南 1 深圳',
        'oss-cn-hongkong.aliyuncs.com'    => '香港 1',
        'oss-us-west-1.aliyuncs.com'      => '美国西部 1 硅谷',
        'oss-us-east-1.aliyuncs.com'      => '美国东部 1 弗吉尼亚',
        'oss-ap-southeast-1.aliyuncs.com' => '亚太东南 1 新加坡',
        'oss-ap-southeast-2.aliyuncs.com' => '亚太东南 2 悉尼',
        'oss-ap-southeast-3.aliyuncs.com' => '亚太东南 3 吉隆坡',
        'oss-ap-southeast-5.aliyuncs.com' => '亚太东南 5 雅加达',
        'oss-ap-northeast-1.aliyuncs.com' => '亚太东北 1 日本',
        'oss-ap-south-1.aliyuncs.com'     => '亚太南部 1 孟买',
        'oss-eu-central-1.aliyuncs.com'   => '欧洲中部 1 法兰克福',
        'oss-eu-west-1.aliyuncs.com'      => '英国 1 伦敦',
        'oss-me-east-1.aliyuncs.com'      => '中东东部 1 迪拜',
    ];

    /**
     * 系统参数配置
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function info()
    {
        $this->applyCsrfToken();
        if (Request::isGet()) {
            $this->title = '系统参数配置';
            $this->fetch();
        } else {
            foreach (Request::post() as $key => $value) {
                sysconf($key, $value);
            }
            $this->success('系统参数配置成功！');
        }
    }

    /**
     * 文件存储引擎
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function file()
    {
        $this->applyCsrfToken();
        if (Request::isGet()) {
            $this->type = input('type', 'local');
            $this->fetch("storage-{$this->type}");
        }
        $post = Request::post();
        if (isset($post['storage_type']) && isset($post['storage_local_exts'])) {
            $exts = array_unique(explode(',', strtolower($post['storage_local_exts'])));
            sort($exts);
            if (in_array('php', $exts)) $this->error('禁止上传可执行文件到本地服务器！');
            $post['storage_local_exts'] = join(',', $exts);
        }
        foreach ($post as $key => $value) sysconf($key, $value);
        if (isset($post['storage_type']) && $post['storage_type'] === 'oss') {
            try {
                $local = sysconf('storage_oss_domain');
                $bucket = $this->request->post('storage_oss_bucket');
                $domain = \library\File::instance('oss')->setBucket($bucket);
                if (empty($local) || stripos($local, '.aliyuncs.com') !== false) {
                    sysconf('storage_oss_domain', $domain);
                }
                $this->success('阿里云OSS存储配置成功！');
            } catch (HttpResponseException $exception) {
                throw $exception;
            } catch (\Exception $e) {
                $this->error("阿里云OSS存储配置失效，{$e->getMessage()}");
            }
        } else {
            $this->success('文件存储配置成功！');
        }
    }

}
