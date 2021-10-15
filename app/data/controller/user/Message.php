<?php

namespace app\data\controller\user;

use app\data\model\DataUserMessage;
use app\data\service\MessageService;
use think\admin\Controller;

/**
 * 短信发送管理
 * Class Message
 * @package app\data\controller\user
 */
class Message extends Controller
{
    /**
     * 短信发送管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '短信发送管理';
        $query = DataUserMessage::mQuery();
        $query->equal('status')->like('phone,content');
        $query->dateBetween('create_at')->order('id desc')->page();
    }

    /**
     * 短信接口配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        if ($this->request->isGet()) {
            $this->title = '短信接口配置';
            $this->result = MessageService::instance()->balance();
            $this->fetch();
        } else {
            $data = $this->request->post();
            foreach ($data as $k => $v) sysconf($k, $v);
            $this->success('配置保存成功！');
        }
    }

    /**
     * 删除短信记录
     * @auth true
     */
    public function remove()
    {
        DataUserMessage::mDelete();
    }
}