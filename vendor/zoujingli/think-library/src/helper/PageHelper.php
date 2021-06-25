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
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
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
     * @param Model|Query|string $dbQuery
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
    public function init($dbQuery, bool $page = true, bool $display = true, $total = false, int $limit = 0, string $template = ''): array
    {
        $this->query = $this->buildQuery($dbQuery);
        // 数据列表排序自动处理
        if ($this->app->request->isPost() && $this->app->request->post('action') === 'sort') {
            if (in_array('sort', $this->query->getTableFields())) {
                if ($this->app->request->has($pk = $this->query->getPk() ?: 'id', 'post')) {
                    $map = [$pk => $this->app->request->post($pk, 0)];
                    $data = ['sort' => intval($this->app->request->post('sort', 0))];
                    if ($this->app->db->table($this->query->getTable())->where($map)->update($data) !== false) {
                        $this->class->success(lang('think_library_sort_success'), '');
                    }
                }
            }
            $this->class->error(lang('think_library_sort_error'));
        }
        // 列表分页及结果集处理
        if ($page) {
            if ($limit <= 1) {
                $limit = $this->app->request->get('limit', $this->app->cookie->get('limit', 20));
                if (intval($this->app->request->get('not_cache_limit', 0)) < 1) {
                    $this->app->cookie->set('limit', ($limit = intval($limit >= 5 ? $limit : 20)) . '');
                }
            }
            $query = $this->app->request->get();
            $pager = $this->query->paginate(['list_rows' => $limit, 'query' => $query], $total);
            [$data, $opts] = [$pager->toArray(), ''];
            foreach ([10, 20, 30, 40, 50, 60, 70, 80, 90, 100, 110, 120, 130, 140, 150, 160, 170, 180, 190, 200] as $num) {
                $url = $this->app->request->baseUrl() . '?' . urldecode(http_build_query(array_merge($query, ['limit' => $num, 'page' => 1])));
                $opts .= sprintf('<option data-num="%d" value="%s" %s>%d</option>', $num, $url, $limit === $num ? 'selected' : '', $num);
            }
            $select = "<select onchange='location.href=this.options[this.selectedIndex].value'>{$opts}</select>";
            $pagehtml = lang('think_library_page_html', [$data['total'], $select, $data['last_page'], $data['current_page']]);
            $this->class->assign('pagehtml', "<div class='pagination-container nowrap'><span>{$pagehtml}</span>{$pager->render()}</div>");
            $result = ['page' => ['limit' => $data['per_page'], 'total' => $data['total'], 'pages' => $data['last_page'], 'current' => $data['current_page']], 'list' => $data['data']];
        } else {
            $result = ['list' => $this->query->select()->toArray()];
        }
        if (false !== $this->class->callback('_page_filter', $result['list']) && $display) {
            if ($this->app->request->get('output') === 'json') {
                $this->class->success('JSON-DATA', $result);
            } else {
                $this->class->fetch($template, $result);
            }
        }
        return $result;
    }
}
