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

namespace app\company\controller;

use app\company\service\DataService;
use library\Controller;
use think\Db;

/**
 * 企业员工管理
 * Class User
 * @package app\worker\controller
 */
class User extends Controller
{

    /**
     * 绑定当前数据表
     * @var string
     */
    protected $table = 'CompanyUser';

    /**
     * 企业员工管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '仓库权限管理';
        $this->_query($this->table)->like('nickname,svn_username')->equal('status')->page();
    }

    /**
     * 添加企业员工
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }


    /**
     * 修改企业员工
     * @auth true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 权限表单数据处理
     * @param array $data 表单数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function _form_filter(&$data)
    {
        if ($this->request->isGet()) {
            $where = ['status' => '1', 'is_deleted' => '0'];
            $this->auths = Db::name('company_user_auth')->where($where)->order('sort desc,id desc')->select();
            array_unshift($this->auths, ['id' => '0', 'title' => '所有权限', 'path' => '/']);
            $data['svn_authorize'] = isset($data['svn_authorize']) ? explode(',', $data['svn_authorize']) : [];
        } else {
            if (isset($data['svn_authorize']) && is_array($data['svn_authorize'])) {
                $data['svn_authorize'] = join(',', $data['svn_authorize']);
            } else {
                $data['svn_authorize'] = '';
            }
            $macs = [];
            foreach (explode(PHP_EOL, preg_replace("/\s+/", PHP_EOL, trim($data['mobile_macs']))) as $mac) {
                if (DataService::applyMacValue($mac)) $macs[] = $mac;
            }
            $data['mobile_macs'] = join(PHP_EOL, array_unique($macs));
        }
    }

    /**
     * 更改企业员工状态
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function state()
    {
        $this->_save($this->table, ['status' => input('status', '0')]);
    }

    /**
     * 删除企业员工
     * @auth true
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
