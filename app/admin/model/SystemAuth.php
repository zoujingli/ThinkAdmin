<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\admin\Model;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 用户权限模型
 * Class SystemAuth
 * @package app\admin\model
 */
class SystemAuth extends Model
{
    /**
     * 日志名称
     * @var string
     */
    protected $oplogName = '系统权限';

    /**
     * 日志类型
     * @var string
     */
    protected $oplogType = '系统权限管理';

    /**
     * 获取权限数据
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function items(): array
    {
        return $this->where(['status' => 1])->order('sort desc,id desc')->select()->toArray();
    }

    /**
     * 删除权限事件
     * @param string $ids
     */
    public function onAdminDelete(string $ids)
    {
        if (count($aids = str2arr($ids ?? '')) > 0) {
            SystemNode::mk()->whereIn('auth', $aids)->delete();
        }
        sysoplog($this->oplogType, "删除{$this->oplogName}[{$ids}]及授权配置");
    }

    /**
     * 格式化创建时间
     * @param string $value
     * @return string
     */
    public function getCreateAtAttr(string $value): string
    {
        return format_datetime($value);
    }
}