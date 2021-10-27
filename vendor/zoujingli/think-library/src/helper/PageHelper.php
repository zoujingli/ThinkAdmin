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

namespace think\admin\helper;

use think\admin\Helper;
use think\admin\service\AdminService;
use think\db\BaseQuery;
use think\db\Query;
use think\exception\HttpResponseException;
use think\Model;

/**
 * 列表处理管理器
 * Class PageHelper
 * @package think\admin\helper
 */
class PageHelper extends Helper
{
    /**
     * 逻辑器初始化
     * @param Model|BaseQuery|string $dbQuery
     * @param boolean $page 是否启用分页
     * @param boolean $display 是否渲染模板
     * @param boolean|integer $total 集合分页记录数
     * @param integer $limit 集合每页记录数
     * @param string $template 模板文件名称
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function init($dbQuery, bool $page = true, bool $display = true, $total = false, int $limit = 0, string $template = ''): array
    {
        if ($page) {
            $limits = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200];
            if ($limit <= 1) {
                $limit = $this->app->request->get('limit', $this->app->cookie->get('limit', 20));
                if (in_array($limit, $limits) && intval($this->app->request->get('not_cache_limit', 0)) < 1) {
                    $this->app->cookie->set('limit', ($limit = intval($limit >= 5 ? $limit : 20)) . '');
                }
            }
            $get = $this->app->request->get();
            $inner = strpos($get['spm'] ?? '', 'm-') === 0;
            $prefix = $inner ? (sysuri('admin/index/index') . '#') : '';
            // 生成分页数据
            $data = ($paginate = $this->autoSortQuery($dbQuery)->paginate(['list_rows' => $limit, 'query' => $get], $total))->toArray();
            $result = ['page' => ['limit' => $data['per_page'], 'total' => $data['total'], 'pages' => $data['last_page'], 'current' => $data['current_page']], 'list' => $data['data']];
            // 分页跳转参数
            $select = "<select onchange='location.href=this.options[this.selectedIndex].value'>";
            if (in_array($limit, $limits)) foreach ($limits as $num) {
                $url = $this->app->request->baseUrl() . '?' . http_build_query(array_merge($get, ['limit' => $num, 'page' => 1]));
                $select .= sprintf('<option data-num="%d" value="%s" %s>%d</option>', $num, $prefix . $url, $limit === $num ? 'selected' : '', $num);
            } else {
                $select .= "<option selected>{$limit}</option>";
            }
            $html = lang('think_library_page_html', [$data['total'], "{$select}</select>", $data['last_page'], $data['current_page']]);
            $link = $inner ? str_replace('<a href=', '<a data-open=', $paginate->render() ?: '') : ($paginate->render() ?: '');
            $this->class->assign('pagehtml', "<div class='pagination-container nowrap'><span>{$html}</span>{$link}</div>");
        } else {
            $result = ['list' => $this->autoSortQuery($dbQuery)->select()->toArray()];
        }
        if (false !== $this->class->callback('_page_filter', $result['list']) && $display) {
            if ($this->output === 'get.json') {
                $this->class->success('JSON-DATA', $result);
            } else {
                $this->class->fetch($template, $result);
            }
        }
        return $result;
    }

    /**
     * 组件 Layui.Table 处理
     * @param Model|BaseQuery|string $dbQuery
     * @param string $template
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function layTable($dbQuery, string $template = ''): array
    {
        if ($this->output === 'get.json') {
            return PageHelper::instance()->init($dbQuery);
        }
        if ($this->output === 'get.layui.table') {
            $get = $this->app->request->get();
            $query = $this->autoSortQuery($dbQuery);
            // 根据参数排序
            if (isset($get['_field_']) && isset($get['_order_'])) {
                $query->order("{$get['_field_']} {$get['_order_']}");
            }
            // 数据分页处理
            if (isset($get['page']) && isset($get['limit'])) {
                $rows = $get['limit'] ?: 20;
                $total = $this->app->db->table($query->buildSql() . ' a')->count();
                $data = $query->paginate(['list_rows' => $rows, 'query' => $get], $total)->toArray();
                $result = ['msg' => '', 'code' => 0, 'count' => $total, 'data' => $data['data']];
            } else {
                $data = $query->select()->toArray();
                $result = ['msg' => '', 'code' => 0, 'count' => count($data), 'data' => $data];
            }
            $this->xssFilter($result['data']);
            if (false !== $this->class->callback('_page_filter', $result['data'])) {
                throw new HttpResponseException(json($result));
            } else {
                return $result;
            }
        } else {
            $this->class->fetch($template);
            return [];
        }
    }

    /**
     * 输出 XSS 过滤处理
     * @param array $items
     */
    private function xssFilter(array &$items)
    {
        foreach ($items as &$item) if (is_array($item)) {
            $this->xssFilter($item);
        } elseif (is_string($item)) {
            $item = htmlspecialchars($item, ENT_QUOTES);
        }
    }

    /**
     * 绑定排序并返回操作对象
     * @param Model|BaseQuery|string $dbQuery
     * @return Query
     * @throws \think\db\exception\DbException
     */
    public function autoSortQuery($dbQuery): Query
    {
        $query = $this->buildQuery($dbQuery);
        if ($this->app->request->isPost() && $this->app->request->post('action') === 'sort') {
            if (!AdminService::instance()->isLogin()) {
                $this->class->error(lang('think_library_not_login'));
            }
            if (method_exists($query, 'getTableFields') && in_array('sort', $query->getTableFields())) {
                if ($this->app->request->has($pk = $query->getPk() ?: 'id', 'post')) {
                    $map = [$pk => $this->app->request->post($pk, 0)];
                    $data = ['sort' => intval($this->app->request->post('sort', 0))];
                    if ($this->app->db->table($query->getTable())->where($map)->update($data) !== false) {
                        $this->class->success(lang('think_library_sort_success'), '');
                    }
                }
            }
            $this->class->error(lang('think_library_sort_error'));
        }
        return $query;
    }
}