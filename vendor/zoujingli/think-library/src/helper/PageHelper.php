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
use think\db\Query;

/**
 * 列表处理管理器
 * Class PageHelper
 * @package think\admin\helper
 */
class PageHelper extends Helper
{

    /**
     * 逻辑器初始化
     * @param string|Query $dbQuery
     * @param boolean $page 是否启用分页
     * @param boolean $display 是否渲染模板
     * @param boolean|integer $total 集合分页记录数
     * @param integer $limit 集合每页记录数
     * @param string $template 模板文件名称
     * @return array|mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function init($dbQuery, bool $page = true, bool $display = true, $total = false, int $limit = 0, string $template = '')
    {
        $this->query = $this->buildQuery($dbQuery);
        // 数据列表排序自动处理
        if ($this->app->request->isPost()) $this->_sortAction();
        // 列表设置默认排序处理
        if (!$this->query->getOptions('order')) $this->_orderAction();
        // 列表分页及结果集处理
        if ($page) {
            if ($limit > 0) {
                $limit = intval($limit);
            } else {
                $limit = $this->app->request->get('limit', $this->app->cookie->get('limit', 20));
                $this->app->cookie->set('limit', ($limit = intval($limit >= 10 ? $limit : 20)) . '');
            }
            [$options, $query] = ['', $this->app->request->get()];
            $pager = $this->query->paginate(['list_rows' => $limit, 'query' => $query], $total);
            foreach ([10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200] as $num) {
                [$query['limit'], $query['page'], $selects] = [$num, 1, $limit === $num ? 'selected' : ''];
                if (stripos($this->app->request->get('spm', '-'), 'm-') === 0) {
                    $url = sysuri('admin/index/index') . '#' . $this->app->request->baseUrl() . '?' . urldecode(http_build_query($query));
                } else {
                    $url = $this->app->request->baseUrl() . '?' . urldecode(http_build_query($query));
                }
                $options .= "<option data-num='{$num}' value='{$url}' {$selects}>{$num}</option>";
            }
            $selects = "<select onchange='location.href=this.options[this.selectedIndex].value' data-auto-none>{$options}</select>";
            $pagetext = lang('think_library_page_html', [$pager->total(), $selects, $pager->lastPage(), $pager->currentPage()]);
            $pagehtml = "<div class='pagination-container nowrap'><span>{$pagetext}</span>{$pager->render()}</div>";
            if (stripos($this->app->request->get('spm', '-'), 'm-') === 0) {
                $this->class->assign('pagehtml', preg_replace('|href="(.*?)"|', 'data-open="$1" onclick="return false" href="$1"', $pagehtml));
            } else {
                $this->class->assign('pagehtml', $pagehtml);
            }
            $result = ['page' => ['limit' => intval($limit), 'total' => intval($pager->total()), 'pages' => intval($pager->lastPage()), 'current' => intval($pager->currentPage())], 'list' => $pager->items()];
        } else {
            $result = ['list' => $this->query->select()->toArray()];
        }
        if (false !== $this->class->callback('_page_filter', $result['list']) && $display) {
            $this->class->fetch($template, $result);
        } else {
            return $result;
        }
    }

    /**
     * 执行列表排序操作
     * POST 提交 {action:sort,PK:$PK,SORT:$SORT}
     * @throws \think\db\exception\DbException
     */
    private function _sortAction()
    {
        if ($this->app->request->post('action') === 'sort') {
            if (method_exists($this->query, 'getTableFields') && in_array('sort', $this->query->getTableFields())) {
                $pk = $this->query->getPk() ?: 'id';
                if ($this->app->request->has($pk, 'post')) {
                    $map = [$pk => $this->app->request->post($pk, 0)];
                    $data = ['sort' => intval($this->app->request->post('sort', 0))];
                    if ($this->app->db->table($this->query->getTable())->where($map)->update($data) !== false) {
                        $this->class->success(lang('think_library_sort_success'), '');
                    }
                }
            }
            $this->class->error(lang('think_library_sort_error'));
        }
    }

    /**
     * 列表默认排序处理
     * 未配置排序规则时自动按SORT排序
     */
    private function _orderAction()
    {
        if (method_exists($this->query, 'getTableFields')) {
            if (in_array('sort', $this->query->getTableFields())) {
                $this->query->order('sort desc');
            }
        }
    }

}
