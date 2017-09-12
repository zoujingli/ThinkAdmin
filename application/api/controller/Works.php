<?php

namespace app\api\controller;

use controller\BasicApi;
use service\DocumentService;

class Works extends BasicApi
{

	public function index()
	{
		$page = input('page/d');
		
		$list = DocumentService::getWorksList(['is_deleted'=>0], 15, $page);
		
		return $this->response('SUCCESS', '200', $list);
		
	}
}