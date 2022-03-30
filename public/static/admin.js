// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2022 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
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

/*! 应用根路径，静态插件库路径，动态插件库路径 */
var srcs = document.scripts[document.scripts.length - 1].src.split('/');
window.appRoot = srcs.slice(0, -2).join('/') + '/';
window.baseRoot = srcs.slice(0, -1).join('/') + '/';
window.tapiRoot = window.tapiRoot || window.appRoot + "admin";

/*! 挂载 layui & jquery 对象 */
layui.config({base: baseRoot + 'plugs/layui_exts/'});
window.form = layui.form, window.layer = layui.layer;
window.laytpl = layui.laytpl, window.laydate = layui.laydate;
window.jQuery = window.$ = window.jQuery || window.$ || layui.$;

/*! 配置 require 参数  */
require.config({
    baseUrl: baseRoot, waitSeconds: 60,
    map: {'*': {css: baseRoot + 'plugs/require/css.js'}},
    paths: {
        'vue': ['plugs/vue/vue.min'],
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
        'sortablejs': ['plugs/sortable/sortable.min'],
        'vue.sortable': ['plugs/sortable/vue.draggable.min'],
        'jquery.ztree': ['plugs/ztree/ztree.all.min'],
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.cropper': ['plugs/cropper/cropper.min'],
        'jquery.autocompleter': ['plugs/jquery/autocompleter.min'],
    },
    shim: {
        'excel': {deps: [baseRoot + 'plugs/layui_exts/excel.js']},
        'websocket': {deps: [baseRoot + 'plugs/socket/swfobject.min.js']},
        'cropper': {deps: ['css!' + baseRoot + 'plugs/cropper/cropper.min.css']},
        'vue.sortable': {deps: ['vue', 'sortablejs']},
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

    /*! 注册确认回调 */
    function onConfirm(confirm, callable) {
        confirm ? $.msg.confirm(confirm, callable) : callable();
    }

    /*! 获取加载回调 */
    onConfirm.getLoadCallable = function (tabldId, callable) {
        typeof callable === 'function' && callable();
        return tabldId ? function (ret) {
            if (ret.code > 0) return $.msg.success(ret.info, 3, function () {
                $.layTable.reload(tabldId);
            }) && false;
        } : false;
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
        this.idx = [], this.mdx = [];
        this.shade = [0.02, '#000000'];
        /*! 关闭消息框 */
        this.close = function (idx) {
            if (idx !== null) return layer.close(idx);
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
            }, this.done = function () {
                that.page.$body.fadeOut();
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
                return url ? location.href = url : $.form.reload();
            } else return (parseInt(ret.code) === 1) ? this.success(msg, time, function () {
                url ? location.href = url : $.form.reload();
                that.close($.msg.mdx.length > 0 ? $.msg.mdx.pop() : null);
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
            if (force) return top.location.reload();
            if (self !== top) return location.reload();
            return $.menu.href(location.hash);
        };
        /*! 内容区域动态加载后初始化 */
        this.reInit = function ($dom) {
            $.vali.listen($dom = $dom || $(this.selecter));
            layui.form.render(), layui.element.render(), $(window).trigger('scroll');
            return $dom.find('[required]').map(function ($parent) {
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
                    this.dataset.lazyLoaded = 'true';
                    if (this.nodeName === 'IMG') this.src = this.dataset.lazySrc;
                    else this.style.backgroundImage = 'url(' + this.dataset.lazySrc + ')';
                }
            }), $body.trigger('reInit', $dom), $dom;
        };
        /*! 在内容区显示视图 */
        this.show = function (html) {
            that.reInit($(this.selecter).html(html));
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
                    $.msg.page.done();
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
        this.iframe = function (url, name, area, offset, destroy) {
            return layer.open({title: name || '窗口', type: 2, area: area || ['800px', '580px'], end: destroy || null, offset: offset, fixed: true, maxmin: false, content: url});
        };
        /*! 加载 HTML 到弹出层 */
        this.modal = function (url, data, name, call, load, tips, area, offset) {
            this.load(url, data, 'GET', function (res) {
                if (typeof res === 'object') return $.msg.auto(res), false;
                return $.msg.mdx.push(layer.open({
                    type: 1, btn: false, area: area || "800px", resize: false, content: res, title: name || '', offset: offset || 'auto', success: function ($dom, idx) {
                        typeof call === 'function' && call.call(that, $dom);
                        $.form.reInit($dom.off('click', '[data-close]').on('click', '[data-close]', function () {
                            onConfirm(this.dataset.confirm, function () {
                                layer.close(idx);
                            });
                        }));
                    }
                })), false;
            }, load, tips);
        };
    };

    /*! 后台菜单辅助插件 */
    $.menu = new function () {
        var that = this;
        /*! 计算 URL 地址中有效的 URI */
        this.getUri = function (uri) {
            uri = uri || location.href;
            uri = uri.indexOf(location.host) > -1 ? uri.split(location.host)[1] : uri;
            return (uri.indexOf('#') > -1 ? uri.split('#')[1] : uri).split('?')[0];
        };
        /*! 通过 URI 查询最佳菜单 NODE */
        this.queryNode = function (uri, node) {
            if (!/^m-/.test(node = node || location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1'))) {
                var $menu = $('[data-menu-node][data-open*="' + uri.replace(/\.html$/ig, '') + '"]');
                return $menu.size() ? $menu.get(0).dataset.menuNode : '';
            }
            return node;
        };
        /*! 完整 URL 转 URI 地址 */
        this.parseUri = function (uri, elem, vars, temp, attrs) {
            vars = {}, attrs = [], elem = elem || document.createElement('a');
            if (uri.indexOf('?') > -1) uri.split('?')[1].split('&').forEach(function (item) {
                if (item.indexOf('=') > -1 && (temp = item.split('=')) && typeof temp[0] === 'string' && temp[0].length > 0) {
                    vars[temp[0]] = encodeURIComponent(decodeURIComponent(temp[1].replace(/%2B/ig, '%20')));
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
            var layout = $('.layui-layout-admin'), mclass = 'layui-layout-left-mini';
            /*! 菜单切及MiniTips处理 */
            onEvent('click', '[data-target-menu-type]', function () {
                layui.data('AdminMenuType', {key: 'mini', value: layout.toggleClass(mclass).hasClass(mclass)});
            }).on('click', '[data-submenu-layout]>a', function () {
                setTimeout("$.menu.sync(1)", 100);
            }).on('mouseenter', '[data-target-tips]', function (evt) {
                if (!layout.hasClass(mclass) || !this.dataset.targetTips) return;
                evt.idx = layer.tips(this.dataset.targetTips, this, {time: 0});
                $(this).mouseleave(function () {
                    layer.close(evt.idx);
                });
            });
            /*! 监听窗口大小及HASH切换 */
            $(window).on('resize', function () {
                (layui.data('AdminMenuType')['mini'] || $body.width() < 1000) ? layout.addClass(mclass) : layout.removeClass(mclass);
            }).trigger('resize').on('hashchange', function () {
                if (/^#(https?:)?(\/\/|\\\\)/.test(location.hash)) return $.msg.tips('禁止访问外部链接！');
                if (location.hash.length < 1) return $body.find('[data-menu-node]:first').trigger('click');
                else return that.href(location.hash);
            }).trigger('hashchange');
        };
        /*! 同步二级菜单展示状态 */
        this.sync = function (mode) {
            $('[data-submenu-layout]').map(function () {
                var node = this.dataset.submenuLayout;
                if (mode === 1) layui.data('AdminMenuState', {key: node, value: $(this).hasClass('layui-nav-itemed') ? 2 : 1});
                else if (mode === 2) (layui.data('AdminMenuState')[node] || 2) === 2 && $(this).addClass('layui-nav-itemed');
            });
        };
        /*! 页面 LOCATION-HASH 跳转 */
        this.href = function (hash, node) {
            if ((hash || '').length < 1) return $('[data-menu-node]:first').trigger('click');
            // $.msg.page.show(),$.form.load(hash, {}, 'get', $.msg.page.hide, true),that.sync(2);
            $.form.load(hash, {}, 'get', false, !$.msg.page.stat()), that.sync(2);
            /*! 菜单选择切换 */
            if (/^m-/.test(node = node || that.queryNode(that.getUri()))) {
                var arr = node.split('-'), tmp = arr.shift(), $all = $('a[data-menu-node]').parent('.layui-this');
                while (arr.length > 0) {
                    tmp = tmp + '-' + arr.shift();
                    $all = $all.not($('a[data-menu-node="' + tmp + '"]').parent().addClass('layui-this'));
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
                setTimeout("$.menu.sync(1);", 100);
            }
        };
    };

    /*! 表单验证组件 */
    $.vali = function (form, callable) {
        return $(form).data('validate') || new Validate();

        function Validate() {
            var that = this;
            /* 绑定表单元素 */
            this.form = $(form);
            /* 绑定元素事件, 筛选表单元素 */
            this.evts = 'blur change';
            this.tags = 'input,select,textarea';
            /* 预设检测规则 */
            this.patterns = {
                phone: '^1[3-9][0-9]{9}$',
                email: '^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$'
            };
            /*! 检测属性是否有定义 */
            this.hasProp = function (ele, prop) {
                var attrProp = ele.getAttribute(prop);
                return typeof attrProp !== 'undefined' && attrProp !== null && attrProp !== false;
            }, this.isRegex = function (ele) {
                var real = $.trim($(ele).val());
                var regexp = ele.getAttribute('pattern');
                regexp = this.patterns[regexp] || regexp;
                if (real === "" || !regexp) return true;
                return new RegExp(regexp, 'i').test(real);
            }, this.checkAllInput = function () {
                var status = true;
                return that.form.find(this.tags).each(function () {
                    if (that.checkInput(this) === false) return $(this).focus(), status = false;
                }), status;
            }, this.checkInput = function (input) {
                if (this.hasProp(input, 'data-auto-none')) return true;
                var type = (input.getAttribute('type') || '').replace(/\W+/, "").toLowerCase();
                var ingores = ['file', 'reset', 'image', 'radio', 'checkbox', 'submit', 'hidden'];
                if (ingores.length > 0) for (var i in ingores) if (type === ingores[i]) return true;
                if (this.hasProp(input, 'required') && $.trim($(input).val()) === '') return this.remind(input);
                return this.isRegex(input) ? (this.hideError(input), true) : this.remind(input);
            }, this.remind = function (input) {
                if (!$(input).is(':visible')) return true;
                return this.showError(input, input.getAttribute('title') || input.getAttribute('placeholder') || '输入错误'), false;
            }, this.showError = function (ele, tip) {
                $(ele).addClass('validate-error');
                this.insertError(ele).addClass('layui-anim-fadein').css({width: 'auto'}).html(tip);
            }, this.hideError = function (ele) {
                $(ele).removeClass('validate-error');
                this.insertError(ele).removeClass('layui-anim-fadein').css({width: '30px'}).html('');
            }, this.insertError = function (ele) {
                if ($(ele).data('input-info')) return $(ele).data('input-info');
                var $html = $('<span class="absolute block layui-anim text-center font-s12 notselect" style="color:#A44;z-index:2"></span>');
                var $next = $(ele).nextAll('.input-right-icon'), right = ($next ? $next.width() + parseFloat($next.css('right') || '0') : 0) + 10;
                var style = {top: $(ele).position().top + 'px', right: right + 'px', lineHeight: ele.nodeName === 'TEXTAREA' ? '32px' : $(ele).css('height')};
                return $(ele).data('input-info', $html.css(style).insertAfter(ele)), $html;
            };
            /*! 表单元素验证 */
            this.form.attr({onsubmit: 'return false', novalidate: 'novalidate', autocomplete: 'off'});
            this.form.off(this.evts, this.tags).on(this.evts, this.tags, function () {
                that.checkInput(this);
            }).data('validate', this).bind("submit", function (evt) {
                evt.button = that.form.find('button[type=submit],button:not([type=button])');
                /* 检查所有表单元素是否通过H5的规则验证 */
                if (that.checkAllInput() && typeof callable === 'function') {
                    if (typeof CKEDITOR === 'object' && typeof CKEDITOR.instances === 'object') {
                        for (var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
                    }
                    /* 触发表单提交后，锁定三秒不能再次提交表单 */
                    if (that.form.attr('submit-locked')) return false;
                    that.form.attr('submit-locked', 1), evt.button.addClass('submit-button-loading');
                    callable.call(this, that.form.formToJson(), []), setTimeout(function () {
                        that.form.removeAttr('submit-locked'), evt.button.removeClass('submit-button-loading');
                    }, 3000);
                }
                return evt.preventDefault(), false;
            }).find('[data-form-loaded]').map(function () {
                $(this).html(this.dataset.formLoaded || this.innerHTML);
                $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
            });
        }
    };

    /*! 自动监听表单 */
    $.vali.listen = function ($dom, $els) {
        $els = $($dom || $body).find('form[data-auto]');
        $dom && $($dom).filter('form[data-auto]') && $els.add($dom);
        $els.size() > 0 && $els.map(function (idx, form) {
            $(this).vali(function (data) {
                var emap = form.dataset, type = form.method || 'POST', href = form.action || location.href;
                var tips = emap.tips || undefined, time = emap.time || undefined, taid = emap.tableId || false;
                var call = window[emap.callable || '_default_callable'] || (taid ? function (ret) {
                    if (typeof ret === 'object' && ret.code > 0 && $('#' + taid).size() > 0) {
                        return $.msg.success(ret.info, 3, function () {
                            (typeof ret.data === 'string' && ret.data) ? location.href = ret.data : $.layTable.reload(taid);
                            $.msg.close($.msg.mdx.length > 0 ? $.msg.mdx.pop() : null);
                        }) && false;
                    }
                } : undefined);
                onConfirm(emap.confirm, function () {
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
        }, this.pushCounter = function (name) {
            if (push[name] === undefined) push[name] = 0;
            return push[name]++;
        }, $.each($(this).serializeArray(), function () {
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
            var $in = $(this), $bt = $('<a data-file class="uploadimage transition"><span class="layui-icon">&#x1006;</span><span class="layui-icon">&#xe615;</span></a>').data('input', this);
            $bt.attr('data-size', $in.data('size') || 0).attr('data-type', $in.data('type') || 'png,jpg,gif,jpeg').find('span').on('click', function (event) {
                event.stopPropagation();
                if ($(this).index() === 0) $bt.attr('style', ''), $in.val(''); else $in.val() && $.previewImage(encodeURI($in.val()));
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
            $in.after($bt.attr('data-size', $in.data('size') || 0).attr('data-type', $in.data('type') || 'gif,png,jpg,jpeg').uploadFile(function (src) {
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
            $text.on('blur keydown', function (event, value) {
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
            this.focus();
            if (document.selection) {
                var selection = document.selection.createRange();
                (selection.text = value), selection.select(), selection.unselect();
            } else if (this.selectionStart || this.selectionStart === 0) {
                var spos = this.selectionStart, apos = this.selectionEnd || spos;
                this.value = this.value.substring(0, spos) + value + this.value.substring(apos, this.value.length);
                this.selectionEnd = this.selectionStart = spos + value.length;
            } else {
                this.value += value;
            }
            this.focus();
        });
    };

    /*! 组件 layui.table 封装 */
    $.fn.layTable = function (params) {
        return this.each(function () {
            $.layTable.create(this, params);
        });
    };
    $.layTable = new function () {
        this.render = function (tabldId) {
            return $('#' + tabldId).trigger('render');
        }, this.reload = function (tabldId) {
            return $('#' + tabldId).trigger('reload');
        }, this.create = function (table, params) {
            // 动态初始化表格
            table.id = table.id || 't' + Math.random().toString().replace('.', '');
            var $table = $(table).attr('lay-filter', table.dataset.id = table.getAttribute('lay-filter') || table.id);
            // 插件初始化参数
            var option = params || {}, data = option.where || {}, sort = option.initSort || option.sort || {};
            option.id = table.id, option.elem = table, option.url = params.url || table.dataset.url || location.href;
            option.page = params.page !== false ? (params.page || true) : false, option.limit = params.limit || 20;
            option.loading = !!params.loading, option.autoSort = params.autoSort === true, option.cols = params.cols || [[]];
            // 初始化不显示头部
            option.css = (option.css || '') + '.layui-table-box{opacity:0}.layui-table-page{opacity:0}';
            // 默认动态设置页数, 动态设置最大高度
            if (option.page === true) option.page = {curr: layui.sessionData('pages')[option.id] || 1};
            if (option.height === 'full') if ($table.parents('.iframe-pagination').size()) {
                $table.parents('.iframe-pagination').addClass('not-footer');
                option.height = $(window).height() - $table.removeClass('layui-hide').offset().top - 20;
            } else {
                option.height = $(window).height() - $table.removeClass('layui-hide').offset().top - 35;
            }
            // 动态计算最大页数
            option.done = function () {
                $table.data('that', this).next().find('.layui-table-box,.layui-table-page').animate({opacity: 1});
                (option.loading = this.loading = true) && layui.sessionData('pages', {key: table.id, value: this.page.curr || 1});
                $.form.reInit($table.next()).find('[data-load],[data-queue],[data-action],[data-iframe]').not('[data-table-id]').attr('data-table-id', table.id);
            }, option.parseData = function (res) {
                if (typeof params.filter === 'function') {
                    res.data = params.filter(res.data, res);
                }
                if (!this.page || !this.page.curr) return res;
                var curp = this.page.curr, maxp = Math.ceil(res.count / option.limit);
                if (curp > maxp && maxp > 1) $table.trigger('reload', {page: {curr: maxp}});
                return res;
            };
            // 实例并绑定事件
            $table.data('this', layui.table.render(bindData(option)));
            $table.bind('reload render reloadData', function (evt, opts) {
                data = $.extend({}, data, (opts = opts || {}).where || {});
                opts = bindData($.extend({}, opts, {loading: true}));
                if (evt.type.indexOf('reload') > -1) {
                    var $that = $table.data('that');
                    if ($that && $that.page && $that.page.jump) {
                        $that.sort = $that.initSort = opts.initSort, $that.where = data;
                        if (opts.page && opts.page.curr) $that.page.curr = opts.page.curr || 1;
                        $that.page.jump({curr: $that.page.curr, limit: option.limit});
                    } else {
                        layui.table.reloadData(table.id, opts);
                    }
                } else {
                    layui.table.reload(table.id, opts);
                }
            }).bind('row sort tool edit radio toolbar checkbox rowDouble', function (evt, call) {
                layui.table.on(evt.type + '(' + table.dataset.id + ')', call)
            }).bind('setFullHeight', function () {
                $table.trigger('render', {height: $(window).height() - $table.next().offset().top - 35})
            }).trigger('sort', function (rets) {
                (sort = rets), $table.trigger('reload')
            });
            // 搜索表单关联对象
            var search = params.search || table.dataset.targetSearch;
            if (search) $body.find(search).map(function () {
                $(this).attr('data-table-id', table.id);
            });
            // 绑定选择项关联对象
            var checked = params.checked || table.dataset.targetChecked;
            if (checked) $body.find(checked).map(function () {
                $(this).attr('data-table-id', table.id);
            });
            return $table;

            // 生成初始化参数
            function bindData(options) {
                data['output'] = 'layui.table';
                if (sort.field && sort.type) {
                    data['_order_'] = sort.type, data['_field_'] = sort.field;
                    options.initSort = {type: sort.type.split(',')[0].split(' ')[0], field: sort.field.split(',')[0].split(' ')[0]};
                }
                if (options.page === false) options.limit = '';
                return (options['where'] = data), options;
            }
        };
    };

    /*! 弹出图片层 */
    $.previewImage = function (src, area) {
        var img = new Image(), defer = $.Deferred(), loaded = $.msg.loading();
        img.style.background = '#FFF', img.referrerPolicy = 'no-referrer';
        img.style.height = 'auto', img.style.width = area || '100%', img.style.display = 'none';
        return document.body.appendChild(img), img.onerror = function () {
            $.msg.close(loaded), defer.reject();
        }, img.src = src, img.onload = function () {
            layer.open({
                type: 1, title: false, shadeClose: true, content: $(img), success: function ($elem, idx) {
                    $.msg.close(loaded), defer.notify($elem, idx);
                }, area: area || '480px', skin: 'layui-layer-nobg', closeBtn: 1, end: function () {
                    document.body.removeChild(img), defer.resolve()
                }
            });
        }, defer.promise();
    };

    /*! 以手机模式显示内容 */
    $.previewPhonePage = function (href, title) {
        var template = '<div class="mobile-preview"><div class="mobile-header">{{d.title}}</div><div class="mobile-body"><iframe src="{{d.url}}"></iframe></div></div>';
        layer.style(layer.open({type: true, resize: false, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: true, shadeClose: false, skin: 'layui-layer-nobg', content: laytpl(template).render({title: title || '公众号', url: href})}), {boxShadow: 'none'});
    };

    /*! 显示任务进度消息 */
    $.loadQueue = function (code, doScript, element) {
        var doAjax = true, doReload = false;
        layer.open({
            type: 1, title: false, area: ['560px', '315px'], anim: 2, shadeClose: false, end: function () {
                doAjax = false;
                if (doReload && doScript) {
                    if (element && element.dataset && element.dataset.tableId) {
                        $.layTable.reload(element.dataset.tableId);
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
        if (this.dataset.tableId) return $('table#' + this.dataset.tableId).trigger('reload', {
            page: {curr: 1}, where: $(this).formToJson()
        });
        var url = $(this).attr('action').replace(/&?page=\d+/g, '');
        if ((this.method || 'get').toLowerCase() === 'get') {
            var split = url.indexOf('?') > -1 ? '&' : '?', stype = location.href.indexOf('spm=') > -1 ? '#' : '';
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
        if (emap.rule && (applyRuleValue(this, data)) === false) return false; else onConfirm(emap.confirm, function () {
            $.form.load(emap.load, data, 'get', onConfirm.getLoadCallable(emap.tableId), true, emap.tips, emap.time);
        });
    });

    /*! 注册 data-reload 事件行为 */
    onEvent('click', '[data-reload]', function () {
        this.dataset.tableId ? $.layTable.reload(this.dataset.tableId) : $.form.reload();
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
        onConfirm(emap.confirm, function () {
            $.form.load(emap.actionBlur || emap.blurAction, data, emap.method || 'post', function (ret) {
                return that.css('border', (ret && ret.code) ? '1px solid #e6e6e6' : '1px solid red') && false;
            }, emap.loading !== 'false', emap.loading, emap.time);
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
        if ((applyRuleValue(this, data)) === false) return false; else onConfirm(emap.confirm, function () {
            $.form.load(emap.action, data, emap.method || 'post', onConfirm.getLoadCallable(emap.tableId), load, tips, emap.time)
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
        var name = emap.title || this.innerText || 'IFRAME 窗口';
        var area = emap.area || [emap.width || '800px', emap.height || '580px'];
        var frame = emap.iframe + (emap.iframe.indexOf('?') > -1 ? '&' : '?') + $.param(data);
        $(this).attr('data-index', $.form.iframe(frame, name, area, emap.offset || 'auto', emap.tableId ? function () {
            typeof emap.refresh !== 'undefined' && $.layTable.reload(emap.tableId);
        } : function () {
            typeof emap.refresh !== 'undefined' && $.form.reload();
        }));
    });

    /*! 注册 data-icon 事件行为 */
    onEvent('click', '[data-icon]', function () {
        var location = tapiRoot + '/api.plugs/icon', field = this.dataset.icon || this.dataset.field || 'icon';
        $.form.iframe(location + (location.indexOf('?') > -1 ? '&' : '?') + 'field=' + field, '图标选择', ['900px', '700px']);
    });

    /*! 注册 data-copy 事件行为 */
    onEvent('click', '[data-copy]', function () {
        var copy = this.dataset.copy || this.innerText;
        if (window.clipboardData) {
            window.clipboardData.setData('text', copy);
            $.msg.tips('已复制到剪贴板！');
        } else {
            var $input = $('<textarea readonly></textarea>');
            $input.css({position: 'fixed', top: '-500px'}).appendTo($body).val(copy).select();
            $.msg.tips(document.execCommand('Copy') ? '已复制到剪贴板！' : '请使用鼠标操作复制！') && $input.remove();
        }
    });

    /*! 异步任务状态监听与展示 */
    onEvent('click', '[data-queue]', function () {
        var that = this, emap = this.dataset;
        onConfirm(emap.confirm || false, function () {
            $.form.load(emap.queue, {}, 'post', function (ret) {
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
            setTimeout("layer.close('" + layidx + "')", 100);
        });
    });

    /*! 注册 data-tips-hover 事件行为 */
    onEvent('mouseenter', '[data-tips-image][data-tips-hover]', function () {
        var img = new Image(), ele = $(this);
        if ((img.src = this.dataset.tipsImage || this.dataset.lazySrc || this.src)) {
            img.layopt = {time: 0, skin: 'layui-layer-image', anim: 5, isOutAnim: false, scrollbar: false};
            img.referrerPolicy = 'no-referrer', img.style.maxWidth = '260px', img.style.maxHeight = '260px';
            ele.data('layidx', layer.tips(img.outerHTML, this, img.layopt)).off('mouseleave').on('mouseleave', function () {
                layer.close(ele.data('layidx'));
            });
        }
    });

    /*! 注册 data-tips-image 事件行为 */
    onEvent('click', '[data-tips-image]', function (event) {
        (event.items = [], event.$imgs = $(this).parent().find('[data-tips-image]')).map(function () {
            event.items.push({src: this.dataset.tipsImage || this.dataset.lazySrc || this.src});
        }) && layer.photos({
            anim: 5, closeBtn: 1, photos: {start: event.$imgs.index(this), data: event.items}, tab: function (pic, $ele) {
                $ele.find('.layui-layer-close').css({top: 0, right: 0, position: 'fixed'});
            }
        });
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

    /*! 图片加载异常处理 */
    document.addEventListener('error', function (event) {
        if (event.target.nodeName !== 'IMG') return;
        event.target.src = baseRoot + 'theme/img/404_icon.png';
    }, true);

    /*! 系统菜单表单页面初始化 */
    $.menu.listen(), $.form.reInit($body);
});