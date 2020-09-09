<?php
if (!function_exists('show_goods_spec')) {
    function show_goods_spec($spec)
    {
        $specs = [];
        foreach (explode(';;', $spec) as $sp) {
            $specs[] = explode('::', $sp)[1];
        }
        return join(' ', $specs);
    }
}