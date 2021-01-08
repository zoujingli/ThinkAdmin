<?php

namespace app\data\controller;

use app\data\service\MessageService;
use think\admin\Controller;

/**
 * 短信发送管理
 * Class UserMessage
 * @package app\data\controller
 */
class UserMessage extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'DataUserMessage';

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
        $query = $this->_query($this->table);
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
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
