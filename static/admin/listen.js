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

define(['jquery', 'admin.plugs'], function () {

    /*! 定义当前body对象 */
    this.$body = $('body');

    /*! 注册 data-load 事件行为 */
    this.$body.on('click', '[data-load]', function () {
        var url = $(this).attr('data-load'), tips = $(this).attr('data-tips');

        function _goLoad() {
            $.form.load(url, {}, 'GET', null, true, tips);
        }

        if ($(this).attr('data-confirm')) {
            return $.msg.confirm($(this).attr('data-confirm'), _goLoad);
        }
        return _goLoad.call(this);
    });

    /*! 注册 data-serach 表单搜索行为 */
    this.$body.on('submit', 'form.form-search', function () {
        var url = $(this).attr('action');
        var split = url.indexOf('?') === -1 ? '?' : '&';
        if ((this.method || 'get').toLowerCase() === 'get') {
            window.location.href = '#' + parseUri(url + split + $(this).serialize());
        } else {
            $.form.load(url, this, 'post');
        }
    });

    /*! 注册 data-modal 事件行为 */
    this.$body.on('click', '[data-modal]', function () {
        return $.form.modal($(this).attr('data-modal'), 'open_type=modal', $(this).attr('data-title') || '编辑');
    });

    /*! 注册 data-open 事件行为 */
    this.$body.on('click', '[data-open]', function () {
        $.form.href($(this).attr('data-open'), this);
    });

    /*! 注册 data-reload 事件行为 */
    this.$body.on('click', '[data-reload]', function () {
        $.form.reload();
    });

    /*! 注册 data-check 事件行为 */
    this.$body.on('click', '[data-check-target]', function () {
        var checked = !!this.checked;
        $($(this).attr('data-check-target')).map(function () {
            this.checked = checked;
        });
    });

    /*! 注册 data-update 事件行为 */
    this.$body.on('click', '[data-update]', function () {
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
    });

    /*! 注册 data-href 事件行为 */
    this.$body.on('click', '[data-href]', function () {
        var href = $(this).attr('data-href');
        if (href && href.indexOf('#') !== 0) {
            window.location.href = href;
        }
    });

    /*! 注册 data-page-href 事件行为 */
    this.$body.on('click', 'a[data-page-href]', function () {
        window.location.href = '#' + parseUri(this.href, this);
    });

    /*! 注册 data-file 事件行为 */
    this.$body.on('click', '[data-file]', function () {
        var type = $(this).attr('data-type') || 'jpg,png';
        var field = $(this).attr('data-field') || 'file';
        var method = $(this).attr('data-file') === 'one' ? 'one' : 'mtl';
        var title = $(this).attr('data-title') || '文件上传';
        var uptype = $(this).attr('data-uptype') || '';
        var url = window.ROOT_URL + '/index.php/admin/plugs/upfile/mode/' + method + '.html?uptype=' + uptype + '&type=' + type + '&field=' + field;
        $.form.iframe(url, title || '文件管理');
    });

    /*! 注册 data-iframe 事件行为 */
    this.$body.on('click', '[data-iframe]', function () {
        $.form.iframe($(this).attr('data-iframe'), $(this).attr('data-title') || '窗口');
    });

    /*! 注册 data-icon 事件行为 */
    this.$body.on('click', '[data-icon]', function () {
        var field = $(this).attr('data-icon') || $(this).attr('data-field') || 'icon';
        var url = window.ROOT_URL + '/index.php/admin/plugs/icon.html?field=' + field;
        $.form.iframe(url, '图标选择');
    });

    /*! 注册 data-tips-image 事件行为 */
    this.$body.on('click', '[data-tips-image]', function () {
        var src = this.getAttribute('data-tips-image') || this.src, img = new Image();
        var imgWidth = this.getAttribute('data-width') || '480px';
        img.onload = function () {
            layer.open({
                type: 1, area: imgWidth, title: false, closeBtn: 1, skin: 'layui-layer-nobg', shadeClose: true,
                content: $(img).appendTo('body').css({background: '#fff', width: imgWidth, height: 'auto'}),
                end: function () {
                    $(img).remove();
                }
            });
        };
        img.src = src;
    });

    /*! 注册 data-tips-text 事件行为 */
    this.$body.on('mouseenter', '[data-tips-text]', function () {
        var text = $(this).attr('data-tips-text');
        var placement = $(this).attr('data-tips-placement') || 'auto';
        $(this).tooltip({title: text, placement: placement}).tooltip('show');
    });

    /*! 注册 data-phone-view 事件行为 */
    this.$body.on('click', '[data-phone-view]', function () {
        var src = this.getAttribute('data-phone-view') || this.href;
        var $container = $('<div class="mobile-preview pull-left"><div class="mobile-header">公众号</div><div class="mobile-body"><iframe id="phone-preview" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div></div>').appendTo('body');
        var $iframe = $container.find('iframe').attr('src', src);
        $container.find('.mobile-header').on('click', function () {
            $iframe.attr('src', src);
        });
        var index = layer.open({
            type: 1,
            scrollbar: false,
            area: ['330px', '600px'],
            title: false,
            closeBtn: 1,
            skin: 'layui-layer-nobg',
            shadeClose: true,
            content: $container.removeClass('hide'),
            end: function () {
                $container.remove();
            }
        });
        layer.style(index, {boxShadow: 'none'});
    });

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

    /*!　URL转URI */
    window.parseUri = function (uri, obj) {
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
        uri = getUri(uri);
        params.spm = obj && obj.getAttribute('data-menu-node') || queryNode(uri);
        if (!params.token) {
            var token = window.location.href.replace(/.*token=(\w+).*/ig, '$1');
            (/^\w{16}$/.test(token)) && (params.token = token);
        }
        delete params[""];
        var query = '?' + $.param(params);
        return uri + (query !== '?' ? query : '');
    };
    /*! 通过URI查询最有可能的菜单NODE */
    function queryNode(url) {
        var $menu = $('[data-menu-node][data-open*="_URL_"]'.replace('_URL_', url.replace(/\.html$/ig, '')));
        if ($menu.size()) {
            return $menu.get(0).getAttribute('data-menu-node');
        }
        return /^m\-/.test(node = location.href.replace(/.*spm=([\d\-m]+).*/ig, '$1')) ? node : '';
    }

    /*! 计算URL地址中有效的URI */
    function getUri(uri) {
        uri = uri || window.location.href;
        uri = (uri.indexOf(window.location.host) !== -1 ? uri.split(window.location.host)[1] : uri).split('?')[0];
        return (uri.indexOf('#') !== -1 ? uri.split('#')[1] : uri);
    }

    /*! URI路由处理 */
    window.onhashchange = function () {
        var hash = (window.location.hash || '').substring(1), node = hash.replace(/.*spm=([\d\-m]+).*/ig, "$1");
        if (!/^m\-[\d\-]+$/.test(node)) {
            node = queryNode(getUri()) || '';
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
        /* 加载资源 */
        $.form.open(hash);
    };
    // URI初始化动作
    window.onhashchange.call(this);
});