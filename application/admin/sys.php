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

use library\File;
use library\service\AdminService;
use library\service\CaptchaService;
use library\service\SystemService;
use think\Db;
use think\facade\Middleware;
use think\facade\Route;
use think\Request;

if (!function_exists('auth')) {
    /**
     * 节点访问权限检查
     * @param string $node 需要检查的节点
     * @return boolean
     * @throws ReflectionException
     */
    function auth($node)
    {
        return AdminService::instance()->check($node);
    }
}

if (!function_exists('sysdata')) {
    /**
     * JSON 数据读取与存储
     * @param string $name 数据名称
     * @param mixed $value 数据内容
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    function sysdata($name, $value = null)
    {
        if (is_null($value)) {
            return SystemService::instance()->getData($name);
        } else {
            return SystemService::instance()->setData($name, $value);
        }
    }
}

if (!function_exists('sysoplog')) {
    /**
     * 写入系统日志
     * @param string $action 日志行为
     * @param string $content 日志内容
     * @return boolean
     */
    function sysoplog($action, $content)
    {
        return SystemService::instance()->setOplog($action, $content);
    }
}

if (!function_exists('sysqueue')) {
    /**
     * 创建异步处理任务
     * @param string $title 任务名称
     * @param string $loade 执行内容
     * @param integer $later 延时执行时间
     * @param array $data 任务附加数据
     * @param integer $double 任务多开
     * @return boolean
     * @throws \think\Exception
     */
    function sysqueue($title, $loade, $later = 0, $data = [], $double = 1)
    {
        $map = [['title', 'eq', $title], ['status', 'in', [1, 2]]];
        if (empty($double) && Db::name('SystemQueue')->where($map)->count() > 0) {
            throw new \think\Exception('该任务已经创建，请耐心等待处理完成！');
        }
        $result = Db::name('SystemQueue')->insert([
            'title'  => $title, 'preload' => $loade,
            'data'   => json_encode($data, JSON_UNESCAPED_UNICODE),
            'time'   => $later > 0 ? time() + $later : time(),
            'double' => intval($double), 'create_at' => date('Y-m-d H:i:s'),
        ]);
        return $result !== false;
    }
}

if (!function_exists('local_image')) {
    /**
     * 下载远程文件到本地
     * @param string $url 远程图片地址
     * @param boolean $force 是否强制重新下载
     * @param integer $expire 强制本地存储时间
     * @return string
     */
    function local_image($url, $force = false, $expire = 0)
    {
        $result = File::down($url, $force, $expire);
        if (isset($result['url'])) {
            return $result['url'];
        } else {
            return $url;
        }
    }
}

if (!function_exists('base64_image')) {
    /**
     * base64 图片上传接口
     * @param string $content 图片base64内容
     * @param string $dirname 图片存储目录
     * @return string
     */
    function base64_image($content, $dirname = 'base64/')
    {
        try {
            if (preg_match('|^data:image/(.*?);base64,|i', $content)) {
                list($ext, $base) = explode('|||', preg_replace('|^data:image/(.*?);base64,|i', '$1|||', $content));
                $info = File::save($dirname . md5($base) . '.' . (empty($ext) ? 'tmp' : $ext), base64_decode($base));
                return $info['url'];
            } else {
                return $content;
            }
        } catch (\Exception $e) {
            return $content;
        }
    }
}

// 访问权限检查中间键
Middleware::add(function (Request $request, \Closure $next) {
    if (AdminService::instance()->check()) {
        return $next($request);
    } elseif (AdminService::instance()->isLogin()) {
        return json(['code' => 0, 'msg' => '抱歉，没有访问该操作的权限！']);
    } else {
        return json(['code' => 0, 'msg' => '抱歉，需要登录获取访问权限！', 'url' => url('@admin/login')]);
    }
});

// ThinkAdmin 图形验证码
Route::get('/think/admin/captcha', function () {
    $image = CaptchaService::instance();
    return json(['code' => '1', 'info' => '生成验证码', 'data' => [
        'uniqid' => $image->getUniqid(), 'image' => $image->getData()
    ]]);
});