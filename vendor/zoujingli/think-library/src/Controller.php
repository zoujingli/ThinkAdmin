<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin;

use think\admin\helper\DeleteHelper;
use think\admin\helper\FormHelper;
use think\admin\helper\PageHelper;
use think\admin\helper\QueryHelper;
use think\admin\helper\SaveHelper;
use think\admin\helper\TokenHelper;
use think\admin\helper\ValidateHelper;
use think\admin\service\QueueService;
use think\App;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
use think\exception\HttpResponseException;
use think\Request;

/**
 * 标准控制器基类
 * Class Controller
 * @package think\admin
 */
abstract class Controller extends \stdClass
{

    /**
     * 应用容器
     * @var App
     */
    public $app;

    /**
     * 请求对象
     * @var Request
     */
    public $request;

    /**
     * 控制器中间键
     * @var array
     */
    protected $middleware = [];

    /**
     * 表单CSRF验证状态
     * @var boolean
     */
    public $csrf_state = false;

    /**
     * 表单CSRF验证失败提示
     * @var string
     */
    public $csrf_message;

    /**
     * Controller constructor.
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $app->request;
        $this->app->bind('think\admin\Controller', $this);
        if (in_array($this->request->action(), get_class_methods(__CLASS__))) {
            $this->error('Access without permission.');
        }
        $this->csrf_message = lang('think_library_csrf_error');
        $this->initialize();
    }

    /**
     * 控制器初始化
     */
    protected function initialize()
    {
    }

    /**
     * 返回失败的操作
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param integer $code 返回代码
     */
    public function error($info, $data = '{-null-}', $code = 0): void
    {
        if ($data === '{-null-}') $data = new \stdClass();
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }

    /**
     * 返回成功的操作
     * @param mixed $info 消息内容
     * @param mixed $data 返回数据
     * @param integer $code 返回代码
     */
    public function success($info, $data = '{-null-}', $code = 1): void
    {
        if ($this->csrf_state) {
            TokenHelper::instance()->clear();
        }
        if ($data === '{-null-}') $data = new \stdClass();
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }

    /**
     * URL重定向
     * @param string $url 跳转链接
     * @param integer $code 跳转代码
     */
    public function redirect(string $url, $code = 301): void
    {
        throw new HttpResponseException(redirect($url, $code));
    }

    /**
     * 返回视图内容
     * @param string $tpl 模板名称
     * @param array $vars 模板变量
     * @param null|string $node 授权节点
     */
    public function fetch(string $tpl = '', array $vars = [], ?string $node = null): void
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
        } elseif (is_array($name)) {
            foreach ($name as $k => $v) {
                if (is_string($k)) $this->$k = $v;
            }
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
    public function callback(string $name, &$one = [], &$two = []): bool
    {
        if (is_callable($name)) return call_user_func($name, $this, $one, $two);
        foreach (["_{$this->app->request->action()}{$name}", $name] as $method) {
            if (method_exists($this, $method) && false === $this->$method($one, $two)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 快捷查询逻辑器
     * @param string|Query $dbQuery
     * @param array|string|null $input
     * @return QueryHelper
     */
    protected function _query($dbQuery, $input = null): QueryHelper
    {
        return QueryHelper::instance()->init($dbQuery, $input);
    }

    /**
     * 快捷分页逻辑器
     * @param string|Query $dbQuery
     * @param boolean $page 是否启用分页
     * @param boolean $display 是否渲染模板
     * @param boolean|integer $total 集合分页记录数
     * @param integer $limit 集合每页记录数
     * @param string $template 模板文件名称
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    protected function _page($dbQuery, bool $page = true, bool $display = true, $total = false, int $limit = 0, string $template = '')
    {
        return PageHelper::instance()->init($dbQuery, $page, $display, $total, $limit, $template);
    }

    /**
     * 快捷表单逻辑器
     * @param string|Query $dbQuery
     * @param string $template 模板名称
     * @param string $field 指定数据对象主键
     * @param array $where 额外更新条件
     * @param array $data 表单扩展数据
     * @return array|boolean
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    protected function _form($dbQuery, string $template = '', string $field = '', array $where = [], array $data = [])
    {
        return FormHelper::instance()->init($dbQuery, $template, $field, $where, $data);
    }

    /**
     * 快捷输入并验证（ 支持 规则 # 别名 ）
     * @param array $rules 验证规则（ 验证信息数组 ）
     * @param string|array $type 输入方式 ( post. 或 get. )
     * @return array
     */
    protected function _vali(array $rules, $type = '')
    {
        return ValidateHelper::instance()->init($rules, $type);
    }

    /**
     * 快捷更新逻辑器
     * @param string|Query $dbQuery
     * @param array $data 表单扩展数据
     * @param string $field 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean
     * @throws DbException
     */
    protected function _save($dbQuery, array $data = [], string $field = '', array $where = [])
    {
        return SaveHelper::instance()->init($dbQuery, $data, $field, $where);
    }

    /**
     * 快捷删除逻辑器
     * @param string|Query $dbQuery
     * @param string $field 数据对象主键
     * @param array $where 额外更新条件
     * @return boolean|null
     * @throws DbException
     */
    protected function _delete($dbQuery, string $field = '', array $where = [])
    {
        return DeleteHelper::instance()->init($dbQuery, $field, $where);
    }

    /**
     * 检查表单令牌验证
     * @param boolean $return 是否返回结果
     * @return boolean
     */
    protected function _applyFormToken(bool $return = false)
    {
        return TokenHelper::instance()->init($return);
    }

    /**
     * 创建异步任务并返回任务编号
     * @param string $title 任务名称
     * @param string $command 执行内容
     * @param integer $later 延时执行时间
     * @param array $data 任务附加数据
     * @param integer $rscript 任务类型(0单例,1多例)
     * @param integer $loops 循环等待时间
     */
    protected function _queue(string $title, string $command, int $later = 0, array $data = [], int $rscript = 0, int $loops = 0)
    {
        try {
            $queue = QueueService::instance()->register($title, $command, $later, $data, $rscript, $loops);
            $this->success('创建任务成功！', $queue->code);
        } catch (Exception $exception) {
            $code = $exception->getData();
            if (is_string($code) && stripos($code, 'Q') === 0) {
                $this->success('任务已经存在，无需再次创建！', $code);
            } else {
                $this->error($exception->getMessage());
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error("创建任务失败，{$exception->getMessage()}");
        }
    }

}
