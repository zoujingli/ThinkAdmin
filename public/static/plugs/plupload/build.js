define(['plupload'], function (plupload) {
    window.plupload = plupload;
    return function (element, InitHandler, UploadedHandler, CompleteHandler) {
        var $element = $(element), index = 0;
        if ($element.data('uploader')) return $element.data('uploader');
        var loader = new plupload.Uploader({
            multi_selection: $element.attr('data-multiple') > 0,
            multipart_params: {
                safe: $element.attr('data-safe') || '0',
                uptype: $element.attr('data-uptype') || '',
            },
            drop_element: $element.get(0),
            browse_button: $element.get(0),
            url: '?s=admin/api.plugs/plupload',
            runtimes: 'html5,flash,silverlight,html4',
            file_data_name: $element.attr('data-name') || 'file',
            flash_swf_url: baseRoot + 'plugs/plupload/Moxie.swf',
            silverlight_xap_url: baseRoot + 'plugs/plupload/Moxie.xap',
            filters: [{title: 'files', extensions: $element.attr('data-type') || '*'}],
        });
        if (typeof InitHandler === 'function') {
            loader.bind('Init', InitHandler);
        }
        loader.bind('FilesAdded', function () {
            loader.start();
            index = $.msg.loading('上传进度 <span data-upload-progress></span>');
        });
        loader.bind('UploadProgress', function (up, file) {
            $('[data-upload-progress]').html(parseFloat(file.loaded * 100 / file.total).toFixed(2) + '%');
        });
        loader.bind('FileUploaded', function (up, file, res) {
            if (parseInt(res.status) === 200) {
                var ret = JSON.parse(res.response);
                if (ret.uploaded) {
                    if (typeof UploadedHandler === 'function') {
                        UploadedHandler(ret.url);
                    } else {
                        var field = $element.data('field') || 'file';
                        $('[name="' + field + '"]').val(ret.url).trigger('change');
                    }
                } else {
                    $.msg.error(ret.error.message || '文件上传出错！');
                }
            }
        });
        loader.bind('Error', function () {
            console.log(arguments);
        });
        loader.bind('UploadComplete', function () {
            $.msg.close(index), $element.html($element.data('html'));
            if (typeof CompleteHandler === 'function') {
                CompleteHandler();
            }
        });
        $element.data('html', $element.html()), loader.init();
        return $element.data('uploader', loader), loader;
    }
});