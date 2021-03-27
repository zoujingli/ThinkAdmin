<?php

namespace app\data\controller\user;

use app\data\service\UserAdminService;
use app\data\service\UserUpgradeService;
use think\admin\Controller;

/**
 * 普通用户管理
 * Class Admin
 * @package app\data\controller\user
 */
class Admin extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUser';

    /**
     * 普通用户管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '普通用户管理';
        $query = $this->_query($this->table);
        // 用户搜索查询
        $db = $this->_query('DataUser')->equal('vip_code#from_vipcode')->like('phone#from_phone,username|nickname#from_username')->db();
        if ($db->getOptions('where')) $query->whereRaw("pid1 in {$db->field('id')->buildSql()}");
        // 数据查询分页
        $query->like('phone,username|nickname#username')->equal('status,vip_code');
        $query->order('id desc')->dateBetween('create_at')->page();
    }

    /**
     * 数据列表处理
     * @param array $data
     */
    protected function _page_filter(array &$data)
    {
        $this->upgrades = UserUpgradeService::instance()->levels();
        UserAdminService::instance()->buildByUid($data, 'pid1', 'from');
    }

    /**
     * 修改用户上传
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function parent()
    {
        $data = $this->_vali(['pid.default' => '', 'uid.require' => '待操作UID不能为空']);
        if ($data['uid'] === $data['pid']) $this->error('推荐人不能是自己');
        if (empty($data['pid'])) {
            $map = [['id', '<>', $data['uid']], ['deleted', '=', 0]];
            $query = $this->_query($this->table)->where($map)->equal('status,vip_code');
            $query->like('phone,username|nickname#username')->dateBetween('create_at')->order('id desc')->page();
        } else try {
            $user = $this->app->db->name('DataUser')->where(['id' => $data['uid']])->find();
            $parent = $this->app->db->name('DataUser')->where(['id' => $data['pid']])->find();
            if (empty($user)) $this->error('读取用户数据失败！');
            if (empty($parent)) $this->error('读取推荐人数据失败！');
            $this->app->db->transaction(function () use ($data, $user, $parent) {
                if (empty($parent['vip_code'])) $this->error('推荐人无推荐资格');
                if (is_numeric(strpos($parent['path'], "-{$data['uid']}-"))) $this->error('推荐人不能绑下属');
                // 组装当前用户上级数据
                $path = rtrim($parent['path'] ?: '-', '-') . "-{$parent['id']}-";
//                $this->app->db->name('DataUser')->where(['id' => $data['uid']])->update([
//                    'pid0' => $parent['id'], 'pid1' => $parent['id'], 'pid2' => $parent['pid1'],
//                    'path' => $path, 'layer' => substr_count($path, '-'),
//                ]);
                // 替换原来用户的下级用户
                $newPath = rtrim($path, '-') . "-{$user['id']}-";
                $oldPath = rtrim($user['path'], '-') . "-{$user['id']}-";
                foreach ($this->app->db->name('DataUser')->whereLike('path', "{$oldPath}%")->cursor() as $vo) {
                    dump($vo);
                }
//                $this->app->db->name('DataUser')->whereLike('path', "{$oldPath}%")->update([
//                    'path' => $this->app->db->raw("replace(path,'{$oldPath}','{$newPath}')"),
//                ]);
//                foreach (array_reverse(array_unique(array_merge(str2arr($newPath), str2arr($oldPath)))) as $uid) {
//                    UserUpgradeService::instance()->upgrade($uid);
//                }
            });
            exit;
            $this->success('修改推荐人成功！');
        } catch (\think\exception\HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 重算用户余额返利
     * @auth true
     */
    public function sync()
    {
        $this->_queue('重新计算用户余额返利', 'xdata:UserAmount');
    }

    /**
     * 修改用户状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

}