<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use controller\BasicAdmin;
use service\DocumentService;
use think\Db;

/**
 * 文档管理
 * Class Menu
 *
 * @package app\admin\controller
 * @author Anyon <zoujingli@qq.com>
 *         @date 2017/02/15
 */
class Works extends BasicAdmin
{
	
	/**
	 * 绑定作品操作模型
	 *
	 * @var string
	 */
	public $table = 'AppsWorks';

	public function index()
	{
		$this->title = '作品列表';
		return parent::_list($this->table);
	}
	
	/**
	 * 列表数据处理
	 * @param array $data
	 */
	protected function _index_data_filter(&$data)
	{
		foreach ($data as &$vo) {
			$vo['link'] = getWorksUrl($vo['id']);
		}
	}
	

	/**
	 * 添加菜单
	 */
	public function add()
	{
		if($this->request->isGet())
		{
			$this->title = '添加作品';
			$this->assign('categories', Db::name('AppsCategory')->column('id', 'title'));
			return $this->_form($this->table, 'form');
		}
		if($this->request->isPost())
		{
			$data = $this->request->post();
			
			if(($result = $this->_apply_works($data)) &&  ! empty($result))
			{
				$this->success('作品添加成功！', '');
			}
			$this->error('作品添加失败，请稍候再试！');
		}
	
	}

	/**
	 * 编辑菜单
	 */
	public function edit()
	{
		$id = input('id/d');
		
		if($this->request->isGet())
		{
			empty($id) && $this->error('参数错误，请稍候再试！');
			// 详情
			return view('form', ['title' => '编辑作品', 'vo' => DocumentService::getWorksById($id)]);
		}
		
		// 获取提交数据
		$data = $this->request->post();
		
		if(($result = $this->_apply_works($data, $id)))
		{
			$this->success('作品更新成功！', '');
		}
		$this->error('作品添加失败，请稍候再试！');
	}

	/**
	 * 作品更新操作
	 *
	 * @param array $data
	 * @param array $ids
	 * @return string
	 */
	protected function _apply_works($data, $id = 0)
	{
		// 更新时间
		$data['update_time'] = time();
		
		// 替换存储地址
		$data['vfile'] = str_replace(sysconf('storage_local_domain'), '', $data['vfile']);
		$data['cover'] = str_replace(sysconf('storage_local_domain'), '', $data['cover']);
		$data['photos'] = str_replace(sysconf('storage_local_domain'), '', $data['photos']);
		
		if(empty($id))
		{
			// 创建时间
			$data['create_time'] = time();
			
			// 组图
			$data['photos'] = explode('|', $data['photos']);
			foreach($data['photos'] as $key => $photo)
			{
				$item['photo'] = $photo;
				$item['text'] = '';
				// 存放数据格式
				$data['photos'][$key] = $item;
			}
			$data['photos'] = json_encode($data['photos'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			
			$result = Db::name('AppsWorks')->insertGetId($data);
		}
		else
		{
			// 获取作品详情
			$works = DocumentService::getWorksById($id);
			foreach($works['photos'] as $key => &$photo)
			{
				$photo['photo'] = str_replace(sysconf('storage_local_domain'), '', $photo['photo']);
				$photo['text'] = $data['text'][$key];
			}
			
			// 新增组图
			if( ! empty($data['photos']))
			{
				$data['photos'] = explode('|', $data['photos']);
				foreach($data['photos'] as $key => $vo)
				{
					$item['photo'] = $vo;
					$item['text'] = '';
					// 存放数据格式
					$data['photos'][$key] = $item;
				}
				$data['photos'] = array_merge($works['photos'], $data['photos']);
			}
			else
			{
				$data['photos'] = $works['photos'];
			}
			
			unset($data['guid']);
			unset($data['text']);
			$data['photos'] = json_encode($data['photos'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			
			$result = Db::name('AppsWorks')->where('id', $id)->update($data);
		}
		return $result;
	}

}
