## 搜索构建器 · 使用说明

为了更加方便生成表单列表搜索，此构建器提供快速方法接口，基于ThinkAdmin-v5版本。

下方说明基于会员管理列表来说明。

## 使用说明

1、`PHP` 需要在对应的控制器中引入 `app\admin\traits\SearchTraits`

2、`PHP` 在对应的方法内调用 `$this->setSearchParames();` ，参数请参考下方代码和说明

```php
<?php
namespace app\store\controller;

use library\Controller;

/**
 * 会员信息管理
 * Class Member
 * @package app\store\controller
 */
class Member extends Controller
{

    use \app\admin\traits\SearchTraits;

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'StoreMember';

    /**
     * 会员信息管理
     * @auth true
     * @menu true
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        $this->title = '会员信息管理';
        
        // 搜索构建器示例
        $this->setSearchParames([
            [
                'name'  => 'nickname',
                'type'  => 'text',
                'title' => '会员昵称',
            ],
            [
                'name'  => 'username',
                'type'  => 'text',
                'title' => '会员手机',
            ],
            [
                'name'  => 'level',
                'type'  => 'select',
                'title' => '会员等级',
                'tips'  => ['0'=>'游客会员','1'=>'临时会员','2'=>'VIP1会员','3'=>'VIP2会员'],
            ],
            [
                'name'  => 'create_at',
                'type'  => 'date',
                'title' => '注册时间',
                'range' => true,
            ],
        ]);
        
        $query = $this->_query($this->table)->like('nickname,phone')->equal('vip_level');
        $query->dateBetween('create_at')->order('id desc')->page();
    }
}
```

3、`html` 在对应方法的html模板对应位置加上 `{notempty name='searchHtml'}{$searchHtml|raw}{/notempty}`

```html
{extend name='admin@main'}

{block name="content"}
<div class="think-box-shadow">

    {notempty name='searchHtml'}{$searchHtml|raw}{/notempty}

    <table class="layui-table margin-top-10" lay-skin="line">
        {notempty name='list'}
        <thead>
        <tr>
            <th class='list-table-check-td think-checkbox'>
                <input data-auto-none data-check-target='.list-check-box' type='checkbox'>
            </th>
            <th class='text-left nowrap'>会员昵称</th>
            <th class='text-left nowrap'>会员手机</th>
            <th class='text-left nowrap'>会员级别</th>
            <th class='text-left nowrap'>注册时间</th>
        </tr>
        </thead>
        {/notempty}
        <tbody>
        {foreach $list as $key=>$vo}
        <tr>
            <td class='list-table-check-td think-checkbox'>
                <label><input class="list-check-box" value='{$vo.id}' type='checkbox'></label>
            </td>
            <td class='text-left nowrap'>
                {notempty name='vo.headimg'}
                <img data-tips-image style="width:20px;height:20px;vertical-align:top" src="{$vo.headimg|default=''}" class="margin-right-5">
                {/notempty}
                <div class="inline-block">{$vo.nickname|default='--'}</div>
            </td>
            <td class='text-left'>{$vo.phone|default='--'}</td>
            <td class='text-left'>
                {if $vo.vip_level eq 0} 游客会员
                {elseif $vo.vip_level eq 1} 临时会员（{$vo.vip_date|default=''}）
                {elseif $vo.vip_level eq 2} VIP1会员（{$vo.vip_date|default=''}）
                {elseif $vo.vip_level eq 3} VIP2会员（{$vo.vip_date|default=''}）
                {/if}
            </td>
            <td class='text-left'>{$vo.create_at|format_datetime}</td>
        </tr>
        {/foreach}
        </tbody>
    </table>
    {empty name='list'}<span class="notdata">没有记录哦</span>{else}{$pagehtml|raw|default=''}{/empty}
</div>
{/block}

```

## 参数说明

1、`$this->setSearchParames();` 方法，根据参数生成搜索表单

| 参数名 | 是否必填 | 默认值| 描述 | 备注
| --- | --- | --- | --- | --- |
| name | 是 | 无 | 字段名 | - |
| type | 否 | text | 表单类型 | 'text':文本类,'select':下拉选择,'year':年选择器,'month':年月选择器,'time':时间选择器,'date':日期选择器,'datetime':日期时间选择器] |
| title | 否 | 根据name、type自动生成 | 中文名称 | - |
| tips | 否 | 根据title自动生成 | 提示信息 | 如果type=select，此值需为数组，例如：['0'=>'游客会员','1'=>'临时会员','2'=>'VIP1会员','3'=>'VIP2会员'] |
| range | 否 | false| 是否时间范围 |  当表单为时间选择时生效，为true时可选择时间范围 |

2、`$this->setSearchTitle();` 方法，设置显示标题，默认为：`条件搜索`

3、`$this->setSearchRequestUrl();` 方法，设置搜索请求地址，默认为：`当前链接地址`