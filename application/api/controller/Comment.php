<?php

namespace app\api\controller;

use controller\BasicApi;
use service\CommentService;
use Hashids\Hashids;
use think\Db;

class Comment extends BasicApi
{
	
	protected $page, $page_size, $app, $permaid;
	
	protected function _initSysArgs()
	{
		// 评论校验token
		$token = input('token');
		$hashids = new Hashids(config('data_auth_key'), 9);
		list($this->permaid, $modelid) = $hashids->decode($token);
		
		// 加载评论模型
		$models = config('comment_models');
		$this->app = $models[$modelid];
	}

	public function index()
	{
		$this->page = input('page/d');
		$this->page_size = config('paginate.list_rows');
		
		$map = array(
			'model' => $this->app, 
			'permaid' => $this->permaid, 
			'censor_status' => array('EGT', 0)
		);
		
		// 获取评论
		$list = CommentService::getList($map, $this->page_size, $this->page);
		// 渲染数据
		$data = $this->fetch('index', ['list' => $list]);
		
		return $this->response('SUCCESS', '200', $data);
	
	}

	public function add()
	{
		$openid = session('openid');
		$user = getUserByOpenid($openid, 'id,nickname');
		
		$data['model'] = $this->app;
		$data['permaid'] = $this->permaid;
		$data['parent_id'] = input('parent_id/d');
		$data['author_id'] = $user['id'];
		$data['author_name'] = $user['nickname'];
		$data['author_ip'] = get_client_ip();
		$data['create_at'] = time();
		$data['message'] = input('content', NULL, 'addslashes');
		
		if (empty($data['message'])) return;
		
		//计算当前评论的楼层
		$data['storey'] = Db::name('AppsComment')->where('permaid', $this->permaid)->max('storey') + 1;
		
		$id = Db::name('AppsComment')->insertGetId($data);
	}
	
	public function praise() 
	{
		$guid = $data['id'] = input('id/d');
	
		// 获取cookie
		$cookie_key = 'comment_praise_'.$guid;
		$record  = cookie($cookie_key);
	
		if ($record) {
			$data['errCode'] = 1;
			$data['errMsg'] = '淡定点，淡定点，您已经点过赞了！';
		} else {
			// 点赞+1
			Db::name('AppsComment')->where('id', $guid)->setInc('likes', 1);
			$data['up'] = Db::name('AppsComment')->where('id', $guid)->value('likes');
			cookie($cookie_key, 1, 60*60);
		}
		
		return $this->response('SUCCESS', 200, $data);
	}
}