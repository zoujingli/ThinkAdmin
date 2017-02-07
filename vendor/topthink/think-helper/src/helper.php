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

if (!function_exists('class_basename')) {
    /**
     * 获取类名(不包含命名空间)
     *
     * @param  string|object $class
     * @return string
     */
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('class_uses_recursive')) {
    /**
     *获取一个类里所有用到的trait，包括父类的
     *
     * @param $class
     * @return array
     */
    function class_uses_recursive($class)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }

        $results = [];

        foreach (array_merge([$class => $class], class_parents($class)) as $class) {
            $results += trait_uses_recursive($class);
        }

        return array_unique($results);
    }
}

if (!function_exists('trait_uses_recursive')) {
    /**
     * 获取一个trait里所有引用到的trait
     *
     * @param  string $trait
     * @return array
     */
    function trait_uses_recursive($trait)
    {
        $traits = class_uses($trait);

        foreach ($traits as $trait) {
            $traits += trait_uses_recursive($trait);
        }

        return $traits;
    }
}