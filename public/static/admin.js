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
if (typeof Array.prototype.some !== 'function') {
    Array.prototype.some = function (callable) {
        for (var i in this) if (callable(this[i], i, this) === true) {
            return true;
        }
        return false;
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
if (typeof Array.prototype.forEach !== 'function') {
    Array.prototype.forEach = function (callable, context) {
        typeof context === "undefined" ? context = window : null;
        for (var i in this) callable.call(context, this[i], i, this)
    };
}

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

/*! 配置 layui 插件 */
layui.config({base: baseRoot + 'plugs/layui_exts/'});

/*! 挂载 layui & jquery 对象 */
if (typeof jQuery === 'undefined') window.$ = window.jQuery = layui.$;
window.form = layui.form, window.layer = layui.layer, window.laydate = layui.laydate;

/*! 配置 require 参数  */
require.config({
    waitSeconds: 60,
    baseUrl: baseRoot,
    map: {'*': {css: baseRoot + 'plugs/require/css.js'}},
    paths: {
        'vue': ['plugs/iview/vue.min'],
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
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.cropper': ['plugs/cropper/cropper.min'],
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
        // 新 tableId 规则兼容处理
        if (elem.dataset.tableId && elem.dataset.rule) {
            var idx1, idx2, temp, regx, field, rule = {};
            var json = layui.table.checkStatus(elem.dataset.tableId).data;
            layui.each(elem.dataset.rule.split(';'), function (idx, item, attr) {
                (attr = item.split('#', 2)), rule[attr[0]] = attr[1];
            });
            for (idx1 in rule) {
                temp = [], regx = new RegExp(/^{(.*?)}$/);
                if (regx.test(rule[idx1]) && (field = rule[idx1].replace(regx, '$1'))) {
                    for (idx2 in json) if (json[idx2][field]) temp.push(json[idx2][field]);
                    if (temp.length < 1) return $.msg.tips('请选择需要更改的数据！'), false;
                    data[idx1] = temp.join(',');
                } else {
                    data[idx1] = rule[idx1];
                }
            }
            return data;
        } else {
            var value = elem.dataset.value || (function (rule, array) {
                $(elem.dataset.target || 'input[type=checkbox].list-check-box').map(function () {
                    this.checked && array.push(this.value);
                });
                return array.length > 0 ? rule.replace('{key}', array.join(',')) : '';
            })(elem.dataset.rule || '', []) || '';
            if (value.length < 1) return $.msg.tips('请选择需要更改的数据！'), false;
            return value.split(';').forEach(function (item) {
                data[item.split('#')[0]] = item.split('#')[1];
            }), data;
        }
    }

    /*! 消息组件实例 */
    $.msg = new function () {
        var that = this;
        this.idx = [], this.shade = [0.02, '#000'];
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
        /*! 页面加载层 */
        this.page = new function () {
            this.$body = $('body>.think-page-loader');
            this.$main = $('.think-page-body+.think-page-loader');
            this.stat = function () {
                return this.$body.is(':visible');
            }, this.show = function () {
                this.stat() || this.$main.removeClass('layui-hide').show();
            }, this.hide = function () {
                if (this.time) clearTimeout(this.time);
                this.time = setTimeout(function () {
                    (that.page.time = 0) || that.page.$main.fadeOut();
                }, 200);
            };
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
    $.form = new function () {
        var that = this;
        /*! 内容区选择器 */
        this.selecter = '.layui-layout-admin>.layui-body>.think-page-body';
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
                }, error: function (XMLHttpRequest, $dialog, layIdx, iframe) {
                    if (parseInt(XMLHttpRequest.status) !== 200 && XMLHttpRequest.responseText.indexOf('Call Stack') > -1) try {
                        layIdx = layer.open({title: XMLHttpRequest.status + ' - ' + XMLHttpRequest.statusText, type: 2, move: false, content: 'javascript:;'});
                        layer.full(layIdx), $dialog = $('#layui-layer' + layIdx), iframe = $dialog.find('iframe').get(0);
                        (iframe.contentDocument || iframe.contentWindow.document).write(XMLHttpRequest.responseText);
                        $dialog.find('.layui-layer-setwin').css({right: '35px', top: '28px'}).find('a').css({marginLeft: 0});
                        $dialog.find('.layui-layer-title').css({color: 'red', height: '70px', lineHeight: '70px', fontSize: '22px', textAlign: 'center', fontWeight: 700});
                    } catch (e) {
                        layer.close(layIdx);
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
        /*! 以 HASH 打开新网页 */
        this.href = function (url, ele) {
            // 重置表格页数缓存
            if (ele && ele.dataset.menuNode) layui.sessionData('pages', null);
            if (url !== '#') location.hash = $.menu.parseUri(url, ele);
            else if (ele && ele.dataset.menuNode) $('[data-menu-node^="' + ele.dataset.menuNode + '-"]:first').trigger('click');
        };
        /*! 加载 HTML 到 BODY 位置 */
        this.open = function (url, data, call, load, tips) {
            this.load(url, data, 'get', function (ret) {
                return (typeof ret === 'object' ? $.msg.auto(ret) : that.show(ret)), false;
            }, load, tips);
        };
        /*! 打开 IFRAME 窗口 */
        this.iframe = function (url, name, area, offset) {
            return layer.open({title: name || '窗口', type: 2, area: area || ['800px', '580px'], offset: offset, fixed: true, maxmin: false, content: url});
        };
        /*! 加载 HTML 到弹出层 */
        this.modal = function (url, data, name, call, load, tips, area, offset) {
            this.load(url, data, 'GET', function (res) {
                if (typeof (res) === 'object') return $.msg.auto(res), false;
                $.msg.idx.push(layer.open({
                    type: 1, btn: false, area: area || "800px", resize: false, content: res, title: name || '', offset: offset || 'auto', success: function ($dom, idx) {
                        $.form.reInit($dom.off('click', '[data-close]').on('click', '[data-close]', function () {
                            (function (confirm, callable) {
                                confirm ? $.msg.confirm(confirm, callable) : callable();
                            })(this.dataset.confirm, function () {
                                layer.close(idx);
                            });
                        }));
                    }
                }));
                return (typeof call === 'function') && call.call(that);
            }, load, tips);
        };
    };

    /*! 后台菜单辅助插件 */
    $.menu = new function () {
        var that = this;
        /*! 计算 URL 地址中有效的 URI */
        this.getUri = function (uri) {
            uri = uri || location.href;
            uri = (uri.indexOf(location.host) > -1 ? uri.split(location.host)[1] : uri);
            return (uri.indexOf('#') > -1 ? uri.split('#')[1] : uri).split('?')[0];
        };
        /*! 通过 URI 查询最有可能的菜单 NODE */
        this.queryNode = function (url, node) {
            if (!/^m-/.test(node = node || location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1'))) {
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
            var $menu = $('.layui-layout-admin'), miniClass = 'layui-layout-left-mini';
            /*! Mini 菜单模式切换及显示 */
            if (layui.data('admin-menu-type')['type-mini']) $menu.addClass(miniClass);
            /*! 菜单切换事件处理 */
            onEvent('click', '[data-target-menu-type]', function () {
                layui.data('admin-menu-type', {key: 'type-mini', value: $menu.toggleClass(miniClass).hasClass(miniClass)});
            });
            /*! 监听窗口尺寸处理 */
            (function (callable) {
                $(window).on('resize', callable).trigger('resize');
            })(function () {
                (layui.data('admin-menu-type')['type-mini'] || $body.width() < 1000) ? $menu.addClass(miniClass) : $menu.removeClass(miniClass);
            });
            /*! Mini 菜单模式时TIPS文字显示 */
            $('[data-target-tips]').mouseenter(function () {
                if ($menu.hasClass(miniClass)) (function (idx) {
                    $(this).mouseleave(function () {
                        layer.close(idx);
                    });
                }).call(this, layer.tips(this.dataset.targetTips || '', this, {time: 0}));
            });
            /*!  左则二级菜单展示 */
            $('[data-submenu-layout]>a').on('click', function () {
                that.syncOpenStatus(1);
            });
            /*! 同步二级菜单展示状态 */
            this.syncOpenStatus = function (mode) {
                $('[data-submenu-layout]').map(function () {
                    var node = this.dataset.submenuLayout;
                    if (mode === 1) layui.data('admin-menu-stat', {key: node, value: $(this).hasClass('layui-nav-itemed') ? 2 : 1});
                    else if ((layui.data('admin-menu-stat')[node] || 2) === 2) $(this).addClass('layui-nav-itemed');
                });
            };
            window.onhashchange = function () {
                var hash = location.hash || '', node;
                if (hash.length < 1) return $('[data-menu-node]:first').trigger('click');
                // $.msg.page.show(),$.form.load(hash, {}, 'get', $.msg.page.hide, true),that.syncOpenStatus(2);
                $.form.load(hash, {}, 'get', false, !$.msg.page.stat()), that.syncOpenStatus(2);
                /*! 菜单选择切换 */
                if (/^m-/.test(node = that.queryNode(that.getUri()))) {
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
                    } else {
                        $('.layui-layout-admin').addClass('layui-layout-left-hide');
                    }
                    that.syncOpenStatus(1);
                }
            };
            /*! URI初始化动作 */
            window.onhashchange.call(this);
        };
    };

    /*! 注册对象到Jq */
    $.vali = function (form, callable) {
        if ($(form).attr('submit-listen')) {
            return $(form).data('validate');
        }
        return (new function () {
            var that = this;
            /* 绑定表单元素 */
            this.form = $(form);
            /* 绑定元素事件 */
            this.evts = 'blur change';
            /* 筛选表单元素 */
            this.tags = 'input,select,textarea';
            /* 预设检测规则 */
            this.patterns = {
                phone: '^1[3-9][0-9]{9}$',
                email: '^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$'
            };
            /*! 去除字符串的空格 */
            this.trim = function (str) {
                return str.replace(/(^\s*)|(\s*$)/g, '');
            };
            /*! 检测属性是否有定义 */
            this.hasProp = function (ele, prop) {
                if (typeof prop !== "string") return false;
                var attrProp = ele.getAttribute(prop);
                return typeof attrProp !== 'undefined' && attrProp !== null && attrProp !== false;
            };
            /*! 正则验证表单元素 */
            this.isRegex = function (ele) {
                var real = this.trim($(ele).val());
                var regexp = ele.getAttribute('pattern');
                regexp = that.patterns[regexp] || regexp;
                if (real === "" || !regexp) return true;
                return new RegExp(regexp, 'i').test(real);
            };
            /*! 检侧所有表单元素 */
            this.checkAllInput = function () {
                var isPass = true;
                that.form.find(this.tags).each(function () {
                    if (that.checkInput(this) === false) {
                        return $(this).focus(), isPass = false;
                    }
                });
                return isPass;
            };
            /*! 检测表单单元 */
            this.checkInput = function (input) {
                if (this.hasProp(input, 'data-auto-none')) return true;
                var type = (input.getAttribute("type") || '').replace(/\W+/, "").toLowerCase();
                var ingoreTypes = ['file', 'reset', 'image', 'radio', 'checkbox', 'submit', 'hidden'];
                if (ingoreTypes.length > 0) for (var i in ingoreTypes) if (type === ingoreTypes[i]) return true;
                if (this.hasProp(input, "required") && this.trim($(input).val()) === '') return this.remind(input);
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
                var $html = $('<span class="absolute block layui-anim text-center font-s12 notselect" style="color:#A44;z-index:2"></span>');
                var $next = $(ele).nextAll('.input-right-icon'), right = ($next ? $next.width() + parseFloat($next.css('right') || '0') : 0) + 10;
                var style = {top: $(ele).position().top + 'px', right: right + 'px', lineHeight: ele.nodeName === 'TEXTAREA' ? '32px' : $(ele).css('height')};
                return $(ele).data('input-info', $html.css(style).insertAfter(ele)), $html;
            };
            /*! 表单验证入口 */
            that.form.off(that.evts, that.tags).on(that.evts, that.tags, function () {
                that.checkInput(this);
            }).attr('novalidate', 'novalidate').attr('submit-listen', 'validate.submit');
            /*! 绑定提交事件 */
            that.form.data('validate', this).bind("submit", function (evt) {
                evt.button = that.form.find('button[type=submit],button:not([type=button])');
                /* 检查所有表单元素是否通过H5的规则验证 */
                if (that.checkAllInput() && typeof callable === 'function') {
                    if (typeof CKEDITOR === 'object' && typeof CKEDITOR.instances === 'object') {
                        for (var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
                    }
                    /* 触发表单提交后，锁定三秒不能再次提交表单 */
                    if (that.form.attr('submit-locked')) return false;
                    that.form.attr('submit-locked', 1), evt.button.addClass('submit-button-loading');
                    callable.call(this, that.form.formToJson()), setTimeout(function () {
                        that.form.removeAttr('submit-locked'), evt.button.removeClass('submit-button-loading');
                    }, 3000);
                }
                return evt.preventDefault(), false;
            }).find('[data-form-loaded]').map(function () {
                $(this).html(this.dataset.formLoaded || this.innerHTML);
                $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
            });
        });
    };

    /*! 自动监听规则内表单 */
    $.vali.listen = function () {
        $('form[data-auto]').map(function (index, form) {
            $(this).vali(function (data) {
                var type = form.method || 'POST', href = form.action || location.href;
                var call = window[form.dataset.callable || '_default_callable'] || undefined;
                var tips = form.dataset.tips || undefined, time = form.dataset.time || undefined;
                (function (confirm, callable) {
                    confirm ? $.msg.confirm(confirm, callable) : callable();
                })(form.dataset.confirm, function () {
                    $.form.load(href, data, type, call, true, tips, time);
                });
            });
        });
    };

    /*! 注册对象到JqFn */
    $.fn.vali = function (callable) {
        return this.each(function () {
            $.vali(this, callable);
        });
    };

    /*! 表单转JSON */
    $.fn.formToJson = function () {
        var self = this, data = {}, push = {};
        var rules = {key: /[a-zA-Z0-9_]+|(?=\[])/g, push: /^$/, fixed: /^\d+$/, named: /^[a-zA-Z0-9_]+$/};
        this.build = function (base, key, value) {
            return (base[key] = value), base;
        };
        this.pushCounter = function (name) {
            if (push[name] === undefined) push[name] = 0;
            return push[name]++;
        };
        $.each($(this).serializeArray(), function () {
            var key, keys = this.name.match(rules.key), merge = this.value, name = this.name;
            while ((key = keys.pop()) !== undefined) {
                name = name.replace(new RegExp("\\[" + key + "\\]$"), '');
                if (key.match(rules.push)) merge = self.build([], self.pushCounter(name), merge);
                else if (key.match(rules.fixed)) merge = self.build([], key, merge);
                else if (key.match(rules.named)) merge = self.build({}, key, merge);
            }
            data = $.extend(true, data, merge);
        });
        return data;
    };

    /*! 全局文件上传插件 */
    $.fn.uploadFile = function (callable, initialize) {
        return this.each(function () {
            if ($(this).data('inited')) return false;
            var that = $(this), mult = '|one|btn|'.indexOf(that.data('file') || 'one') > -1 ? 0 : 1;
            that.data('inited', true).data('multiple', mult), require(['upload'], function (apply) {
                apply(that, callable), (typeof initialize === 'function' && setTimeout(initialize, 100));
            });
        });
    };

    /*! 上传单张图片 */
    $.fn.uploadOneImage = function () {
        return this.each(function () {
            if ($(this).data('inited')) return true; else $(this).data('inited', true);
            var $in = $(this), $bt = $('<a data-file class="uploadimage transition"><span class="layui-icon">&#x1006;</span></a>').data('input', this);
            $bt.attr('data-size', $in.data('size') || 0).attr('data-type', $in.data('type') || 'png,jpg,gif').find('span').on('click', function (event) {
                event.stopPropagation(), $bt.attr('style', ''), $in.val('');
            }), $in.on('change', function () {
                if (this.value) $bt.css('backgroundImage', 'url(' + encodeURI(this.value) + ')');
            }).after($bt).trigger('change');
        });
    };

    /*! 上传多张图片 */
    $.fn.uploadMultipleImage = function () {
        return this.each(function () {
            if ($(this).data('inited')) return true; else $(this).data('inited', true);
            var $in = $(this), $bt = $('<a data-file="mul" class="uploadimage"></a>'), imgs = this.value ? this.value.split('|') : []
            $in.after($bt.attr('data-size', $in.data('size') || 0).attr('data-type', $in.data('type') || 'png,jpg,gif').uploadFile(function (src) {
                imgs.push(src), $in.val(imgs.join('|')), showImageContainer([src]);
            })), (imgs.length > 0 && showImageContainer(imgs));

            function showImageContainer(srcs) {
                $(srcs).each(function (idx, src, $image) {
                    $image = $('<div class="uploadimage uploadimagemtl transition"><div><a class="layui-icon">&#xe603;</a><a class="layui-icon">&#x1006;</a><a class="layui-icon">&#xe602;</a></div></div>');
                    $image.attr('data-tips-image', encodeURI(src)).css('backgroundImage', 'url(' + encodeURI(src) + ')').on('click', 'a', function (event, index, prevs, $item) {
                        event.stopPropagation(), $item = $(this).parent().parent(), index = $(this).index();
                        if (index === 2 && $item.index() !== $bt.prevAll('div.uploadimage').length) $item.next().after($item);
                        else if (index === 0 && $item.index() > 1) $item.prev().before($item); else if (index === 1) $item.remove();
                        imgs = [], $bt.prevAll('.uploadimage').map(function () {
                            imgs.push($(this).attr('data-tips-image'));
                        });
                        imgs.reverse(), $in.val(imgs.join('|'));
                    }), $bt.before($image);
                });
            }
        });
    };

    /*! 标签输入插件 */
    $.fn.initTagInput = function () {
        return this.each(function () {
            var $this = $(this), tags = this.value ? this.value.split(',') : [];
            var $text = $('<textarea class="layui-input layui-input-inline layui-tag-input"></textarea>');
            var $tags = $('<div class="layui-tags"></div>').append($text);
            $this.parent().append($tags), $text.off('keydown blur'), (tags.length > 0 && showTags(tags));
            $text.on('keydown blur', function (event, value) {
                if (event.keyCode === 13 || event.type === 'blur') {
                    event.preventDefault(), (value = $text.val().replace(/^\s*|\s*$/g, ''));
                    if (tags.indexOf($(this).val()) > -1) return layer.msg('该标签已经存在！');
                    if (value.length > 0) tags.push(value), $this.val(tags.join(',')), showTags([value]), this.focus(), $text.val('');
                }
            });

            function showTags(tagsArr) {
                $(tagsArr).each(function (idx, text, elem) {
                    elem = $('<div class="layui-tag"></div>').html(text + '<i class="layui-icon">&#x1006;</i>');
                    elem.on('click', 'i', function (tagText, tagIdx) {
                        tagText = $(this).parent().text(), tagIdx = tags.indexOf(tagText);
                        tags.splice(tagIdx, 1), $(this).parent().remove(), $this.val(tags.join(','));
                    }), $tags.append(elem, $text);
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
                var startPos = this.selectionStart, afterPos = this.selectionAfter, scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos) + value + this.value.substring(afterPos, this.value.length);
                if (scrollTop > 0) this.scrollTop = scrollTop;
                this.focus();
                this.selectionAfter = startPos + value.length;
                this.selectionStart = startPos + value.length;
            } else (this.value += value), this.focus();
        });
    }

    /*! 组件 layui.table 封装 */
    $.fn.layTable = function (params) {
        return this.each(function (idx, elem) {
            // 动态初始化数据表
            this.id = this.id || 't' + Math.random().toString().replace('.', '');
            this.setAttribute('lay-filter', this.dataset.id = this.getAttribute('lay-filter') || this.id);
            // 插件初始化参数
            var opt = params || {}, data = opt.where || {}, sort = opt.initSort || opt.sort || {};
            opt.id = elem.id, opt.elem = elem, opt.url = params.url || elem.dataset.url || location.href;
            opt.page = params.page !== false ? (params.page || true) : false, opt.limit = params.limit || 20;
            opt.loading = params.loading === true, opt.autoSort = params.autoSort === true, opt.cols = params.cols || [[]];
            // 默认动态设置页数, 动态设置最大高度
            if (opt.page === true) opt.page = {curr: layui.sessionData('pages')[opt.id] || 1}
            if (opt.height === 'full') opt.height = $(window).height() - $(elem).removeClass('layui-hide').offset().top - 35;
            // 动态计算最大页数
            opt.done = function () {
                layui.sessionData('pages', {key: elem.id, value: this.page.curr || 1}), (this.loading = true);
                this.elem.next().find('[data-load],[data-queue],[data-action]').not('[data-table-id]').attr('data-table-id', elem.id);
            }, opt.parseData = function (res) {
                var maxPage = Math.ceil(res.count / this.limit), curPage = layui.sessionData('pages')[opt.id] || 1;
                if (curPage > maxPage && curPage > 1) this.elem.trigger('reload', {page: {curr: maxPage}});
            };
            // 实例并绑定的对象
            $(this).data('this', layui.table.render(bindData(opt)));
            // 绑定实例重载事件
            $(this).bind('reload', function (evt, opts) {
                opts = opts || {}, opts.loading = true;
                data = $.extend({}, data, opts.where || {});
                layui.table.reload(elem.id, bindData(opts || {}));
            }).bind('row sort tool edit radio toolbar checkbox rowDouble', function (evt, call) {
                layui.table.on(evt.type + '(' + elem.dataset.id + ')', call)
            }).bind('setFullHeight', function () {
                $(elem).trigger('reload', {height: $(window).height() - $(elem).next().offset().top - 35})
            }).trigger('sort', function (object) {
                (sort = object), $(elem).trigger('reload')
            });
            // 搜索表单关联对象
            var search = params.search || this.dataset.targetSearch;
            if (search) $body.find(search).map(function () {
                $(this).attr('data-table-id', elem.id);
            });
            // 绑定选择项关联对象
            var checked = params.checked || this.dataset.targetChecked;
            if (checked) $body.find(checked).map(function () {
                $(this).attr('data-table-id', elem.id);
            });

            // 生成初始化参数
            function bindData(opts) {
                data['output'] = 'layui.table';
                if (sort.field && sort.type) {
                    data['_order_'] = sort.type, data['_field_'] = sort.field;
                    opts.initSort = {type: sort.type.split(',')[0].split(' ')[0], field: sort.field.split(',')[0].split(' ')[0]};
                }
                return (opts['where'] = data), opts;
            }
        });
    }

    /*! 弹出图片层 */
    $.previewImage = function (src, area) {
        var img = new Image(), defer = $.Deferred(), loaded = $.msg.loading();
        img.style.background = '#FFF', img.referrerPolicy = 'no-referrer';
        img.style.height = 'auto', img.style.width = area || '100%', img.style.display = 'none';
        document.body.appendChild(img), img.onerror = function () {
            $.msg.close(loaded), defer.reject();
        }, img.onload = function () {
            layer.open({
                type: 1, title: false, shadeClose: true, content: $(img), success: function ($elem, idx) {
                    $.msg.close(loaded), defer.notify($elem, idx);
                }, area: area || '480px', skin: 'layui-layer-nobg', closeBtn: 1, end: function () {
                    document.body.removeChild(img), defer.resolve()
                }
            });
        };
        return (img.src = src), defer.resolve();
    };

    /*! 以手机模式显示内容 */
    $.previewPhonePage = function (href, title) {
        var template = '<div class="mobile-preview"><div class="mobile-header">{{d.title}}</div><div class="mobile-body"><iframe src="{{d.url}}"></iframe></div></div>';
        layer.style(layer.open({type: true, resize: false, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: true, shadeClose: false, skin: 'layui-layer-nobg', content: layui.laytpl(template).render({title: title || '公众号', url: href})}), {boxShadow: 'none'});
    };

    /*! 显示任务进度消息 */
    $.loadQueue = function (code, doScript, element) {
        var doAjax = true, doReload = false;
        layui.layer.open({
            type: 1, title: false, area: ['560px', '315px'], anim: 2, shadeClose: false, end: function () {
                doAjax = false;
                if (doReload && doScript) {
                    if (element && element.dataset && element.dataset.tableId) {
                        $('#' + element.dataset.tableId).trigger('reload');
                    } else {
                        $.form.reload();
                    }
                }
            }, content: '' +
                '<div class="padding-30 padding-bottom-0"  data-queue-load="' + code + '">' +
                '   <div class="layui-elip notselect nowrap" data-message-title></div>' +
                '   <div class="margin-top-15 layui-progress layui-progress-big" lay-showPercent="yes"><div class="layui-progress-bar transition" lay-percent="0.00%"></div></div>' +
                '   <div class="margin-top-15"><code class="layui-textarea layui-bg-black border-0" disabled style="resize:none;overflow:hidden;height:190px"></code></div>' +
                '</div>',
            success: function ($elem) {
                new function () {
                    var that = this;
                    this.$box = $elem.find('[data-queue-load=' + code + ']');
                    if (doAjax === false || this.$box.length < 1) return false;
                    this.$coder = this.$box.find('code'), this.$name = this.$box.find('[data-message-title]');
                    this.$percent = this.$box.find('.layui-progress div'), this.SetCache = function (code, index, value) {
                        var ckey = code + '_' + index, ctype = 'admin-queue-script';
                        return value !== undefined ? layui.data(ctype, {key: ckey, value: value}) : layui.data(ctype)[ckey] || 0;
                    }, this.SetState = function (status, message) {
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
                            doReload = true;
                            that.$name.html('<b class="color-green">' + message + '</b>').addClass('text-center');
                            that.$percent.addClass('layui-bg-green').removeClass('layui-bg-blue layui-bg-red');
                        } else if (status === 4) {
                            that.$name.html('<b class="color-red">' + message + '</b>').addClass('text-center');
                            that.$percent.addClass('layui-bg-red').removeClass('layui-bg-blue layui-bg-green');
                        }
                    }, (this.LoadProgress = function () {
                        if (doAjax === false || that.$box.length < 1) return false;
                        $.form.load(tapiRoot + '/api.queue/progress', {code: code}, 'post', function (ret) {
                            if (ret.code) {
                                var lines = [];
                                for (var idx in ret.data.history) {
                                    var line = ret.data.history[idx], percent = '[ ' + line.progress + '% ] ';
                                    if (line.message.indexOf('javascript:') === -1) lines.push(line.message.indexOf('>>>') > -1 ? line.message : percent + line.message);
                                    else if (!that.SetCache(code, idx) && doScript !== false) that.SetCache(code, idx, 1), location.href = line.message;
                                }
                                if (ret.data.status > 0) {
                                    that.SetState(parseInt(ret.data.status), ret.data.message);
                                    that.$percent.attr('lay-percent', (parseFloat(ret.data.progress || '0.00').toFixed(2)) + '%'), layui.element.render();
                                    that.$coder.html('<p class="layui-elip">' + lines.join('</p><p class="layui-elip">') + '</p>').animate({scrollTop: that.$coder[0].scrollHeight + 'px'}, 200);
                                    return parseInt(ret.data.status) === 3 || parseInt(ret.data.status) === 4 || setTimeout(that.LoadProgress, Math.floor(Math.random() * 200)), false;
                                } else return setTimeout(that.LoadProgress, Math.floor(Math.random() * 500) + 200), false;
                            }
                        }, false);
                    })();
                };
            }
        });
    };

    /*! 注册 data-search 表单搜索行为 */
    onEvent('submit', 'form.form-search', function () {
        var tableId = this.dataset.tableId;
        if (tableId) return $('table#' + tableId).trigger('reload', {
            page: {curr: 1}, where: $(this).formToJson()
        });
        var url = $(this).attr('action').replace(/&?page=\d+/g, '');
        if ((this.method || 'get').toLowerCase() === 'get') {
            var split = url.indexOf('?') > -1 ? '&' : '?';
            var stype = location.href.indexOf('spm=') > -1 ? '#' : '';
            return location.href = stype + $.menu.parseUri(url + split + $(this).serialize());
        }
        return $.form.load(url, this, 'post');
    });

    /*! 注册 data-file 事件行为 */
    onEvent('click', '[data-file]', function () {
        if ($(this).data('inited') !== true) (function (that) {
            that.uploadFile(undefined, function () {
                that.trigger('upload.start');
            });
        })($(this));
    });

    /*! 注册 data-load 事件行为 */
    onEvent('click', '[data-load]', function () {
        var emap = this.dataset, data = {};
        if (this.dataset.rule && (applyRuleValue(this, data)) === false) return false;
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(emap.confirm, function () {
            var call = !emap.tableId ? false : function (ret) {
                if (ret.code > 0) return $.msg.success(ret.info, 3, function () {
                    $('#' + emap.tableId).trigger('reload');
                }), false;
            }
            $.form.load(emap.load, data, 'get', call, true, emap.tips, emap.time);
        });
    });

    /*! 注册 data-reload 事件行为 */
    onEvent('click', '[data-reload]', function () {
        this.dataset.tableId ? $('#' + this.dataset.tableId).trigger('reload') : $.form.reload();
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

    /*! 表单元素失去焦点时数字 */
    onEvent('blur', '[data-blur-number]', function () {
        var emap = this.dataset, min = emap.valueMin, max = emap.valueMax;
        var value = parseFloat(this.value) || 0, fiexd = parseInt(emap.blurNumber || 0);
        if (typeof min !== 'undefined' && value < min) value = min;
        if (typeof max !== 'undefined' && value > max) value = max;
        this.value = parseFloat(value).toFixed(fiexd);
    });

    /*! 表单元素失焦时提交 */
    onEvent('blur', '[data-action-blur],[data-blur-action]', function () {
        var that = $(this), emap = this.dataset, data = {'_token_': emap.token || emap.csrf || '--'};
        var attrs = (emap.value || '').replace('{value}', that.val()).split(';');
        for (var i in attrs) data[attrs[i].split('#')[0]] = attrs[i].split('#')[1];
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(emap.confirm, function () {
            $.form.load(emap.actionBlur || emap.blurAction, data, emap.method || 'post', function (ret) {
                return that.css('border', (ret && ret.code) ? '1px solid #e6e6e6' : '1px solid red'), false;
            }, emap.loading !== 'false', emap.loading, emap.time)
        });
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
            var call = !emap.tableId ? false : function (ret) {
                if (ret.code > 0) return $.msg.success(ret.info, 3, function () {
                    $('#' + emap.tableId).trigger('reload');
                }), false;
            }
            $.form.load(emap.action, data, emap.method || 'post', call, load, tips, emap.time)
        });
    });

    /*! 注册 data-modal 事件行为 */
    onEvent('click', '[data-modal]', function () {
        var emap = this.dataset, data = {open_type: 'modal'}, un = undefined;
        if (emap.rule && (applyRuleValue(this, data)) === false) return false;
        return $.form.modal(emap.modal, data, emap.title || this.innerText || '编辑', un, un, un, emap.area || emap.width || '800px', emap.offset || 'auto');
    });

    /*! 注册 data-iframe 事件行为 */
    onEvent('click', '[data-iframe]', function () {
        var emap = this.dataset, data = {open_type: 'iframe'};
        if (emap.rule && (applyRuleValue(this, data)) === false) return false;
        var frame = emap.iframe + (emap.iframe.indexOf('?') > -1 ? '&' : '?') + $.param(data);
        $(this).attr('data-index', $.form.iframe(frame, emap.title || this.innerText || '窗口', emap.area || [
            emap.width || '800px', emap.height || '580px'
        ], emap.offset || 'auto'));
    });

    /*! 注册 data-icon 事件行为 */
    onEvent('click', '[data-icon]', function () {
        var location = tapiRoot + '/api.plugs/icon', field = this.dataset.icon || this.dataset.field || 'icon';
        $.form.iframe(location + (location.indexOf('?') > -1 ? '&' : '?') + 'field=' + field, '图标选择', ['900px', '700px']);
    });

    /*! 注册 data-copy 事件行为 */
    onEvent('click', '[data-copy]', function () {
        (function (content, $textarea) {
            $body.append($textarea.val(content)), $textarea.select();
            document.execCommand('Copy') ? $.msg.tips('已复制到剪贴板！') : $.msg.tips('请使用鼠标操作复制！');
            $textarea.remove();
        })(this.dataset.copy, $('<textarea style="position:fixed;top:-500px"></textarea>'));
    });

    /*! 异步任务状态监听与展示 */
    onEvent('click', '[data-queue]', function () {
        var that = this;
        (function (confirm, callable) {
            confirm ? $.msg.confirm(confirm, callable) : callable();
        })(this.dataset.confirm, function () {
            $.form.load(that.dataset.queue, {}, 'post', function (ret) {
                if (typeof ret.data === 'string' && ret.data.indexOf('Q') === 0) {
                    return $.loadQueue(ret.data, true, that), false;
                }
            });
        });
    });

    /*! 注册 data-tips-text 事件行为 */
    onEvent('mouseenter', '[data-tips-text]', function () {
        var opts = {tips: [$(this).attr('data-tips-type') || 3, '#78BA32'], time: 0};
        var layidx = layer.tips($(this).attr('data-tips-text') || this.innerText, this, opts);
        $(this).off('mouseleave').on('mouseleave', function () {
            setTimeout("layui.layer.close('" + layidx + "')", 100);
        });
    });

    /*! 注册 data-tips-hover 事件行为 */
    onEvent('mouseenter', '[data-tips-image][data-tips-hover]', function () {
        var img = new Image(), that = this, layidx;
        img.referrerPolicy = 'no-referrer', img.style.maxWidth = '260px', img.style.maxHeight = '260px';
        img.src = this.dataset.tipsImage || this.dataset.lazySrc || this.src, img.onload = function () {
            layidx = layer.tips(img.outerHTML, that, {time: 0, skin: 'layui-layer-image', anim: 5, scrollbar: false});
            $(that).off('mouseleave').on('mouseleave', function () {
                layui.layer.close(layidx);
            });
        }
    });

    /*! 注册 data-tips-image 事件行为 */
    onEvent('click', '[data-tips-image]', function () {
        $.previewImage(this.dataset.tipsImage || this.dataset.lazySrc || this.src, this.dataset.with);
    });

    /*! 注册 data-phone-view 事件行为 */
    onEvent('click', '[data-phone-view]', function () {
        $.previewPhonePage(this.dataset.phoneView || this.href);
    });

    /*! 表单编辑返回操作 */
    onEvent('click', '[data-history-back]', function () {
        $.msg.confirm(this.dataset.historyBack || '确定要返回吗？', function () {
            history.back();
        })
    });

    /*! 延时关闭加载动画 */
    window.addEventListener('load', function () {
        setTimeout("$('body>.think-page-loader').fadeOut()", 200);
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