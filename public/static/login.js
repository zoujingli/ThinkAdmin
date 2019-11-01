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
                data['password'] = md5.hash(md5.hash(data['password']) + data['username']);
                if (data['skey']) delete data['skey'];
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
    $body.on('click', '[data-captcha]', function (image, verify, uniqid) {
        image = this, uniqid = this.getAttribute('data-uniqid-field') || 'uniqid';
        verify = this.getAttribute('data-refresh-captcha') || this.getAttribute('data-verify-field') || 'verify';
        $.form.load('?s=admin/login/captcha', {}, 'get', function (ret) {
            image.src = ret.data.image;
            $(image).parents('form').find('[name=' + verify + ']').attr('value', '');
            $(image).parents('form').find('[name=' + uniqid + ']').val(ret.data.uniqid);
            return false;
        }, false);
    });
});