<?php

if (!function_exists('think_string_to_array')) {
    /**
     * 字符串转数组
     * @param string $text 待转内容
     * @param string $separ 分隔字符
     * @param null|array $allow 限定规则
     * @return array
     */
    function think_string_to_array(string $text, string $separ = ',', $allow = null): array
    {
        $text = trim($text, $separ);
        $data = $text ? explode($separ, $text) : [];
        if (is_array($allow)) foreach ($data as $key => $mark) {
            if (!in_array($mark, $allow)) unset($data[$key]);
        }
        return $data;
    }
}

if (!function_exists('think_array_to_string')) {
    /**
     * 数组转字符串
     * @param array $data 待转数组
     * @param string $separ 分隔字符
     * @return string
     */
    function think_array_to_string(array $data, string $separ = ',')
    {
        return join($separ, $data);
    }
}

if (!function_exists('think_show_goods_spec')) {
    /**
     * 商品规格过滤显示
     * @param string $spec 原规格内容
     * @return string
     */
    function think_show_goods_spec(string $spec): string
    {
        $specs = [];
        foreach (explode(';;', $spec) as $sp) {
            $specs[] = explode('::', $sp)[1];
        }
        return join(' ', $specs);
    }
}