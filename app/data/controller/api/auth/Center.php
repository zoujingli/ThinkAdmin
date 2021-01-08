<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\UserService;
use think\admin\Storage;
use think\exception\HttpResponseException;

/**
 * 用户资料管理
 * Class Center
 * @package app\data\controller\api\auth
 */
class Center extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUser';

    /**
     * 更新用户资料
     * @throws \think\db\exception\DbException
     */
    public function set()
    {
        $data = $this->_vali([
            'headimg.default'       => '',
            'username.default'      => '',
            'base_age.default'      => '',
            'base_sex.default'      => '',
            'base_height.default'   => '',
            'base_weight.default'   => '',
            'base_birthday.default' => '',
        ]);
        foreach ($data as $key => $vo) {
            if ($vo === '') unset($data[$key]);
        }
        if (empty($data)) $this->error('没有修改的数据！');
        if ($this->app->db->name($this->table)->where(['id' => $this->uuid])->update($data) !== false) {
            $this->success('更新资料成功！', $this->getUser());
        } else {
            $this->error('更新资料失败！');
        }
    }

    /**
     * 获取用户资料
     */
    public function get()
    {
        $this->success('获取用户资料', $this->getUser());
    }

    /**
     * 获取用户数据统计
     */
    public function total()
    {
        $this->success('获取用户统计!', UserService::instance()->total($this->uuid));
    }

    /**
     * Base64 图片上传
     */
    public function image()
    {
        try {
            $data = $this->_vali(['base64.require' => '图片内容不为空！']);
            if (preg_match('|^data:image/(.*?);base64,|i', $data['base64'])) {
                [$ext, $img] = explode('|||', preg_replace('|^data:image/(.*?);base64,|i', '$1|||', $data['base64']));
                $info = Storage::instance()->set(Storage::name($img, $ext ?: 'png', 'image/'), base64_decode($img));
                $this->success('图片上传成功！', ['url' => $info['url']]);
            } else {
                $this->error('解析内容失败！');
            }
        } catch (HttpResponseException $exception) {
            throw $exception;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    /**
     * 二进制文件上传
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function upload()
    {
        $file = $this->request->file('file');
        if (empty($file)) $this->error('文件上传异常！');
        $extension = strtolower($file->getOriginalExtension());
        if (in_array($extension, ['php', 'sh'])) $this->error('禁止上传此类文件！');
        $bina = file_get_contents($file->getRealPath());
        $name = Storage::name($file->getPathname(), $extension, '', 'md5_file');
        $info = Storage::instance()->set($name, $bina, false, $file->getOriginalName());
        if (is_array($info) && isset($info['url'])) {
            $this->success('文件上传成功！', $info);
        } else {
            $this->error('文件上传失败！');
        }
    }

    /**
     * 绑定用户邀请人
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function bindFrom()
    {
        $data = $this->_vali(['from.require' => '邀请人不能为空']);
        if ($data['from'] == $this->uuid) {
            $this->error('邀请人不能是自己', UserService::instance()->total($this->uuid));
        }
        $from = $this->app->db->name($this->table)->where(['id' => $data['from']])->find();
        if (empty($from)) $this->error('邀请人状态异常', UserService::instance()->get($this->type, $this->uuid));
        if ($this->user['from'] > 0) $this->error('已绑定了邀请人', UserService::instance()->total($this->uuid));
        $data['path'] = rtrim($from['path'] ?: '-', '-') . '-' . $from['id'] . '-';
        if ($this->app->db->name($this->table)->where(['id' => $this->uuid])->update($data) !== false) {
            $this->success('绑定邀请人成功', UserService::instance()->total($this->uuid));
        } else {
            $this->error('绑定邀请人失败', UserService::instance()->total($this->uuid));
        }
    }

    /**
     * 获取我邀请的朋友
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getFrom()
    {
        $query = $this->_query($this->table)->field('id,from,username,nickname,headimg,create_at');
        $this->success('获取我邀请的朋友', $query->where(['from' => $this->uuid])->order('id desc')->page(true, false, false, 15));
    }
}