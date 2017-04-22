/* global layer, ZeroClipboard, Pace */

(function ($) {

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
                self.wrap($('<div></div>').css({position: 'relative', zoom: '1', border: 'none', background: 'none', padding: 'none', margin: 'none'}));
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
     * @returns {common_L11._msg}
     */
    function msg() {
        this.version = '2.0';
        this.shade = [0.01, '#0f0'];
    }

    /**
     * 关闭消息框
     */
    msg.prototype.close = function () {
        return layer.close(this.index);
    };
    /**
     * 弹出警告消息框
     * @param {type} msg
     * @param {type} callback
     * @returns {undefined}
     */
    msg.prototype.alert = function (msg, callback) {
        layer.close(this.index);
        return this.index = layer.alert(msg, {
            end: callback,
            scrollbar: false
        });
    };
    /**
     * 确认对话框
     * @param {type} msg 提示消息内容
     * @param {type} ok 确认的回调函数
     * @param {type} no 取消的回调函数
     * @returns {undefined}
     */
    msg.prototype.confirm = function (msg, ok, no) {
        layer.close(this.index);
        return this.index = layer.confirm(msg, {
            btn: ['确认', '取消']
        }, ok, no);
    };
    /**
     * 显示成功类型的消息
     * @param {type} msg 消息内容
     * @param {type} time  延迟关闭时间
     * @param {type} callback 回调函数
     */
    msg.prototype.success = function (msg, time, callback) {
        layer.close(this.index);
        return this.index = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: callback, time: (time || 2) * 1000});
    };
    /**
     * 显示失败类型的消息
     * @param {type} msg 消息内容
     * @param {type} time 延迟关闭时间
     * @param {type} callback 回调函数
     */
    msg.prototype.error = function (msg, time, callback) {
        layer.close(this.index);
        return this.index = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: callback});
    };
    /**
     * 状态消息提示
     * @param {type} msg
     * @param {type} time
     * @param {type} callback
     * @returns {unresolved}
     */
    msg.prototype.tips = function (msg, time, callback) {
        layer.close(this.index);
        return layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: callback});
    };
    /**
     * 显示正在加载中的提示
     * @param {type} msg 提示内容
     * @param {type} callback 回调方法
     */
    msg.prototype.loading = function (msg, callback) {
        layer.close(this.index);
        if (msg) {
            return this.index = layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: callback});
        }
        return this.index = layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
    };
    /**
     * 自动处理显示Think返回的Json数据
     * @param {type} data JSON数据对象
     * @param {type} time 延迟关闭时间
     */
    msg.prototype.auto = function (data, time) {
        if (data.code === 'SUCCESS') {
            $.msg.success(data.info, time, function () {
                if (data.referer === 'back') {
                    window.history.back();
                } else if (data.referer === 'reload') {
                    $.form.reload();
                } else if (data.referer) {
                    window.location.href = data.referer;
                } else {
                    $.form.reload();
                }
            });
        } else {
            $.msg.error(data.info, 3, function () {
                if (data.code === 'FAILD_LOGIN') {
                    if (data.referer.indexOf('http') === 0) {
                        window.location.href = data.referer;
                    }
                }
            });
        }
    };
    /**
     * 将消息对象挂载到Jq
     */
    $.msg = new msg();
    /**
     * 表单构造函数
     * @returns {common_L11._form}
     */
    function _form() {
        this.version = '2.0';
        this._model = null;
        this.errMsg = '{status}服务器繁忙，请稍候再试！';
    }

    /**
     * 异步加载的数据
     * @param {type} url 请求的地址
     * @param {json|form|$form} data 额外请求数据
     * @param {type} type 提交的类型 GET|POST
     * @param {type} callback 成功后的回调方法
     * @param {type} loading 是否显示加载层
     * @param {type} tips 提示消息
     * @param {type} time 消息提示时间
     */
    _form.prototype.load = function (url, data, type, callback, loading, tips, time) {
        var self = this;
        if (loading !== false) {
            var index = $.msg.loading(tips);
        }
        var send_data = data;
        if (typeof data === 'object' && data.tagName === 'FORM') {
            send_data = $(data).serialize();
        }
        Pace && Pace.restart();
        $.ajax({
            type: type || 'GET',
            url: url,
            data: send_data || {},
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
                if (loading !== false) {
                    $.msg.close(index);
                }
                if (typeof callback === 'function' && callback.call(self, res) === false) {
                    return false;
                }
                if (typeof (res) === 'object') {
                    return $.msg.auto(res, time);
                }
                if (res.indexOf('A PHP Error was encountered') !== -1) {
                    return $.msg.tips(self.errMsg.replace('{status}', 'E505 - '));
                }
                self.show(res);
            }
        });
    };
    /**
     * 加载HTML到目标位置
     * @param {type} url
     * @param {type} data
     * @param {type} target
     * @param {type} callback
     * @param {type} loading
     * @param {type} tips
     * @returns {undefined}
     */
    _form.prototype.open = function (url, data, target, callback, loading, tips) {
        data && (typeof (data) === 'object') && (data = $.param(data));
        data && (url += (url.indexOf('?') === -1 ? '?' : '&') + data);
        this.load(url, data, 'GET', function (res) {
            if (typeof (res) === 'object') {
                return $.msg.auto(res);
            }
            var $container = $('.layer-main-container').html(res);
            if (url !== $container.attr('data-location')) {
                $container.attr('data-backurl', $container.attr('data-location')).attr('data-location', url);
            }
            function reinit() {
                $.validate.listen.call(this);
                $('[data-copy]').map(function () {
                    var client = new ZeroClipboard(this);
                    client.on("ready", function () {
                        client.on("copy", function (event) {
                            event.clipboardData.setData("text/plain", event.target.getAttribute('data-copy'));
                        });
                        client.on("aftercopy", function () {
                            $.msg.tips('内容复制成功！');
                        });
                    });
                });
                JPlaceHolder.init();
                /* 自动给必填字符加上样式 @zoujingli @by 2016-05-11 */
                $container.find('[required]').parent().prevAll('label').addClass('label-required');
            }
            reinit.call(this), setTimeout(reinit, 500), setTimeout(reinit, 1000);
            return (typeof callback === 'function') && callback.call(this);
        }, loading, tips);
    };

    /**
     * 显示HTML到中主内容区
     * @param {type} html
     * @returns {undefined}
     */
    _form.prototype.show = function (html) {
        var $container = $('.layer-main-container').html(html);
        function reinit() {
            $.validate.listen.call(this);
            $container.find('h3').addClass('animated fadeIn container-animated');
        }
        reinit.call(this), setTimeout(reinit, 500), setTimeout(reinit, 1000);
    };
    /**
     * 打开一个iframe窗口
     * @param {type} url
     * @returns {unresolved}
     */
    _form.prototype.iframe = function (url, title) {
        return layer.open({title: title || '窗口', type: 2, area: ['800px', '530px'], fix: true, maxmin: false, content: url});
    };
    /**
     * 关闭FORM框
     * @returns {undefined}
     */
    _form.prototype.close = function () {
        return $(this._modal).modal('hide');
    };

    /*刷新当前页面*/
    _form.prototype.reload = function () {
        window.onhashchange.call(this);
    };

    /*!表单实例挂载*/
    $.form = new _form();


    /**　URL转URI */
    function _parse_uri(url, obj) {
        url = url.indexOf(window.location.hostname) !== -1 ? url.split(window.location.hostname)[1] : url;
         url = url.replace(/spm=[\d\-m]+/ig, '');
        if (obj && (node = obj.getAttribute('data-menu-node'))) {
            url += ((url.indexOf('?') === -1 ? '?' : '&') + 'spm=' + node);
        } else {
            window.location.href.replace(/spm=([\d\-m]+)/ig, function (str, node) {
                url += ((url.indexOf('?') === -1 ? '?' : '&') + 'spm=' + node);
            });
        }
        return url;
    }

    /** 事件委派 */
    $('body').on('click', '[data-load]', function () {
        $.form.load($(this).attr('data-load'), {}, 'GET', null, true, $(this).attr('data-tips'));
    }).on('click', '[data-open]', function () {
        var url = $(this).attr('data-open');
        window.location.href = '#' + _parse_uri(url, this);
    }).on('click', 'a[data-page-href]', function () {
        window.location.href = '#' + _parse_uri(this.href, this);
    }).on('submit', 'form[data-form-href]', function () {
        return $.form.open(this.action, $(this).serialize(), 'main'), false;
    }).on('click', '[data-back]', function () {
        window.history.back();
    }).on('click', '[data-reload]', function () {
        $.form.reload();
    }).on('click', '[data-check-target]', function () {
        var checked = !!this.checked;
        $($(this).attr('data-check-target')).map(function () {
            this.checked = checked;
        });
    }).on('click', '[data-update]', function () {
        var id = $(this).attr('data-update') || (function () {
            var data = [];
            return $($(this).attr('data-list-target') || 'input.list-check-box').map(function () {
                (this.checked) && data.push(this.value);
            }), data.join(',');
        }).call(this);
        if (id.length < 1) {
            return $.msg.tips('请选择需要操作的数据！');
        }
        var action = $(this).attr('data-action') || $(this).parents('[data-location]').attr('data-location');
        var value = $(this).attr('data-value') || 0, field = $(this).attr('data-field') || 'status';
        $.msg.confirm('确定要操作这些数据吗？', function () {
            $.form.load(action, {field: field, value: value, id: id}, 'POST');
        });
    }).on('click', '[data-href]', function () {
        var href = $(this).attr('data-href');
        if (href && href.indexOf('#') !== 0) {
            window.location.href = href;
        }
    }).on('click', '[data-file]', function () {
        var type = $(this).attr('data-type') || 'image'; //jpg,png
        var field = $(this).attr('data-field') || type;
        var method = $(this).attr('data-one') ? 'one' : 'index';
        var title = $(this).attr('data-title') || '文件管理';
        var uptype = $(this).attr('data-uptype') || 'qiniu';
        var url = window.APP_URL + '/plugs/file/' + method + '.html?uptype=' + uptype + '&type=' + type + '&field=' + field;
        $.form.iframe(url, title || '文件管理');
    }).on('click', '[data-iframe]', function () {
        $.form.iframe($(this).attr('data-iframe'), $(this).attr('data-title') || '窗口');
    }).on('click', '[data-icon]', function () {
        var field = $(this).attr('data-field') || 'iconv';
        var url = window.APP_URL + '/plugs/icon.html?field=' + field;
        $.form.iframe(url, '图标选择');
    }).on('click', '[data-tips-image]', function () {
        var src = this.getAttribute('data-tips-image') || this.src, img = new Image(), index;
        img.onload = function () {
            index = layer.open({
                type: 1, area: '480px', title: false, closeBtn: 1, skin: 'layui-layer-nobg', shadeClose: true,
                content: $(img).appendTo('body').css({background: '#fff', width: '480px', height: 'auto'}),
                end: function () {
                    $(img).remove();
                }
            });
        };
        img.src = src;
    }).on('mouseenter', '[data-tips-text]', function () {
        var text = $(this).attr('data-tips-text');
        var placement = $(this).attr('data-tips-placement') || 'auto';
        $(this).tooltip({title: text, placement: placement}).tooltip('show');
    }).on('click', '[data-phone-view]', function () {
        var src = this.getAttribute('data-phone-view') || this.href;
        var $container = $('<div class="phone-container hide"><img src="http://static.cdn.cuci.cc/mobile_head.png" style="width:100%"/><div class="phone-screen"><iframe frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div>').appendTo('body');
        var $iframe = $container.find('iframe').attr('src', src);
        $container.find('img').on('click', function () {
            $iframe.attr('src', src);
        });
        var index = layer.open({
            type: 1, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: 1, skin: 'layui-layer-nobg', shadeClose: true,
            content: $container.removeClass('hide'),
            end: function () {
                $container.remove();
            }
        });
        layer.style(index, {boxShadow: 'none'});
    });

    /**
     * 后台页面初始化操作
     * @returns {undefined}
     */
    $(function () {
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
        /*! Mini Tips 显示*/
        $('body').on('mouseenter mouseleave', '.framework-sidebar-mini .sidebar-trans .nav-item,.framework-sidebar-mini .sidebar-title', function (e) {
            $(this).tooltip({
                template: '<div class="console-sidebar-tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
                title: $(this).text(), placement: 'right', container: 'body'
            }).tooltip('show');
            (e.type === 'mouseleave') && $(this).tooltip('destroy');
        });
        /*! 切换左侧菜单 */
        function showLeftMenu(menuNode, $openNode) {
            var $leftmenu = $('[data-menu-box=' + menuNode + ']').removeClass('hide');
            $("[data-menu-box]").not($leftmenu).addClass('hide');
            $openNode ? $openNode.trigger('click') : $leftmenu.find('[data-open]:first').trigger('click');
        }
        var $menutarget = $('[data-menu-target]').on('click', function () {
            $menutarget.not($(this).addClass('active')).removeClass('active');
            showLeftMenu($(this).attr('data-menu-target'));
        });
        /*! 左侧菜单样式切换 */
        var $targetmenu = $('.sidebar-fold').on('click', function () {
            var $body = $('.framework-body').toggleClass('framework-sidebar-mini framework-sidebar-full');
            $.cookie('menu-style', $body.hasClass('framework-sidebar-mini') ? 'mini' : 'full');
        });
        ($.cookie('menu-style') !== 'mini') && $targetmenu.trigger('click');
        /*! URI路由处理 */
        window.onhashchange = function () {
            var hash = (window.location.hash || '').substring(1);
            if (hash.length < 1) {
                return $('.topbar-home-link:first').trigger('click')
            }
            $.form.open(hash);
            function _get_menu_by_spm() {
                window.location.href.replace(/spm=([\d\-m]+)/ig, function (str, node) {
                    $menu = $('[data-menu-node="' + node + '"]');
                });
                if ($menu && $menu.size() > 0) {
                    return $menu;
                } else {
                    return null;
                }
            }
            var uris = hash.split('?')[0].split('/'), $menu = null;
            for (var i = uris.length; i > 0; i--) {
                if ($('.framework-sidebar [data-open*="' + uris.join('/') + '"]').size() < 1) {
                    delete uris[uris.length - 1];
                } else {
                    $menu = $('.framework-sidebar [data-open*="' + uris.join('/') + '"]');
                    if ($menu.size() > 1 && /spm=/ig.test(window.location.href)) {
                        $menu = _get_menu_by_spm();
                    }
                    break;
                }
            }
            if ($menu) {
                $menu.parent('li').addClass('active');
                $menu.parents('.sidebar-trans').removeClass('hide').show();
                $menu.parents('.main-nav').addClass('open');
                $menu.parents('[data-menu-box]').removeClass('hide').siblings('[data-menu-box]').addClass('hide');
            }
        };
        window.onhashchange.call(this);
    });
})(jQuery);  