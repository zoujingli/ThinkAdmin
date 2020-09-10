<?php

if (!function_exists('think_string_to_array')) {
    /**
     * 字符串转数组
     * @param string $text
     * @param string $separ
     * @return array|false|string[]
     */
    function think_string_to_array(string $text, string $separ = ','): array
    {
        $text = trim($text, $separ);
        return $text ? explode($separ, $text) : [];
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