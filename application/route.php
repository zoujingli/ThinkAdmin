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


think\Route::get([
	// 作品	
	'works$'  		=> 'Index/Works/index',
	'works/:guid'  	=> ['Index/Works/detail', [], ['guid'=>'\d+']],
		
	'api/works$'	=> 'Api/Works/index',
		
	// 评论
	'api/comment/praise/:id' => ['Api/Comment/praise', [], ['id'=>'\d+']],
	'api/comment/:token' => ['Api/Comment/index', [], ['token'=>'[a-zA-Z0-9]+']],
]);

think\Route::post([
	// 评论
	'api/comment/add/:token' => ['Api/Comment/add', [], ['token'=>'[a-zA-Z0-9]+']],
]);

return [];
