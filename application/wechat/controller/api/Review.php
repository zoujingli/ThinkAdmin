<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\wechat\controller\api;

use app\wechat\service\Media;
use library\Controller;
use think\Db;

/**
 * Class Review
 * @package app\wechat\controller\api
 */
class Review extends Controller
{

    /**
     * 显示图文列表
     * @param integer $id
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function news($id = 0)
    {
        $this->news = Media::news(empty($id) ? input('id') : $id);
        return $this->fetch();
    }

    /**
     * 显示图文内容
     * @param integer $id
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function view($id = 0)
    {
        $where = ['id' => empty($id) ? input('id') : $id];
        Db::name('WechatNewsArticle')->where($where)->update(['read_num' => Db::raw('read_num+1')]);
        return $this->fetch('', ['info' => Db::name('WechatNewsArticle')->where($where)->find()]);
    }

    public function text()
    {
        return $this->fetch();
    }

    public function image()
    {
        return $this->fetch();
    }

    public function video()
    {
        return $this->fetch();
    }

    public function voice()
    {
        return $this->fetch();
    }

    public function music()
    {
        return $this->fetch();
    }

}