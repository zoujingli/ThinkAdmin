<?php

namespace app\admin\traits;

/**
 * 列表搜索构建器-用于快速生成搜索html代码
 * Trait SearchTraits
 */
trait SearchTraits
{

    /**
     * 搜索html
     * @var string
     */
    protected $searchHtml;

    /**
     * 搜索显示标题
     * @var string
     */
    protected $searchTitle = '条件搜索';

    /**
     * 搜索参数
     * @var array
     */
    protected $searchParames;

    /**
     * 搜索请求地址
     * @var string
     */
    protected $searchRequestUrl;

    /**
     * 搜索器类型
     * @var array
     */
    protected $searchTypeArray = [
        'text', // 文本类 （默认，或者不存在时都是选择它）
        'select', // 下拉框
        'year', // 年选择器
        'month', // 年月选择器
        'time', // 时间选择器
        'date', // 日期选择器
        'datetime', // 日期时间选择器
    ];

    /**
     * 设置搜索标题
     * @param $title
     * @return $this
     */
    public function setSearchTitle($title)
    {
        $this->searchTitle = $title;
        return $this;
    }

    /**
     * 搜索请求地址
     * @param $url
     * @return $this
     */
    public function setSearchRequestUrl($url)
    {
        $url = url($url);
        $this->searchRequestUrl = $url;
        return $this;
    }

    /**
     * 设置搜索参数
     * @param null $parames
     * @return $this
     */
    public function setSearchParames($parames = null)
    {
        $this->searchParames = $parames;
        $this->buildSearchHtml();
        return $this;
    }

    /**
     * 构建搜索html
     * @return $this
     */
    protected function buildSearchHtml()
    {
        list($searchParamesHtml, $searchScript, $option) = [null, null, null];
        foreach ($this->searchParames as &$vo) {
            // 判断参数异常
            if (!isset($vo['name'])) {
                continue;
            }
            if (isset($vo['type']) && !in_array($vo['type'], $this->searchTypeArray)) {
                $vo['type'] = $this->searchTypeArray[0];
            }

            // 补齐参数
            !isset($vo['type']) && $vo['type'] = 'text';
            !isset($vo['title']) && $vo['title'] = $vo['name'];
            !isset($vo['value']) && $vo['value'] = input("get.{$vo['name']}", null);
            !isset($vo['range']) && $vo['range'] = false;
            if (!isset($vo['tips'])) {
                if ($vo['type'] == 'text') {
                    $vo['tips'] = "请输入{$vo['title']}";
                } elseif ($vo['type'] == 'select') {
                    $vo['tips'] = [];
                } else {
                    $vo['tips'] = "请选择{$vo['title']}";
                }
            }
            if ($vo['type'] == 'select' && !is_array($vo['tips'])) {
                $vo['tips'] = [$vo['tips']];
            }

            if ($vo['type'] == 'text') { // 文本
                $searchParamesHtml .= <<<EOT
        <div class="layui-form-item layui-inline">
            <label class="layui-form-label">{$vo['title']}</label>
            <div class="layui-input-inline">
                <input name="{$vo['name']}" value="{$vo['value']}" placeholder="{$vo['tips']}" class="layui-input">
            </div>
        </div>
EOT;
            } elseif ($vo['type'] == 'select') { // 下拉选择
                $vo['tips'] = array_merge(['' => '- 全部 -'], $vo['tips']);
                foreach ($vo['tips'] as $k => $v) {
                    if ($k == $vo['value']) {
                        $option .= " <option selected value='{$k}'>{$v}</option>";
                    } else {
                        $option .= " <option value='{$k}'>{$v}</option>";
                    }
                }
                $searchParamesHtml .= <<<EOT
        <div class="layui-form-item layui-inline">
            <label class="layui-form-label">{$vo['title']}</label>
            <div class="layui-input-inline">
                <select class="layui-select" name="{$vo['name']}">
                {$option}
                </select>
            </div>
        </div>
EOT;
            } else { // 时间类型
                $searchParamesHtml .= <<<EOT
        <div class="layui-form-item layui-inline">
            <label class="layui-form-label">{$vo['title']}</label>
            <div class="layui-input-inline">
                <input name="{$vo['name']}" value="{$vo['value']}" placeholder="{$vo['tips']}" class="layui-input">
            </div>
        </div>
EOT;
                if ($vo['range']) {
                    $searchScript .= <<<EOT
laydate.render({range: true, type: '{$vo['type']}',elem: '[name="{$vo['name']}"]'});
EOT;
                } else {
                    $searchScript .= <<<EOT
laydate.render({type: '{$vo['type']}',elem: '[name="{$vo['name']}"]'});
EOT;
                }
            }
        }
        $this->searchHtml = $this->getSearchTemplate();
        $this->searchHtml = str_replace("{%searchTitle%}", $this->searchTitle, $this->searchHtml);
        $this->searchHtml = str_replace("{%searchParamesHtml%}", $searchParamesHtml, $this->searchHtml);
        $this->searchHtml = str_replace("{%searchScript%}", $searchScript, $this->searchHtml);
        return $this;
    }

    /**
     * 获取搜索模板
     * @return string
     */
    protected function getSearchTemplate()
    {
        empty($this->searchRequestUrl) && $this->searchRequestUrl = request()->url();
        $template = <<<EOT
<fieldset>
    <legend>{%searchTitle%}</legend>
    <form class="layui-form layui-form-pane form-search" action="{$this->searchRequestUrl}" onsubmit="return false" method="get" autocomplete="off">
        <div class="layui-form-item layui-inline">
        {%searchParamesHtml%}
        <div class="layui-form-item layui-inline">
            <button class="layui-btn layui-btn-primary"><i class="layui-icon">&#xe615;</i> 搜 索</button>
        </div>
    </form>
    <script>
        form.render();
        {%searchScript%}
    </script>
</fieldset>
EOT;
        return $template;
    }

}