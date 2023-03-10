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

$(function () {

    window.$body = $('body');

    /*! 登录界面背景切换 */
    $('[data-bg-transition]').each(function (i, el) {
        el.idx = 0, el.imgs = [], el.SetBackImage = function (css) {
            window.setTimeout(function () {
                $(el).removeClass(el.imgs.join(' ')).addClass(css)
            }, 1000) && $body.removeClass(el.imgs.join(' ')).addClass(css)
        }, el.lazy = window.setInterval(function () {
            el.imgs.length > 0 && el.SetBackImage(el.imgs[++el.idx] || el.imgs[el.idx = 0]);
        }, 5000) && el.dataset.bgTransition.split(',').forEach(function (image) {
            layui.img(image, function (img, cssid, style) {
                style = document.createElement('style'), cssid = 'LoginBackImage' + (el.imgs.length + 1);
                style.innerHTML = '.' + cssid + '{background-image:url("' + encodeURI(image) + '")!important}';
                document.head.appendChild(style) && el.imgs.push(cssid);
            });
        });
    });

    /*! 后台加密登录处理 */
    $body.find('form[data-login-form]').each(function (idx, form) {
        require(['md5'], function (md5) {
            $(form).vali(function (data) {
                data['password'] = md5.hash(md5.hash(data['password']) + data['uniqid']);
                $.form.load(location.href, data, "post", function (ret) {
                    if (parseInt(ret.code) !== 1) {
                        $(form).find('[data-captcha]').trigger('click');
                        $(form).find('.verify.layui-hide').removeClass('layui-hide');
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