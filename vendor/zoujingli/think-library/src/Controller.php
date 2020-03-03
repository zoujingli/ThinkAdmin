<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library;

use library\helper\DeleteHelper;
use library\helper\FormHelper;
use library\helper\InputHelper;
use library\helper\PageHelper;
use library\helper\QueryHelper;
use library\helper\SaveHelper;
use library\helper\TokenHelper;
use library\helper\ValidateHelper;
use think\App;
use think\Container;
use think\db\Query;
use think\exception\HttpResponseException;
use think\Response;

/**
 * 标准控制器基类
 * Class Controller
 * @package library
 */
abstract class Controller extends \stdClass
{

    /**
     * 当前应用实例
     * @var App
     */
    public $app;

    /**
     * 当前请求对象
     * @var \think\Request
     */
    public $request;

    /**
     * 表单CSRF验证状态
     * @var boolean
     */
    public $csrf_state = false;

    /**
     * 表单CSRF验证失败提示消息
     * @var string
     */
    public $csrf_message = '';

    /**
     * Controller constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        // 控制器注入容器
        Container::set('library\Controller', $this);
        if (in_array($this->request->action(), get_class_methods(__CLASS__))) {
            $this->error('Access without permission.');
        }
        // 初始化控制器
        $this->initialize();
        // 控制器后置操作
        if (method_exists($this, $method = "_{$this->request->action()}_{$this->request->method()}")) {
            $this->app->hook->add('app_end', function (Response $response) use ($method) {
                try {
                    [ob_start(), ob_clean()];
                    $return = call_user_func_array([$this, $method], $this->request->route());
                    if (is_string($return)) {
                        $response->content($response->getContent() . $return);
                    } elseif ($return instanceof Response) {
                        $this->__mergeResponse($response, $return);
                    }
                } catch (HttpResponseException $exception) {
                    $this->__mergeResponse($response, $exception->getResponse());
                } catch (\Exception $exception) {
                    throw $exception;
                }
            });
        }
    }

    /**
     * 合并请求对象
     * @param Response $response 目标响应对象
     * @param Response $source 数据源响应对象
     * @return Response
     */
    private function __mergeResponse(Response $response, Response $source)
    {
        $response->code($source->getCode())->content($response->getContent() . $source->getContent());
        foreach ($source->getHeader() as $name => $value) if (!empty($name) && is_string($name)) $response->header($name, $value);
        return $response;
    }

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
        if (empty($this->csrf_message)) {
            $this->csrf_message = lang('think_library_csrf_error');
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
        if ($this->csrf_state) {
            TokenHelper::instance()->clear();
        }
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
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
            TokenHelper::instance()->fetchTemplate($tpl, $vars, $node);
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
            if (method_exists($this, $method)) if (false === $this->$method($one, $two)) {
                return false;
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
        return TokenHelper::instance()->init($return);
    }

    /**
     * 快捷查询逻辑器
     * @param string|Query $dbQuery
     * @return QueryHelper
     */
    protected function _query($dbQuery)
    {
        return QueryHelper::instance()->init($dbQuery);
    }

    /**
     * 快捷分页逻辑器
     * @param string|Query $dbQuery
     * @param boolean $page 是否启用分页
     * @param boolean $display 是否渲染模板
     * @param boolean $total 集合分页记录数
     * @param integer $limit 集合每页记录数
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _page($dbQuery, $page = true, $display = true, $total = false, $limit = 0)
    {
        return PageHelper::instance()->init($dbQuery, $page, $display, $total, $limit);
    }

    /**
     * 快捷表单逻辑器
     * @param string|Query $dbQuery
     * @param string $template 模板名称
     * @param string $field 指定数据对象主键
     * @param array $where 额外更新条件
     * @param array $data 表单扩展数据
     * @return array|boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    protected function _form($dbQuery, $template = '', $field = '', $where = [], $data = [])
    {
        return FormHelper::instance()->init($dbQuery, $template, $field, $where, $data);
    }

    /**
     * 快捷更新逻辑器
     * @param string|Query $dbQuery
     * @param array $data 表单扩展数据
     * @param string $field 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _save($dbQuery, $data = [], $field = '', $where = [])
    {
        return SaveHelper::instance()->init($dbQuery, $data, $field, $where);
    }

    /**
     * 快捷输入并验证（ 支持 规则 # 别名 ）
     * @param array $rules 验证规则（ 验证信息数组 ）
     * @param string $type 输入方式 ( post. 或 get. )
     * @return array
     */
    protected function _vali(array $rules, $type = '')
    {
        return ValidateHelper::instance()->init($rules, $type);
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
        return InputHelper::instance()->init($data, $rule, $info);
    }

    /**
     * 快捷删除逻辑器
     * @param string|Query $dbQuery
     * @param string $field 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean|null
     * @return boolean|null
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    protected function _delete($dbQuery, $field = '', $where = [])
    {
        return DeleteHelper::instance()->init($dbQuery, $field, $where);
    }

}
