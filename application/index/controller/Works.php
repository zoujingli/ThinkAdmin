<?php

namespace app\index\controller;

use controller\BasicWechat;
use service\DocumentService;

class Works extends BasicWechat
{
	
	protected $guid;
	
	/**
	 * 禁用自动网页授权
	 *
	 * @var bool
	 */
	protected $checkAuth = true;

	protected function _initSysArgs()
	{
		$this->guid = input('guid/d', 0);
		
		if(input('d'))
		{
			print_r($this->fansinfo);
		}
	
	}

	/**
	 * 我的作品
	 */
	public function index()
	{
		// 获取用户详情信息
		return view('index', ['title' => '我的作品']);
	}

	/**
	 * 作品详情
	 */
	public function detail()
	{
		$item_info = DocumentService::getWorksById($this->guid);
		
		if(input('d'))
		{
			print_r($item_info);
		}
		
		return view('detail', ['title' => '作品详情', 'item_info' => $item_info]);
	}

}
