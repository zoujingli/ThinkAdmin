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

    return function (form, callable, onConfirm) {
        var that = this;
        // 绑定表单元素
        this.form = $(form);
        // 绑定元素事件
        this.evts = 'blur change';
        // 检测表单元素
        this.tags = 'input,textarea';
        // 预设检测规则
        this.patterns = {
            qq: '^[1-9][0-9]{4,11}$',
            ip: '^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$',
            url: '^((https?|ftp|file):\\/\\/)?([\\da-z\\.-]+)\\.([a-z\\.]{2,6})([\\/\\w \\.-]*)*\\/?$',
            phone: '^1[3-9][0-9]{9}$',
            email: '^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$',
            wechat: '^[a-zA-Z]([-_a-zA-Z0-9]{5,19})+$',
            cardid: '^[1-9]\\d{5}(18|19|([23]\\d))\\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\\d{3}[0-9Xx]$',
            userame: '^[a-zA-Z0-9_-]{4,16}$',
        };
        this.isRegex = function (el, value, pattern) {
            pattern = pattern || el.getAttribute('pattern');
            if ((value = value || $.trim($(el).val())) === '') return true;
            if (!(pattern = this.patterns[pattern] || pattern)) return true;
            return new RegExp(pattern, 'i').test(value);
        };
        this.hasProp = function (el, prop) {
            var attrProp = el.getAttribute(prop);
            return typeof attrProp !== 'undefined' && attrProp !== null && attrProp !== false;
        };
        this.needCheck = function (el, type) {
            if (this.hasProp(el, 'data-auto-none')) return false;
            type = (el.getAttribute('type') || '').replace(/\W+/, '').toLowerCase();
            return $.inArray(type, ['file', 'reset', 'image', 'radio', 'checkbox', 'submit', 'hidden']) < 0;
        };
        this.checkAllInput = function () {
            var status = true;
            return this.form.find(this.tags).each(function () {
                !that.checkInput(this) && status && (status = !$(this).focus());
            }) && status;
        };
        this.checkInput = function (el) {
            if (!this.needCheck(el)) return true;
            if (this.hasProp(el, 'required') && $.trim($(el).val()) === '') return this.remind(el, 'required');
            return this.isRegex(el) ? !!this.hideError(el) : this.remind(el, 'pattern');
        };
        this.remind = function (el, type, tips) {
            return $(el).is(':visible') ? this.showError(el, tips || el.getAttribute(type + '-error') || function (name, tips) {
                return name ? name + (type === 'required' ? '不能为空' : "格式错误") : (tips || el.getAttribute('placeholder') || '输入格式错误');
            }(el.getAttribute('vali-name') || el.getAttribute('data-vali-name'), el.getAttribute('title'))) && false : true;
        };
        this.showError = function (el, tip) {
            return this.insertError($(el).addClass('validate-error')).addClass('layui-anim-fadein').css({width: 'auto'}).html(tip);
        };
        this.hideError = function (el) {
            return this.insertError($(el).removeClass('validate-error')).removeClass('layui-anim-fadein').css({width: '30px'}).html('');
        };
        this.insertError = function (el) {
            if ($(el).data('input-info')) return $(el).data('input-info');
            var $html = $('<span class="absolute block layui-anim text-center font-s12 notselect" style="color:#A44;z-index:2"></span>');
            var $next = $(el).nextAll('.input-right-icon'), right = ($next ? $next.width() + parseFloat($next.css('right') || '0') : 0) + 10;
            var style = {top: $(el).position().top + 'px', right: right + 'px', lineHeight: el.nodeName === 'TEXTAREA' ? '32px' : $(el).css('height')};
            $(el).data('input-info', $html.css(style).insertAfter(el));
            return $html;
        };
        /*! 预埋异常标签*/
        this.form.find(this.tags).each(function () {
            that.needCheck(this) && that.hideError(this, '');
        });
        /*! 表单元素验证 */
        this.form.attr({onsubmit: 'return false', novalidate: 'novalidate', autocomplete: 'off'}).on('keydown', this.tags, function () {
            that.hideError(this)
        }).off(this.evts, this.tags).on(this.evts, this.tags, function () {
            that.checkInput(this);
        }).data('validate', this).bind('submit', function (event) {
            event.preventDefault();
            /* 检查所有表单元素是否通过H5的规则验证 */
            if (that.checkAllInput() && typeof callable === 'function') {
                if (typeof CKEDITOR === 'object' && typeof CKEDITOR.instances === 'object') {
                    for (var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
                }
                /* 触发表单提交后，锁定三秒不能再次提交表单 */
                if (that.form.attr('submit-locked')) return false;
                var submit = that.form.find('button[type=submit],button:not([type=button])');
                onConfirm(submit.attr('data-confirm'), function () {
                    that.form.attr('submit-locked', 1);
                    submit.addClass('submit-button-loading');
                    callable.call(form, that.form.formToJson(), []);
                    setTimeout(function () {
                        that.form.removeAttr('submit-locked');
                        submit.removeClass('submit-button-loading');
                    }, 3000);
                });
            }
        }).find('[data-form-loaded]').map(function () {
            $(this).html(this.dataset.formLoaded || this.innerHTML);
            $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
        });
    }
});