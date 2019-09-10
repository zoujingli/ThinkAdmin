define(function () {
    return function (element, InitHandler, UploadedHandler, CompleteHandler) {
        var exts = $(element).data('type') || '*';
        var uptype = $(element).attr('data-uptype') || '';

        // 检查可以上传的文件后缀
        $.form.load('?s=admin/api.plugs/check', {exts: exts, uptype: uptype}, 'post', function (ret, options) {
            options = {url: ret.data.push.url, exts: ret.data.exts, acceptMime: ret.data.mime, data: {token: ret.data.push.token}};
            if (exts.indexOf('*') > -1) delete options.exts, delete options.acceptMime;
            return renderUploader(options), false;
        }, false, false, 0);

        // 初始化上传组件
        function renderUploader(options) {
            this.options = {
                proindex: 0,
                elem: element,
                multiple: $(element).attr('data-multiple') > 0,
                url: '?s=admin/api.plugs/plupload',
                before: function () {
                    this.proindex = $.msg.loading('上传进度 <span data-upload-progress></span>');
                },
                progress: function (n) {
                    $('[data-upload-progress]').html(n + '%');
                },
                done: function (ret) {
                    this.multiple || $.msg.close(this.proindex);
                    if (ret.uploaded) {
                        if (typeof UploadedHandler === 'function') UploadedHandler(ret.url);
                        else $('[name="' + ($(element).data('field') || 'file') + '"]').val(ret.url).trigger('change');
                    } else {
                        $.msg.error(ret.info || ret.error.message || '文件上传出错！');
                    }
                },
                allDone: function () {
                    $.msg.close(this.proindex), $(element).html($(element).data('html'));
                    if (typeof CompleteHandler === 'function') CompleteHandler();
                }
            };
            layui.upload.render($.extend(this.options, options));
        };
    };
});