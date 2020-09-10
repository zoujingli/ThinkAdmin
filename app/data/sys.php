<?php
if (!function_exists('show_goods_spec')) {
    /**
     * 商品规格过滤显示
     * @param string $spec
     * @return string
     */
    function show_goods_spec($spec)
    {
        $specs = [];
        foreach (explode(';;', $spec) as $sp) {
            $specs[] = explode('::', $sp)[1];
        }
        return join(' ', $specs);
    }
}