/* global require, layer, layui */
var a = document.scripts, c = a[a.length - 1].src, baseUrl = c.substring(0, c.lastIndexOf("/") + 1);

require.config({
    baseUrl: baseUrl,
    waitSeconds: 0,
    map: {'*': {css: '//cdn.bootcss.com/require-css/0.1.8/css.min.js'}},
    paths: {
        'pace': ['//cdn.bootcss.com/pace/1.0.2/pace.min', '../plugs/jquery/pace.min'],
        'echarts': ['//cdn.bootcss.com/echarts/3.2.3/echarts.min'],
        'base64': ['//cdn.bootcss.com/Base64/1.0.0/base64.min'],
        'json': ['//cdn.bootcss.com/json2/20150503/json2.min'],
        'socket': ['//cdn.bootcss.com/web-socket-js/1.0.0/web_socket.min'],
        'jquery': ['//cdn.bootcss.com/jquery/1.12.4/jquery.min', '../plugs/jquery/jquery.min'],
        'jquery.icheck': ['//cdn.bootcss.com/iCheck/1.0.2/icheck.min'],
        'jquery.cookies': ['//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie', '../plugs/jquery/jquery.cookie'],
        'bootstrap': ['//cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min', '../plugs/bootstrap/script/bootstrap.min'],
        'bootstrap.multiselect': ['//cdn.bootcss.com/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min', '../plugs/multiselect/bootstrap-multiselect'],
        'pcasunzips': ['../plugs/jquery/pcasunzips'],
        'layui': ['../plugs/layui/layui'],
        'laydate': ['../plugs/layui/laydate/laydate'],
        'template': ['../plugs/template/template'],
        'ueditor': ['../plugs/ueditor/ueditor'],
        'zeroclipboard': ['//cdn.bootcss.com/zeroclipboard/2.2.0/ZeroClipboard.min'],
        'admin.plugs': ['plugs'],
        'admin.listen': ['listen']
    },
    shim: {
        'laydate': {deps: ['jquery']},
        'layui': {deps: ['jquery', 'css!' + baseUrl + '../plugs/layui/css/layui.css']},
        'socket': {deps: ['//cdn.bootcss.com/swfobject/2.2/swfobject.min.js']},
        'bootstrap': {deps: ['jquery']},
        'bootstrap.multiselect': {deps: ['jquery', 'bootstrap', 'css!//cdn.bootcss.com/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css']},
        'jquery.icheck': {deps: ['jquery', 'bootstrap', 'css!//cdn.bootcss.com/iCheck/1.0.2/skins/square/blue.css']},
        'jquery.cookies': {deps: ['jquery']},
        'admin.plugs': {deps: ['jquery', 'layui']},
        'admin.listen': {deps: ['jquery', 'jquery.cookies', 'admin.plugs']},
    },
    deps: ['css!//cdn.bootcss.com/font-awesome/4.6.3/css/font-awesome.min.css'],
    // urlArgs: "t=" + (new Date()).getTime()
});

window.WEB_SOCKET_SWF_LOCATION = "//cdn.bootcss.com/web-socket-js/1.0.0/WebSocketMain.swf";
window.UEDITOR_HOME_URL = (window.ROOT_URL ? window.ROOT_URL + '/static/' : baseUrl) + '../plugs/ueditor/';
window.LAYDATE_PATH = baseUrl + '../plugs/layui/laydate/';

require(['pace', 'jquery', 'layui', 'laydate', 'bootstrap', 'template', 'ueditor', 'jquery.cookies'], function () {
    layui.config({dir: baseUrl + '../plugs/layui/'});
    layui.use(['layer'], function () {
        window.layer = layui.layer;
        require(['admin.listen']);
    });
});
