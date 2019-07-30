define(['angular', baseRoot + 'plugs/michat/mimc-min_1_0_2.js', 'css!' + baseRoot + 'plugs/michat/michat.css'], function () {
    return new function (that) {
        this.appid = '', this.appkey = '';
        this.secret = '', this.account = '';
        that = this, this.list = [], this.body = $('body');
        // 数据网络请求
        this.httpRequest = function (url, data) {
            this.xhr = new XMLHttpRequest();
            this.xhr.open('post', url, false);
            this.xhr.setRequestHeader('content-type', 'application/json');
            this.xhr.send(JSON.stringify(data));
            return JSON.parse(this.xhr.response);
        };
        // 显示消息图标
        this.showMessageIcon = function () {
            that.body.append('<a class="michat-message-icon layui-btn layui-btn-normal"><i class="layui-icon">&#xe667;</i><b class="michat-message-number">0</b></a>');
            that.body.on('click', '.michat-message-icon', function () {
                layui.$.get(baseRoot + 'plugs/michat/template.html', function (template) {
                    layui.layer.open({
                        type: 1, title: false, skin: 'michat', area: ['800px', '520px'],
                        closeBtn: true, shadeClose: false, content: template, success: function () {
                            layui.$.getScript(baseRoot + 'plugs/michat/chart.js')
                        }
                    });
                });
            });
        };
        this.showMessageIcon();
        // 给指定账号发送消息
        this.send = function (account, payload) {
            this.user.sendMessage(account, payload, false);
        };
        // SDK登录初始化
        this.login = function () {
            this.user = new MIMCUser(this.appid, this.account);
            this.user.registerP2PMsgHandler(function (message) {
                console.log("time: " + new Date(parseInt(message.getTimeStamp())));
                console.log('load：' + message.getPayload());
                that.list.push({
                    type: message.getBizType || 'TEXT',
                    text: message.getPayload(),
                    date: new Date(parseInt(message.getTimeStamp()))
                });
                $('.michat-message-number').html(that.list.length);
            });
            this.user.registerGroupMsgHandler(function (message) {
                console.log(message);
            });
            this.user.registerFetchToken(function () {
                return that.httpRequest('https://mimc.chat.xiaomi.net/api/account/token', {
                    appId: that.appid, appKey: that.appkey, appSecret: that.secret, appAccount: that.account
                });
            });
            this.user.registerStatusChange(function (bindResult, errType, errReason, errDesc) {
                if (bindResult) {
                    console.log("login succeed");
                } else {
                    console.log("login failed.errReason=" + errReason + ",errDesc=" + errDesc + ",errType=" + errType);
                }
            });
            this.user.registerServerAckHandler(function (packetId, sequence, timeStamp, errMsg) {
                console.log(packetId, sequence, timeStamp, errMsg);
            });
            this.user.registerDisconnHandler(function () {
                console.log('disconnect');
            });
            this.user.registerUCDismissHandler(function (topicId) {
                console.log("uc dismiss:" + topicId);
            });
            this.user.registerUCJoinRespHandler(function (topicId, code, msg, context) {
                console.log("uc join:" + topicId + ",code=" + code + ",msg=" + msg + ",context=" + context);
            });
            this.user.registerUCMsgHandler(function (groupMsg) {
                console.log(groupMsg)
            });
            this.user.registerUCQuitRespHandler(function (topicId, code, msg, context) {
                console.log("uc quit:" + topicId + ",code=" + code + ",msg=" + msg + ",context=" + context);
            });
            this.user.login();
        }
    };
});
