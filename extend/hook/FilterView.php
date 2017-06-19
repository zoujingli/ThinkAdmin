<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace hook;

use think\Request;

/**
 * 视图输出过滤
 * Class FilterView
 * @package hook
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/04/25 11:59
 */
class FilterView {

    /**
     * 当前请求对象
     * @var Request
     */
    protected $request;

    /**
     * 行为入口
     * @param $params
     */
    public function run(&$params) {
        $this->request = Request::instance();
        $appRoot = $this->request->root(true);
        $replace = [
            '__APP__'    => $appRoot,
            '__SELF__'   => $this->request->url(true),
            '__PUBLIC__' => strpos($appRoot, EXT) ? ltrim(dirname($appRoot), DS) : $appRoot,
        ];
        $params = str_replace(array_keys($replace), array_values($replace), $params);
        !IS_CLI && $this->baidu($params);
    }

    /**
     * 百度统计实现代码
     * @param $params
     */
    public function baidu(&$params) {
        if (($key = sysconf('tongji_baidu_key'))) {
            $script = <<<SCRIPT
        <script>
            var _hmt = _hmt || [];
            (function() {
                var hm = document.createElement("script");
                hm.src = "https://hm.baidu.com/hm.js?{$key}";
                var s = document.getElementsByTagName("script")[0]; 
                s.parentNode.insertBefore(hm, s);
            })();
        </script>
SCRIPT;
            $params = preg_replace('|</body>|i', "{$script}\n    </body>", $params);
        }
    }

}
