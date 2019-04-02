<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library;

use library\tools\Cors;
use library\tools\Csrf;

/**
 * 标准控制器基类
 * --------------------------------
 * Class Controller
 * @package library
 * --------------------------------
 * @method logic\Query _query($dbQuery)
 * @method array _input($data, $rule = [], $info = [])
 * @method mixed _delete($dbQuery, $pkField = '', $where = [])
 * @method mixed _save($dbQuery, $data = [], $pkField = '', $where = [])
 * @method mixed _form($dbQuery, $tplFile = '', $pkField = '', $where = [], $data = [])
 * @method array _page($dbQuery, $isPage = true, $isDisplay = true, $total = false, $limit = 0)
 * --------------------------------
 * @author Anyon <zoujingli@qq.com>
 * @date 2018/08/10 11:31
 */
class Controller extends \stdClass
{

    /**
     * 当前请求对象
     * @var \think\Request
     */
    public $request;

    /**
     * 表单CSRF验证
     * @var boolean
     */
    private $_isCsrf = false;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->request = request();
        Cors::setOptionHandler($this->request);
    }

    /**
     * 实例方法调用
     * @param string $method 函数名称
     * @param array $arguments 调用参数
     * @return mixed
     * @throws \ReflectionException
     * @throws \think\Exception
     */
    public function __call($method, $arguments = [])
    {
        if (class_exists($name = "library\\logic\\" . ucfirst(ltrim($method, '_')))) {
            return (new \ReflectionClass($name))->newInstanceArgs($arguments)->init($this);
        }
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }
        throw new \think\Exception('method not exists:' . get_class($this) . '->' . $method);
    }

    /**
     * 返回成功的操作
     * @param mixed $info 消息内容
     * @param array $data 返回数据
     * @param integer $code 返回代码
     */
    public function success($info, $data = [], $code = 1)
    {
        $result = ['code' => $code, 'info' => $info, 'data' => $data];
        if ($this->_isCsrf) Csrf::clearFormToken(Csrf::getToken());
        throw new \think\exception\HttpResponseException(json($result, 200, Cors::getRequestHeader($this->request)));
    }

    /**
     * 返回失败的请求
     * @param mixed $info 消息内容
     * @param array $data 返回数据
     * @param integer $code 返回代码
     */
    public function error($info, $data = [], $code = 0)
    {
        $result = ['code' => $code, 'info' => $info, 'data' => $data];
        throw new \think\exception\HttpResponseException(json($result, 200, Cors::getRequestHeader($this->request)));
    }

    /**
     * URL重定向
     * @param string $url 重定向跳转链接
     * @param array $params 重定向链接参数
     * @param integer $code 重定向跳转代码
     */
    public function redirect($url, $params = [], $code = 301)
    {
        throw new \think\exception\HttpResponseException(redirect($url, $params, $code));
    }

    /**
     * 返回视图内容
     * @param string $tpl 模板名称
     * @param array $vars 模板变量
     * @param string $node CSRF授权节点
     */
    public function fetch($tpl = '', $vars = [], $node = null)
    {
        foreach ($this as $name => $value) $vars[$name] = $value;
        if ($this->_isCsrf) Csrf::fetchTemplate($tpl, $vars, $node);
        else throw new \think\exception\HttpResponseException(view($tpl, $vars));
    }

    /**
     * 模板变量赋值
     * @param mixed $name 要显示的模板变量
     * @param mixed $value 变量的值
     * @return $this
     */
    public function assign($name, $value = '')
    {
        if (is_string($name)) {
            $this->$name = $value;
        } elseif (is_array($name)) foreach ($name as $k => $v) {
            if (is_string($k)) $this->$k = $v;
        }
        return $this;
    }

    /**
     * 数据回调处理机制
     * @param string $name 回调方法名称
     * @param mixed $one 回调引用参数1
     * @param mixed $two 回调引用参数2
     * @return boolean
     */
    public function callback($name, &$one = [], &$two = [])
    {
        $methods = [$name, "_{$this->request->action()}{$name}"];
        foreach ($methods as $method) if (method_exists($this, $method)) {
            if (false === $this->$method($one, $two)) return false;
        }
        return true;
    }

    /**
     * 检查表单令牌验证
     * @param boolean $isRutrun
     * @return boolean
     */
    protected function applyCsrfToken($isRutrun = false)
    {
        $this->_isCsrf = true;
        if ($this->request->isPost() && !Csrf::checkFormToken()) {
            if ($isRutrun) return false;
            $this->error('表单令牌验证失败，请刷新页面再试！');
        }
        return true;
    }

}