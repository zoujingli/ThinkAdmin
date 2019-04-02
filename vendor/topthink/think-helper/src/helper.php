<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------


if (!function_exists('classnames')) {
    /**
     * css样式名生成器
     * classnames("foo", "bar"); // => "foo bar"
     * classnames("foo", [ "bar"=> true ]); // => "foo bar"
     * classnames([ "foo-bar"=> true ]); // => "foo-bar"
     * classnames([ "foo-bar"=> false ]); // => "
     * classnames([ "foo" => true ], [ "bar"=> true ]); // => "foo bar"
     * classnames([ "foo" => true, "bar"=> true ]); // => "foo bar"
     * classnames("foo", [ "bar"=> true, "duck"=> false ], "baz", [ "quux"=> true ]); // => "foo bar baz quux"
     * classnames(null, false, "bar", 0, 1, [ "baz"=> null ]); // => "bar 1"
     */
    function classnames()
    {
        $args    = func_get_args();
        $classes = array_map(function ($arg) {
            if (is_array($arg)) {
                return implode(" ", array_filter(array_map(function ($expression, $class) {
                    return $expression ? $class : false;
                }, $arg, array_keys($arg))));
            }
            return $arg;
        }, $args);
        return implode(" ", array_filter($classes));
    }
}