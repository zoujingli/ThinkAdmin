(new function () {
    this.app = angular.module("michat", []).run(callback);
    angular.bootstrap(document.getElementById(this.app.name), [this.app.name]);

    function callback($rootScope) {
        $rootScope.text = '';
        $rootScope.user = {};
        $rootScope.list = [];

        // 数字位数处理
        function toNum(value, fixed) {
            while (("" + value).length < fixed) value = '0' + value;
            return value;
        }

        // 显示时间内容
        $rootScope.showDatetime = function (date) {
            var md, td, tm, my = new Date();
            md = my.getFullYear() + '-' + toNum(my.getMonth() + 1, 2) + '-' + toNum(my.getDate(), 2);
            td = date.getFullYear() + '-' + toNum(date.getMonth() + 1, 2) + '-' + toNum(date.getDate(), 2);
            tm = toNum(date.getHours(), 2) + ':' + toNum(date.getMinutes(), 2) + ':' + toNum(date.getSeconds(), 2);
            return md === td ? tm : (td + tm);
        };
        for (let i = 10; i <= 99; i++) $rootScope.list.push({
            active: false,
            headimg: 'https://demo.thinkadmin.top/upload/decb0fe26fa3f486/b3f6521bf29403c8.png',
            username: 'nickname_a_' + i,
            nickname: 'NickName_A_B_C' + i,
            message: [
                {
                    type: 'text',
                    float: 'left',
                    nickname: 'Nickname_A_' + i,
                    headimg: 'https://demo.thinkadmin.top/upload/decb0fe26fa3f486/b3f6521bf29403c8.png',
                    content: '消息内容_1_' + i,
                    datetime: new Date()
                },
                {
                    type: 'text',
                    float: 'right',
                    username: 'think_admin',
                    nickname: 'ThinkAdmin',
                    headimg: 'https://demo.thinkadmin.top/upload/decb0fe26fa3f486/b3f6521bf29403c8.png',
                    content: '消息内容_2_' + i,
                    datetime: new Date()
                },
                {
                    type: 'text',
                    float: 'right',
                    username: 'think_admin',
                    nickname: 'ThinkAdmin',
                    headimg: 'https://demo.thinkadmin.top/upload/decb0fe26fa3f486/b3f6521bf29403c8.png',
                    content: '消息内容_2_' + i,
                    datetime: new Date()
                },
                {
                    type: 'text',
                    float: 'left',
                    username: 'nickname_a_' + i,
                    nickname: 'Nickname_A_' + i,
                    headimg: 'https://demo.thinkadmin.top/upload/decb0fe26fa3f486/b3f6521bf29403c8.png',
                    content: '消息内容_2_' + i,
                    datetime: new Date()
                }
            ]
        });
        // 移除当前用户
        $rootScope.removeUser = function (user, temp) {
            temp = [];
            for (let i in $rootScope.list) {
                if ($rootScope.list[i].username !== user.username) {
                    temp.push($rootScope.list[i]);
                }
            }
            $rootScope.list = temp;
        };
        // 聊天内容底部
        $rootScope.scrollBottom = function () {
            setTimeout(function (div) {
                div = document.querySelector('.michat-right-list');
                div.scrollTop = div.scrollHeight;
            }, 10);
        };
        // 切换当前用户
        $rootScope.switchUser = function (user) {
            for (let i in $rootScope.list) {
                if ($rootScope.list[i].username === user.username) {
                    $rootScope.list[i].active = true;
                    $rootScope.user = user;
                } else {
                    $rootScope.list[i].active = false;
                }
            }
            this.scrollBottom();
        };
        // 回复消息内容
        $rootScope.replyUser = function () {
            if ($rootScope.text.length < 1) {
                alert('请输入内容');
            }
            $rootScope.user.message.push({
                type: 'text',
                float: 'right',
                username: 'NICKNAME_A',
                headimg: 'https://demo.thinkadmin.top/upload/decb0fe26fa3f486/b3f6521bf29403c8.png',
                content: $rootScope.text,
                datetime: new Date()
            });
            $rootScope.text = '';
            $rootScope.scrollBottom();
        };
        // 默认选择会话
        $rootScope.switchUser($rootScope.list[2]);
    }
});

