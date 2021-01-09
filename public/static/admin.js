// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

/*! 数组兼容处理 */
if (typeof Array.prototype.forEach !== 'function') {
    Array.prototype.forEach = function (callback, context) {
        typeof context === "undefined" ? context = window : null;
        for (var i in this) callback.call(context, this[i], i, this)
    };
}
if (typeof Array.prototype.every !== 'function') {
    Array.prototype.every = function (callback) {
        for (var i in this) if (callback(this[i], i, this) === false) {
            return false;
        }
        return true;
    };
}
if (typeof Array.prototype.some !== 'function') {
    Array.prototype.some = function (callback) {
        for (var i in this) if (callback(this[i], i, this) === true) {
            return true;
        }
        return false;
    };
}

/*! LayUI & jQuery */
if (typeof jQuery === 'undefined') window.$ = window.jQuery = layui.$;
window.form = layui.form, window.layer = layui.layer, window.laydate = layui.laydate;

/*! 应用根路径 */
window.appRoot = (function (src) {
    return src.pop(), src.pop(), src.join('/') + '/';
})(document.scripts[document.scripts.length - 1].src.split('/'));

/*! 静态插件库路径 */
window.baseRoot = (function (src) {
    return src.substring(0, src.lastIndexOf("/") + 1);
})(document.scripts[document.scripts.length - 1].src);

/*! 动态插件库路径 */
window.tapiRoot = window.tapiRoot || window.appRoot + "admin";

/*! require 配置 */
require.config({
    waitSeconds: 60,
    baseUrl: baseRoot,
    map: {'*': {css: baseRoot + 'plugs/require/css.js'}},
    paths: {
        'md5': ['plugs/jquery/md5.min'],
        'chat': ['plugs/michat/michat'],
        'json': ['plugs/jquery/json.min'],
        'xlsx': ['plugs/jquery/xlsx.min'],
        'excel': ['plugs/jquery/excel.xlsx'],
        'base64': ['plugs/jquery/base64.min'],
        'upload': [tapiRoot + '/api.upload?.js'],
        'angular': ['plugs/angular/angular.min'],
        'echarts': ['plugs/echarts/echarts.min'],
        'ckeditor': ['plugs/ckeditor/ckeditor'],
        'websocket': ['plugs/socket/websocket'],
        'pcasunzips': ['plugs/jquery/pcasunzips'],
        'jquery.ztree': ['plugs/ztree/ztree.all.min'],
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.autocompleter': ['plugs/jquery/autocompleter.min'],
    },
    shim: {
        'websocket': {deps: [baseRoot + 'plugs/socket/swfobject.min.js']},
        'jquery.ztree': {deps: ['jquery', 'css!' + baseRoot + 'plugs/ztree/zTreeStyle/zTreeStyle.css']},
        'jquery.autocompleter': {deps: ['jquery', 'css!' + baseRoot + 'plugs/jquery/autocompleter.css']},
    }
});

/*! 注册 jquery 到 require 模块 */
define('jquery', [], function () {
    return layui.$;
});

$(function () {
    window.$body = $('body');
    /*! 消息组件实例 */
    $.msg = new function (that) {
        that = this, this.idx = [], this.shade = [0.02, '#000'];
        /*! 关闭消息框 */
        this.close = function (index) {
            return layer.close(index);
        };
        /*! 弹出警告框 */
        this.alert = function (msg, callback) {
            var index = layer.alert(msg, {end: callback, scrollbar: false});
            return this.idx.push(index), index;
        };
        /*! 确认对话框 */
        this.confirm = function (msg, ok, no) {
            var index = layer.confirm(msg, {title: '操作确认', btn: ['确认', '取消']}, function () {
                typeof ok === 'function' && ok.call(this, index);
            }, function () {
                typeof no === 'function' && no.call(this, index);
                that.close(index);
            });
            return index;
        };
        /*! 显示成功类型的消息 */
        this.success = function (msg, time, callback) {
            var index = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: callback, time: (time || 2) * 1000, shadeClose: true});
            return this.idx.push(index), index;
        };
        /*! 显示失败类型的消息 */
        this.error = function (msg, time, callback) {
            var index = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: callback, shadeClose: true});
            return this.idx.push(index), index;
        };
        /*! 状态消息提示 */
        this.tips = function (msg, time, callback) {
            var index = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: callback, shadeClose: true});
            return this.idx.push(index), index;
        };
        /*! 显示正在加载中的提示 */
        this.loading = function (msg, callback) {
            var index = msg ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: callback}) : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
            return this.idx.push(index), index;
        };
        /*! 自动处理显示返回的Json数据 */
        this.auto = function (ret, time) {
            var url = ret.url || (typeof ret.data === 'string' ? ret.data : '');
            var msg = ret.msg || (typeof ret.info === 'string' ? ret.info : '');
            if (parseInt(ret.code) === 1 && time === 'false') {
                return url ? (location.href = url) : $.form.reload();
            }
            return (parseInt(ret.code) === 1) ? this.success(msg, time, function () {
                url ? (location.href = url) : $.form.reload();
                for (var i in that.idx) layer.close(that.idx[i]);
                that.idx = [];
            }) : this.error(msg, 3, function () {
                url ? location.href = url : '';
            });
        };
    };

    /*! 表单自动化组件 */
    $.form = new function (that) {
        that = this;
        /*! 内容区选择器 */
        this.selecter = '.layui-layout-admin>.layui-body';
        /*! 刷新当前页面 */
        this.reload = function () {
            self === top ? window.onhashchange.call(this) : location.reload();
        };
        /*! 内容区域动态加载后初始化 */
        this.reInit = function ($dom) {
            $(window).trigger('scroll'), $.vali.listen(this), $dom = $dom || $(this.selecter);
            $dom.find('[required]').map(function ($parent) {
                if (($parent = $(this).parent()) && $parent.is('label')) {
                    $parent.addClass('label-required-prev');
                } else {
                    $parent.prevAll('label').addClass('label-required-next');
                }
            }), $dom.find('input[data-date-range]').map(function () {
                this.setAttribute('autocomplete', 'off');
                laydate.render({
                    type: this.dataset.dateRange || 'date',
                    range: true, elem: this, done: function (value) {
                        $(this.elem).val(value).trigger('change');
                    }
                });
            }), $dom.find('input[data-date-input]').map(function () {
                this.setAttribute('autocomplete', 'off');
                laydate.render({
                    type: this.dataset.dateInput || 'date',
                    range: false, elem: this, done: function (value) {
                        $(this.elem).val(value).trigger('change');
                    }
                });
            }), $dom.find('[data-file]:not([data-inited])').map(function (index, elem, $this, field) {
                $this = $(elem), field = this.dataset.field || 'file';
                if (!$this.data('input')) $this.data('input', $('[name="' + field + '"]').get(0));
                $this.uploadFile(function (url, file) {
                    $($this.data('input')).data('file', file).val(url).trigger('change');
                });
            }), $dom.find('[data-lazy-src]:not([data-lazy-loaded])').each(function () {
                if (this.dataset.lazyLoaded !== 'true') {
                    if (this.nodeName === 'IMG') {
                        this.src = this.dataset.lazySrc;
                    } else {
                        this.style.backgroundImage = 'url(' + this.dataset.lazySrc + ')';
                    }
                    this.dataset.lazyLoaded = "true";
                }
            });
        };
        /*! 在内容区显示视图 */
        this.show = function (html) {
            $(this.selecter).html(html), this.reInit($(this.selecter)), setTimeout(function () {
                that.reInit($(that.selecter));
            }, 500);
        };
        /*! 以 HASH 打开新网页 */
        this.href = function (url, obj) {
            if (url !== '#') location.href = '#' + $.menu.parseUri(url, obj);
            else if (obj && obj.dataset.menuNode) {
                $('[data-menu-node^="' + obj.dataset.menuNode + '-"][data-open!="#"]:first').trigger('click');
            }
        };
        /*! 异步加载的数据 */
        this.load = function (url, data, method, callback, loading, tips, time, headers) {
            var index = loading !== false ? $.msg.loading(tips) : 0;
            if (typeof data === 'object' && typeof data['_token_'] === 'string') {
                headers = headers || {}, headers['User-Form-Token'] = data['_token_'], delete data['_token_'];
            }
            $.ajax({
                data: data || {}, type: method || 'GET', url: $.menu.parseUri(url), beforeSend: function (xhr, i) {
                    if (typeof Pace === 'object' && loading !== false) Pace.restart();
                    if (typeof headers === 'object') for (i in headers) xhr.setRequestHeader(i, headers[i]);
                }, error: function (XMLHttpRequest, $dialog, dialogIdx, iframe) {
                    if (parseInt(XMLHttpRequest.status) !== 200 && XMLHttpRequest.responseText.indexOf('Call Stack') > -1) try {
                        dialogIdx = layer.open({title: XMLHttpRequest.status + ' - ' + XMLHttpRequest.statusText, type: 2, move: false, content: 'javascript:;'});
                        layer.full(dialogIdx), $dialog = $('#layui-layer' + dialogIdx), iframe = $dialog.find('iframe').get(0);
                        (iframe.contentDocument || iframe.contentWindow.document).write(XMLHttpRequest.responseText);
                        $dialog.find('.layui-layer-setwin').css({right: '35px', top: '28px'}).find('a').css({marginLeft: 0});
                        $dialog.find('.layui-layer-title').css({color: 'red', height: '70px', lineHeight: '70px', fontSize: '22px', textAlign: 'center', fontWeight: 700});
                    } catch (e) {
                        layer.close(dialogIdx);
                    }
                    layer.closeAll('loading');
                    if (parseInt(XMLHttpRequest.status) !== 200) {
                        $.msg.tips('E' + XMLHttpRequest.status + ' - 服务器繁忙，请稍候再试！');
                    } else {
                        this.success(XMLHttpRequest.responseText);
                    }
                }, success: function (ret) {
                    if (typeof callback === 'function' && callback.call(that, ret) === false) return false;
                    return typeof ret === 'object' ? $.msg.auto(ret, time || ret.wait || undefined) : that.show(ret);
                }, complete: function () {
                    $.msg.close(index);
                }
            });
        };
        /*! 加载 HTML 到目标位置 */
        this.open = function (url, data, callback, loading, tips) {
            this.load(url, data, 'get', function (ret) {
                return (typeof ret === 'object' ? $.msg.auto(ret) : that.show(ret)), false;
            }, loading, tips);
        };
        /*! 打开一个iframe窗口 */
        this.iframe = function (url, title, area) {
            return layer.open({title: title || '窗口', type: 2, area: area || ['800px', '580px'], fix: true, maxmin: false, content: url});
        };
        /*! 加载 HTML 到弹出层 */
        this.modal = function (url, data, title, callback, loading, tips, area) {
            this.load(url, data, 'GET', function (res, index) {
                if (typeof (res) === 'object') return $.msg.auto(res), false;
                index = layer.open({
                    type: 1, btn: false, area: area || "800px", content: res, title: title || '', success: function (dom, index) {
                        $(dom).find('[data-close]').off('click').on('click', function () {
                            if (this.dataset.confirm) return $.msg.confirm(this.dataset.confirm, function (_index) {
                                layer.close(_index), layer.close(index);
                            }), false;
                            layer.close(index);
                        });
                        $.form.reInit($(dom));
                    }
                });
                $.msg.idx.push(index);
                return (typeof callback === 'function') && callback.call(that);
            }, loading, tips);
        };
    };

    /*! 后台菜单辅助插件 */
    $.menu = new function (that) {
        that = this;
        /*! 计算 URL 地址中有效的 URI */
        this.getUri = function (uri) {
            uri = uri || location.href;
            uri = (uri.indexOf(location.host) > -1 ? uri.split(location.host)[1] : uri);
            return (uri.indexOf('#') > -1 ? uri.split('#')[1] : uri).split('?')[0];
        };
        /*! 通过 URI 查询最有可能的菜单 NODE */
        this.queryNode = function (url, node) {
            node = node || location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1');
            if (!/^m-/.test(node)) {
                var $menu = $('[data-menu-node][data-open*="' + url.replace(/\.html$/ig, '') + '"]');
                return $menu.size() ? $menu.get(0).dataset.menuNode : '';
            }
            return node;
        };
        /*! URL 转 URI */
        this.parseUri = function (uri, elem, vars, temp, attrs) {
            vars = {}, attrs = [], elem = elem || document.createElement('a');
            if (uri.indexOf('?') > -1) uri.split('?')[1].split('&').forEach(function (item) {
                if (item.indexOf('=') > -1 && (temp = item.split('=')) && typeof temp[0] === 'string' && temp[0].length > 0) {
                    vars[temp[0]] = decodeURIComponent(temp[1].replace(/%2B/ig, '%20'));
                }
            });
            uri = this.getUri(uri);
            if (typeof vars.spm !== 'string') vars.spm = elem.dataset.menuNode || this.queryNode(uri) || '';
            if (typeof vars.spm !== 'string' || vars.spm.length < 1) delete vars.spm;
            for (var i in vars) attrs.push(i + '=' + vars[i]);
            return uri + (attrs.length > 0 ? '?' + attrs.join('&') : '');
        };
        /*! 后台菜单动作初始化 */
        this.listen = function () {
            /*! 菜单模式切换 */
            (function ($menu, miniClass) {
                /*! Mini 菜单模式切换及显示 */
                if (layui.data('admin-menu-type')['type-mini']) $menu.addClass(miniClass);
                $body.on('click', '[data-target-menu-type]', function () {
                    $menu.toggleClass(miniClass), layui.data('admin-menu-type', {key: 'type-mini', value: $menu.hasClass(miniClass)});
                }).on('resize', function () {
                    $body.width() > 1000 ? (layui.data('admin-menu-type')['type-mini'] ? $menu.addClass(miniClass) : $menu.removeClass(miniClass)) : $menu.addClass(miniClass);
                }).trigger('resize');
                /*! Mini 菜单模式时TIPS文字显示 */
                $('[data-target-tips]').mouseenter(function () {
                    if ($menu.hasClass(miniClass)) $(this).attr('index', layer.tips(this.dataset.targetTips || '', this));
                }).mouseleave(function () {
                    layer.close($(this).attr('index'));
                });
            })($('.layui-layout-admin'), 'layui-layout-left-mini');
            /*!  左则二级菜单展示 */
            $('[data-submenu-layout]>a').on('click', function () {
                that.syncOpenStatus(1);
            });
            /*! 同步二级菜单展示状态 */
            this.syncOpenStatus = function (mode) {
                $('[data-submenu-layout]').map(function (node) {
                    node = this.dataset.submenuLayout;
                    if (mode === 1) {
                        layui.data('admin-menu-stat', {key: node, value: $(this).hasClass('layui-nav-itemed') ? 2 : 1});
                    } else if ((layui.data('admin-menu-stat')[node] || 2) === 2) {
                        $(this).addClass('layui-nav-itemed');
                    }
                });
            };
            window.onhashchange = function (hash, node) {
                hash = location.hash || '';
                if (hash.length < 1) return $('[data-menu-node][data-open!="#"]:first').trigger('click');
                $.form.load(hash), that.syncOpenStatus(2);
                /*! 菜单选择切换 */
                node = that.queryNode(that.getUri());
                if (/^m-/.test(node)) {
                    var $all = $('a[data-menu-node]').parent(), tmp = node.split('-'), tmpNode = tmp.shift();
                    while (tmp.length > 0) {
                        tmpNode = tmpNode + '-' + tmp.shift();
                        $all = $all.not($('a[data-menu-node="' + tmpNode + '"]').parent().addClass('layui-this'));
                    }
                    $all.removeClass('layui-this');
                    /*! 菜单模式切换 */
                    if (node.split('-').length > 2) {
                        var _tmp = node.split('-'), _node = _tmp.shift() + '-' + _tmp.shift();
                        $('[data-menu-layout]').not($('[data-menu-layout="' + _node + '"]').removeClass('layui-hide')).addClass('layui-hide');
                        $('[data-menu-node="' + node + '"]').parent().parent().parent().addClass('layui-nav-itemed');
                        $('.layui-layout-admin').removeClass('layui-layout-left-hide');
                    } else $('.layui-layout-admin').addClass('layui-layout-left-hide');
                    that.syncOpenStatus(1);
                }
            };
            /*! URI初始化动作 */
            window.onhashchange.call(this);
        };
    };

    /*! 注册对象到Jq */
    $.vali = function (form, callback, options) {
        return (new function (that) {
            /*! 表单元素 */
            that = this, this.tags = 'input,textarea,select';
            /*! 检测元素事件 */
            this.checkEvent = {change: true, blur: true, keyup: false};
            /*! 去除字符串的空格 */
            this.trim = function (str) {
                return str.replace(/(^\s*)|(\s*$)/g, '');
            };
            /*! 标签元素是否可见 */
            this.isVisible = function (ele) {
                return $(ele).is(':visible');
            };
            /*! 检测属性是否有定义 */
            this.hasProp = function (ele, prop) {
                if (typeof prop !== "string") return false;
                var attrProp = ele.getAttribute(prop);
                return (typeof attrProp !== 'undefined' && attrProp !== null && attrProp !== false);
            };
            /*! 判断表单元素是否为空 */
            this.isEmpty = function (ele, value) {
                var trim = this.trim(ele.value);
                value = value || ele.getAttribute('placeholder');
                return (trim === "" || trim === value);
            };
            /*! 正则验证表单元素 */
            this.isRegex = function (ele, regex, params) {
                var input = $(ele).val(), real = this.trim(input);
                regex = regex || ele.getAttribute('pattern');
                if (real === "" || !regex) return true;
                return new RegExp(regex, params || 'i').test(real);
            };
            /*! 检侧所有表单元素 */
            this.checkAllInput = function () {
                var isPass = true;
                $(form).find(this.tags).each(function () {
                    if (that.checkInput(this) === false) return $(this).focus(), isPass = false;
                });
                return isPass;
            };
            /*! 检测表单单元 */
            this.checkInput = function (input) {
                var tag = input.tagName.toLowerCase(), need = this.hasProp(input, "required");
                var type = (input.getAttribute("type") || '').replace(/\W+/, "").toLowerCase();
                if (this.hasProp(input, 'data-auto-none')) return true;
                var ingoreTags = ['select'], ingoreType = ['radio', 'checkbox', 'submit', 'reset', 'image', 'file', 'hidden'];
                for (var i in ingoreTags) if (tag === ingoreTags[i]) return true;
                for (var i in ingoreType) if (type === ingoreType[i]) return true;
                if (need && this.isEmpty(input)) return this.remind(input);
                return this.isRegex(input) ? (this.hideError(input), true) : this.remind(input);
            };
            /*! 验证标志 */
            this.remind = function (input) {
                if (!this.isVisible(input)) return true;
                this.showError(input, input.getAttribute('title') || input.getAttribute('placeholder') || '输入错误');
                return false;
            };
            /*! 错误消息显示 */
            this.showError = function (ele, content) {
                $(ele).addClass('validate-error'), this.insertError(ele);
                $($(ele).data('input-info')).addClass('layui-anim layui-anim-fadein').css({width: 'auto'}).html(content);
            };
            /*! 错误消息消除 */
            this.hideError = function (ele) {
                $(ele).removeClass('validate-error'), this.insertError(ele);
                $($(ele).data('input-info')).removeClass('layui-anim-fadein').css({width: '30px'}).html('');
            };
            /*! 错误消息标签插入 */
            this.insertError = function (ele) {
                var $html = $('<span style="padding-right:12px;color:#a94442;position:absolute;right:0;font-size:12px;z-index:2;display:block;width:34px;text-align:center;pointer-events:none"></span>');
                $html.css({top: $(ele).position().top + 'px', paddingBottom: $(ele).css('paddingBottom'), lineHeight: $(ele).css('height')});
                $(ele).data('input-info') || $(ele).data('input-info', $html.insertAfter(ele));
            };
            /*! 表单验证入口 */
            this.check = function (form, callback) {
                $(form).attr("novalidate", "novalidate");
                $(form).find(that.tags).map(function () {
                    this.bindEventMethod = function () {
                        that.checkInput(this);
                    };
                    for (var e in that.checkEvent) if (that.checkEvent[e] === true) {
                        $(this).off(e, this.bindEventMethod).on(e, this.bindEventMethod);
                    }
                });
                $(form).bind("submit", function (event) {
                    if (that.checkAllInput() && typeof callback === 'function') {
                        if (typeof CKEDITOR === 'object' && typeof CKEDITOR.instances === 'object') {
                            for (var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
                        }
                        callback.call(this, $(form).formToJson());
                    }
                    return event.preventDefault(), false;
                }).find('[data-form-loaded]').map(function () {
                    $(this).html(this.dataset.formLoaded || this.innerHTML);
                    $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
                });
                return $(form).data('validate', this);
            };
        }).check(form, callback, options);
    };

    /*! 自动监听规则内表单 */
    $.vali.listen = function () {
        $('form[data-auto]').map(function (index, form) {
            if (this.dataset.listen === 'true') return true;
            $(this).attr('data-listen', 'true').vali(function (data) {
                var call = form.dataset.callback || '_default_callback';
                var type = form.method || 'POST', tips = form.dataset.tips || undefined;
                var time = form.dataset.time || undefined, href = form.action || location.href;
                $.form.load(href, data, type, window[call] || undefined, true, tips, time);
            });
        });
    };

    /*! 注册对象到JqFn */
    $.fn.vali = function (callback, options) {
        return $.vali(this, callback, options);
    };

    /*! 表单转JSON */
    $.fn.formToJson = function () {
        var self = this, data = {}, push = {};
        var patterns = {"key": /[a-zA-Z0-9_]+|(?=\[])/g, "push": /^$/, "fixed": /^\d+$/, "named": /^[a-zA-Z0-9_]+$/};
        this.build = function (base, key, value) {
            return (base[key] = value), base;
        };
        this.pushCounter = function (name) {
            if (push[name] === undefined) push[name] = 0;
            return push[name]++;
        };
        $.each($(this).serializeArray(), function () {
            var key, keys = this.name.match(patterns.key), merge = this.value, name = this.name;
            while ((key = keys.pop()) !== undefined) {
                name = name.replace(new RegExp("\\[" + key + "\\]$"), '');
                if (key.match(patterns.push)) { // push
                    merge = self.build([], self.pushCounter(name), merge);
                } else if (key.match(patterns.fixed)) { // fixed
                    merge = self.build([], key, merge);
                } else if (key.match(patterns.named)) { // named
                    merge = self.build({}, key, merge);
                }
            }
            data = $.extend(true, data, merge);
        });
        return data;
    };

    /*! 全局文件上传入口 */
    $.fn.uploadFile = function (callback) {
        if (this.attr('data-inited')) return false;
        var that = this, mode = this.attr('data-file') || 'one';
        this.attr('data-inited', true).attr('data-multiple', (mode !== 'btn' && mode !== 'one') ? 1 : 0);
        require(['upload'], function (apply) {
            apply.call(this, that, callback);
        });
    };

    /*! 上传单张图片 */
    $.fn.uploadOneImage = function () {
        return this.each(function ($in, $tpl) {
            $in = $(this), $tpl = $('<a data-file="one" class="uploadimage transition"><span class="layui-icon">&#x1006;</span></a>');
            $tpl.attr('data-type', $in.data('type') || 'png,jpg,gif').attr('data-size', $in.data('size') || 0);
            $tpl.attr('data-field', $in.attr('name') || 'image').data('input', this);
            $tpl.find('span').on('click', function (event) {
                event.stopPropagation(), $tpl.attr('style', ''), $in.val('');
            });
            $in.attr('name', $tpl.attr('data-field')).after($tpl).on('change', function () {
                if (this.value) $tpl.css('backgroundImage', 'url(' + encodeURI(this.value) + ')');
            }).trigger('change');
        }), this;
    };

    /*! 上传多张图片 */
    $.fn.uploadMultipleImage = function () {
        return this.each(function () {
            var $button = $('<a class="uploadimage"></a>'), images = this.value ? this.value.split('|') : [];
            var $input = $(this), name = $input.attr('name') || 'umt-image', type = $input.data('type') || 'png,jpg,gif';
            $button.attr('data-type', type).attr('data-field', name).attr('data-file', 'mut').data('input', this);
            $input.attr('name', name).after($button), $button.uploadFile(function (src) {
                images.push(src), $input.val(images.join('|')), showImageContainer([src]);
            });
            if (images.length > 0) showImageContainer(images);

            function showImageContainer(srcs) {
                $(srcs).each(function (idx, src, $image) {
                    $image = $('<div class="uploadimage uploadimagemtl transition"><a class="layui-icon margin-right-5">&#xe602;</a><a class="layui-icon margin-right-5">&#x1006;</a><a class="layui-icon margin-right-5">&#xe603;</a></div>');
                    $image.attr('data-tips-image', encodeURI(src)).css('backgroundImage', 'url(' + encodeURI(src) + ')').on('click', 'a', function (event, index, prevs, $item) {
                        event.stopPropagation(), $item = $(this).parent(), index = $(this).index(), prevs = $button.prevAll('div.uploadimage').length;
                        if (index === 0 && $item.index() !== prevs) $item.next().after($item);
                        else if (index === 2 && $item.index() > 1) $item.prev().before($item);
                        else if (index === 1) $item.remove();
                        images = [], $button.prevAll('.uploadimage').map(function () {
                            images.push($(this).attr('data-tips-image'));
                        });
                        images.reverse(), $input.val(images.join('|'));
                    }), $button.before($image);
                });
            };
        }), this;
    };

    /*! 标签输入插件 */
    $.fn.initTagInput = function () {
        return this.each(function () {
            var $box = $('<div class="layui-tags"></div>');
            var $this = $(this), tags = this.value ? this.value.split(',') : [];
            var $text = $('<textarea class="layui-input layui-input-inline layui-tag-input"></textarea>');
            $this.parent().append($box.append($text)), $text.off('keydown blur'), (tags.length > 0 && showTags(tags));
            $text.on('keydown blur', function (event, value) {
                if (event.keyCode === 13 || event.type === 'blur') {
                    event.preventDefault(), (value = $text.val().replace(/^\s*|\s*$/g, ''));
                    if (tags.indexOf($(this).val()) > -1) return layer.msg('该标签已经存在！');
                    if (value.length > 0) tags.push(value), $this.val(tags.join(',')), showTags([value]), this.focus(), $text.val('');
                }
            });

            function showTags(tagsArr) {
                $(tagsArr).each(function (idx, text, element) {
                    element = $('<div class="layui-tag"></div>').html(text + '<i class="layui-icon">&#x1006;</i>');
                    element.on('click', 'i', function (tagText, tagIndex) {
                        tagText = $(this).parent().text(), tagIndex = tags.indexOf(tagText);
                        tags.splice(tagIndex, 1), $(this).parent().remove(), $this.val(tags.join(','));
                    }), $box.append(element, $text);
                });
            }
        });
    };

    /*! 文本框插入内容 */
    $.fn.insertAtCursor = function (value) {
        return this.each(function () {
            if (document.selection) {
                this.focus();
                var selection = document.selection.createRange();
                (selection.text = value), selection.select();
            } else if (this.selectionStart || this.selectionStart === 0) {
                var startPos = this.selectionStart, afterPos = this.selectionEnd, scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + value + this.value.substring(afterPos, this.value.length);
                if (scrollTop > 0) this.scrollTop = scrollTop;
                this.focus();
                this.selectionEnd = startPos + value.length;
                this.selectionStart = startPos + value.length;
            } else (this.value += value), this.focus();
        });
    }

    /*! 注册 data-load 事件行为 */
    $body.on('click', '[data-load]', function () {
        var url = this.dataset.load, tips = this.dataset.tips, time = this.dataset.time;
        this.dataset.confirm ? $.msg.confirm(this.dataset.confirm, function () {
            $.form.load(url, {}, 'get', null, true, tips, time);
        }) : $.form.load(url, {}, 'get', null, true, tips, time);
    });

    /*! 注册 data-serach 表单搜索行为 */
    $body.on('submit', 'form.form-search', function () {
        var url = $(this).attr('action').replace(/&?page=\d+/g, ''), split = url.indexOf('?') === -1 ? '?' : '&';
        if ((this.method || 'get').toLowerCase() === 'get') {
            if (location.href.indexOf('spm=') > -1) {
                return location.href = '#' + $.menu.parseUri(url + split + $(this).serialize());
            } else {
                return location.href = $.menu.parseUri(url + split + $(this).serialize());
            }
        }
        $.form.load(url, this, 'post');
    });

    /*! 注册 data-modal 事件行为 */
    $body.on('click', '[data-modal]', function () {
        var area = this.dataset.area || this.dataset.width || '800px';
        return $.form.modal(this.dataset.modal, 'open_type=modal', this.dataset.title || this.innerText || '编辑', undefined, undefined, undefined, area);
    });

    /*! 注册 data-open 事件行为 */
    $body.on('click', '[data-open]', function () {
        if (this.dataset.open.match(/^https?:/)) {
            location.href = this.dataset.open;
        } else {
            $.form.href(this.dataset.open, this);
        }
    });

    /*! 注册 data-dbclick 事件行为 */
    $body.on('dblclick', '[data-dbclick]', function () {
        $(this).find(this.dataset.dbclick || '[data-dbclick]').trigger('click');
    });

    /*! 注册 data-reload 事件行为 */
    $body.on('click', '[data-reload]', function () {
        $.form.reload();
    });

    /*! 注册 data-check 事件行为 */
    $body.on('click', '[data-check-target]', function (event) {
        $(this.dataset.checkTarget).map(function () {
            (this.checked = !!event.target.checked), $(this).trigger('change');
        });
    });

    /*! 注册 data-action 事件行为 */
    $body.on('click', '[data-action]', function () {
        var data = {}, time = this.dataset.time, action = this.dataset.action;
        var loading = this.dataset.loading, method = this.dataset.method || 'post';
        var rule = this.dataset.value || (function (elem, rule, ids) {
            $(elem.dataset.target || 'input[type=checkbox].list-check-box').map(function () {
                (this.checked) && ids.push(this.value);
            });
            return ids.length > 0 ? rule.replace('{key}', ids.join(',')) : '';
        })(this, this.dataset.rule || '', []) || '';
        if (rule.length < 1) return $.msg.tips('请选择需要更改的数据！');
        rule.split(';').forEach(function (rule) {
            if (rule.length < 2) return $.msg.tips('异常的数据操作规则，请修改规则！');
            data[rule.split('#')[0]] = rule.split('#')[1];
        });
        data['_token_'] = this.dataset.token || this.dataset.csrf || '--';
        var load = loading !== 'false', tips = typeof loading === 'string' ? loading : undefined;
        this.dataset.confirm ? $.msg.confirm(this.dataset.confirm, function () {
            $.form.load(action, data, method, false, load, tips, time);
        }) : $.form.load(action, data, method, false, load, tips, time);
    });

    /*! 表单元素失焦时提交 */
    $body.on('blur', '[data-action-blur]', function () {
        var data = {}, that = this, $this = $(this), action = this.dataset.actionBlur;
        var time = this.dataset.time, loading = this.dataset.loading || false, load = loading !== 'false';
        var tips = typeof loading === 'string' ? loading : undefined, method = this.dataset.method || 'post';
        var attrs = (this.dataset.value || '').replace('{value}', $this.val()).split(';');
        for (var i in attrs) {
            if (attrs[i].length < 2) return $.msg.tips('异常的数据操作规则，请修改规则！');
            data[attrs[i].split('#')[0]] = attrs[i].split('#')[1];
        }
        that.callback = function (ret) {
            return $this.css('border', (ret && ret.code) ? '1px solid #e6e6e6' : '1px solid red'), false;
        };
        data['_token_'] = this.dataset.token || this.dataset.csrf || '--';
        this.dataset.confirm ? $.msg.confirm(this.dataset.confirm, function () {
            $.form.load(action, data, method, that.callback, load, tips, time);
        }) : $.form.load(action, data, method, that.callback, load, tips, time);
    });

    /*! 表单元素失去焦点时数字 */
    $body.on('blur', '[data-blur-number]', function () {
        var fiexd = parseInt(this.dataset.blurNumber || 0);
        this.value = (parseFloat(this.value) || 0).toFixed(fiexd);
    });

    /*! 注册 data-href 事件行为 */
    $body.on('click', '[data-href]', function () {
        var href = this.dataset.href;
        if (href && href.indexOf('#') !== 0) location.href = href;
    });

    /*! 注册 data-iframe 事件行为 */
    $body.on('click', '[data-iframe]', function () {
        $(this).attr('data-index', $.form.iframe(this.dataset.iframe, this.dataset.title || this.innerText || '窗口', this.dataset.area || [
            this.dataset.width || '800px', this.dataset.height || '580px'
        ]));
    });

    /*! 注册 data-icon 事件行为 */
    $body.on('click', '[data-icon]', function () {
        var location = tapiRoot + '/api.plugs/icon', field = this.dataset.icon || this.dataset.field || 'icon';
        $.form.iframe(location + (location.indexOf('?') > -1 ? '&' : '?') + 'field=' + field, '图标选择');
    });

    /*! 注册 data-copy 事件行为 */
    $body.on('click', '[data-copy]', function () {
        $.copyToClipboard(this.dataset.copy);
    });
    $.copyToClipboard = function (content, input) {
        input = document.createElement('textarea');
        input.style.position = 'absolute', input.style.left = '-100000px';
        input.style.width = '1px', input.style.height = '1px', input.innerText = content;
        document.body.appendChild(input), input.select(), setTimeout(function () {
            document.execCommand('Copy') ? $.msg.tips('复制成功') : $.msg.tips('复制失败，请使用鼠标操作复制！');
            document.body.removeChild(input);
        }, 100);
    };

    /*! 注册 data-tips-text 事件行为 */
    $body.on('mouseenter', '[data-tips-text]', function () {
        $(this).attr('index', layer.tips($(this).attr('data-tips-text'), this, {tips: [$(this).attr('data-tips-type') || 3, '#78BA32'], time: 0}));
    }).on('mouseleave', '[data-tips-text]', function () {
        layer.close($(this).attr('index'));
    });

    /*! 注册 data-tips-image 事件行为 */
    $body.on('click', '[data-tips-image]', function () {
        $.previewImage(this.dataset.tipsImage || this.dataset.lazySrc || this.src, this.dataset.with);
    });
    $.previewImage = function (src, area) {
        var img = new Image(), defer = $.Deferred(), load = $.msg.loading();
        img.style.height = 'auto', img.style.width = area || '480px';
        img.style.display = 'none', img.style.background = '#FFFFFF';
        document.body.appendChild(img), img.onerror = function () {
            $.msg.close(load), defer.reject();
        }, img.onload = function () {
            layer.open({
                type: 1, title: false, shadeClose: true, content: $(img), success: function ($ele, idx) {
                    $.msg.close(load), defer.notify($ele, idx);
                }, area: area || '480px', skin: 'layui-layer-nobg', closeBtn: 1, end: function () {
                    document.body.removeChild(img), defer.resolve()
                }
            });
        };
        return (img.src = src), defer;
    };

    /*! 注册 data-phone-view 事件行为 */
    $body.on('click', '[data-phone-view]', function () {
        $.previewPhonePage(this.dataset.phoneView || this.href);
    });
    $.previewPhonePage = function (href, title, template) {
        template = '<div><div class="mobile-preview pull-left"><div class="mobile-header">_TITLE_</div><div class="mobile-body"><iframe id="phone-preview" src="_URL_" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div></div>';
        layer.style(layer.open({type: true, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: true, shadeClose: false, skin: 'layui-layer-nobg', content: $(template.replace('_TITLE_', title || '公众号').replace('_URL_', href)).html()}), {boxShadow: 'none'});
    };

    /*! 表单编辑返回操作 */
    $body.on('click', '[data-history-back]', function () {
        $.msg.confirm(this.dataset.historyBack || '确定要返回吗？', function (index) {
            history.back(), $.msg.close(index);
        })
    });

    /*! 异步任务状态监听与展示 */
    $body.on('click', '[data-queue]', function (action) {
        action = this.dataset.queue || '';
        if (action.length < 1) return $.msg.tips('任务地址不能为空！');
        this.doRuntime = function (index) {
            $.form.load(action, {}, 'post', function (ret) {
                if (typeof ret.data === 'string' && ret.data.indexOf('Q') === 0) {
                    return $.loadQueue(ret.data, true), false;
                }
            }), $.msg.close(index);
        };
        this.dataset.confirm ? $.msg.confirm(this.dataset.confirm, this.doRuntime) : this.doRuntime(0);
    });
    $.loadQueue = function (code, doScript, doAjax) {
        layer.open({
            type: 1, title: false, area: ['560px', '315px'], anim: 2, shadeClose: false, end: function () {
                doAjax = false;
            }, content: '' +
                '<div class="padding-30 padding-bottom-0" style="width:500px" data-queue-load="' + code + '">' +
                '   <div class="layui-elip nowrap" data-message-title></div>' +
                '   <div class="margin-top-15 layui-progress layui-progress-big" lay-showPercent="yes"><div class="layui-progress-bar transition" lay-percent="0.00%"></div></div>' +
                '   <div class="margin-top-15"><code class="layui-textarea layui-bg-black border-0" disabled style="resize:none;overflow:hidden;height:190px"></code></div>' +
                '</div>'
        });
        (function loadprocess(code, that) {
            that = this, this.$box = $('[data-queue-load=' + code + ']');
            if (doAjax === false || that.$box.length < 1) return false;
            this.$code = that.$box.find('code'), this.$name = that.$box.find('[data-message-title]');
            this.$percent = that.$box.find('.layui-progress div'), this.runCache = function (code, index, value) {
                this.ckey = code + '_' + index, this.ctype = 'admin-queue-script';
                return value !== undefined ? layui.data(this.ctype, {key: this.ckey, value: value}) : layui.data(this.ctype)[this.ckey] || 0;
            };
            this.setState = function (status, message) {
                if (message.indexOf('javascript:') === -1) if (status === 1) {
                    that.$name.html('<b class="color-text">' + message + '</b>').addClass('text-center');
                    that.$percent.addClass('layui-bg-blue').removeClass('layui-bg-green layui-bg-red');
                } else if (status === 2) {
                    if (message.indexOf('>>>') > -1) {
                        that.$name.html('<b class="color-blue">' + message + '</b>').addClass('text-center');
                    } else {
                        that.$name.html('<b class="color-blue">正在处理：</b>' + message).removeClass('text-center');
                    }
                    that.$percent.addClass('layui-bg-blue').removeClass('layui-bg-green layui-bg-red');
                } else if (status === 3) {
                    that.$name.html('<b class="color-green">' + message + '</b>').addClass('text-center');
                    that.$percent.addClass('layui-bg-green').removeClass('layui-bg-blue layui-bg-red');
                } else if (status === 4) {
                    that.$name.html('<b class="color-red">' + message + '</b>').addClass('text-center');
                    that.$percent.addClass('layui-bg-red').removeClass('layui-bg-blue layui-bg-green');
                }
            };
            $.form.load(tapiRoot + '/api.queue/progress', {code: code}, 'post', function (ret) {
                if (ret.code) {
                    that.lines = [];
                    for (this.lineIndex in ret.data.history) {
                        this.line = ret.data.history[this.lineIndex], this.percent = '[ ' + this.line.progress + '% ] ';
                        if (this.line.message.indexOf('javascript:') === -1) {
                            that.lines.push(this.line.message.indexOf('>>>') > -1 ? this.line.message : this.percent + this.line.message);
                        } else if (!that.runCache(code, this.lineIndex) && doScript !== false) {
                            that.runCache(code, this.lineIndex, 1), location.href = this.line.message;
                        }
                    }
                    if (ret.data.status > 0) {
                        that.$code.html('<p class="layui-elip">' + that.lines.join('</p><p class="layui-elip">') + '</p>'), that.$code.animate({scrollTop: that.$code[0].scrollHeight + 'px'}, 200);
                        that.$percent.attr('lay-percent', (parseFloat(ret.data.progress || '0.00').toFixed(2)) + '%'), layui.element.render();
                        that.setState(parseInt(ret.data.status), ret.data.message);
                    } else return setTimeout(function () {
                        loadprocess(code);
                    }, Math.floor(Math.random() * 500) + 200), false;
                    if (parseInt(ret.data.status) === 3 || parseInt(ret.data.status) === 4) return false; else return setTimeout(function () {
                        loadprocess(code);
                    }, Math.floor(Math.random() * 200)), false;
                }
            }, false);
        })(code)
    };

    /*! 图片加载异常处理 */
    document.addEventListener('error', function (event) {
        var elem = event.target;
        if (elem.nodeName === 'IMG') {
            event.target.src = baseRoot + 'theme/img/404_icon.png';
        }
    }, true);

    /*! 系统菜单表单页面初始化 */
    $.menu.listen(), $.vali.listen(), $.form.reInit($body);
});