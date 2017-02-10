(function ($) {

    /**
     * 定义模块函数
     * @returns {validate_L1.validate}
     */
    var validate = function () {
        // 模式检测
        this.isSupport = ($('<input type="email">').attr("type") === "email");
        // 表单元素
        this.inputTag = 'input,textarea,select';
        // 检测元素事件
        this.checkEvent = {change: true, blur: true, keyup: false};
    };

    /**
     *获取表单元素的类型
     */
    validate.prototype.getElementType = function (ele) {
        return (ele.getAttribute("type") + "").replace(/\W+$/, "").toLowerCase();
    };

    /**
     *去除字符串两头的空格
     */
    validate.prototype.trim = function (str) {
        return str.replace(/(^\s*)|(\s*$)/g, '');
    };


    /**
     * 标签元素是否可见
     * @returns {Boolean}
     */
    validate.prototype.isVisible = function (ele) {
        return $(ele).is(':visible');
    };

    /**
     * 检测属性是否有定义
     * @param {type} ele
     * @param {type} prop
     * @param {type} undefined
     * @returns {Boolean}
     */
    validate.prototype.hasProp = function (ele, prop, undefined) {
        if (typeof prop !== "string") {
            return false;
        }
        var attrProp = ele.getAttribute(prop);
        return (attrProp !== undefined && attrProp !== null && attrProp !== false)
    };

    /**
     * 设置文件选择范围
     * @param {type} ele
     * @param {type} start
     * @param {type} end
     * @returns {validate_L1.validate.prototype}
     */
    validate.prototype.selectRange = function (ele, start, end) {
        if (ele.createTextRange) {
            var range = ele.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        } else {
            //ele.focus();
            ele.setSelectionRange(start, end);
        }
        return this;
    };

    /**
     * 判断表单元素是否为空
     * @param {type} ele
     * @param {type} value
     * @returns {Boolean}
     */
    validate.prototype.isEmpty = function (ele, value) {
        value = value || ele.getAttribute('placeholder');
        var trimValue = ele.value;
        trimValue = this.trim(trimValue);
        if (trimValue === "" || trimValue === value) {
            return true;
        }
        return false;
    };

    /**
     * 正则验证表单元素
     * @param {type} ele
     * @param {type} regex
     * @param {type} params
     * @returns {Boolean}
     */
    validate.prototype.isRegex = function (ele, regex, params) {
        var self = this;
        // 原始值和处理值
        var inputValue = ele.value;
        var dealValue = inputValue;
        var type = this.getElementType(ele);

        if (type !== "password") {
            // 密码不trim前后空格
            dealValue = this.trim(inputValue);
            if (dealValue !== inputValue) {
                if (ele.tagName.toLowerCase() !== "textarea") {
                    ele.value = dealValue;
                } else {
                    ele.innerHTML = dealValue;
                }
            }
        }
        // 获取正则表达式，pattern属性获取优先，然后通过type类型匹配。注意，不处理为空的情况
        regex = regex || ele.getAttribute('pattern');
        if (dealValue === "" || !regex) {
            return true;
        }
        // multiple多数据的处理
        var isMultiple = this.hasProp(ele, 'multiple'), newRegExp = new RegExp(regex, params || 'i');
        // number类型下multiple是无效的
        if (isMultiple && !/^number|range$/i.test(type)) {
            var isAllPass = true;
            var dealValues = dealValue.split(",");
            for (var i in dealValues) {
                var partValue = self.trim(dealValues[i]);
                if (isAllPass && !newRegExp.test(partValue)) {
                    isAllPass = false;
                }
            }
            return isAllPass;
        } else {
            return newRegExp.test(dealValue);
        }
        return true;
    };

    /**
     * 检侧所的表单元素
     */
    validate.prototype.isAllpass = function (elements, options) {
        if (!elements) {
            return true;
        }
        var params = options || {};
        var allpass = true;
        var self = this;
        if (elements.size && elements.size() === 1 && elements.get(0).tagName.toLowerCase() === "form") {
            elements = $(elements).find(self.inputTag);
        } else if (elements.tagName && elements.tagName.toLowerCase() === "form") {
            elements = $(elements).find(self.inputTag);
        }
        elements.each(function () {
            if (self.checkInput(this, params) === false) {
                $(this).focus();
                allpass = false;
                return false;
            }
        });
        return allpass;
    };

    /**
     * 验证标志
     */
    validate.prototype.remind = function (input, type, tag) {
        var text = '';
        // 如果元素完全显示
        if (this.isVisible(input)) {
            if (type === "radio" || type === "checkbox") {
                this.errorPlacement(input, this.getErrMsg(input));
            } else if (tag === "select" || tag === "empty") {
                // 下拉值为空或文本框文本域等为空
                this.errorPlacement(input, (tag === "empty" && text) ? "您尚未输入" + text : this.getErrMsg(input));
            } else if (/^range|number$/i.test(type) && Number(input.value)) {
                // 整数值与数值的特殊提示
                this.errorPlacement(input, "值无效");
            } else {
                // 文本框文本域格式不准确
                var finalText = this.getErrMsg(input);
                if (text) {
                    finalText = "您输入的" + text + "格式不准确";
                }
                this.errorPlacement(input, finalText);
            }
        }
        return false;
    };

    /**
     * 检测表单单元
     */
    validate.prototype.checkInput = function (input, options) {
        var type = this.getElementType(input);
        var tag = input.tagName.toLowerCase();
        var isRequired = this.hasProp(input, "required");
        var isNone = this.hasProp(input, 'data-auto-none');
        //无需要验证
        if (isNone || input.disabled || type === 'submit' || type === 'reset' || type === 'file' || type === 'image' || !this.isVisible(input)) {
            return;
        }
        var allpass = true;
        // 需要验证的有
        if (type === "radio" && isRequired) {
            var eleRadios = input.name ? $("input[type='radio'][name='" + input.name + "']") : $(input);
            var radiopass = false;
            eleRadios.each(function () {
                if (radiopass === false && $(this).is("[checked]")) {
                    radiopass = true;
                }
            });
            if (radiopass === false) {
                allpass = this.remind(eleRadios.get(0), type, tag);
            } else {
                this.successPlacement(input);
            }
        } else if (type === "checkbox" && isRequired && !$(input).is("[checked]")) {
            allpass = this.remind(input, type, tag);
        } else if (tag === "select" && isRequired && !input.value) {
            allpass = this.remind(input, type, tag);
        } else if ((isRequired && this.isEmpty(input)) || !(allpass = this.isRegex(input))) {
            allpass ? this.remind(input, type, "empty") : this.remind(input, type, tag);
            allpass = false;
        } else {
            this.successPlacement(input);
        }
        return allpass;
    };

    /**
     *获取错误提示的内容
     */
    validate.prototype.getErrMsg = function (ele) {
        return ele.getAttribute('title') || '';
    };

    /**
     * 错误消息显示
     * @param {type} ele
     * @param {type} content
     * @param {type} options
     * @returns {undefined}
     */
    validate.prototype.errorPlacement = function (ele, content) {
        $(ele).addClass('validate-error');
        this.insertErrorEle(ele);
        $($(ele).data('input-info')).addClass('fadeInRight animated').css({width: 'auto'}).html(content);
    };

    /**
     * 错误消息消除
     */
    validate.prototype.successPlacement = function (ele) {
        $(ele).removeClass('validate-error');
        this.insertErrorEle(ele);
        $($(ele).data('input-info')).removeClass('fadeInRight').css({width: '30px'}).html('');
    };

    /**
     * 错误消息标签插入
     * @param {type} ele
     * @returns {undefined}
     */
    validate.prototype.insertErrorEle = function (ele) {
        var $html = $('<span style="-webkit-animation-duration:.2s;animation-duration:.2s;padding-right:20px;color:#a94442;position:absolute;right:0;font-size:12px;z-index:2;display:block;width:34px;text-align:center;pointer-events:none"></span>');
        $html.css({top: $(ele).position().top + 'px', paddingTop: $(ele).css('paddingTop'), paddingBottom: $(ele).css('paddingBottom'), lineHeight: $(ele).css('lineHeight')});
        $(ele).data('input-info') || $(ele).data('input-info', $html.insertAfter(ele));
    };

    /**
     * 表单验证入口
     * @param {type} callback
     * @param {type} options
     * @returns {$|Function|Zepto}
     */
    validate.prototype.check = function (form, callback, options) {
        var self = this;
        var defaults = {
            // 取消浏览器默认的HTML验证
            novalidate: true,
            // 禁用submit按钮可用
            submitEnabled: true,
            // 额外的其他验证
            validate: function () {
                return true;
            }
        };
        var params = $.extend({}, defaults, options || {});
        if (this.isSupport) {
            if (params.novalidate) {
                $(form).attr("novalidate", "novalidate");
            } else {
                params.hasTypeNormally = true;
            }
        }

        // disabled的submit按钮还原
        if (params.submitEnabled) {
            $(form).find("[disabled]").each(function () {
                if (/^image|submit$/.test(this.type)) {
                    $(this).removeAttr("disabled");
                }
            });
        }

        //元素动态监听
        $(form).find(self.inputTag).map(function () {
            for (var i in self.checkEvent) {
                if (self.checkEvent[i] === true) {
                    $(this).off(i).on(i, function () {
                        self.checkInput(this);
                    });
                }
            }
        });

        $(form).bind("submit", function (event) {
            var elements = $(this).find(self.inputTag);
            if (self.isAllpass(elements, params) && params.validate() && $.isFunction(callback)) {
                var sdata = {};
                var data = $(form).serializeArray();
                for (var i in data) {
                    var key = data[i].name, value = data[i].value;
                    if (sdata.hasOwnProperty(key)) {
                        if (typeof sdata[key] === 'object') {
                            sdata[key].push(value);
                        } else {
                            sdata[key] = [sdata[key], value];
                        }
                    } else {
                        sdata[key] = value;
                    }
                }
                callback.call(this, sdata);
            }
            event.preventDefault();
            return false;
        });
        return $(form);
    };

    /**
     * 注册对象到Jq
     * @param {type} form
     * @param {type} callback
     * @param {type} options
     * @returns {undefined}
     */
    $.validate = function (form, callback, options) {
        (new validate()).check(form, callback, options);
    };

    /**
     * 注册对象到JqFn
     * @param {type} callback
     * @param {type} options
     * @returns {jquery.validate_L1.$|Function|Zepto|$}
     */
    $.fn.validate = function (callback, options) {
        return (new validate()).check(this, callback, options);
    };

    if ($.form && typeof $.form.load === 'function') {
        $.validate.listen = function () {
            $('form[data-auto]').map(function () {
                if ($(this).attr('data-listen') === 'true') {
                    return;
                }
                var callback = $(this).attr('data-callback');
                $(this).attr('data-listen', "true").validate(function (data) {
                    $.form.load(this.getAttribute('action') || window.location.href, data,
                            this.getAttribute('method') || 'POST',
                            window[callback || '_default_callback'] || undefined, true,
                            this.getAttribute('data-tips') || undefined,
                            this.getAttribute('data-time') || undefined);
                });
            });
        };
        $.validate.listen.call(this);
    }
})(jQuery);
