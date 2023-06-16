// +----------------------------------------------------------------------
// | Static Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-static
// | github 代码仓库：https://github.com/zoujingli/think-plugs-static
// +----------------------------------------------------------------------

define(function () {

    let template = '<div class="padding-30 padding-bottom-0" data-queue-load="{{d.code}}"><div class="layui-elip notselect nowrap" data-message-title><b class="color-desc">...</b></div><div class="margin-top-15 layui-progress layui-progress-big" lay-showPercent="yes"><div class="layui-progress-bar transition" lay-percent="0.00%"></div></div>' + '<div class="margin-top-15"><code class="layui-textarea layui-bg-black border-0" style="resize:none;overflow:hidden;height:190px"></code></div></div>';

    return Queue;

    function Queue(code, doScript, element) {
        let queue = this;
        (this.doAjax = true) && (this.doReload = false) || layer.open({
            type: 1, title: false, area: ['560px', '315px'], anim: 2, shadeClose: false, end: function () {
                queue.doAjax = queue.doReload && doScript && $.layTable.reload(((element || {}).dataset || {}).tableId || true) && false;
            }, content: laytpl(template).render({code: code}), success: function ($elem) {
                new Progress($elem, code, queue, doScript);
            }
        });
    }

    function Progress($elem, code, queue, doScript) {
        let that = this;

        this.$box = $elem.find('[data-queue-load=' + code + ']');
        if (queue.doAjax === false || this.$box.length < 1) return false;

        this.$code = this.$box.find('code');
        this.$title = this.$box.find('[data-message-title]');
        this.$percent = this.$box.find('.layui-progress div');

        // 设置数据缓存
        this.SetCache = function (code, index, value) {
            let ckey = code + '_' + index, ctype = 'admin-queue-script';
            return value !== undefined ? layui.data(ctype, {key: ckey, value: value}) : layui.data(ctype)[ckey] || 0;
        };

        // 更新任务显示状态
        this.SetState = function (status, message) {
            if (message.indexOf('javascript:') === -1) if (status === 1) {
                that.$title.html('<b class="color-text">' + message + '</b>').addClass('text-center');
                that.$percent.addClass('layui-bg-blue').removeClass('layui-bg-green layui-bg-red');
            } else if (status === 2) {
                if (message.indexOf('>>>') > -1) {
                    that.$title.html('<b class="color-blue">' + message + '</b>').addClass('text-center');
                } else {
                    that.$title.html('<b class="color-blue">正在处理：</b>' + message).removeClass('text-center');
                }
                that.$percent.addClass('layui-bg-blue').removeClass('layui-bg-green layui-bg-red');
            } else if (status === 3) {
                queue.doReload = true;
                that.$title.html('<b class="color-green">' + message + '</b>').addClass('text-center');
                that.$percent.addClass('layui-bg-green').removeClass('layui-bg-blue layui-bg-red');
            } else if (status === 4) {
                that.$title.html('<b class="color-red">' + message + '</b>').addClass('text-center');
                that.$percent.addClass('layui-bg-red').removeClass('layui-bg-blue layui-bg-green');
            }
        };

        // 读取任务进度信息
        this.LoadProgress = function () {
            if (queue.doAjax === false || that.$box.length < 1) return false;
            $.form.load(tapiRoot + '/api.queue/progress', {code: code}, 'post', function (ret) {
                if (ret.code) {
                    let lines = [];
                    for (let idx in ret.data.history) {
                        let line = ret.data.history[idx], percent = '[ ' + line.progress + '% ] ';
                        if (line.message.indexOf('javascript:') === -1) {
                            lines.push(line.message.indexOf('>>>') > -1 ? line.message : percent + line.message);
                        } else if (!that.SetCache(code, idx) && doScript !== false) {
                            that.SetCache(code, idx, 1)
                            $.form.goto(line.message);
                        }
                    }
                    if (ret.data.status > 0) {
                        that.SetState(parseInt(ret.data.status), ret.data.message);
                        that.$percent.attr('lay-percent', (parseFloat(ret.data.progress || '0.00').toFixed(2)) + '%') && layui.element.render();
                        that.$code.html('<p class="layui-elip">' + lines.join('</p><p class="layui-elip">') + '</p>').animate({scrollTop: that.$code[0].scrollHeight + 'px'}, 200);
                        parseInt(ret.data.status) === 3 || parseInt(ret.data.status) === 4 || setTimeout(that.LoadProgress, Math.floor(Math.random() * 200));
                    } else {
                        setTimeout(that.LoadProgress, Math.floor(Math.random() * 500) + 200);
                    }
                    return false;
                }
            }, false);
        };

        // 首页加载进度信息
        this.LoadProgress();
    }
});