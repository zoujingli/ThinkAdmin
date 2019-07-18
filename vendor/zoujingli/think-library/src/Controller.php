<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library;

use library\logic\Delete;
use library\logic\Form;
use library\logic\Input;
use library\logic\Page;
use library\logic\Query;
use library\logic\Save;
use library\tools\Csrf;
use think\exception\HttpResponseException;

/**
 * 标准控制器基类
 * --------------------------------
 * Class Controller
 */
class Controller extends \stdClass
{

    /**
     * 当前请求对象
     * @var \think\Request
     */
    public $request;

    /**
     * 表单CSRF验证状态
     * @var boolean
     */
    private $csrf_state = false;

    /**
     * 表单CSRF验证失败提示消息
     * @var string
     */
    protected $csrf_message = '表单令牌验证失败，请刷新页面再试！';

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->request = request();
        if (in_array($this->request->action(), get_class_methods(__CLASS__))) {
            $this->error('Access without permission.');
        }
    }

    /**
     * Controller destruct
     */
    public function __destruct()
    {
        $this->request = request();
        $action = $this->request->action();
        $method = strtolower($this->request->method());
        if (method_exists($this, $callback = "_{$action}_{$method}")) {
            call_user_func_array([$this, $callback], $this->request->route());
        }
    }

    /**
     * 返回失败的操作
     * @param mixed $info 消息内容
     * @param array $data 返回数据
     * @param integer $code 返回代码
     */
    public function error($info, $data = [], $code = 0)
    {
        $result = ['code' => $code, 'info' => $info, 'data' => $data];
        throw new HttpResponseException(json($result));
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
        if ($this->csrf_state) Csrf::clearFormToken(Csrf::getToken());
        throw new HttpResponseException(json($result));
    }

    /**
     * URL重定向
     * @param string $url 跳转链接
     * @param array $vars 跳转参数
     * @param integer $code 跳转代码
     */
    public function redirect($url, $vars = [], $code = 301)
    {
        throw new HttpResponseException(redirect($url, $vars, $code));
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
        if ($this->csrf_state) {
            Csrf::fetchTemplate($tpl, $vars, $node);
        } else {
            throw new HttpResponseException(view($tpl, $vars));
        }
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
        if (is_callable($name)) {
            return call_user_func($name, $this, $one, $two);
        }
        foreach ([$name, "_{$this->request->action()}{$name}"] as $method) {
            if (method_exists($this, $method)) {
                if (false === $this->$method($one, $two)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 检查表单令牌验证
     * @param boolean $return 是否返回结果
     * @return boolean
     */
    protected function applyCsrfToken($return = false)
    {
        $this->csrf_state = true;
        if ($this->request->isPost() && !Csrf::checkFormToken()) {
            if ($return) return false;
            $this->error($this->csrf_message);
        } else {
            return true;
        }
    }

    /**
     * 快捷查询逻辑器
     * @param string|\think\db\Query $dbQuery
     * @return Query
     */
    protected function _query($dbQuery)
    {
        return (new Query($dbQuery))->init($this);
    }

    /**
     * 快捷分页逻辑器
     * @param string|\think\db\Query $dbQuery
     * @param boolean $isPage 是否启用分页
     * @param boolean $isDisplay 是否渲染模板
     * @param boolean $total 集合分页记录数
     * @param integer $limit 集合每页记录数
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _page($dbQuery, $isPage = true, $isDisplay = true, $total = false, $limit = 0)
    {
        return (new Page($dbQuery, $isPage, $isDisplay, $total, $limit))->init($this);
    }

    /**
     * 快捷表单逻辑器
     * @param string|\think\db\Query $dbQuery
     * @param string $tpl 模板名称
     * @param string $pkField 指定数据对象主键
     * @param array $where 额外更新条件
     * @param array $data 表单扩展数据
     * @return array|boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _form($dbQuery, $tpl = '', $pkField = '', $where = [], $data = [])
    {
        return (new Form($dbQuery, $tpl, $pkField, $where, $data))->init($this);
    }

    /**
     * 快捷更新逻辑器
     * @param string|\think\db\Query $dbQuery
     * @param array $data 表单扩展数据
     * @param string $pkField 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _save($dbQuery, $data = [], $pkField = '', $where = [])
    {
        return (new Save($dbQuery, $data, $pkField, $where))->init($this);
    }

    /**
     * 快捷输入逻辑器
     * @param array|string $data 验证数据
     * @param array $rule 验证规则
     * @param array $info 验证消息
     * @return array
     */
    protected function _input($data, $rule = [], $info = [])
    {
        return (new Input($data, $rule, $info))->init($this);
    }

    /**
     * 快捷删除逻辑器
     * @param string|\think\db\Query $dbQuery
     * @param string $pkField 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean|null
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _delete($dbQuery, $pkField = '', $where = [])
    {
        return (new Delete($dbQuery, $pkField, $where))->init($this);
    }

}
