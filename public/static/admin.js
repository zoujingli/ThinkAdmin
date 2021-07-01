// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免费声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

/*! 数组兼容处理 */
if (typeof Array.prototype.forEach !== 'function') {
    Array.prototype.forEach = function (callable, context) {
        typeof context === "undefined" ? context = window : null;
        for (var i in this) callable.call(context, this[i], i, this)
    };
}

if (typeof Array.prototype.every !== 'function') {
    Array.prototype.every = function (callable) {
        for (var i in this) if (callable(this[i], i, this) === false) {
            return false;
        }
        return true;
    };
}

if (typeof Array.prototype.some !== 'function') {
    Array.prototype.some = function (callable) {
        for (var i in this) if (callable(this[i], i, this) === true) {
            return true;
        }
        return false;
    };
}

/*! LayUI & jQuery */
if (typeof jQuery === 'undefined') window.$ = window.jQuery = layui.$;
window.form = layui.form, window.layer = layui.layer, window.laydate = layui.laydate;

/*! 脚本应用根路径 */
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
        'json': ['plugs/jquery/json.min'],
        'xlsx': ['plugs/jquery/xlsx.min'],
        'excel': ['plugs/jquery/excel.xlsx'],
        'base64': ['plugs/jquery/base64.min'],
        'upload': [tapiRoot + '/api.upload/index?'],
        'angular': ['plugs/angular/angular.min'],
        'cropper': ['plugs/cropper/cropper.min'],
        'echarts': ['plugs/echarts/echarts.min'],
        'ckeditor': ['plugs/ckeditor/ckeditor'],
        'websocket': ['plugs/socket/websocket'],
        'pcasunzips': ['plugs/jquery/pcasunzips'],
        'jquery.ztree': ['plugs/ztree/ztree.all.min'],
        'jquery.cropper': ['plugs/jquery/cropper.min'],
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.autocompleter': ['plugs/jquery/autocompleter.min'],
    },
    shim: {
        'excel': {deps: [baseRoot + 'plugs/layui_exts/excel.js']},
        'websocket': {deps: [baseRoot + 'plugs/socket/swfobject.min.js']},
        'cropper': {deps: ['css!' + baseRoot + 'plugs/cropper/cropper.min.css']},
        'jquery.ztree': {deps: ['jquery', 'css!' + baseRoot + 'plugs/ztree/zTreeStyle/zTreeStyle.css']},
        'jquery.autocompleter': {deps: ['jquery', 'css!' + baseRoot + 'plugs/jquery/autocompleter.css']},
    }
});

/*! 注册 jquery 组件 */
define('jquery', [], function () {
    return layui.$;
});

$(function () {
    window.$body = $('body');

    /*! 注册单次事件 */
    function onEvent(event, select, callable) {
        return $body.off(event, select).on(event, select, callable);
    }

    /*! 读取 data-rule 绑定 table 值 */
    function applyRuleValue(elem, data) {
        var rule = elem.dataset.value || (function (rule, array) {
            $(elem.dataset.target || 'input[type=checkbox].list-check-box').map(function () {
                this.checked && array.push(this.value);
            });
            return array.length > 0 ? rule.replace('{key}', array.join(',')) : '';
        })(elem.dataset.rule || '', []) || '';
        if (rule.length < 1) return $.msg.tips('请选择需要更改的数据！'), false;
        return rule.split(';').forEach(function (item) {
            data[item.split('#')[0]] = item.split('#')[1];
        }), data;
    }

    /*! 消息组件实例 */
    $.msg = new function (that) {
        that = this, this.idx = [], this.shade = [0.02, '#000'];
        /*! 关闭消息框 */
        this.close = function (index) {
            if (index !== null) return layer.close(index);
            for (var i in this.idx) that.close(this.idx[i]);
            this.idx = [];
        };
        /*! 弹出警告框 */
        this.alert = function (msg, call) {
            var idx = layer.alert(msg, {end: call, scrollbar: false});
            return that.idx.push(idx), idx;
        };
        /*! 显示成功类型的消息 */
        this.success = function (msg, time, call) {
            var idx = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: call, time: (time || 2) * 1000, shadeClose: true});
            return that.idx.push(idx), idx;
        };
        /*! 显示失败类型的消息 */
        this.error = function (msg, time, call) {
            var idx = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: call, shadeClose: true});
            return that.idx.push(idx), idx;
        };
        /*! 状态消息提示 */
        this.tips = function (msg, time, call) {
            var idx = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: call, shadeClose: true});
            return that.idx.push(idx), idx;
        };
        /*! 显示加载提示 */
        this.loading = function (msg, call) {
            var idx = msg ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: call}) : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: call});
            return that.idx.push(idx), idx;
        };
        /*! 确认对话框 */
        this.confirm = function (msg, ok, no) {
            return layer.confirm(msg, {title: '操作确认', btn: ['确认', '取消']}, function (idx) {
                (typeof ok === 'function' && ok.call(this, idx)), that.close(idx);
            }, function (idx) {
                (typeof no === 'function' && no.call(this, idx)), that.close(idx);
            });
        };
        /*! 自动处理JSON数据 */
        this.auto = function (ret, time) {
            var url = ret.url || (typeof ret.data === 'string' ? ret.data : '');
            var msg = ret.msg || (typeof ret.info === 'string' ? ret.info : '');
            if (parseInt(ret.code) === 1 && time === 'false') {
                return url ? (location.href = url) : $.form.reload();
            }
            return (parseInt(ret.code) === 1) ? this.success(msg, time, function () {
                (url ? (location.href = url) : $.form.reload()), that.close(null);
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
        this.reload = function (force) {
            if (force) top.location.reload();
            else if (self !== top) location.reload();
            else window.onhashchange.call(this);
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
                this.setAttribute('autocomplete', 'off'), laydate.render({
                    type: this.dataset.dateRange || 'date', range: true, elem: this, done: function (value) {
                        $(this.elem).val(value).trigger('change');
                    }
                });
            }), $dom.find('input[data-date-input]').map(function () {
                this.setAttribute('autocomplete', 'off'), laydate.render({
                    type: this.dataset.dateInput || 'date', range: false, elem: this, done: function (value) {
                        $(this.elem).val(value).trigger('change');
                    }
                });
            }), $dom.find('[data-file]:not([data-inited])').map(function () {
                $(this).uploadFile();
            }), $dom.find('[data-lazy-src]:not([data-lazy-loaded])').each(function () {
                if (this.dataset.lazyLoaded !== 'true') {
                    this.dataset.lazyLoaded = "true";
                    if (this.nodeName === 'IMG') {
                        this.src = this.dataset.lazySrc;
                    } else {
                        this.style.backgroundImage = 'url(' + this.dataset.lazySrc + ')';
                    }
                }
            });
        };
        /*! 在内容区显示视图 */
        this.show = function (html) {
            $(this.selecter).html(html), setTimeout(function () {
                that.reInit($(that.selecter));
            }, 500);
        };
        /*! 以 HASH 打开新网页 */
        this.href = function (url, ele) {
            if (url !== '#') {
                location.href = '#' + $.menu.parseUri(url, ele);
            } else if (ele && ele.dataset.menuNode) {
                $('[data-menu-node^="' + ele.dataset.menuNode + '-"][data-open!="#"]:first').trigger('click');
            }
        };
        /*! 异步加载的数据 */
        this.load = function (url, data, method, callable, loading, tips, time, headers) {
            // 如果主页面 loader 显示中，绝对不显示 loading 图标
            loading = $('.layui-page-loader').is(':visible') ? false : loading;
            var loadidx = loading !== false ? $.msg.loading(tips) : 0;
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
                    if (typeof callable === 'function' && callable.call(that, ret) === false) return false;
                    return typeof ret === 'object' ? $.msg.auto(ret, time || ret.wait || undefined) : that.show(ret);
                }, complete: function () {
                    $.msg.close(loadidx);
                }
            });
        };
        /*! 加载 HTML 到目标位置 */
        this.open = function (url, data, call, load, tips) {
            this.load(url, data, 'get', function (ret) {
                return (typeof ret === 'object' ? $.msg.auto(ret) : that.show(ret)), false;
            }, load, tips);
        };
        /*! 打开一个iframe窗口 */
        this.iframe = function (url, name, area) {
            return layer.open({title: name || '窗口', type: 2, area: area || ['800px', '580px'], anim: 2, fixed: true, maxmin: false, content: url});
        };
        /*! 加载 HTML 到弹出层 */
        this.modal = function (url, data, name, call, load, tips, area) {
            this.load(url, data, 'GET', function (res) {
                if (typeof (res) === 'object') return $.msg.auto(res), false;
                $.msg.idx.push(layer.open({
                    type: 1, btn: false, area: area || "800px", content: res, title: name || '', success: function ($dom, idx) {
                        $dom.off('click', '[data-close]').on('click', '[data-close]', function () {
                            (function (confirm, callable) {
                                confirm ? $.msg.confirm(confirm, callable) : callable();
                            })(this.dataset.confirm, function () {
                                layer.close(idx);
                            });
                        }), $.form.reInit($dom);
                    }
                }));
                return (typeof call === 'function') && call.call(that);
            }, load, tips);
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
                onEvent('click', '[data-target-menu-type]', function () {
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
    $.vali = function (form, callable, options) {
        return (new function (that) {
            /*! 表单元素 */
            that = this, this.tags = 'input,textarea,select';
            /*! 检测元素事件 */
            this.checkEvent = {change: true, blur: true, keyup: false};
            /*! 去除字符串的空格 */
            this.trim = function (str) {
                return str.replace(/(^\s*)|(\s*$)/g, '');
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
            /*! 显示验证标志 */
            this.remind = function (input) {
                if (!$(input).is(':visible')) return true;
                return this.showError(input, input.getAttribute('title') || input.getAttribute('placeholder') || '输入错误'), false;
            };
            /*! 错误消息显示 */
            this.showError = function (ele, tip) {
                $(ele).addClass('validate-error');
                this.insertError(ele).addClass('layui-anim-fadein').css({width: 'auto'}).html(tip);
            };
            /*! 错误消息消除 */
            this.hideError = function (ele) {
                $(ele).removeClass('validate-error');
                this.insertError(ele).removeClass('layui-anim-fadein').css({width: '30px'}).html('');
            };
            /*! 错误标签插入 */
            this.insertError = function (ele) {
                if ($(ele).data('input-info')) return $(ele).data('input-info');
                var $next = $(ele).nextAll('.input-right-icon'), right = ($next ? $next.width() + parseFloat($next.css('right') || '0') : 0) + 10;
                var $html = $('<span class="absolute block layui-anim text-center font-s12" style="color:#a44;z-index:2;pointer-events:none"></span>');
                var style = {top: $(ele).position().top + 'px', right: right + 'px', lineHeight: $(ele).css('height'), paddingBottom: $(ele).css('paddingBottom')};
                return $(ele).data('input-info', $html.css(style).insertAfter(ele)), $html;
            };
            /*! 表单验证入口 */
            this.check = function (form, callable) {
                $(form).attr('novalidate', 'novalidate').find(that.tags).map(function (idx, input) {
                    (function (evt) {
                        for (var e in that.checkEvent) if (that.checkEvent[e]) $(input).off(e, evt).on(e, evt);
                    })(function () {
                        that.checkInput(input);
                    });
                });
                $(form).bind("submit", function (event) {
                    if (that.checkAllInput() && typeof callable === 'function') {
                        if (typeof CKEDITOR === 'object' && typeof CKEDITOR.instances === 'object') {
                            for (var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
                        }
                        callable.call(this, $(form).formToJson());
                    }
                    return event.preventDefault(), false;
                }).find('[data-form-loaded]').map(function () {
                    $(this).html(this.dataset.formLoaded || this.innerHTML);
                    $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
                });
                return $(form).data('validate', this);
            };
        }).check(form, callable, options);
    };

    /*! 自动监听规则内表单 */
    $.vali.listen = function () {
        $('form[data-auto]').map(function (index, form) {
            if (this.dataset.listen === 'true') return true;
            $(this).attr('data-listen', 'true').vali(function (data) {
                var call = form.dataset.callable || '_default_callable';
                var type = form.method || 'POST', tips = form.dataset.tips || undefined;
                var time = form.dataset.time || undefined, href = form.action || location.href;
                $.form.load(href, data, type, window[call] || undefined, true, tips, time);
            });
        });
    };

    /*! 注册对象到JqFn */
    $.fn.vali = function (callable, options) {
        return $.vali(this, callable, options);
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
    $.fn.uploadFile = function (callable) {
        if (this.data('inited')) return false;
        var that = this, mult = 'one|btn'.indexOf(this.data('file') || 'one') < 0 ? 1 : 0;
        this.data('inited', true).data('multiple', mult), require(['upload'], function (apply) {
            apply.call(this, that, callable);
        });
    };

    /*! 上传单张图片 */
    $.fn.uploadOneImage = function () {
        return this.each(function ($in, $bt) {
            $in = $(this), $bt = $('<a data-file="one" class="uploadimage transition"><span class="layui-icon">&#x1006;</span></a>');
            $bt.attr('data-size', $in.data('size') || 0).attr('data-file', 'one').attr('data-type', $in.data('type') || 'png,jpg,gif');
            $bt.attr('input', $in.get(0)).data('input', this).find('span').on('click', function (event) {
                event.stopPropagation(), $bt.attr('style', ''), $in.val('');
            });
            $in.attr('name', $bt.attr('data-field')).after($bt).on('change', function () {
                if (this.value) $bt.css('backgroundImage', 'url(' + encodeURI(this.value) + ')');
            }).trigger('change');
        }), this;
    };

    /*! 上传多张图片 */
    $.fn.uploadMultipleImage = function () {
        return this.each(function () {
            var $in = $(this), $bt = $('<a class="uploadimage"></a>'), imgs = this.value ? this.value.split('|') : [];
            $bt.attr('data-size', $in.data('size') || 0).attr('data-file', 'mut').attr('data-type', $in.data('type') || 'png,jpg,gif');
            $in.after($bt), $bt.uploadFile(function (src) {
                imgs.push(src), $in.val(imgs.join('|')), showImageContainer([src]);
            });
            if (imgs.length > 0) showImageContainer(imgs);

            function showImageContainer(srcs) {
                $(srcs).each(function (idx, src, $image) {
                    $image = $('<div class="uploadimage uploadimagemtl transition"><a class="layui-icon margin-right-5">&#xe602;</a><a class="layui-icon margin-right-5">&#x1006;</a><a class="layui-icon margin-right-5">&#xe603;</a></div>');
                    $image.attr('data-tips-image', encodeURI(src)).css('backgroundImage', 'url(' + encodeURI(src) + ')').on('click', 'a', function (event, index, prevs, $item) {
                        event.stopPropagation(), $item = $(this).parent(), index = $(this).index(), prevs = $bt.prevAll('div.uploadimage').length;
                        if (index === 0 && $item.index() !== prevs) $item.next().after($item);
                        else if (index === 2 && $item.index() > 1) $item.prev().before($item);
                        else if (index === 1) $item.remove();
                        imgs = [], $bt.prevAll('.uploadimage').map(function () {
                            imgs.push($(this).attr('data-tips-image'));
                        });
                        imgs.reverse(), $in.val(imgs.join('|'));
                    }), $bt.before($image);
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

    /*! 注册 data-serach 表单搜索行为 */
    onEvent('submit', 'form.form-search', function () {
        var url = $(this).attr('action').replace(/&?page=\d+/g, '');
        if ((this.method || 'get').toLowerCase() === 'get') {
            var split = url.indexOf('?') === -1 ? '?' : '&';
            if (location.href.indexOf('spm=') > -1) {
                return location.href = '#' + $.menu.parseUri(url + split + $(this).serialize());
            } else {
                return location.href = $.menu.parseUri(url + split + $(this).serialize());
            }
        }
        $.form.load(url, this, 'post');
    });

    /*! 注册 data-load 事件行为 */
    onEvent('click', '[data-load]', function () {
        var emap = this.dataset, data = {};
        if (this.dataset.rule && (applyRuleValue(this, data)) === false) return false;
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(emap.confirm, function () {
            $.form.load(emap.load, data, 'get', null, true, emap.tips, emap.time);
        });
    });

    /*! 注册 data-reload 事件行为 */
    onEvent('click', '[data-reload]', function () {
        $.form.reload();
    });

    /*! 注册 data-dbclick 事件行为 */
    onEvent('dblclick', '[data-dbclick]', function () {
        $(this).find(this.dataset.dbclick || '[data-dbclick]').trigger('click');
    });

    /*! 注册 data-check 事件行为 */
    onEvent('click', '[data-check-target]', function () {
        var target = this;
        $(this.dataset.checkTarget).map(function () {
            (this.checked = !!target.checked), $(this).trigger('change');
        });
    });

    /*! 表单元素失焦时提交 */
    onEvent('blur', '[data-action-blur]', function () {
        var that = $(this), emap = this.dataset, data = {'_token_': emap.token || emap.csrf || '--'};
        var attrs = (emap.value || '').replace('{value}', that.val()).split(';');
        for (var i in attrs) data[attrs[i].split('#')[0]] = attrs[i].split('#')[1];
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(emap.confirm, function () {
            $.form.load(emap.actionBlur, data, emap.method || 'post', function (ret) {
                return that.css('border', (ret && ret.code) ? '1px solid #e6e6e6' : '1px solid red'), false;
            }, emap.loading !== 'false', emap.loading, emap.time)
        });
    });

    /*! 表单元素失去焦点时数字 */
    onEvent('blur', '[data-blur-number]', function () {
        var emap = this.dataset, min = emap.valueMin, max = emap.valueMax;
        var value = parseFloat(this.value) || 0, fiexd = parseInt(emap.blurNumber || 0);
        if (typeof min !== 'undefined' && value < min) value = min;
        if (typeof max !== 'undefined' && value > max) value = max;
        this.value = parseFloat(value).toFixed(fiexd);
    });

    /*! 注册 data-href 事件行为 */
    onEvent('click', '[data-href]', function () {
        if (this.dataset.href && this.dataset.href.indexOf('#') !== 0) {
            location.href = this.dataset.href;
        }
    });

    /*! 注册 data-open 事件行为 */
    onEvent('click', '[data-open]', function () {
        if (this.dataset.open.match(/^https?:/)) {
            location.href = this.dataset.open;
        } else {
            $.form.href(this.dataset.open, this);
        }
    });

    /*! 注册 data-action 事件行为 */
    onEvent('click', '[data-action]', function () {
        var emap = this.dataset, data = {'_token_': emap.token || emap.csrf || '--'};
        var load = emap.loading !== 'false', tips = typeof load === 'string' ? load : undefined;
        if ((applyRuleValue(this, data)) === false) return false;
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(emap.confirm, function () {
            $.form.load(emap.action, data, emap.method || 'post', false, load, tips, emap.time)
        });
    });

    /*! 注册 data-modal 事件行为 */
    onEvent('click', '[data-modal]', function () {
        var emap = this.dataset, data = {open_type: 'modal'}, un = undefined;
        if (emap.rule && (applyRuleValue(this, data)) === false) return false;
        return $.form.modal(emap.modal, data, emap.title || this.innerText || '编辑', un, un, un, emap.area || emap.width || '800px');
    });

    /*! 注册 data-iframe 事件行为 */
    onEvent('click', '[data-iframe]', function () {
        var emap = this.dataset, data = {open_type: 'iframe'};
        if (emap.rule && (applyRuleValue(this, data)) === false) return false;
        var frame = emap.iframe + (emap.iframe.indexOf('?') > -1 ? '&' : '?') + $.param(data);
        $(this).attr('data-index', $.form.iframe(frame, emap.title || this.innerText || '窗口', emap.area || [
            emap.width || '800px', emap.height || '580px'
        ]));
    });

    /*! 注册 data-icon 事件行为 */
    onEvent('click', '[data-icon]', function () {
        var location = tapiRoot + '/api.plugs/icon', field = this.dataset.icon || this.dataset.field || 'icon';
        $.form.iframe(location + (location.indexOf('?') > -1 ? '&' : '?') + 'field=' + field, '图标选择', ['800px', '600px']);
    });

    /*! 注册 data-copy 事件行为 */
    onEvent('click', '[data-copy]', function () {
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
    onEvent('mouseenter', '[data-tips-text]', function () {
        var opt = {tips: [$(this).attr('data-tips-type') || 3, '#78BA32'], time: 0};
        $(this).attr('index', layer.tips($(this).attr('data-tips-text') || this.innerText, this, opt));
    }).on('mouseleave', '[data-tips-text]', function () {
        layer.close($(this).attr('index'));
    });

    /*! 注册 data-tips-image 事件行为 */
    onEvent('click', '[data-tips-image]', function () {
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
        return (img.src = src), defer.resolve();
    };

    /*! 注册 data-phone-view 事件行为 */
    onEvent('click', '[data-phone-view]', function () {
        $.previewPhonePage(this.dataset.phoneView || this.href);
    });
    $.previewPhonePage = function (href, title, template) {
        template = '<div><div class="mobile-preview pull-left"><div class="mobile-header">_TITLE_</div><div class="mobile-body"><iframe id="phone-preview" src="_URL_" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div></div>';
        layer.style(layer.open({type: true, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: true, shadeClose: false, skin: 'layui-layer-nobg', content: $(template.replace('_TITLE_', title || '公众号').replace('_URL_', href)).html()}), {boxShadow: 'none'});
    };

    /*! 表单编辑返回操作 */
    onEvent('click', '[data-history-back]', function () {
        $.msg.confirm(this.dataset.historyBack || '确定要返回吗？', function () {
            history.back();
        })
    });

    /*! 异步任务状态监听与展示 */
    onEvent('click', '[data-queue]', function (e) {
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(e.currentTarget.dataset.confirm, function () {
            $.form.load(e.currentTarget.dataset.queue, {}, 'post', function (ret) {
                if (typeof ret.data === 'string' && ret.data.indexOf('Q') === 0) {
                    return $.loadQueue(ret.data, true), false;
                }
            });
        });
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
            that = this, that.$box = $('[data-queue-load=' + code + ']');
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

    /*! 延时关闭加载动画 */
    window.addEventListener('load', function () {
        setTimeout(function () {
            $('body>.layui-page-loader').fadeOut();
        }, 200);
    }, true);

    /*! 图片加载异常处理 */
    document.addEventListener('error', function (event) {
        var elem = event.target;
        if (elem.nodeName === 'IMG') {
            elem.src = baseRoot + 'theme/img/404_icon.png';
        }
    }, true);

    /*! 系统菜单表单页面初始化 */
    $.menu.listen(), $.vali.listen(), $.form.reInit($body);
});