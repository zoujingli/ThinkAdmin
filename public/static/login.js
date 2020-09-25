// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
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
        (that = this), require(["md5"], function (md5) {
            $("form").vali(function (data) {
                data['password'] = md5.hash(md5.hash(data['password']) + data['uniqid']);
                $.form.load(location.href, data, "post", function (ret) {
                    if (parseInt(ret.code) !== 1) {
                        $(that).find('[data-captcha]').trigger('click');
                        $(that).find('.verify.layui-hide').removeClass('layui-hide');
                    }
                }, null, null, 'false');
            });
        });
    });

    /*! 登录图形验证码刷新 */
    $body.on('click', '[data-captcha]', function () {
        var $that = $(this), $form = $that.parents('form');
        var action = this.dataset.captcha || location.href;
        if (action.length < 5) return $.msg.tips('请设置验证码请求及验证地址');
        var type = this.dataset.captchaType || 'captcha-type', token = this.dataset.captchaToken || 'captcha-token';
        var uniqid = this.dataset.fieldUniqid || 'captcha-uniqid', verify = this.dataset.fieldVerify || 'captcha-verify';
        $.form.load(action, {type: type, token: token}, 'post', function (ret) {
            if (ret.code) {
                $that.html('<img alt="img" src="' + ret.data.image + '"><input type="hidden">').find('input').attr('name', uniqid).val(ret.data.uniqid || '');
                $form.find('[name="' + verify + '"]').attr('value', ret.data.code || '').val(ret.data.code || '');
                return (ret.data.code || $form.find('.verify.layui-hide').removeClass('layui-hide')), false;
            }
        }, false);
    });

    /*! 初始化登录图形 */
    $('[data-captcha]').map(function () {
        $(this).trigger('click');
    });

});