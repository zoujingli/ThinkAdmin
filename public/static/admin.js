// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站:http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

// IE兼容提示
(function (w) {
    if (!("WebSocket" in w && 2 === w.WebSocket.CLOSING)) {
        document.body.innerHTML = '<div class="version-debug">您使用的浏览器已经<strong>过时</strong>，建议使用最新版本的谷歌浏览器。<a target="_blank" href="https://pc.qq.com/detail/1/detail_2661.html" class="layui-btn layui-btn-primary">立即下载</a></div>';
    }
}(window));

// Layui及jQuery兼容处理
if (typeof jQuery === 'undefined') window.$ = window.jQuery = layui.$;
window.form = layui.form, window.layer = layui.layer, window.laydate = layui.laydate;

// 当前资源URL目录
window.baseRoot = (function () {
    var src = document.scripts[document.scripts.length - 1].src;
    return src.substring(0, src.lastIndexOf("/") + 1);
})();

// require 配置参数
require.config({
    waitSeconds: 60,
    baseUrl: baseRoot,
    map: {'*': {css: baseRoot + 'plugs/require/css.js'}},
    paths: {
        'md5': ['plugs/jquery/md5.min'],
        'spop': ['plugs/spop/spop.min'],
        'json': ['plugs/jquery/json.min'],
        'upload': ['plugs/plupload/build'],
        'base64': ['plugs/jquery/base64.min'],
        'angular': ['plugs/angular/angular.min'],
        'ckeditor': ['plugs/ckeditor/ckeditor'],
        'plupload': ['plugs/plupload/plupload.full.min'],
        'websocket': ['plugs/socket/websocket'],
        'pcasunzips': ['plugs/jquery/pcasunzips'],
        'jquery.ztree': ['plugs/ztree/ztree.all.min'],
        'jquery.masonry': ['plugs/jquery/masonry.min'],
        'jquery.autocompleter': ['plugs/jquery/autocompleter.min'],
    },
    shim: {
        'spop': {deps: ['css!' + baseRoot + 'plugs/spop/spop.min.css']},
        'websocket': {deps: [baseRoot + 'plugs/socket/swfobject.min.js']},
        'jquery.ztree': {deps: ['jquery', 'css!' + baseRoot + 'plugs/ztree/zTreeStyle/zTreeStyle.css']},
        'jquery.autocompleter': {deps: ['jquery', 'css!' + baseRoot + 'plugs/jquery/autocompleter.css']},
    }
});

// 注册jquery到require模块
define('jquery', [], function () {
    return layui.$;
});

$(function () {
    window.$body = $('body');
    /*! 消息组件实例 */
    $.msg = new function () {
        var that = this;
        this.indexs = [];
        this.shade = [0.02, '#000'];
        // 关闭消息框
        this.close = function (index) {
            return layer.close(index);
        };
        // 弹出警告框
        this.alert = function (msg, callback) {
            var index = layer.alert(msg, {end: callback, scrollbar: false});
            return this.indexs.push(index), index;
        };
        // 确认对话框
        this.confirm = function (msg, ok, no) {
            var index = layer.confirm(msg, {title: '操作确认', btn: ['确认', '取消']}, function () {
                typeof ok === 'function' && ok.call(this, index);
            }, function () {
                typeof no === 'function' && no.call(this, index);
                that.close(index);
            });
            return index;
        };
        // 显示成功类型的消息
        this.success = function (msg, time, callback) {
            var index = layer.msg(msg, {icon: 1, shade: this.shade, scrollbar: false, end: callback, time: (time || 2) * 1000, shadeClose: true});
            return this.indexs.push(index), index;
        };
        // 显示失败类型的消息
        this.error = function (msg, time, callback) {
            var index = layer.msg(msg, {icon: 2, shade: this.shade, scrollbar: false, time: (time || 3) * 1000, end: callback, shadeClose: true});
            return this.indexs.push(index), index;
        };
        // 状态消息提示
        this.tips = function (msg, time, callback) {
            var index = layer.msg(msg, {time: (time || 3) * 1000, shade: this.shade, end: callback, shadeClose: true});
            return this.indexs.push(index), index;
        };
        // 显示正在加载中的提示
        this.loading = function (msg, callback) {
            var index = msg ? layer.msg(msg, {icon: 16, scrollbar: false, shade: this.shade, time: 0, end: callback}) : layer.load(2, {time: 0, scrollbar: false, shade: this.shade, end: callback});
            return this.indexs.push(index), index;
        };
        // 自动处理显示Think返回的Json数据
        this.auto = function (ret, time) {
            var url = ret.url || (typeof ret.data === 'string' ? ret.data : '');
            var msg = ret.msg || (typeof ret.info === 'string' ? ret.info : '');
            if (parseInt(ret.code) === 1 && time === 'false') {
                return url ? (window.location.href = url) : $.form.reload();
            }
            return (parseInt(ret.code) === 1) ? this.success(msg, time, function () {
                url ? (window.location.href = url) : $.form.reload();
                for (var i in that.indexs) layer.close(that.indexs[i]);
                that.indexs = [];
            }) : this.error(msg, 3, function () {
                url ? window.location.href = url : '';
            });
        };
    };

    /*! 表单自动化组件 */
    $.form = new function () {
        var that = this;
        // 内容区选择器
        this.targetClass = '.layui-layout-admin>.layui-body';
        // 刷新当前页面
        this.reload = function () {
            window.onhashchange.call(this);
        };
        // 内容区域动态加载后初始化
        this.reInit = function ($dom) {
            $.vali.listen(this);
            $dom = $dom || $(this.targetClass);
            $dom.find('[required]').parent().prevAll('label').addClass('label-required');
            $dom.find('[data-date-range]').map(function () {
                laydate.render({range: true, elem: this});
                this.setAttribute('autocomplete', 'off');
            });
            $dom.find('[data-file]:not([data-inited])').map(function (index, elem, $this, field) {
                $this = $(elem), field = $this.attr('data-field') || 'file';
                if (!$this.data('input')) $this.data('input', $('[name="' + field + '"]').get(0));
                $this.uploadFile(function (url) {
                    $($this.data('input')).val(url).trigger('change');
                });
            });
        };
        // 在内容区显示视图
        this.show = function (html) {
            $(this.targetClass).html(html);
            this.reInit(), setTimeout(this.reInit, 500), setTimeout(this.reInit, 1000);
        };
        // 以hash打开网页
        this.href = function (url, obj) {
            if (url !== '#') window.location.href = '#' + $.menu.parseUri(url, obj);
            else if (obj && obj.getAttribute('data-menu-node')) {
                var node = obj.getAttribute('data-menu-node');
                $('[data-menu-node^="' + node + '-"][data-open!="#"]:first').trigger('click');
            }
        };
        // 异步加载的数据
        this.load = function (url, data, method, callback, loading, tips, time, headers) {
            var index = loading !== false ? $.msg.loading(tips) : 0;
            if (typeof data === 'object' && typeof data['_csrf_'] === 'string') {
                headers = headers || {};
                headers['User-Token-Csrf'] = data['_csrf_'];
                delete data['_csrf_'];
            }
            $.ajax({
                data: data || {}, type: method || 'GET', url: $.menu.parseUri(url), beforeSend: function (xhr) {
                    if (typeof Pace === 'object') Pace.restart();
                    if (typeof headers === 'object') for (var i in headers) xhr.setRequestHeader(i, headers[i]);
                }, error: function (XMLHttpRequest) {
                    if (parseInt(XMLHttpRequest.status) === 200) this.success(XMLHttpRequest.responseText);
                    else $.msg.tips('E' + XMLHttpRequest.status + ' - 服务器繁忙，请稍候再试！');
                }, success: function (ret) {
                    if (typeof callback === 'function' && callback.call(that, ret) === false) return false;
                    return typeof ret === 'object' ? $.msg.auto(ret, time || ret.wait || undefined) : that.show(ret);
                }, complete: function () {
                    $.msg.close(index);
                }
            });
        };
        // 加载HTML到目标位置
        this.open = function (url, data, callback, loading, tips) {
            this.load(url, data, 'get', function (ret) {
                return typeof ret === 'object' ? $.msg.auto(ret) : that.show(ret);
            }, loading, tips);
        };
        // 打开一个iframe窗口
        this.iframe = function (url, title, area) {
            return layer.open({title: title || '窗口', type: 2, area: area || ['800px', '550px'], fix: true, maxmin: false, content: url});
        };
        // 加载HTML到弹出层
        this.modal = function (url, data, title, callback, loading, tips) {
            this.load(url, data, 'GET', function (res) {
                if (typeof (res) === 'object') return $.msg.auto(res);
                var index = layer.open({
                    type: 1, btn: false, area: "800px", content: res, title: title || '', success: function (dom, index) {
                        $(dom).find('[data-close]').off('click').on('click', function () {
                            if ($(this).attr('data-confirm')) return $.msg.confirm($(this).attr('data-confirm'), function (_index) {
                                layer.close(_index), layer.close(index);
                            }), false;
                            layer.close(index);
                        });
                        $.form.reInit($(dom));
                    }
                });
                $.msg.indexs.push(index);
                return (typeof callback === 'function') && callback.call(this);
            }, loading, tips);
        };
    };

    /*! 后台菜单辅助插件 */
    $.menu = new function () {
        var self = this;
        // 计算URL地址中有效的URI
        this.getUri = function (uri) {
            uri = uri || window.location.href;
            uri = (uri.indexOf(window.location.host) > -1 ? uri.split(window.location.host)[1] : uri);
            return (uri.indexOf('#') > -1 ? uri.split('#')[1] : uri).split('?')[0];
        };
        // 通过URI查询最有可能的菜单NODE
        this.queryNode = function (url) {
            var node = location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1');
            if (!/^m-/.test(node)) {
                var $menu = $('[data-menu-node][data-open*="' + url.replace(/\.html$/ig, '') + '"]');
                return $menu.size() ? $menu.get(0).getAttribute('data-menu-node') : '';
            }
            return node;
        };
        // URL转URI
        this.parseUri = function (uri, obj) {
            var params = {};
            if (uri.indexOf('?') > -1) {
                var attrs = uri.split('?')[1].split('&');
                for (var i in attrs) if (attrs[i].indexOf('=') > -1) {
                    var tmp = attrs[i].split('=').slice();
                    params[tmp[0]] = decodeURI(tmp[1].replace(/%2B/ig, '%20'));
                }
            }
            delete params[""];
            uri = this.getUri(uri);
            params.spm = obj && obj.getAttribute('data-menu-node') || this.queryNode(uri);
            if (params.spm === '' || typeof params.spm !== 'string') delete params.spm;
            var query = '?' + $.param(params);
            return uri + (query === '?' ? '' : query);
        };
        // 后台菜单动作初始化
        this.listen = function () {
            // 菜单模式切换
            (function ($menu, miniClass) {
                // Mini 菜单模式切换及显示
                if (layui.data('menu')['type-min']) $menu.addClass(miniClass);
                $body.on('click', '[data-target-menu-type]', function () {
                    $menu.toggleClass(miniClass);
                    layui.data('menu', {key: 'type-min', value: $menu.hasClass(miniClass)});
                }).on('resize', function () {
                    var isMini = $('.layui-layout-left-mini').size() > 0;
                    $body.width() > 1000 ? isMini && $menu.toggleClass(miniClass) : isMini || $menu.toggleClass(miniClass);
                }).trigger('resize');
                //  Mini 菜单模式时TIPS文字显示
                $('[data-target-tips]').mouseenter(function () {
                    if ($menu.hasClass(miniClass)) $(this).attr('index', layer.tips($(this).attr('data-target-tips') || '', this));
                }).mouseleave(function () {
                    layer.close($(this).attr('index'));
                });
            })($('.layui-layout-admin'), 'layui-layout-left-mini');
            // 左则二级菜单展示
            $('[data-submenu-layout]>a').on('click', function () {
                self.syncOpenStatus(1);
            });
            // 同步二级菜单展示状态
            this.syncOpenStatus = function (mode) {
                $('[data-submenu-layout]').map(function () {
                    var node = $(this).attr('data-submenu-layout');
                    if (mode === 1) layui.data('menu', {key: node, value: $(this).hasClass('layui-nav-itemed') ? 2 : 1});
                    else if ((layui.data('menu')[node] || 2) === 2) $(this).addClass('layui-nav-itemed');
                });
            };
            window.onhashchange = function () {
                var hash = window.location.hash || '';
                if (hash.length < 1) return $('[data-menu-node][data-open!="#"]:first').trigger('click');
                $.form.load(hash), self.syncOpenStatus(2);
                // 菜单选择切换
                var node = self.queryNode(self.getUri());
                if (/^m-/.test(node)) {
                    var $all = $('a[data-menu-node]').parent(), tmp = node.split('-'), tmpNode = tmp.shift();
                    while (tmp.length > 0) {
                        tmpNode = tmpNode + '-' + tmp.shift();
                        $all = $all.not($('a[data-menu-node="' + tmpNode + '"]').parent().addClass('layui-this'));
                    }
                    $all.removeClass('layui-this');
                    // 菜单模式切换
                    if (node.split('-').length > 2) {
                        var _tmp = node.split('-'), _node = _tmp.shift() + '-' + _tmp.shift();
                        $('[data-menu-layout]').not($('[data-menu-layout="' + _node + '"]').removeClass('layui-hide')).addClass('layui-hide');
                        $('[data-menu-node="' + node + '"]').parent().parent().parent().addClass('layui-nav-itemed');
                        $('.layui-layout-admin').removeClass('layui-layout-left-hide');
                    } else $('.layui-layout-admin').addClass('layui-layout-left-hide');
                    self.syncOpenStatus(1);
                }
            };
            // URI初始化动作
            window.onhashchange.call(this);
        };
    };

    /*! 注册对象到Jq */
    $.vali = function (form, callback, options) {
        return (new function () {
            var that = this;
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
                if (typeof prop !== "string") return false;
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
                var inputValue = $(ele).val();
                var realValue = this.trim(inputValue);
                regex = regex || ele.getAttribute('pattern');
                if (realValue === "" || !regex) return true;
                return new RegExp(regex, params || 'i').test(realValue);
            };
            // 检侧所的表单元素
            this.checkAllInput = function () {
                var isPass = true;
                $(form).find(this.tags).each(function () {
                    if (that.checkInput(this) === false) return $(this).focus(), isPass = false;
                });
                return isPass;
            };
            // 检测表单单元
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
            // 验证标志
            this.remind = function (input) {
                if (!this.isVisible(input)) return true;
                this.showError(input, input.getAttribute('title') || input.getAttribute('placeholder') || '输入错误');
                return false;
            };
            // 错误消息显示
            this.showError = function (ele, content) {
                $(ele).addClass('validate-error'), this.insertError(ele);
                $($(ele).data('input-info')).addClass('layui-anim layui-anim-fadein').css({width: 'auto'}).html(content);
            };
            // 错误消息消除
            this.hideError = function (ele) {
                $(ele).removeClass('validate-error'), this.insertError(ele);
                $($(ele).data('input-info')).removeClass('layui-anim-fadein').css({width: '30px'}).html('');
            };
            // 错误消息标签插入
            this.insertError = function (ele) {
                var $html = $('<span style="padding-right:12px;color:#a94442;position:absolute;right:0;font-size:12px;z-index:2;display:block;width:34px;text-align:center;pointer-events:none"></span>');
                $html.css({top: $(ele).position().top + 'px', paddingBottom: $(ele).css('paddingBottom'), lineHeight: $(ele).css('height')});
                $(ele).data('input-info') || $(ele).data('input-info', $html.insertAfter(ele));
            };
            // 表单验证入口
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
                });
                $(form).find('[data-form-loaded]').map(function () {
                    $(this).html(this.getAttribute('data-form-loaded') || this.innerHTML);
                    $(this).removeAttr('data-form-loaded').removeClass('layui-disabled');
                });
                return $(form).data('validate', this);
            };
        }).check(form, callback, options);
    };

    /*! 自动监听规则内表单 */
    $.vali.listen = function () {
        $('form[data-auto]').map(function () {
            if ($(this).attr('data-listen') !== 'true') $(this).attr('data-listen', 'true').vali(function (data) {
                var call = $(this).attr('data-callback') || '_default_callback';
                var type = this.getAttribute('method') || 'POST', tips = this.getAttribute('data-tips') || undefined;
                var time = this.getAttribute('data-time') || undefined, href = this.getAttribute('action') || window.location.href;
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
        var self = this, data = {}, pushCounters = {};
        var patterns = {"key": /[a-zA-Z0-9_]+|(?=\[\])/g, "push": /^$/, "fixed": /^\d+$/, "named": /^[a-zA-Z0-9_]+$/};
        this.build = function (base, key, value) {
            base[key] = value;
            return base;
        };
        this.pushCounter = function (name) {
            if (pushCounters[name] === undefined) pushCounters[name] = 0;
            return pushCounters[name]++;
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
        var that = this, mode = $(this).attr('data-file') || 'one';
        this.attr('data-inited', true);
        this.attr('data-multiple', (mode !== 'btn' && mode !== 'one') ? 1 : 0);
        require(['upload'], function (apply) {
            apply(that, null, callback);
        });
    };

    /*! 上传单个图片 */
    $.fn.uploadOneImage = function () {
        var name = $(this).attr('name') || 'image', type = $(this).data('type') || 'png,jpg,gif';
        var $tpl = $('<a data-file="btn" class="uploadimage"></a>').attr('data-field', name).attr('data-type', type);
        $(this).attr('name', name).after($tpl.data('input', this)).on('change', function () {
            if (this.value) $tpl.css('backgroundImage', 'url(' + this.value + ')');
        }).trigger('change');
    };

    /*! 上传多个图片 */
    $.fn.uploadMultipleImage = function () {
        var type = $(this).data('type') || 'png,jpg,gif', name = $(this).attr('name') || 'umt-image';
        var $tpl = $('<a class="uploadimage"></a>').attr('data-file', 'mul').attr('data-field', name).attr('data-type', type);
        $(this).attr('name', name).after($tpl.data('input', this)).on('change', function () {
            var input = this;
            this.setImageData = function () {
                input.value = input.getImageData().join('|');
            };
            this.getImageData = function () {
                var values = [];
                $(input).prevAll('.uploadimage').map(function () {
                    values.push($(this).attr('data-tips-image'));
                });
                return values.reverse(), values;
            };
            var urls = this.getImageData(), srcs = this.value.split('|');
            for (var i in srcs) if (srcs[i]) urls.push(srcs[i]);
            $(this).prevAll('.uploadimage').remove();
            this.value = urls.join('|');
            for (var i in urls) {
                var tpl = '<div class="uploadimage uploadimagemtl"><a class="layui-icon margin-right-5">&#xe602;</a><a class="layui-icon margin-right-5">&#x1006;</a><a class="layui-icon margin-right-5">&#xe603;</a></div>';
                var $tpl = $(tpl).attr('data-tips-image', urls[i]).css('backgroundImage', 'url(' + urls[i] + ')').on('click', 'a', function (e) {
                    e.stopPropagation();
                    var $cur = $(this).parent();
                    switch ($(this).index()) {
                        case 1:// remove
                            return $.msg.confirm('确定要移除这张图片吗？', function (index) {
                                $cur.remove(), input.setImageData(), $.msg.close(index);
                            });
                        case 0: // right
                            var lenght = $cur.siblings('div.uploadimagemtl').length;
                            if ($cur.index() !== lenght) $cur.next().after($cur);
                            return input.setImageData();
                        case 2: // left
                            if ($cur.index() !== 0) $cur.prev().before($cur);
                            return input.setImageData();
                    }
                });
                $(this).before($tpl);
            }
        }).trigger('change');
    };

    /*! 注册 data-load 事件行为 */
    $body.on('click', '[data-load]', function () {
        var url = $(this).attr('data-load'), tips = $(this).attr('data-tips'), time = $(this).attr('data-time');
        if ($(this).attr('data-confirm')) return $.msg.confirm($(this).attr('data-confirm'), function () {
            $.form.load(url, {}, 'get', null, true, tips, time);
        });
        $.form.load(url, {}, 'get', null, true, tips, time);
    });

    /*! 注册 data-serach 表单搜索行为 */
    $body.on('submit', 'form.form-search', function () {
        var url = $(this).attr('action').replace(/&?page=\d+/g, ''), split = url.indexOf('?') === -1 ? '?' : '&';
        if ((this.method || 'get').toLowerCase() === 'get') {
            return window.location.href = '#' + $.menu.parseUri(url + split + $(this).serialize());
        }
        $.form.load(url, this, 'post');
    });

    /*! 注册 data-modal 事件行为 */
    $body.on('click', '[data-modal]', function () {
        return $.form.modal($(this).attr('data-modal'), 'open_type=modal', $(this).attr('data-title') || $(this).text() || '编辑');
    });

    /*! 注册 data-open 事件行为 */
    $body.on('click', '[data-open]', function () {
        $.form.href($(this).attr('data-open'), this);
    });

    /*! 注册 data-dbclick 事件行为 */
    $body.on('dblclick', '[data-dbclick]', function () {
        $(this).find(this.getAttribute('data-dbclick') || '[data-dbclick]').trigger('click');
    });

    /*! 注册 data-reload 事件行为 */
    $body.on('click', '[data-reload]', function () {
        $.form.reload();
    });

    /*! 注册 data-check 事件行为 */
    $body.on('click', '[data-check-target]', function () {
        var checked = !!this.checked;
        $($(this).attr('data-check-target')).map(function () {
            this.checked = checked;
        });
    });

    /*! 注册 data-action 事件行为 */
    $body.on('click', '[data-action]', function () {
        var $this = $(this), data = {};
        var time = $this.attr('data-time'), action = $this.attr('data-action');
        var loading = $this.attr('data-loading'), method = $this.attr('data-method') || 'post';
        var rule = $this.attr('data-value') || (function (rule, ids) {
            $($this.attr('data-target') || 'input[type=checkbox].list-check-box').map(function () {
                (this.checked) && ids.push(this.value);
            });
            return ids.length > 0 ? rule.replace('{key}', ids.join(',')) : '';
        }).call(this, $this.attr('data-rule') || '', []) || '';
        if (rule.length < 1) return $.msg.tips('请选择需要更改的数据！');
        var rules = rule.split(';');
        for (var i in rules) {
            if (rules[i].length < 2) return $.msg.tips('异常的数据操作规则，请修改规则！');
            data[rules[i].split('#')[0]] = rules[i].split('#')[1];
        }
        data['_csrf_'] = $this.attr('data-token') || $this.attr('data-csrf') || '--';
        var load = loading !== 'false', tips = typeof loading === 'string' ? loading : undefined;
        if (!$this.attr('data-confirm')) $.form.load(action, data, method, false, load, tips, time);
        else $.msg.confirm($this.attr('data-confirm'), function () {
            $.form.load(action, data, method, false, load, tips, time);
        });
    });

    /*! 输入框失焦提交 */
    $body.on('blur', '[data-action-blur]', function () {
        var data = {}, that = this, $this = $(this), action = $this.attr('data-action-blur');
        var time = $this.attr('data-time'), loading = $this.attr('data-loading') || false;
        var load = loading !== 'false', tips = typeof loading === 'string' ? loading : undefined;
        var method = $this.attr('data-method') || 'post', confirm = $this.attr('data-confirm');
        var attrs = $this.attr('data-value').replace('{value}', $this.val()).split(';');
        for (var i in attrs) {
            if (attrs[i].length < 2) return $.msg.tips('异常的数据操作规则，请修改规则！');
            data[attrs[i].split('#')[0]] = attrs[i].split('#')[1];
        }
        that.callback = function (ret) {
            $this.css('border', (ret && ret.code) ? '1px solid #e6e6e6' : '1px solid red');
            return false;
        };
        data['_csrf_'] = $this.attr('data-token') || $this.attr('data-csrf') || '--';
        if (!confirm) return $.form.load(action, data, method, that.callback, load, tips, time);
        $.msg.confirm(confirm, function () {
            $.form.load(action, data, method, that.callback, load, tips, time);
        });
    });

    /*! 注册 data-href 事件行为 */
    $body.on('click', '[data-href]', function () {
        var href = $(this).attr('data-href');
        if (href && href.indexOf('#') !== 0) window.location.href = href;
    });

    /*! 注册 data-iframe 事件行为 */
    $body.on('click', '[data-iframe]', function () {
        var index = $.form.iframe($(this).attr('data-iframe'), $(this).attr('data-title') || '窗口');
        $(this).attr('data-index', index);
    });

    /*! 注册 data-icon 事件行为 */
    $body.on('click', '[data-icon]', function () {
        var field = $(this).attr('data-icon') || $(this).attr('data-field') || 'icon';
        var location = window.ROOT_URL + '?s=admin/api.plugs/icon.html&field=' + field;
        $.form.iframe(location, '图标选择');
    });

    /*! 注册 data-copy 事件行为 */
    $body.on('click', '[data-copy]', function () {
        $.copyToClipboard(this.getAttribute('data-copy'));
    });
    $.copyToClipboard = function (content) {
        var input = document.createElement('textarea');
        input.style.position = 'absolute', input.style.left = '-100000px';
        input.style.width = '1px', input.style.height = '1px', input.innerText = content;
        document.body.appendChild(input), input.select(), setTimeout(function () {
            document.execCommand('Copy') ? $.msg.tips('复制成功') : $.msg.tips('复制失败，请使用鼠标操作复制！');
            document.body.removeChild(input);
        }, 100);
    };

    /*! 注册 data-tips-image 事件行为 */
    $body.on('click', '[data-tips-image]', function () {
        $.previewImage(this.getAttribute('data-tips-image') || this.src, this.getAttribute('data-width'));
    });
    $.previewImage = function (src, area) {
        var img = new Image(), index = $.msg.loading();
        img.style.background = '#fff', img.style.display = 'none';
        img.style.height = 'auto', img.style.width = area || '480px';
        document.body.appendChild(img), img.onerror = function () {
            $.msg.close(index);
        }, img.onload = function () {
            layer.open({
                type: 1, shadeClose: true, success: img.onerror, content: $(img), title: false,
                area: area || '480px', closeBtn: 1, skin: 'layui-layer-nobg', end: function () {
                    document.body.removeChild(img);
                }
            });
        };
        img.src = src;
    };

    /*! 注册 data-phone-view 事件行为 */
    $body.on('click', '[data-phone-view]', function () {
        $.previewPhonePage(this.getAttribute('data-phone-view') || this.href);
    });
    $.previewPhonePage = function (href, title) {
        var tpl = '<div><div class="mobile-preview pull-left"><div class="mobile-header">_TITLE_</div><div class="mobile-body"><iframe id="phone-preview" src="_URL_" frameborder="0" marginheight="0" marginwidth="0"></iframe></div></div></div>';
        layer.style(layer.open({type: true, scrollbar: false, area: ['320px', '600px'], title: false, closeBtn: true, shadeClose: false, skin: 'layui-layer-nobg', content: $(tpl.replace('_TITLE_', title || '公众号').replace('_URL_', href)).html(),}), {boxShadow: 'none'});
    };

    /*! 注册 data-tips-text 事件行为 */
    $body.on('mouseenter', '[data-tips-text]', function () {
        $(this).attr('index', layer.tips($(this).attr('data-tips-text'), this, {tips: [$(this).attr('data-tips-type') || 3, '#78BA32']}));
    }).on('mouseleave', '[data-tips-text]', function () {
        layer.close($(this).attr('index'));
    });

    /*! 后台加密登录处理 */
    $body.find('[data-login-form]').map(function () {
        require(["md5"], function (md5) {
            $("form").vali(function (data) {
                data['password'] = md5.hash(md5.hash(data['password']) + data['skey']);
                if (data['skey']) delete data['skey'];
                $.form.load(location.href, data, "post", null, null, null, 'false');
            });
        });
    });

    /*! 初始化事件 */
    $.menu.listen();
    $.vali.listen();
});