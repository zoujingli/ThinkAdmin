// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

$(function () {

    window.$body = $('body');

    /*! 后台加密登录处理 */
    $body.find('[data-login-form]').map(function (that) {
        that = this;
        require(["md5"], function (md5) {
            $("form").vali(function (data) {
                data['password'] = md5.hash(md5.hash(data['password']) + data['uniqid']);
                $.form.load(location.href, data, "post", function (ret) {
                    if (parseInt(ret.code) !== 1) {
                        $(that).find('.verify.layui-hide').removeClass('layui-hide');
                        $(that).find('[data-captcha]').trigger('click');
                    }
                }, null, null, 'false');
            });
        });
    });

    /*! 登录图形验证码刷新 */
    $body.on('click', '[data-captcha]', function () {
        var type, token, verify, uniqid, action, $that = $(this);
        action = this.getAttribute('data-captcha') || location.href;
        if (action.length < 5) return $.msg.tips('请设置验证码请求地址');
        type = this.getAttribute('data-captcha-type') || 'captcha-type';
        token = this.getAttribute('data-captcha-token') || 'captcha-token';
        uniqid = this.getAttribute('data-field-uniqid') || 'uniqid';
        verify = this.getAttribute('data-field-verify') || 'verify';
        $.form.load(action, {type: type, token: token}, 'post', function (ret) {
            if (ret.code) {
                $that.html('');
                $that.append($('<img alt="img" src="">').attr('src', ret.data.image));
                $that.append($('<input type="hidden">').attr('name', uniqid).val(ret.data.uniqid));
                if (ret.data.code) {
                    $that.parents('form').find('[name=' + verify + ']').attr('value', ret.data.code);
                } else {
                    $that.parents('form').find('[name=' + verify + ']').attr('value', '');
                }
                return false;
            }
        }, false);
    });

    $('[data-captcha]').map(function () {
        $(this).trigger('click')
    });

});