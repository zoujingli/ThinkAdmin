
require(['socket', 'layui', 'json'], function () {
    layui.config({dir: baseUrl + 'plugs/layui/'});
    WEB_SOCKET_DEBUG = true;
    WEB_SOCKET_SWF_LOCATION = "//cdn.bootcss.com/web-socket-js/1.0.0/WebSocketMain.swf";
    var userinfo = {
    };
    var socket;
    function connect_socket() {
        socket = new WebSocket('ws://basic.demo.cuci.cc:8888');
        socket.onopen = function () {
            socket.send(JSON.stringify({type: 'init'}));
        };
        socket.onmessage = function (e) {
            var msg = JSON.parse(e.data);
            switch (msg.type) {
                case 'push':
                for (var i in msg.data) {
                    if (userinfo['id'] !== msg.data[i].id)
                    {
                        console.log(msg.data[i]);
                        layui.layim.getMessage(msg.data[i]);
                    }
                    return;
                }
            }
        };
        socket.onclose = connect_socket;
    }
    connect_socket.call(this);
    layui.use('layim', function (layim) {
        //基础配置
        layim.config({
            init: {
                url: 'http://basic.demo.cuci.cc/socket/init.html'
            }
            , find: ''
            , copyright: true
        });
        //监听发送消息
        layim.on('sendMessage', function (data) {
            socket.send(JSON.stringify({type: 'msg', data: data}));
        });
    });



});