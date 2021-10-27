<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\model;

use think\admin\Model;

/**
 * 用户权限模型
 * Class SystemAuth
 * @package think\admin\model
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
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
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