
// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

define(['jquery'], function () {

    /*!
     * jQuery placeholder, fix for IE6,7,8,9
     */
    var JPlaceHolder = {
        _check: function () {
            return 'placeholder' in document.createElement('input');
        },
        init: function () {
            !this._check() && this.fix();
        },
        fix: function () {
            $(':input[placeholder]').map(function () {
                var self = $(this), txt = self.attr('placeholder');
                self.wrap($('<div></div>').css({zoom: '1', margin: 'none', border: 'none', padding: 'none', background: 'none', position: 'relative'}));
                var pos = self.position(), h = self.outerHeight(true), paddingleft = self.css('padding-left');
                var holder = $('<span></span>').text(txt).css({position: 'absolute', left: pos.left, top: pos.top, height: h, lineHeight: h + 'px', paddingLeft: paddingleft, color: '#aaa'}).appendTo(self.parent());
                self.on('focusin focusout change keyup', function () {
                    self.val() ? holder.hide() : holder.show();
                });
                holder.click(function () {
                    self.get(0).focus();
                });
                self.val() && holder.hide();
            });
        }
    };
    JPlaceHolder.init();

    /**
     * 定义消息处理构造方法
     */
    function msg() {
        this.version = '2.0';
        this.shade = [0.02, '#000'];
        this.closeIndexs = {};
    }

    /**
     * 关闭消息框
     */
    msg.prototype.close = function () {
        if (!this.closeIndexs['_' + this.index]) {
            this.closeIndexs['_' + this.index] = true;
            return layer.close(this.index);
        }
    };

    /**
     * 弹出警告消息框
     * @param msg 消息内容
     * @param callback 回调函数
     * @return {*|undefined}
     */
    msg.prototype.alert = function (msg, callback) {
        this.close();
        return this.index = layer.alert(msg, {end: callback, scrollbar: false});
    };

    /**
     * 确认对话框
     * @param msg 提示消息内容
     * @param ok 确认的回调函数
     * @param no 取消的回调函数
     * @return {undefined|*}
     */
    msg.prototype.confirm = function (msg, ok, no) {
        var self = this;
        return this.index = layer.confirm(msg, {btn: ['确认', '取消']}, function () {
            typeof ok === 'function' && ok.call(this);
            self.close();
        }, function () {
            typeof no === 'function' && ok.call(this);
            self.close();
        });
    };

    /**
     * 显示成功类型的消息
     * @param msg 消息内容
     * @param time 延迟关闭时间
     * @param callback 回调函数
     * @return {common_L11._msg|*}
     */
    msg.prototype.success = function (msg, time, callback) {
        this.close();
        return this.index = layer.msg(msg, {
            icon: 1,
            shade: this.shade,
            scrollbar: false,
            end: callback,
            time: (time || 2) * 1000,
            shadeClose: true
        });
    };

    /**
     * 显示失败类型的消息
     * @param msg 消息内容
     * @param time 延迟关闭时间
     * @param callback 回调函数
     * @return {common_L11._msg|*}
     */
    msg.prototype.error = function (msg, time, callback) {
        this.close();
        return this.index = layer.msg(msg, {
            icon: 2,
            shade: this.shade,
            scrollbar: false,
            time: (time || 3) * 1000,
            end: callback,
            shadeClose: true
        });
    };

    /**
     * 状态消息提示
     * @param msg 消息内容
     * @param time 显示时间s
     * @param callback 回调函数
     * @return {common_L11._msg|*}
     */
    msg.prototype.tips = function (msg, time, callback) {
        this.close();
        return this.index = layer.msg(msg, {
            time: (time || 3) * 1000,
            shade: this.shade,
            end: callback,
            shadeClose: true
        });
    };

    /**
     * 显示正在加载中的提示
     * @param msg 提示内容
     * @param callback 回调方法
     * @return {common_L11._msg|*}
     */
    msg.prototype.loading = function (msg, callback) {
        this.close();
        return this.index = msg
                ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: callback})
                : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
    };

    /**
     * 自动处理显示Think返回的Json数据
     * @param data JSON数据对象
     * @param time 延迟关闭时间
     * @return {common_L11._msg|*}
     */
    msg.prototype.auto = function (data, time) {
        var self = this;
        if (parseInt(data.code) === 1) {
            return self.success(data.msg, time, function () {
                !!data.url ? (window.location.href = data.url) : $.form.reload();
                if (self.autoSuccessCloseIndexs && self.autoSuccessCloseIndexs.length > 0) {
                    for (var i in self.autoSuccessCloseIndexs) {
                        layer.close(self.autoSuccessCloseIndexs[i]);
                    }
                    self.autoSuccessCloseIndexs = [];
                }
            });
        }
        self.error(data.msg, 3, function () {
            !!data.url && (window.location.href = data.url);
        });
    };

    /**
     * auto处理成功的自动关闭
     * @param index
     */
    msg.prototype.addAutoSuccessCloseIndex = function (index) {
        this.autoSuccessCloseIndexs = this.autoSuccessCloseIndexs || [];
        this.autoSuccessCloseIndexs.push(index);
    };

    /**
     * 将消息对象挂载到Jq
     */
    $.msg = new msg();


    /**
     * 表单构造函数
     * @private
     */
    function _form() {
        this.version = '2.0';
        this.errMsg = '{status}服务器繁忙，请稍候再试！';
    }

    /**
     * 异步加载的数据
     * @param url 请求的地址
     * @param data 额外请求数据
     * @param type 提交的类型 GET|POST
     * @param callback 成功后的回调方法
     * @param loading 是否显示加载层
     * @param tips 提示消息
     * @param time 消息提示时间
     */
    _form.prototype.load = function (url, data, type, callback, loading, tips, time) {
        var self = this, dialogIndex = 0;
        (loading !== false) && (dialogIndex = $.msg.loading(tips));
        (typeof Pace === 'object') && Pace.restart();
        $.ajax({
            type: type || 'GET',
            url: $.menu.parseUri(url),
            data: data || {},
            statusCode: {
                404: function () {
                    $.msg.tips(self.errMsg.replace('{status}', 'E404 - '));
                },
                500: function () {
                    $.msg.tips(self.errMsg.replace('{status}', 'E500 - '));
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                $.msg.tips(self.errMsg.replace('{status}', 'E' + textStatus + ' - '));
            },
            success: function (res) {
                $.msg.close(dialogIndex);
                if (typeof callback === 'function' && callback.call(self, res) === false) {
                    return false;
                }
                if (typeof (res) === 'object') {
                    return $.msg.auto(res, time);
                }
                self.show(res);
            }
        });
    };

    /**
     * 动态HTML事件重载
     * @param $container
     */
    _form.prototype.reInit = function ($container) {
        $.validate.listen.call(this), JPlaceHolder.init();
        $container.find('[required]').parent().prevAll('label').addClass('label-required');
    };

    /**
     * 加载HTML到目标位置
     * @param url 目标URL地址
     * @param data URL参数
     * @param callback 回调函数
     * @param loading 是否显示加载
     * @param tips 提示消息
     */
    _form.prototype.open = function (url, data, callback, loading, tips) {
        this.load(url, data, 'GET', function (res) {
            if (typeof (res) === 'object') {
                return $.msg.auto(res);
            }
            var $container = $('.layer-main-container').html(res);
            reinit.call(this), setTimeout(reinit, 500), setTimeout(reinit, 1000);
            return (typeof callback === 'function') && callback.call(this);
            function reinit() {
                $.form.reInit($container);
            }
        }, loading, tips);
    };

    /**
     * 打开一个内置HTML页面
     * @param url
     * @param obj
     */
    _form.prototype.href = function (url, obj) {
        window.location.href = '#' + $.menu.parseUri(url, obj);
    };

    /**
     * 加载HTML到弹出层
     * @param url
     * @param data
     * @param title
     * @param callback
     * @param loading
     * @param tips
     */
    _form.prototype.modal = function (url, data, title, callback, loading, tips) {
        this.load(url, data, 'GET', function (res) {
            if (typeof (res) === 'object') {
                return $.msg.auto(res);
            }
            layer.open({
                type: 1,
                btn: false,
                area: "800px",
                content: res,
                title: title || '',
                success: function (dom, index) {
                    // 此窗口完成时需要自动关闭
                    $.msg.addAutoSuccessCloseIndex(index);
                    var $container = $(dom);
                    /* 处理样式及返回按钮事件 */
                    $container.find('[data-close]').off('click').on('click', function () {
                        if ($(this).attr('data-confirm')) {
                            $.msg.confirm($(this).attr('data-confirm'), function () {
                                layer.close(index);
                            });
                        } else {
                            layer.close(index);
                        }
                    });
                    /* 事件重载 */
                    $.form.reInit($container);
                }
            });
            return (typeof callback === 'function') && callback.call(this);
        }, loading, tips);
    };

    /**
     * 显示HTML到中主内容区
     * @param html
     */
    _form.prototype.show = function (html) {
        var $container = $('.layer-main-container').html(html);
        reinit.call(this), setTimeout(reinit, 500), setTimeout(reinit, 1000);
        function reinit() {
            $.form.reInit($container);
        }
    };

    /**
     * 打开一个iframe窗口
     * @param url iframe打开的URL地址
     * @param title 窗口标题
     */
    _form.prototype.iframe = function (url, title) {
        return layer.open({title: title || '窗口', type: 2, area: ['800px', '530px'], fix: true, maxmin: false, content: url});
    };

    /**
     * 关闭FORM框
     * @return {*|jQuery}
     */
    _form.prototype.close = function () {
        return $(this._modal).modal('hide');
    };

    /**
     * 刷新当前页面
     */
    _form.prototype.reload = function () {
        window.onhashchange.call(this);
    };

    /*!表单实例挂载*/
    $.form = new _form();

    /**
     * 定义模块函数
     * @returns {validate_L1.validate}
     */
    var validate = function () {
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
     * 判断表单元素是否为空
     * @param {type} ele
     * @param {type} value
     * @returns {Boolean}
     */
    validate.prototype.isEmpty = function (ele, value) {
        value = value || ele.getAttribute('placeholder');
        var trimValue = this.trim(ele.value);
        return (trimValue === "" || trimValue === value);
    };

    /**
     * 正则验证表单元素
     * @param {type} ele
     * @param {type} regex
     * @param {type} params
     * @returns {Boolean}
     */
    validate.prototype.isRegex = function (ele, regex, params) {
        // 原始值和处理值
        var inputValue = ele.value, dealValue = inputValue;
        var self = this, type = this.getElementType(ele);
        if (type !== "password") {  // 密码不trim前后空格
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
    };

    /**
     * 检侧所的表单元素
     */
    validate.prototype.isAllpass = function (elements, options) {
        if (!elements) {
            return true;
        }
        var allpass = true, self = this, params = options || {};
        if (elements.size && elements.size() === 1 && elements.get(0).tagName.toLowerCase() === "form") {
            elements = $(elements).find(self.inputTag);
        } else if (elements.tagName && elements.tagName.toLowerCase() === "form") {
            elements = $(elements).find(self.inputTag);
        }
        elements.each(function () {
            if (self.checkInput(this, params) === false) {
                return $(this).focus(), (allpass = false);
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
        $(ele).addClass('validate-error'), this.insertErrorEle(ele);
        $($(ele).data('input-info')).addClass('fadeInRight animated').css({width: 'auto'}).html(content);
    };

    /**
     * 错误消息消除
     */
    validate.prototype.successPlacement = function (ele) {
        $(ele).removeClass('validate-error'), this.insertErrorEle(ele);
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
        var params = $.extend({}, options || {}), self = this;
        // 去除HTML默认验证
        $(form).attr("novalidate", "novalidate");
        // 表单元素动态监听
        $(form).find(self.inputTag).map(function () {
            var func = function () {
                self.checkInput(this);
            };
            for (var i in self.checkEvent) {
                if (self.checkEvent[i] === true) {
                    $(this).off(i, func).on(i, func);
                }
            }
        });
        // 表单提交事情监听
        $(form).bind("submit", function (event) {
            if (self.isAllpass($(this).find(self.inputTag), params) && typeof callback === 'function') {
                callback.call(this, $(form).serialize());
            }
            return event.preventDefault(), false;
        });
        // 表单对象绑定
        return $(form).data('validate', this);
    };

    /**
     * 注册对象到JqFn
     * @param callback
     * @param options
     * @return {$|Function|Zepto}
     */
    $.fn.validate = function (callback, options) {
        return (new validate()).check(this, callback, options);
    };

    /**
     * 注册对象到Jq
     * @param form
     * @param callback
     * @param options
     * @return {$|Function|Zepto}
     */
    $.validate = function (form, callback, options) {
        return (new validate()).check(form, callback, options);
    };

    /*! 自动监听规则内表单 */
    $.validate.listen = function () {
        $('form[data-auto]').map(function () {
            if ($(this).attr('data-listen') !== 'true') {
                // 表单监听初始化
                var callback = $(this).attr('data-callback');
                $(this).attr('data-listen', 'true').validate(function (data) {
                    $.form.load(this.getAttribute('action') || window.location.href,
                            data,
                            this.getAttribute('method') || 'POST',
                            window[callback || '_default_callback'] || undefined,
                            true,
                            this.getAttribute('data-tips') || undefined,
                            this.getAttribute('data-time') || undefined);
                });
                // 表单监听初始完成后的处理
                $(this).find('[data-form-loaded]').map(function () {
                    $(this).html(this.getAttribute('data-form-loaded') || this.innerHTML);
                    $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
                });
            }
        });
    };

    /**
     * 后台菜单辅助插件
     * @returns {plugsL#14.menu}
     */
    var menu = function () {
        this.version = '1.0';
    };

    /*! 计算URL地址中有效的URI */
    menu.prototype.getUri = function (uri) {
        uri = uri || window.location.href;
        uri = (uri.indexOf(window.location.host) !== -1 ? uri.split(window.location.host)[1] : uri).split('?')[0];
        return (uri.indexOf('#') !== -1 ? uri.split('#')[1] : uri);
    };

    /*! 通过URI查询最有可能的菜单NODE */
    menu.prototype.queryNode = function (url) {
        var $menu = $('[data-menu-node][data-open*="_URL_"]'.replace('_URL_', url.replace(/\.html$/ig, '')));
        if ($menu.size()) {
            return $menu.get(0).getAttribute('data-menu-node');
        }
        return /^m\-/.test(node = location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1')) ? node : '';
    };

    /*!　URL转URI */
    menu.prototype.parseUri = function (uri, obj) {
        var params = {};
        if (uri.indexOf('?') !== -1) {
            var queryParams = uri.split('?')[1].split('&');
            for (var i in queryParams) {
                if (queryParams[i].indexOf('=') !== -1) {
                    var hash = queryParams[i].split('=');
                    try {
                        params[hash[0]] = window.decodeURIComponent(window.decodeURIComponent(hash[1].replace(/%2B/ig, ' ')));
                    } catch (e) {
                        console.log([e, uri, queryParams, hash]);
                    }
                }
            }
        }
        uri = this.getUri(uri);
        params.spm = obj && obj.getAttribute('data-menu-node') || this.queryNode(uri);
        if (!params.token) {
            var token = window.location.href.replace(/.*token=(\w+).*/ig, '$1');
            (/^\w{16}$/.test(token)) && (params.token = token);
        }
        delete params[""];
        var query = '?' + $.param(params);
        return uri + (query !== '?' ? query : '');
    };

    /*! 后台菜单动作初始化 */
    menu.prototype.listen = function () {
        /*! 左侧菜单状态切换 */
        $('ul.sidebar-trans .nav-item a').on('click', function () {
            $(this).parents('.sidebar-nav.main-nav').addClass('open').find('ul.sidebar-trans').show();
            $('.sidebar-trans .nav-item').not($(this).parent().addClass('active')).removeClass('active');
        });
        $('body').on('click', '.framework-sidebar-full .sidebar-title', function () {
            var $trans = $(this).next('ul.sidebar-trans'), node = $trans.attr('data-menu-node') || false;
            node && $.cookie(node, $(this).parent().toggleClass('open').hasClass('open') ? 2 : 1);
            $(this).parent().hasClass('open') ? $trans.show() : $trans.hide();
        });
        $('ul.sidebar-trans').map(function () {
            var node = this.getAttribute('data-menu-node') || false;
            node && (parseInt($.cookie(node) || 2) === 2) && $(this).show().parent().addClass('open');
        });

        /*! Mini 菜单模式 Tips 显示*/
        $('body').on('mouseenter mouseleave', '.framework-sidebar-mini .sidebar-trans .nav-item,.framework-sidebar-mini .sidebar-title', function (e) {
            $(this).tooltip({
                template: '<div class="console-sidebar-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
                title: $(this).text(), placement: 'right', container: 'body'
            }).tooltip('show'), (e.type === 'mouseleave') && $(this).tooltip('destroy');
        });

        /*! 切换左侧菜单 */
        var $menutarget = $('[data-menu-target]').on('click', function () {
            $menutarget.not($(this).addClass('active')).removeClass('active');
            var menuNode = $(this).attr('data-menu-target');
            var $leftmenu = $('[data-menu-box=' + menuNode + ']').removeClass('hide');
            $("[data-menu-box]").not($leftmenu).addClass('hide');
            $leftmenu.find('[data-open]:first').trigger('click')
        });

        /*! 左侧菜单样式切换 */
        var $targetmenu = $('.sidebar-fold').on('click', function () {
            var $body = $('.framework-body').toggleClass('framework-sidebar-mini framework-sidebar-full');
            $.cookie('menu-style', $body.hasClass('framework-sidebar-mini') ? 'mini' : 'full');
        });
        ($.cookie('menu-style') !== 'mini') && $targetmenu.trigger('click');

        /*! URI路由处理 */
        window.onhashchange = function () {
            var hash = (window.location.hash || '').substring(1), node = hash.replace(/.*spm=([\d\-m]+).*/ig, "$1");
            if (!/^m\-[\d\-]+$/.test(node)) {
                node = $.menu.queryNode($.menu.getUri()) || '';
            }
            if (hash.length < 1 || node.length < 1) {
                return $('.topbar-home-link:first').trigger('click');
            }
            /* 顶部菜单选中处理 */
            var parentNode = [node.split('-')[0], node.split('-')[1]].join('-');
            $('[data-menu-target]').not($('[data-menu-target="' + parentNode + '"]').addClass('active')).removeClass('active');
            /* 左则菜单处理 */
            var $menu = $('[data-menu-node="' + node + '"]').eq(0);
            if ($menu.size() > 0) {
                $('.framework-container').addClass('framework-sidebar-full');
                var $li = $menu.parent('li').addClass('active');
                $li.parents('.framework-sidebar').find('li.active').not($li).removeClass('active');
                $menu.parents('.sidebar-trans').removeClass('hide').show();
                $menu.parents('.main-nav').addClass('open');
                $menu.parents('[data-menu-box]').removeClass('hide').siblings('[data-menu-box]').addClass('hide');
            } else {
                $('.framework-container').removeClass('framework-sidebar-full');
            }
            $.form.open(hash);
        };
        // URI初始化动作
        window.onhashchange.call(this);
    };

    /*! 实例并加载到jQ对象上 */
    $.menu = new menu();

});