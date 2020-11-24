<?php

namespace app\data\controller;

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
     * 删除短信记录
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}
