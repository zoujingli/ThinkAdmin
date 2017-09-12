<?php

namespace app\index\widget;

use think\Controller;
use service\CommentService;
use Hashids\Hashids;

/**
 * 评论发布/显示框
 *
 * @example {:widget('Comment/render', array('app'=>'works', 'permaid'=>$item_info['id']))}
 * @author CocaCoffee
 */
class Comment extends Controller
{
	
	// 模型
	protected $models;
	// 页码
	protected $page;
	protected $page_size;
	
	// 配置
	protected $config;

	/**
	 * 初始化业务级参数
	 */
	protected function _initialize()
	{
		// 系统级参数
		$this->page = input('p/d');
		$this->page_size = config('paginate.list_rows');
		
		// 加载模型
		$this->models = config('comment_models');
	}

	/**
	 * 渲染输出评论
	 *
	 * @param unknown $data
	 */
	public function render($app, $permaid, $adapter = 'render')
	{
		$data['permaid'] = (int)$permaid;
		
		// 统一格式，首字母大写
		$data['app'] = ucfirst($app);
		
		// 对应modelid
		$modelid = array_search($data['app'], $this->models);
		$hashids = new Hashids(config('data_auth_key'), 9);
		$data['token'] = $hashids->encode($permaid, $modelid); // o2fXhV
		
		// 获取评论数据
		$map = array(
			'model' => $data['app'], 
			'permaid' => $permaid, 
			'censor_status' => array('EGT', 0)
		);
		// 精彩评论
		$map_hot = array_merge($map, array('likes' => array('EGT', 5)));
		
		$data['list'] 	 = CommentService::getList($map, $this->page_size, $this->page);
		$data['hotlist'] = CommentService::getList($map_hot, $this->page_size, $this->page);
		
		// 分页
		$data['page'] = '';
		
		// 输出
		return $this->fetch('extra@comment/'.$adapter, ['data'=>$data]);
	}

}