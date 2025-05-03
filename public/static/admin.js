// +----------------------------------------------------------------------
// | Static Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2025 ThinkAdmin [ thinkadmin.top ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-static
// | github 代码仓库：https://github.com/zoujingli/think-plugs-static
// +----------------------------------------------------------------------

/*! 应用根路径，静态插件库路径，动态插件库路径 */
let srcs = document.scripts[document.scripts.length - 1].src.split('/');
window.appRoot = srcs.slice(0, -2).join('/') + '/';
window.baseRoot = srcs.slice(0, -1).join('/') + '/';
window.tapiRoot = window.taAdmin || window.appRoot + "admin";

/*! 挂载 layui & jquery 对象 */
layui.config({base: baseRoot + 'plugs/layui_exts/'});
window.form = layui.form, window.layer = layui.layer;
window.laytpl = layui.laytpl, window.laydate = layui.laydate;
window.jQuery = window.$ = window.jQuery || window.$ || layui.$;
window.jQuery.ajaxSetup({xhrFields: {withCredentials: true}});
window.jQuery.fn.size || (window.jQuery.fn.size = () => this.length);

/*! 配置 require 参数  */
require.config({
    baseUrl: baseRoot, waitSeconds: 60,
    map: {'*': {css: baseRoot + 'plugs/require/css.js'}},
    paths: {
        // ---------- 自定义 ----------
        'excel': ['plugs/admin/excel'],
        'queue': ['plugs/admin/queue'],
        'upload': [tapiRoot + '/api.upload/index?'],
        'validate': ['plugs/admin/validate'],
        'pcasunzips': ['plugs/jquery/pcasunzips'],
        // ---------- 开源库 ----------
        'vue': ['plugs/vue/vue.min'],
        'md5': ['plugs/jquery/md5.min'],
        'json': ['plugs/jquery/json.min'],
        'xlsx': ['plugs/jquery/xlsx.min'],
        'jszip': ['plugs/jquery/jszip.min'],
        'marked': ['plugs/jquery/marked.min'],
        'base64': ['plugs/jquery/base64.min'],
        'notify': ['plugs/notify/notify.min'],
        'angular': ['plugs/angular/angular.min'],
        'cropper': ['plugs/cropper/cropper.min'],
        'echarts': ['plugs/echarts/echarts.min'],
        'weditor': ['plugs/editor/create'],
        'ckeditor4': ['plugs/ckeditor4/ckeditor'],
        'ckeditor5': ['plugs/ckeditor5/ckeditor'],
        'artplayer': ['plugs/jquery/artplayer.min'],
        'filesaver': ['plugs/jquery/filesaver.min'],
        'websocket': ['plugs/socket/websocket'],
        'compressor': ['plugs/jquery/compressor.min'],
        'sortablejs': ['plugs/sortable/sortable.min'],
        '_weditor': ['plugs/editor/index'],
        'vue.sortable': ['plugs/sortable/vue.draggable.min'],
        'jquery.ztree': ['plugs/ztree/ztree.all.min'],
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.cropper': ['plugs/cropper/cropper.min'],
        'jquery.autocompleter': ['plugs/jquery/autocompleter.min'],
    }, shim: {
        'jszip': {deps: ['filesaver']},
        'excel': {deps: [baseRoot + 'plugs/layui_exts/excel.js']},
        'notify': {deps: ['css!' + baseRoot + 'plugs/notify/theme.css']},
        'cropper': {deps: ['css!' + baseRoot + 'plugs/cropper/cropper.min.css']},
        '_weditor': {deps: ['css!' + baseRoot + 'plugs/editor/css/style.css']},
        'websocket': {deps: [baseRoot + 'plugs/socket/swfobject.js']},
        'ckeditor5': {deps: ['jquery', 'upload', 'css!' + baseRoot + 'plugs/ckeditor5/ckeditor.css']},
        'vue.sortable': {deps: ['vue', 'sortablejs']},
        'jquery.ztree': {deps: ['jquery', 'css!' + baseRoot + 'plugs/ztree/zTreeStyle/zTreeStyle.css']},
        'jquery.autocompleter': {deps: ['jquery', 'css!' + baseRoot + 'plugs/jquery/autocompleter.css']},
    }
});

/*! 注册 jquery 组件 */
define('jquery', [], function () {
    return layui.$;
});

/*! 注册 ckeditor 组件 */
define('ckeditor', (function (type) {
    if (type === 'wangEditor') return ['weditor'];
    if (/^ckeditor[45]$/.test(type)) return [type];
    return [Object.fromEntries ? 'ckeditor5' : 'ckeditor4'];
})(window.taEditor || 'ckeditor4'), function (ckeditor) {
    return ckeditor;
});

require(['ckeditor'], function () {

})

$(function () {

    window.$body = $('body');

    /*! 基础函数工具 */
    $.base = new function () {
        /*! 注册单次事件 */
        this.onEvent = function (event, select, callable) {
            return $body.off(event, select).on(event, select, callable);
        };

        /*! 注册确认回调 */
        this.onConfirm = function (confirm, callable) {
            return confirm ? $.msg.confirm(confirm, callable) : callable();
        };

        /*! 获取加载回调 */
        this.onConfirm.getLoadCallable = function (tabldId, callable) {
            typeof callable === 'function' && callable();
            return tabldId ? function (ret, time) {
                // 单独处理 javascript: 返回内容处理
                if (typeof ret.data === 'string' && ret.data.indexOf('javascript:') === 0) {
                    $.msg.goto(ret.data)
                }
                if (ret.code < 1) return true;
                time === 'false' ? $.layTable.reload(tabldId) : $.msg.success(ret.info, time, function () {
                    $.layTable.reload(tabldId);
                });
                return false;
            } : false;
        };

        /*! 读取 data-value & data-rule 并应用到 callable */
        this.applyRuleValue = function (elem, data, callabel) {
            // 新 tableId 规则兼容处理
            if (elem.dataset.tableId && elem.dataset.rule) {
                let idx1, idx2, temp, regx, field, rule = {};
                let json = layui.table.checkStatus(elem.dataset.tableId).data;
                layui.each(elem.dataset.rule.split(';'), function (idx, item, attr) {
                    attr = item.split('#', 2), rule[attr[0]] = attr[1];
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
                return $.base.onConfirm(elem.dataset.confirm, function () {
                    return callabel.call(elem, data, elem, elem.dataset || {});
                });
            } else if (elem.dataset.value || elem.dataset.rule) {
                let value = elem.dataset.value || (function (rule, array) {
                    $(elem.dataset.target || 'input[type=checkbox].list-check-box').map(function () {
                        this.checked && array.push(this.value);
                    });
                    return array.length > 0 ? rule.replace('{key}', array.join(',')) : '';
                })(elem.dataset.rule || '', []) || '';
                if (value.length < 1) return $.msg.tips('请选择需要更改的数据！'), false;
                value.split(';').forEach(function (item) {
                    data[item.split('#')[0]] = item.split('#')[1];
                });
                return $.base.onConfirm(elem.dataset.confirm, function () {
                    return callabel.call(elem, data, elem, elem.dataset || {});
                });
            } else {
                return $.base.onConfirm(elem.dataset.confirm, function () {
                    return callabel.call(elem, data, elem, elem.dataset || {});
                });
            }
        }
    };

    /*! 消息组件实例 */
    $.msg = new function () {
        this.idx = [];
        this.mdx = [];
        this.shade = [0.02, '#000000'];
        /*! 关闭元素所在窗口 */
        this.closeThisModal = function (element) {
            layer.close($(element).parents('div.layui-layer-page').attr('times'));
        };
        /*! 关闭顶层最新窗口 */
        this.closeLastModal = function () {
            while ($.msg.mdx.length > 0 && (this.tdx = $.msg.mdx.pop()) > 0) {
                if ($('#layui-layer' + this.tdx).length) return layer.close(this.tdx);
            }
        };
        /*! 关闭消息框 */
        this.close = function (idx) {
            if (idx !== null) return layer.close(idx);
            for (let i in this.idx) $.msg.close(this.idx[i]);
            return (this.idx = []) !== false;
        };
        /*! 弹出警告框 */
        this.alert = function (msg, call) {
            let idx = layer.alert(msg, {end: call, scrollbar: false});
            return $.msg.idx.push(idx), idx;
        };
        /*! 显示成功类型的消息 */
        this.success = function (msg, time, call) {
            let idx = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: call, time: (time || 2) * 1000, shadeClose: true});
            return $.msg.idx.push(idx), idx;
        };
        /*! 显示失败类型的消息 */
        this.error = function (msg, time, call) {
            let idx = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: call, shadeClose: true});
            return $.msg.idx.push(idx), idx;
        };
        /*! 状态消息提示 */
        this.tips = function (msg, time, call) {
            let idx = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: call, shadeClose: true});
            return $.msg.idx.push(idx), idx;
        };
        /*! 显示加载提示 */
        this.loading = function (msg, call) {
            let idx = msg ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: call}) : layer.load(0, {time: 0, scrollbar: false, shade: this.shade, end: call});
            return $.msg.idx.push(idx), idx;
        };
        /*! Notify 调用入口 */
        // https://www.jq22.com/demo/jquerygrowl-notification202104021049
        this.notify = function (title, message, time, option) {
            require(['notify'], function (Notify) {
                Notify.notify(Object.assign({title: title || '', description: message || '', position: 'top-right', closeTimeout: time || 3000, width: '400px'}, option || {}));
            });
        };
        /*! 页面加载层 */
        this.page = new function () {
            this.$body = $('body>.think-page-loader');
            this.$main = $('.think-page-body+.think-page-loader');
            this.stat = function () {
                return this.$body.is(':visible');
            }, this.done = function () {
                return $.msg.page.$body.fadeOut();
            }, this.show = function () {
                this.stat() || this.$main.removeClass('layui-hide').show();
            }, this.hide = function () {
                if (this.time) clearTimeout(this.time);
                this.time = setTimeout(function () {
                    ($.msg.page.time = 0) || $.msg.page.$main.fadeOut();
                }, 200);
            };
        };
        /*! 确认对话框 */
        this.confirm = function (msg, ok, no) {
            return layer.confirm(msg, {title: '操作确认', btn: ['确认', '取消']}, function (idx) {
                (typeof ok === 'function' && ok.call(this, idx)), $.msg.close(idx);
            }, function (idx) {
                (typeof no === 'function' && no.call(this, idx)), $.msg.close(idx);
            });
        };
        /*! 自动处理JSON数据 */
        this.auto = function (ret, time) {
            let url = ret.url || (typeof ret.data === 'string' ? ret.data : '');
            let msg = ret.msg || (typeof ret.info === 'string' ? ret.info : '');
            if (parseInt(ret.code) === 1 && time === 'false') {
                return url ? $.form.goto(url) : $.form.reload();
            } else return (parseInt(ret.code) === 1) ? this.success(msg, time, function () {
                $.msg.closeLastModal(url ? $.form.goto(url) : $.form.reload());
            }) : this.error(msg, 3, function () {
                $.form.goto(url);
            });
        };
    };

    /*! 表单自动化组件 */
    $.form = new function () {
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
            layui.form.render() && layui.element.render() && $(window).trigger('scroll');
            $.vali.listen($dom = $dom || $(this.selecter)) && $body.trigger('reInit', $dom);
            return $dom.find('[required]').map(function () {
                this.$parent = $(this).parent();
                if (this.$parent.is('label')) this.$parent.addClass('label-required-prev'); else this.$parent.prevAll('label.layui-form-label').addClass('label-required-next');
            }), $dom.find('[data-lazy-src]:not([data-lazy-loaded])').map(function () {
                if (this.dataset.lazyLoaded === 'true') return; else this.dataset.lazyLoaded = 'true';
                if (this.nodeName === 'IMG') this.src = this.dataset.lazySrc; else this.style.backgroundImage = 'url(' + this.dataset.lazySrc + ')';
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
            }), $dom;
        };
        /*! 在内容区显示视图 */
        this.show = function (html) {
            $.form.reInit($(this.selecter).html(html));
        };
        /*! 异步加载的数据 */
        this.load = function (url, data, method, callable, loading, tips, time, headers) {
            // 如果主页面 loader 显示中，绝对不显示 loading 图标
            loading = $('.layui-page-loader').is(':visible') ? false : loading;
            let defer = jQuery.Deferred(), loadidx = loading !== false ? $.msg.loading(tips) : 0;
            if (typeof data === 'object' && typeof data['_token_'] === 'string') {
                headers = headers || {}, headers['User-Form-Token'] = data['_token_'], delete data['_token_'];
            }
            $.ajax({
                data: data || {}, type: method || 'GET', url: $.menu.parseUri(url), beforeSend: function (xhr, i) {
                    if (typeof Pace === 'object' && loading !== false) Pace.restart();
                    if (typeof headers === 'object') for (i in headers) xhr.setRequestHeader(i, headers[i]);
                }, error: function (XMLHttpRequest, $dialog, layIdx, iframe) {
                    // 异常消息显示处理
                    if (defer.notify('load.error') && parseInt(XMLHttpRequest.status) !== 200 && XMLHttpRequest.responseText.indexOf('Call Stack') > -1) try {
                        layIdx = layer.open({title: XMLHttpRequest.status + ' - ' + XMLHttpRequest.statusText, type: 2, move: false, content: 'javascript:;'});
                        layer.full(layIdx), $dialog = $('#layui-layer' + layIdx), iframe = $dialog.find('iframe').get(0);
                        (iframe.contentDocument || iframe.contentWindow.document).write(XMLHttpRequest.responseText);
                        iframe.winClose = {width: '30px', height: '30px', lineHeight: '30px', fontSize: '30px', marginLeft: 0};
                        iframe.winTitle = {color: 'red', height: '60px', lineHeight: '60px', fontSize: '20px', textAlign: 'center', fontWeight: 700};
                        $dialog.find('.layui-layer-title').css(iframe.winTitle) && $dialog.find('.layui-layer-setwin').css(iframe.winClose).find('span').css(iframe.winClose);
                        setTimeout(function () {
                            $(iframe).height($dialog.height() - 60);
                        }, 100);
                    } catch (e) {
                        layer.close(layIdx);
                    }
                    layer.closeAll('loading');
                    if (parseInt(XMLHttpRequest.status) !== 200) {
                        $.msg.tips('E' + XMLHttpRequest.status + ' - 服务器繁忙，请稍候再试！');
                    } else {
                        this.success(XMLHttpRequest.responseText);
                    }
                }, success: function (res) {
                    defer.notify('load.success', res) && (time = time || res.wait || undefined);
                    if (typeof callable === 'function' && callable.call($.form, res, time, defer) === false) return false;
                    return typeof res === 'object' ? $.msg.auto(res, time) : $.form.show(res);
                }, complete: function () {
                    defer.notify('load.complete') && $.msg.page.done() && $.msg.close(loadidx);
                }
            });
            return defer;
        };
        /*! 兼容跳转与执行 */
        this.goto = function (url) {
            if (typeof url !== 'string' || url.length < 1) return;
            if (url.toLowerCase().indexOf('javascript:') === 0) {
                return eval($.trim(url.substring(11)));
            } else {
                return location.href = url;
            }
        };
        /*! 以 HASH 打开新网页 */
        this.href = function (url, elem, hash) {
            this.isMenu = !!(elem && elem.dataset.menuNode);
            if (this.isMenu) layui.sessionData('pages', null);
            if (typeof url !== 'string' || url === '#' || url === '') {
                return this.isMenu && $('[data-menu-node^="' + elem.dataset.menuNode + '-"]:first').trigger('click');
            }
            hash = hash || $.menu.parseUri(url, elem);
            this.isRedirect = url.indexOf('#') > -1 && url.split('#', 2)[0] !== location.pathname;
            this.isRedirect ? location.href = url.split('#', 2)[0] + '#' + hash : location.hash = hash;
        };
        /*! 加载 HTML 到 BODY 位置 */
        this.open = function (url, data, call, load, tips) {
            this.load(url, data, 'get', function (ret) {
                return (typeof ret === 'object' ? $.msg.auto(ret) : $.form.show(ret)), false;
            }, load, tips);
        };
        /*! 打开 IFRAME 窗口 */
        this.iframe = function (url, name, area, offset, destroy, success, isfull, maxmin) {
            if (typeof area === 'string' && area.indexOf('[') === 0) area = eval('(' + area + ')');
            this.idx = layer.open({title: name || '窗口', type: 2, area: area || ['800px', '580px'], end: destroy || null, offset: offset, fixed: true, maxmin: maxmin || false, content: url, success: success});
            return isfull && layer.full(this.idx), this.idx;
        };
        /*! 加载 HTML 到弹出层，返回 refer 对象 */
        this.modal = function (url, data, name, call, load, tips, area, offset, isfull, maxmin) {
            return this.load(url, data, 'GET', function (res, time, defer) {
                if (typeof area === 'string' && area.indexOf('[') === 0) area = eval('(' + area + ')');
                return typeof res === 'object' ? $.msg.auto(res) : $.msg.mdx.push(this.idx = layer.open({
                    type: 1, btn: false, area: area || '800px', offset: offset || 'auto', resize: false, content: res, maxmin: maxmin,
                    title: name === 'false' ? '' : name, end: () => defer.notify('modal.close'), success: function ($dom, idx) {
                        defer.notify('modal.success', $dom) && typeof call === 'function' && call.call($.form, $dom);
                        $.form.reInit($dom.off('click', '[data-close]').on('click', '[data-close]', function () {
                            $.base.onConfirm(this.dataset.confirm, () => layer.close(idx));
                        }));
                    }
                })) && isfull && layer.full(this.idx), false;
            }, load, tips);
        };
    };

    /*! 后台菜单辅助插件 */
    $.menu = new function () {
        /*! 计算 URL 地址中有效的 URI */
        this.getUri = function (uri) {
            uri = uri || location.href;
            uri = uri.indexOf(location.host) > -1 ? uri.split(location.host)[1] : uri;
            return (uri.indexOf('#') > -1 ? uri.split('#')[1] : uri).split('?')[0];
        };
        /*! 通过 URI 查询最佳菜单 NODE */
        this.queryNode = function (uri, node) {
            // 如果该节点存在直接返回 Node 值
            if (/^m-/.test(node = node || location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1'))) {
                if ($('[data-menu-node="' + node + '"]').length) return node;
            }
            let path = uri.replace(/\.html$/ig, '');
            // 尝试通过 URI 查询节点值
            let $menu = $('[data-menu-node][data-open*="' + path + '"]');
            if ($menu.length) return $menu.get(0).dataset.menuNode;
            // 尝试通过 URL 查询节点值
            $menu = $('[data-menu-node][data-open~="#' + path + '"]');
            return $menu.length ? $menu.get(0).dataset.menuNode : (/^m-/.test(node || '') ? node : '');
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
            for (let i in vars) attrs.push(i + '=' + vars[i]);
            return uri + (attrs.length > 0 ? '?' + attrs.join('&') : '');
        };
        /*! 后台菜单动作初始化 */
        this.listen = function () {
            let layout = $('.layui-layout-admin'), mini = 'layui-layout-left-mini';
            /*! 菜单切及MiniTips处理 */
            $.base.onEvent('click', '[data-target-menu-type]', function () {
                layui.data('AdminMenuType', {key: 'mini', value: layout.toggleClass(mini).hasClass(mini)});
            }).on('click', '[data-submenu-layout]>a', function () {
                // 关闭已展示的菜单组
                let $this = $(this).parents('[data-submenu-layout]');
                if ($this.hasClass('layui-nav-itemed')) {
                    $this.siblings('[data-submenu-layout].layui-nav-itemed').find('>a').click()
                }
                // 缓存当前菜单状态
                setTimeout("$.menu.sync(1)", 50);
            }).on('mouseenter', '[data-target-tips]', function (evt) {
                if (!layout.hasClass(mini) || !this.dataset.targetTips) return;
                evt.idx = layer.tips(this.dataset.targetTips, this, {time: 0});
                $(this).mouseleave(() => layer.close(evt.idx));
            });
            /*! 监听窗口大小及HASH切换 */
            return $(window).on('resize', function () {
                (layui.data('AdminMenuType')['mini'] || $body.width() < 1000) ? layout.addClass(mini) : layout.removeClass(mini);
            }).trigger('resize').on('hashchange', function () {
                if (/^#(https?:)?(\/\/|\\\\)/.test(location.hash)) return $.msg.tips('禁止访问外部链接！');
                return location.hash.length < 1 ? $body.find('[data-menu-node]:first').trigger('click') : $.menu.href(location.hash);
            }).trigger('hashchange');
        };
        /*! 同步二级菜单展示状态(1同步缓存,2同步展示) */
        this.sync = function (mode) {
            $('[data-submenu-layout]').map(function () {
                let node = this.dataset.submenuLayout;
                if (mode === 1) layui.data('AdminMenuState', {key: node, value: $(this).hasClass('layui-nav-itemed') ? 2 : 1});
                if (mode === 2) (layui.data('AdminMenuState')[node] || 0) === 2 && $(this).hasClass('layui-nav-itemed') ? '' : $(this).click();
            });
        };
        /*! 页面 LOCATION-HASH 跳转 */
        this.href = function (hash, node) {
            if ((hash || '').length < 1) return $('[data-menu-node]:first').trigger('click');
            $.form.load(hash, {}, 'get', false, !$.msg.page.stat()), $.menu.sync(2);
            // 菜单选择切换
            if (/^m-/.test(node = node || $.menu.queryNode($.menu.getUri()))) {
                let arr = node.split('-'), tmp = arr.shift(), all = $('a[data-menu-node]').parent('.layui-this');
                while (arr.length > 0) {
                    tmp = tmp + '-' + arr.shift();
                    all = all.not($('a[data-menu-node="' + tmp + '"]').parent().addClass('layui-this'));
                }
                all.removeClass('layui-this');
                // 菜单模式切换
                if (node.split('-').length > 2) {
                    let tmp = node.split('-'), pnode = tmp.slice(0, 2).join('-'), snode = tmp.slice(0, 3).join('-')
                    $('[data-menu-layout]').not($('[data-menu-layout="' + pnode + '"]').removeClass('layui-hide')).addClass('layui-hide');
                    $('[data-submenu-layout="' + snode + '"]').addClass('layui-nav-itemed');
                    $('.layui-layout-admin').removeClass('layui-layout-left-hide');
                } else {
                    $('.layui-layout-admin').addClass('layui-layout-left-hide');
                }
                setTimeout("$.menu.sync(1);", 50);
            }
        };
    };

    /*! 表单转JSON */
    $.fn.formToJson = function () {
        let self = this, data = {}, push = {};
        let rules = {key: /\w+|(?=\[])/g, push: /^$/, fixed: /^\d+$/, named: /^\w+$/};
        this.build = function (base, key, value) {
            return (base[key] = value), base;
        }, this.pushCounter = function (name) {
            if (push[name] === undefined) push[name] = 0;
            return push[name]++;
        }, $.each($(this).serializeArray(), function () {
            let key, keys = this.name.match(rules.key), merge = this.value, name = this.name;
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

    /*! 全局文件上传 */
    $.fn.uploadFile = function (callable, initialize) {
        return this.each(function (idx, elem) {
            if (elem.dataset.inited) return false; else elem.dataset.inited = 'true';
            elem.dataset.multiple = '|one|btn|'.indexOf(elem.dataset.file || 'one') > -1 ? '0' : '1';
            require(['upload'], function (apply) {
                apply(elem, callable) && setTimeout(function () {
                    typeof initialize === 'function' && initialize.call(elem, elem);
                }, 100);
            });
        });
    };

    /*! 上传单个视频 */
    $.fn.uploadOneVideo = function () {
        return this.each(function () {
            if (this.dataset.inited) return; else this.dataset.inited = 'true';
            let $bt = $('<div class="uploadimage uploadvideo"><span><a data-file class="layui-icon layui-icon-upload-drag"></a><i class="layui-icon layui-icon-search"></i><i class="layui-icon layui-icon-close"></i></span><span data-file></span></div>');
            let $in = $(this).on('change', function () {
                if (this.value) $bt.css('backgroundImage', 'url("")').find('span[data-file]').html('<video width="100%" height="100%" autoplay loop muted><source src="' + encodeURI(this.value) + '" type="video/mp4"></video>');
            }).after($bt).trigger('change');
            $bt.on('click', 'i.layui-icon-search', function (event) {
                event.stopPropagation(), $in.val() && $.form.iframe(encodeURI($in.val()), '视频预览');
            }).on('click', 'i.layui-icon-close', function (event) {
                event.stopPropagation(), $bt.attr('style', '').find('span[data-file]').html('') && $in.val('').trigger('change');
            }).find('[data-file]').data('input', this).attr({
                'data-path': $in.data('path') || '', 'data-size': $in.data('size') || 0, 'data-type': $in.data('type') || 'mp4',
            });
        });
    };

    /*! 上传单张图片 */
    $.fn.uploadOneImage = function () {
        return this.each(function () {
            if (this.dataset.inited) return; else this.dataset.inited = 'true';
            let $bt = $('<div class="uploadimage"><span><a data-file class="layui-icon layui-icon-upload-drag"></a><i class="layui-icon layui-icon-search"></i><i class="layui-icon layui-icon-close"></i></span><span data-file="image"></span></div>');
            let $in = $(this).on('change', function () {
                if (this.value) $bt.css('backgroundImage', 'url(' + encodeURI(this.value) + ')');
            }).after($bt).trigger('change');
            $bt.on('click', 'i.layui-icon-search', function (event) {
                event.stopPropagation(), $in.val() && $.previewImage(encodeURI($in.val()));
            }).on('click', 'i.layui-icon-close', function (event) {
                event.stopPropagation(), $bt.attr('style', '') && $in.val('').trigger('change');
            }).find('[data-file]').data('input', this).attr({
                'data-path': $in.data('path') || '', 'data-size': $in.data('size') || 0, 'data-type': $in.data('type') || 'gif,png,jpg,jpeg',
                'data-max-width': $in.data('max-width') || 0, 'data-max-height': $in.data('max-height') || 0,
                'data-cut-width': $in.data('cut-width') || 0, 'data-cut-height': $in.data('cut-height') || 0,
            });
        });
    };

    /*! 上传多张图片 */
    $.fn.uploadMultipleImage = function () {
        return this.each(function () {
            if (this.dataset.inited) return; else this.dataset.inited = 'true';
            let $bt = $('<div class="uploadimage"><span><a data-file="mul" class="layui-icon layui-icon-upload-drag"></a></span><span data-file="images"></span></div>');
            let ims = this.value ? this.value.split('|') : [], $in = $(this).after($bt);
            $bt.find('[data-file]').attr({
                'data-path': $in.data('path') || '', 'data-size': $in.data('size') || 0, 'data-type': $in.data('type') || 'gif,png,jpg,jpeg',
                'data-max-width': $in.data('max-width') || 0, 'data-max-height': $in.data('max-height') || 0,
                'data-cut-width': $in.data('cut-width') || 0, 'data-cut-height': $in.data('cut-height') || 0,
            }).on('push', function (evt, src) {
                ims.push(src), $in.val(ims.join('|')).trigger('change'), showImageContainer([src]);
            }) && (ims.length > 0 && showImageContainer(ims));

            function showImageContainer(srcs) {
                $(srcs).each(function (idx, src, $img) {
                    $img = $('<div class="uploadimage uploadimagemtl"><div><a class="layui-icon">&#xe603;</a><a class="layui-icon">&#x1006;</a><a class="layui-icon">&#xe602;</a></div></div>');
                    $img.attr('data-tips-image', encodeURI(src)).css('backgroundImage', 'url(' + encodeURI(src) + ')').on('click', 'a', function (event, index, prevs, $item) {
                        event.stopPropagation(), $item = $(this).parent().parent(), index = $(this).index();
                        if (index === 2 && $item.index() !== $bt.prevAll('div.uploadimage').length) $item.next().after($item);
                        else if (index === 0 && $item.index() > 1) $item.prev().before($item); else if (index === 1) $item.remove();
                        ims = [], $bt.prevAll('.uploadimage').map(function () {
                            ims.push($(this).attr('data-tips-image'));
                        });
                        ims.reverse(), $in.val(ims.join('|')).trigger('change');
                    }), $bt.before($img);
                });
            }
        });
    };

    /*! 标签输入插件 */
    $.fn.initTagInput = function () {
        return this.each(function () {
            let $this = $(this), tags = this.value ? this.value.split(',') : [];
            let $text = $('<textarea class="layui-input layui-input-inline layui-tag-input"></textarea>');
            let $tags = $('<div class="layui-tags"></div>').append($text);
            $this.parent().append($tags) && $text.off('keydown blur') && (tags.length > 0 && showTags(tags));
            $text.on('blur keydown', function (event, value) {
                if (event.keyCode === 13 || event.type === 'blur') {
                    event.preventDefault(), (value = $text.val().replace(/^\s*|\s*$/g, ''));
                    if (tags.indexOf($(this).val()) > -1) return $.msg.notify('温馨提示', '该标签已经存在！', 3000, {type: 'error', width: 280});
                    else if (value.length > 0) tags.push(value), $this.val(tags.join(',')), showTags([value]), this.focus(), $text.val('');
                }
            });

            function showTags(tagsArr) {
                $(tagsArr).each(function (idx, text) {
                    $('<div class="layui-tag"></div>').data('value', text).on('click', 'i', function () {
                        tags.splice(tags.indexOf($(this).parent().data('value')), 1);
                        $this.val(tags.join(',')) && $(this).parent().remove();
                    }).insertBefore($text).html(text + '<i class="layui-icon">&#x1006;</i>');
                });
            }
        });
    };

    /*! 文本框插入内容 */
    $.fn.insertAtCursor = function (value) {
        return this.each(function () {
            this.focus();
            if (document.selection) {
                let selection = document.selection.createRange();
                (selection.text = value), selection.select(), selection.unselect();
            } else if (this.selectionStart || this.selectionStart === 0) {
                let spos = this.selectionStart, apos = this.selectionEnd || spos;
                this.value = this.value.substring(0, spos) + value + this.value.substring(apos);
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
        this.showImage = function (image, circle, size, title) {
            if (typeof image !== 'string' || image.length < 5) {
                return '<span class="color-desc">-</span>' + (title ? laytpl('<span class="margin-left-5">{{d.title}}</span>').render({title: title}) : '');
            }
            return laytpl('<div class="headimg {{d.class}} headimg-{{d.size}}" data-tips-image data-tips-hover data-lazy-src="{{d.image}}" style="{{d.style}}"></div>').render({
                size: size || 'ss', class: circle ? 'shadow-inset' : 'headimg-no', image: image, style: 'background-image:url(' + image + ');margin-right:0'
            }) + (title ? laytpl('<span class="margin-left-5">{{d.title}}</span>').render({title: title}) : '');
        }, this.render = function (tabldId) {
            return this.reload(tabldId, true);
        }, this.reload = function (tabldId, force) {
            return typeof tabldId === 'string' ? tabldId.split(',').map(function (tableid) {
                $('#' + tableid).trigger(force ? 'render' : 'reload')
            }) : $.form.reload();
        }, this.create = function (table, params) {
            // 动态初始化表格
            table.id = table.id || 't' + Math.random().toString().replace('.', '');
            let $table = $(table).attr('lay-filter', table.dataset.id = table.getAttribute('lay-filter') || table.id);
            // 插件初始化参数
            let option = params || {}, data = option.where || {}, sort = option.initSort || option.sort || {};
            option.id = table.id, option.elem = table, option.url = params.url || table.dataset.url || location.href;
            option.limit = params.limit || 20, option.loading = params.loading !== false, option.autoSort = params.autoSort === true;
            option.page = params.page !== false ? (params.page || true) : false, option.cols = params.cols || [[]], option.success = params.done || '';
            option.cellExpandedMode = option.cellExpandedMode || 'tips';

            // 默认动态设置页数, 动态设置最大高度
            if (option.page === true) option.page = {curr: layui.sessionData('pages')[option.id] || 1};
            if (option.width === 'full') option.width = $table.parent().width();
            if (option.height === 'full') if ($table.parents('.iframe-pagination').length) {
                $table.parents('.iframe-pagination').addClass('not-footer');
                option.height = $(window).height() - $table.removeClass('layui-hide').offset().top - 20;
            } else if ($table.parents('.laytable-pagination').length) {
                option.height = $table.parents('.laytable-pagination').height() - $table.removeClass('layui-hide').position().top - 20;
            } else {
                option.height = $(window).height() - $table.removeClass('layui-hide').offset().top - 35;
            }

            // 初始化不显示头部
            let cls = ['.layui-table-header', '.layui-table-fixed', '.layui-table-body', '.layui-table-page'];
            option.css = (typeof option.height === 'number' ? '{height:' + option.height + 'px}' : '') + (option.css || '') + cls.concat(['']).join('{opacity:0}');

            // 动态计算最大页数
            option.done = function (res, curr, count) {
                layui.sessionData('pages', {key: table.id, value: this.page.curr || 1});
                typeof option.success === 'function' && option.success.call(this, res, curr, count);
                $.form.reInit($table.next()).find('[data-open],[data-load][data-time!="false"],[data-action][data-time!="false"],[data-queue],[data-iframe]').not('[data-table-id]').attr('data-table-id', table.id);
                (option.loading = this.loading = true) && $table.data('next', this).next().find(cls.join(',')).animate({opacity: 1});
                setTimeout(() => layui.table.resize(table.id), 10);
            }, option.parseData = function (res) {
                if (res.code === 0 && res.url) {
                    return $.msg.auto(res);
                }
                if (typeof params.filter === 'function') {
                    res.data = params.filter(res.data, res);
                }
                if (!this.page || !this.page.curr) return res;
                let curp = this.page.curr, maxp = Math.ceil(res.count / (this.page.limit || option.limit));
                if (curp > maxp && maxp > 1) $table.trigger('reload', {page: {curr: maxp}});
                return res;
            };
            // 关联搜索表单
            let sform, search = params.search || table.dataset.targetSearch || 'form[data-table-id="' + table.id + '"] [data-form-export]';
            if (search) (sform = $body.find(search)).map(function () {
                $(this).attr('data-table-id', table.id);
            });
            // 关联绑定选择项
            let checked = params.checked || table.dataset.targetChecked;
            if (checked) $body.find(checked).map(function () {
                $(this).attr('data-table-id', table.id);
            });
            // 实例并绑定事件
            $table.data('this', layui.table.render(bindData(option)));
            $table.bind('reload render reloadData', function (evt, opts) {
                if (option.page === false) (opts || {}).page = false;
                data = $.extend({}, data, (opts || {}).where || {});
                opts = bindData($.extend({}, opts || {}, {loading: true}));
                table.id.split(',').map(function (tableid) {
                    if (evt.type.indexOf('reload') > -1) {
                        layui.table.reloadData(tableid, opts);
                    } else {
                        layui.table.render(tableid, opts);
                    }
                })
            }).bind('row sort tool edit radio toolbar checkbox rowDouble', function (evt, call) {
                table.id.split(',').map(function (tableid) {
                    layui.table.on(evt.type + '(' + tableid + ')', call)
                })
            }).bind('setFullHeight', function () {
                $table.trigger('render', {height: $(window).height() - $table.next().offset().top - 35})
            }).trigger('sort', function (rets) {
                (sort = rets), $table.trigger('reload')
            }).trigger('rowDouble', function (event) {
                $(event.tr[0]).find('[data-event-dbclick]').map(function () {
                    $(this).trigger(this.dataset.eventDbclick || 'click', event);
                });
            });
            return $table;

            // 生成初始化参数
            function bindData(options) {
                data['output'] = 'layui.table';
                if (sort.field && sort.type) {
                    data['_order_'] = sort.type, data['_field_'] = sort.field;
                    options.initSort = {type: sort.type.split(',')[0].split(' ')[0], field: sort.field.split(',')[0].split(' ')[0]};
                    if (sform) $(sform).find('[data-form-export]').attr({'data-sort-type': sort.type, 'data-sort-field': sort.field});
                }
                if (options.page === false) options.limit = '';
                return (options['where'] = data), options;
            }
        };
    };

    /*！格式化文件大小 */
    $.formatFileSize = function (size, fixed, units) {
        let unit;
        units = units || ['B', 'K', 'M', 'G', 'TB'];
        while ((unit = units.shift()) && size > 1024) size = size / 1024;
        return (unit === 'B' ? size : size.toFixed(fixed === undefined ? 2 : fixed)) + unit;
    }

    /*! 弹出图片层 */
    $.previewImage = function (src, area) {
        let img = new Image(), defer = $.Deferred(), loaded = $.msg.loading();
        img.style.background = '#FFF', img.referrerPolicy = 'no-referrer';
        img.style.height = 'auto', img.style.width = area || '100%', img.style.display = 'none';
        return document.body.appendChild(img), img.onerror = function () {
            $.msg.close(loaded) && defer.reject();
        }, img.src = src, img.onload = function () {
            layer.open({
                type: 1, title: false, shadeClose: true, content: $(img), success: function ($elem, idx) {
                    $.msg.close(loaded) && defer.notify($elem, idx);
                }, area: area || '480px', skin: 'layui-layer-nobg', closeBtn: 1, end: function () {
                    document.body.removeChild(img) && defer.resolve()
                }
            });
        }, defer.promise();
    };

    /*! 以手机模式显示内容 */
    $.previewPhonePage = function (href, title) {
        let template = '<div class="mobile-preview"><div class="mobile-header">{{d.title}}</div><div class="mobile-body"><iframe src="{{d.url}}"></iframe></div></div>';
        layer.style(layer.open({type: true, resize: false, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: true, shadeClose: false, skin: 'layui-layer-nobg', content: laytpl(template).render({title: title || '公众号', url: href})}), {boxShadow: 'none'});
    };

    /*! 显示任务进度 */
    $.loadQueue = function (code, doScript, element) {
        require(['queue'], function (Queue) {
            return new Queue(code, doScript, element);
        });
    };

    /*! 注册JqFn函数 */
    $.fn.vali = function (done, init) {
        return this.each(function () {
            $.vali(this, done, init);
        });
    };

    /*! 创建表单验证 */
    $.vali = function (form, done, init) {
        require(['validate'], function (Validate) {
            /** @type {import("./plugs/admin/validate")|Validate}*/
            let vali = $(form).data('validate') || new Validate(form);
            typeof init === 'function' && init.call(vali, $(form).formToJson(), vali);
            typeof done === 'function' && vali.addDoneEvent(done);
        });
    };

    /*! 自动监听表单 */
    $.vali.listen = function ($dom) {
        let $els = $($dom || $body).find('form[data-auto]');
        $dom && $($dom).filter('form[data-auto]') && $els.add($dom);
        return $els.map(function (idx, form) {
            $(this).vali(function (data) {
                let type = form.getAttribute('method') || 'POST', href = form.getAttribute('action') || location.href;
                let dset = form.dataset, tips = dset.tips || undefined, time = dset.time || undefined, taid = dset.tableId || false;
                let call = window[dset.callable || '_default_callable'] || (taid ? function (ret) {
                    if (typeof ret === 'object' && ret.code > 0 && $('#' + taid).length > 0) {
                        return $.msg.success(ret.info, 3, function () {
                            $.msg.closeLastModal();
                            (typeof ret.data === 'string' && ret.data) ? $.form.goto(ret.data) : $.layTable.reload(taid);
                        }) && false;
                    }
                } : undefined);
                $.base.onConfirm(dset.confirm, function () {
                    $.form.load(href, data, type, call, true, tips, time);
                });
            });
        });
    };

    /*! 注册 data-search 表单搜索行为 */
    $.base.onEvent('submit', 'form.form-search', function () {
        if (this.dataset.tableId) {
            let data = $(this).formToJson();
            return this.dataset.tableId.split(',').map(function (tableid) {
                $('table#' + tableid).trigger('reload', {page: {curr: 1}, where: data});
            });
        }
        let url = $(this).attr('action').replace(/&?page=\d+/g, '');
        if ((this.method || 'get').toLowerCase() === 'get') {
            let split = url.indexOf('?') > -1 ? '&' : '?', stype = location.href.indexOf('spm=') > -1 ? '#' : '';
            $.form.goto(stype + $.menu.parseUri(url + split + $(this).serialize().replace(/\+/g, ' ')));
        } else {
            $.form.load(url, this, 'post');
        }
    });

    /*! 注册 data-file 事件行为 */
    $.base.onEvent('click', '[data-file]', function () {
        this.id = this.dataset.id = this.id || (function (date) {
            return (date + Math.random()).replace('0.', '');
        })(layui.util.toDateString(Date.now(), 'yyyyMMddHHmmss-'));
        /*! 查找表单元素, 如果没有找到将不会自动写值 */
        if (!(this.$elem = $(this)).data('input') && this.$elem.data('field')) {
            let $input = $('input[name="' + this.$elem.data('field') + '"]:not([type=file])');
            this.$elem.data('input', $input.length > 0 ? $input.get(0) : null);
        }
        // 单图或多图选择器 ( image|images )
        if (typeof this.dataset.file === 'string' && /^images?$/.test(this.dataset.file)) {
            return $.form.modal(tapiRoot + '/api.upload/image', this.dataset, '图片选择器')
        }
        // 其他文件上传处理
        this.dataset.inited || $(this).uploadFile(undefined, function () {
            $(this).trigger('upload.start');
        });
    });

    /*! 注册 data-load 事件行为 */
    $.base.onEvent('click', '[data-load]', function () {
        $.base.applyRuleValue(this, {}, function (data, elem, dset) {
            $.form.load(dset.load, data, 'get', $.base.onConfirm.getLoadCallable(dset.tableId), true, dset.tips, dset.time);
        });
    });

    /*! 注册 data-reload 事件行为 */
    $.base.onEvent('click', '[data-reload]', function () {
        $.layTable.reload(this.dataset.tableId || true);
    });

    /*! 注册 data-dbclick 事件行为 */
    $.base.onEvent('dblclick', '[data-dbclick]', function () {
        $(this).find(this.dataset.dbclick || '[data-dbclick]').trigger('click');
    });

    /*! 注册 data-check 事件行为 */
    $.base.onEvent('click', '[data-check-target]', function () {
        let target = this;
        $(this.dataset.checkTarget).map(function () {
            (this.checked = !!target.checked), $(this).trigger('change');
        });
    });

    /*! 表单元素失去焦点时数字 */
    $.base.onEvent('blur', '[data-blur-number]', function () {
        let set = this.dataset, value = parseFloat(this.value) || 0;
        let min = $.isNumeric(set.valueMin) ? set.valueMin : this.min;
        let max = $.isNumeric(set.valueMax) ? set.valueMax : this.max;
        if ($.isNumeric(min) && value < min) value = parseFloat(min) || 0;
        if ($.isNumeric(max) && value > max) value = parseFloat(max) || 0;
        this.value = value.toFixed(parseInt(set.blurNumber) || 0);
    });

    /*! 表单元素失焦时提交 */
    $.base.onEvent('blur', '[data-action-blur],[data-blur-action]', function () {
        let that = $(this), dset = this.dataset, data = {'_token_': dset.token || dset.csrf || '--'};
        let attrs = (dset.value || '').replace('{value}', that.val()).split(';');
        for (let i in attrs) data[attrs[i].split('#')[0]] = attrs[i].split('#')[1];
        $.base.onConfirm(dset.confirm, function () {
            $.form.load(dset.actionBlur || dset.blurAction, data, dset.method || 'post', function (ret) {
                return that.css('border', (ret && ret.code) ? '1px solid #e6e6e6' : '1px solid red') && false;
            }, dset.loading !== 'false', dset.loading, dset.time);
        });
    });

    /*! 注册 data-href 事件行为 */
    $.base.onEvent('click', '[data-href]', function () {
        if (this.dataset.href && this.dataset.href.indexOf('#') !== 0) {
            $.form.goto(this.dataset.href);
        }
    });

    /*! 注册 data-open 事件行为 */
    $.base.onEvent('click', '[data-open]', function () {
        // 仅记录当前表格分页
        let page = 0, tbid = this.dataset.tableId || null;
        if (tbid) page = layui.sessionData('pages')[tbid] || 0;
        layui.sessionData('pages', null);
        if (page > 0) layui.sessionData('pages', {key: tbid, value: page})
        // 根据链接类型跳转页面
        if (this.dataset.open.match(/^https?:/)) {
            $.form.goto(this.dataset.open);
        } else {
            $.form.href(this.dataset.open, this);
        }
    });

    /*! 注册 data-action 事件行为 */
    $.base.onEvent('click', '[data-action]', function () {
        $.base.applyRuleValue(this, {}, function (data, elem, dset) {
            Object.assign(data, {'_token_': dset.token || dset.csrf || '--'})
            let load = dset.loading !== 'false', tips = typeof load === 'string' ? load : undefined;
            $.form.load(dset.action, data, dset.method || 'post', $.base.onConfirm.getLoadCallable(dset.tableId), load, tips, dset.time)
        });
    });

    /*! 注册 data-modal 事件行为 */
    $.base.onEvent('click', '[data-modal]', function () {
        $.base.applyRuleValue(this, {open_type: 'modal'}, function (data, elem, dset) {
            let defer = $.form.modal(dset.modal, data, dset.title || this.innerText || '编辑', undefined, undefined, undefined, dset.area || dset.width || '800px', dset.offset || 'auto', dset.full !== undefined, dset.maxmin || false);
            defer.progress((type) => type === 'modal.close' && dset.closeRefresh && $.layTable.reload(dset.closeRefresh));
        });
    });

    /*! 注册 data-iframe 事件行为 */
    $.base.onEvent('click', '[data-iframe]', function () {
        $.base.applyRuleValue(this, {open_type: 'iframe'}, function (data, elem, dset) {
            let name = dset.title || this.innerText || 'IFRAME 窗口';
            let area = dset.area || [dset.width || '800px', dset.height || '580px'];
            let frame = dset.iframe + (dset.iframe.indexOf('?') > -1 ? '&' : '?') + $.param(data);
            $(this).attr('data-index', $.form.iframe(frame + '&' + $.param(data), name, area, dset.offset || 'auto', function () {
                typeof dset.refresh !== 'undefined' && $.layTable.reload(dset.tableId || true);
            }, undefined, dset.full !== undefined, dset.maxmin || false));
        })
    });

    /*! 注册 data-video-player 事件行为 */
    $.base.onEvent('click', '[data-video-player]', function () {
        let idx = $.msg.loading(), url = this.dataset.videoPlayer, name = this.dataset.title || '媒体播放器', payer;
        require(['artplayer'], () => layer.open({
            title: name, type: 1, fixed: true, maxmin: false,
            content: '<div class="data-play-video" style="width:800px;height:450px"></div>',
            end: () => payer.destroy(), success: $ele => payer = new Artplayer({
                url: url, container: $ele.selector + ' .data-play-video', controls: [
                    {html: '全屏播放', position: 'right', click: () => payer.fullscreen = !payer.fullscreen},
                ]
            }, art => art.play(), $.msg.close(idx))
        }));
    });

    /*! 注册 data-icon 事件行为 */
    $.base.onEvent('click', '[data-icon]', function () {
        let location = tapiRoot + '/api.plugs/icon', field = this.dataset.icon || this.dataset.field || 'icon';
        $.form.iframe(location + (location.indexOf('?') > -1 ? '&' : '?') + 'field=' + field, '图标选择', ['900px', '700px']);
    });

    /*! 注册 data-copy 事件行为 */
    $.base.onEvent('click', '[data-copy]', function () {
        layui.lay.clipboard.writeText({
            text: this.dataset.copy || this.innerText,
            done: () => $.msg.tips('已复制到剪贴板！'),
            error: () => $.msg.tips('请使用鼠标复制！')
        })
    });

    /*! 异步任务状态监听与展示 */
    $.base.onEvent('click', '[data-queue]', function () {
        $.base.applyRuleValue(this, {}, function (data, elem, dset) {
            $.form.load(dset.queue, data, 'post', function (ret) {
                if (typeof ret.data === 'string' && ret.data.indexOf('Q') === 0) {
                    return $.loadQueue(ret.data, true, elem), false;
                }
            });
        });
    });

    /*! 注册 data-tips-text 事件行为 */
    $.base.onEvent('mouseenter', '[data-tips-text]', function () {
        // 获取自定义颜色（优先取 data-tips-color，否则用默认色）
        const color = $(this).attr('data-tips-color') || '#78BA32';
        let opts = {tips: [$(this).attr('data-tips-type') || 3, color], time: 0};
        let layidx = layer.tips($(this).attr('data-tips-text') || this.innerText, this, opts);
        $(this).off('mouseleave').on('mouseleave', function () {
            setTimeout("layer.close('" + layidx + "')", 100);
        });
    });

    /*! 注册 data-tips-hover 事件行为 */
    $.base.onEvent('mouseenter', '[data-tips-image][data-tips-hover],[data-tips-image-hover]', function () {
        let $el = $(this), img = new Image();
        if ((img.src = this.dataset.tipsImage || this.dataset.lazySrc || this.src || this.value)) {
            img.layopt = {anim: 5, tips: 3, time: 0, skin: 'layui-layer-image', isOutAnim: false, scrollbar: false};
            img.referrerPolicy = 'no-referrer', img.style.maxWidth = '260px', img.style.maxHeight = '260px';
            $el.data('layidx', layer.tips(img.outerHTML, this, img.layopt)).off('mouseleave').on('mouseleave', function () {
                $el.off('mousemove') && layer.close($el.data('layidx'));
            });
            let $lay = $('#layui-layer' + $el.data('layidx'));
            $el.on('mousemove', e => $lay.css({top: e.pageY + 20, left: e.pageX - 20}));
        }
    });

    /*! 注册 data-tips-image 事件行为 */
    $.base.onEvent('click', '[data-tips-image]', function (event) {
        (event.items = [], event.$imgs = $(this).parent().find('[data-tips-image]')).map(function () {
            (src => src && event.items.push({src: src}))(this.dataset.tipsImage || this.dataset.lazySrc || this.src || this.value);
        }) && event.items.length > 0 && layer.photos({
            anim: 5, closeBtn: 1, photos: {start: event.$imgs.index(this), data: event.items}, tab: function (pic, $ele) {
                $ele.find('img').attr('referrerpolicy', 'no-referrer');
                $ele.find('.layui-layer-close').css({top: '20px', right: '20px', position: 'fixed'});
            }
        });
    });

    /*! 注册 data-phone-view 事件行为 */
    $.base.onEvent('click', '[data-phone-view]', function () {
        $.previewPhonePage(this.dataset.phoneView || this.href);
    });

    /*! 注册 data-target-submit 事件行为 */
    $.base.onEvent('click', '[data-target-submit]', function () {
        $(this.dataset.targetSubmit || 'form:last').submit();
    });

    /*! 表单编辑返回操作 */
    $.base.onEvent('click', '[data-target-backup],[data-history-back]', function () {
        $.base.onConfirm(this.dataset.historyBack || this.dataset.targetBackup || '确定要返回上个页面吗？', function () {
            history.back();
        });
    });

    /*! 图片加载异常处理 */
    document.addEventListener('error', function (event) {
        if (event.target.nodeName !== 'IMG') return;
        event.target.src = baseRoot + 'theme/img/404_icon.png';
    }, true);

    /*! 初始化系统菜单及表单验证 */
    $.menu.listen() && $.form.reInit($body);
});