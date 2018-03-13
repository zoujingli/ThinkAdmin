// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

// 当前资源URL目录
var baseRoot = (function () {
    var scripts = document.scripts, src = scripts[scripts.length - 1].src;
    return src.substring(0, src.lastIndexOf("/") + 1);
})();

// 配置参数
require.config({
    waitSeconds: 60,
    baseUrl: baseRoot,
    map: {'*': {css: baseRoot + 'plugs/require/require.css.js'}},
    paths: {
        'template': ['plugs/template/template'],
        'pcasunzips': ['plugs/jquery/pcasunzips'],
        // openSource
        'json': ['plugs/jquery/json2.min'],
        'layui': ['plugs/layui/layui'],
        'base64': ['plugs/jquery/base64.min'],
        'angular': ['plugs/angular/angular.min'],
        'ckeditor': ['plugs/ckeditor/ckeditor'],
        'websocket': ['plugs/socket/websocket'],
        // jQuery
        'jquery.ztree': ['plugs/ztree/jquery.ztree.all.min'],
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.cookies': ['plugs/jquery/jquery.cookie'],
        // bootstrap
        'bootstrap': ['plugs/bootstrap/js/bootstrap.min'],
        'bootstrap.typeahead': ['plugs/bootstrap/js/bootstrap3-typeahead.min'],
        'bootstrap.multiselect': ['plugs/bootstrap-multiselect/bootstrap-multiselect'],
        // distpicker
        'distpicker': ['plugs/distpicker/distpicker'],
    },
    shim: {
        // open-source
        'websocket': {deps: [baseRoot + 'plugs/socket/swfobject.min.js']},
        // jquery
        'jquery.ztree': {deps: ['css!' + baseRoot + 'plugs/ztree/zTreeStyle/zTreeStyle.css']},
        // bootstrap
        'bootstrap.typeahead': {deps: ['bootstrap']},
        'bootstrap.multiselect': {deps: ['bootstrap', 'css!' + baseRoot + 'plugs/bootstrap-multiselect/bootstrap-multiselect.css']},
        'distpicker': {deps: [baseRoot + 'plugs/distpicker/distpicker.data.js']},
    },
    deps: ['json', 'bootstrap'],
    // 开启debug模式，不缓存资源
    // urlArgs: "ver=" + (new Date()).getTime()
});

// 注册jquery到require模块
define('jquery', function () {
    return layui.$;
});

// UI框架初始化
PageLayout.call(this);

// UI框架布局函数
function PageLayout(callback, custom) {
    window.WEB_SOCKET_SWF_LOCATION = baseRoot + "plugs/socket/WebSocketMain.swf";
    require(custom || [], callback || false);
}