
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

    // jQuery placeholder, fix for IE6,7,8,9
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

    // 消息处理
    $.msg = new msg();
    function msg() {
        var self = this;
        this.shade = [0.02, '#000'];
        // 关闭消息框
        this.close = function () {
            return layer.close(this.index);
        };
        // 弹出警告消息框
        this.alert = function (msg, callback) {
            return this.index = layer.alert(msg, {end: callback, scrollbar: false});
        };
        // 确认对话框
        this.confirm = function (msg, ok, no) {
            var self = this;
            return this.index = layer.confirm(msg, {btn: ['确认', '取消']}, function () {
                typeof ok === 'function' && ok.call(this);
                self.close();
            }, function () {
                typeof no === 'function' && no.call(this);
                self.close();
            });
        };
        // 显示成功类型的消息
        this.success = function (msg, time, callback) {
            return this.index = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: callback, time: (time || 2) * 1000, shadeClose: true});
        };
        // 显示失败类型的消息
        this.error = function (msg, time, callback) {
            return this.index = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: callback, shadeClose: true});
        };
        // 状态消息提示
        this.tips = function (msg, time, callback) {
            return this.index = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: callback, shadeClose: true});
        };
        // 显示正在加载中的提示
        this.loading = function (msg, callback) {
            return this.index = msg ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: callback}) : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
        };
        this.successNeedCloseLayerIndex = [];
        // 自动处理显示Think返回的Json数据
        this.auto = function (data, time) {
            if (parseInt(data.code) === 1) {
                return self.success(data.msg, time, function () {
                    !!data.url ? (window.location.href = data.url) : $.form.reload();
                    self.close();
                    for (var i in self.successNeedCloseLayerIndex) {
                        layer.close(self.successNeedCloseLayerIndex[i]);
                    }
                    self.successNeedCloseLayerIndex = [];
                });
            }
            return self.error(data.msg, 3, function () {
                !!data.url && (window.location.href = data.url);
            });
        };
    }

    // 表单构造函数
    $.form = new form();
    function form() {
        this.errMsg = '{status}服务器繁忙，请稍候再试！';
        // 内容区域动态加载后初始化
        this.reInit = function ($container) {
            $.validate.listen.call(this), JPlaceHolder.init();
            $container.find('[required]').parent().prevAll('label').addClass('label-required');
        };
        // 以hash打开网页
        this.href = function (url, obj) {
            window.location.href = '#' + $.menu.parseUri(url, obj);
        };
        // 在内容区显示视图
        this.show = function (html) {
            var $container = $('.framework-container').html(html);
            reinit.call(this), setTimeout(reinit, 500), setTimeout(reinit, 1000);
            function reinit() {
                $.form.reInit($container);
            }
        };
        // 刷新当前页面
        this.reload = function () {
            window.onhashchange.call(this);
        };
        // 异步加载的数据
        this.load = function (url, data, type, callback, loading, tips, time) {
            var self = this, dialogIndex = 0;
            (loading !== false) && (dialogIndex = $.msg.loading(tips));
            (typeof Pace === 'object') && Pace.restart();
            $.ajax({
                type: type || 'GET', url: $.menu.parseUri(url), data: data || {},
                statusCode: {
                    404: function () {
                        $.msg.close(dialogIndex);
                        $.msg.tips(self.errMsg.replace('{status}', 'E404 - '));
                    },
                    500: function () {
                        $.msg.close(dialogIndex);
                        $.msg.tips(self.errMsg.replace('{status}', 'E500 - '));
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $.msg.close(dialogIndex);
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
        // 加载HTML到目标位置
        this.open = function (url, data, callback, loading, tips) {
            this.load(url, data, 'get', function (res) {
                if (typeof (res) === 'object') {
                    return $.msg.auto(res);
                }
                var $container = $('.framework-container').html(res);
                reinit.call(this), setTimeout(reinit, 500), setTimeout(reinit, 1000);
                return (typeof callback === 'function') && callback.call(this);
                function reinit() {
                    $.form.reInit($container);
                }
            }, loading, tips);
        };
        // 打开一个iframe窗口
        this.iframe = function (url, title) {
            return layer.open({title: title || '窗口', type: 2, area: ['800px', '530px'], fix: true, maxmin: false, content: url});
        };
        // 加载HTML到弹出层
        this.modal = function (url, data, title, callback, loading, tips) {
            this.load(url, data, 'GET', function (res) {
                if (typeof (res) === 'object') {
                    return $.msg.auto(res);
                }
                var layerIndex = layer.open({type: 1, btn: false, area: "800px", content: res, title: title || '', success: function (dom, index) {
                        $(dom).find('[data-close]').off('click').on('click', function () {
                            if ($(this).attr('data-confirm')) {
                                return $.msg.confirm($(this).attr('data-confirm'), function () {
                                    layer.close(index);
                                });
                            }
                            layer.close(index);
                        });
                        $.form.reInit($(dom));
                    }
                });
                $.msg.successNeedCloseLayerIndex.push(layerIndex);
                return (typeof callback === 'function') && callback.call(this);
            }, loading, tips);
        };
    }

    // 注册对象到JqFn
    $.fn.validate = function (callback, options) {
        return (new validate()).check(this, callback, options);
    };

    // 注册对象到Jq
    $.validate = function (form, callback, options) {
        return (new validate()).check(form, callback, options);
    };

    // 自动监听规则内表单
    $.validate.listen = function () {
        $('form[data-auto]').map(function () {
            if ($(this).attr('data-listen') !== 'true') {
                var callbackname = $(this).attr('data-callback');
                $(this).attr('data-listen', 'true').validate(function (data) {
                    var method = this.getAttribute('method') || 'POST';
                    var tips = this.getAttribute('data-tips') || undefined;
                    var url = this.getAttribute('action') || window.location.href;
                    var callback = window[callbackname || '_default_callback'] || undefined;
                    var time = this.getAttribute('data-time') || undefined;
                    $.form.load(url, data, method, callback, true, tips, time);
                });
                $(this).find('[data-form-loaded]').map(function () {
                    $(this).html(this.getAttribute('data-form-loaded') || this.innerHTML);
                    $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
                });
            }
        });
    };

    // 表单验证
    function validate() {
        var self = this;
        // 表单元素
        this.tags = 'input,textarea,select';
        // 检测元素事件
        this.checkEvent = {change: true, blur: true, keyup: false};
        // 去除字符串两头的空格
        this.trim = function (str) {
            return str.replace(/(^\s*)|(\s*$)/g, '');
        };
        // 标签元素是否可见
        this.isVisible = function (ele) {
            return $(ele).is(':visible');
        };
        // 检测属性是否有定义
        this.hasProp = function (ele, prop) {
            if (typeof prop !== "string") {
                return false;
            }
            var attrProp = ele.getAttribute(prop);
            return (typeof attrProp !== 'undefined' && attrProp !== null && attrProp !== false);
        };
        // 判断表单元素是否为空
        this.isEmpty = function (ele, value) {
            var trimValue = this.trim(ele.value);
            value = value || ele.getAttribute('placeholder');
            return (trimValue === "" || trimValue === value);
        };
        // 正则验证表单元素
        this.isRegex = function (ele, regex, params) {
            var inputValue = ele.value, dealValue = this.trim(inputValue);
            regex = regex || ele.getAttribute('pattern');
            if (dealValue === "" || !regex) {
                return true;
            }
            if (dealValue !== inputValue) {
                (ele.tagName.toLowerCase() !== "textarea") ? (ele.value = dealValue) : (ele.innerHTML = dealValue);
            }
            return new RegExp(regex, params || 'i').test(dealValue);
        };
        // 检侧所的表单元素
        this.isAllpass = function (elements, options) {
            if (!elements) {
                return true;
            }
            var allpass = true, self = this, params = options || {};
            if (elements.size && elements.size() === 1 && elements.get(0).tagName.toLowerCase() === "form") {
                elements = $(elements).find(self.tags);
            } else if (elements.tagName && elements.tagName.toLowerCase() === "form") {
                elements = $(elements).find(self.tags);
            }
            elements.each(function () {
                if (self.checkInput(this, params) === false) {
                    return $(this).focus(), (allpass = false);
                }
            });
            return allpass;
        };
        // 验证标志
        this.remind = function (input) {
            return this.isVisible(input) ? this.showError(input, input.getAttribute('title') || '') : false;
        };
        // 检测表单单元
        this.checkInput = function (input) {
            var type = (input.getAttribute("type") + "").replace(/\W+$/, "").toLowerCase();
            var tag = input.tagName.toLowerCase(), isRequired = this.hasProp(input, "required");
            if (this.hasProp(input, 'data-auto-none') || input.disabled || type === 'submit' || type === 'reset' || type === 'file' || type === 'image' || !this.isVisible(input)) {
                return;
            }
            var allpass = true;
            if (type === "radio" && isRequired) {
                var radiopass = false, eleRadios = input.name ? $("input[type='radio'][name='" + input.name + "']") : $(input);
                eleRadios.each(function () {
                    (radiopass === false && $(this).is("[checked]")) && (radiopass = true);
                });
                if (radiopass === false) {
                    allpass = this.remind(eleRadios.get(0), type, tag);
                } else {
                    this.hideError(input);
                }
            } else if (type === "checkbox" && isRequired && !$(input).is("[checked]")) {
                allpass = this.remind(input, type, tag);
            } else if (tag === "select" && isRequired && !input.value) {
                allpass = this.remind(input, type, tag);
            } else if ((isRequired && this.isEmpty(input)) || !(allpass = this.isRegex(input))) {
                allpass ? this.remind(input, type, "empty") : this.remind(input, type, tag);
                allpass = false;
            } else {
                this.hideError(input);
            }
            return allpass;
        };
        // 错误消息显示
        this.showError = function (ele, content) {
            $(ele).addClass('validate-error'), this.insertError(ele);
            $($(ele).data('input-info')).addClass('fadeInRight animated').css({width: 'auto'}).html(content);
        };
        // 错误消息消除
        this.hideError = function (ele) {
            $(ele).removeClass('validate-error'), this.insertError(ele);
            $($(ele).data('input-info')).removeClass('fadeInRight').css({width: '30px'}).html('');
        };
        // 错误消息标签插入
        this.insertError = function (ele) {
            var $html = $('<span style="-webkit-animation-duration:.2s;animation-duration:.2s;padding-right:20px;color:#a94442;position:absolute;right:0;font-size:12px;z-index:2;display:block;width:34px;text-align:center;pointer-events:none"></span>');
            $html.css({top: $(ele).position().top + 'px', paddingBottom: $(ele).css('paddingBottom'), lineHeight: $(ele).css('height')});
            $(ele).data('input-info') || $(ele).data('input-info', $html.insertAfter(ele));
        };
        // 表单验证入口
        this.check = function (form, callback, options) {
            var params = $.extend({}, options || {});
            $(form).attr("novalidate", "novalidate");
            $(form).find(self.tags).map(function () {
                for (var i in self.checkEvent) {
                    if (self.checkEvent[i] === true) {
                        $(this).off(i, func).on(i, func);
                    }
                }
                function func() {
                    self.checkInput(this);
                }
            });
            $(form).bind("submit", function (event) {
                if (self.isAllpass($(this).find(self.tags), params) && typeof callback === 'function') {
                    if (typeof CKEDITOR === 'object' && typeof CKEDITOR.instances === 'object') {
                        for (var instance in CKEDITOR.instances) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                    }
                    callback.call(this, $(form).serialize());
                }
                return event.preventDefault(), false;
            });
            return $(form).data('validate', this);
        };
    }

    // 后台菜单辅助插件
    $.menu = new menu();
    function menu() {
        // 计算URL地址中有效的URI
        this.getUri = function (uri) {
            uri = uri || window.location.href;
            uri = (uri.indexOf(window.location.host) !== -1 ? uri.split(window.location.host)[1] : uri).split('?')[0];
            return (uri.indexOf('#') !== -1 ? uri.split('#')[1] : uri);
        };
        // 通过URI查询最有可能的菜单NODE
        this.queryNode = function (url) {
            var $menu = $('[data-menu-node][data-open*="_URL_"]'.replace('_URL_', url.replace(/\.html$/ig, '')));
            if ($menu.size()) {
                return $menu.get(0).getAttribute('data-menu-node');
            }
            return /^m\-/.test(node = location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1')) ? node : '';
        };
        // URL转URI
        this.parseUri = function (uri, obj) {
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
        // 后台菜单动作初始化
        this.listen = function () {
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
                var menuNode = $(this).attr('data-menu-target'), $left = $('[data-menu-box=' + menuNode + ']').removeClass('hide');
                $("[data-menu-box]").not($left).addClass('hide'), $left.find('[data-open]:first').trigger('click')
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
                var pNode = [node.split('-')[0], node.split('-')[1]].join('-');
                $('.topbar-home-link').not($('[data-menu-target="' + pNode + '"]').addClass('active')).removeClass('active');
                /* 左则菜单处理 */
                var $menu = $('[data-menu-node="' + node + '"]').eq(0);
                if ($menu.size() > 0) {
                    $menu.parents('.main-nav').addClass('open'), $menu.parents('.sidebar-trans').removeClass('hide').show();
                    var $li = $menu.parent('li').addClass('active');
                    $li.parents('.framework-sidebar').find('li.active').not($li).removeClass('active');
                    $menu.parents('[data-menu-box]').removeClass('hide').siblings('[data-menu-box]').addClass('hide');
                    if (/^m\-\d+$/i.test(node)) {
                        $('.framework-sidebar').addClass('hide'), $menu.addClass('active');
                        $('.framework-container').css('left', 0).addClass('framework-sidebar-full');
                    } else {
                        $('.framework-sidebar').removeClass('hide');
                        $('.framework-container').removeAttr('style').addClass('framework-sidebar-full');
                    }
                } else {
                    $('.framework-sidebar').hide();
                    $('.framework-container').removeClass('framework-sidebar-full');
                }
                $.form.open(hash);
            };
            // URI初始化动作
            window.onhashchange.call(this);
        };
    }
});