define(['md5'], function (SparkMD5, allowExtsMimes) {
    allowExtsMimes = JSON.parse('{$exts|raw}');
    return function (element, UploadedHandler, options) {
        /*! 定义初始化变量 */
        options = {element: $(element), exts: [], mimes: [], files: {}, cache: {}, loading: 0};
        options.count = {total: 0, uploaded: 0};
        options.type = options.element.data('type') || '';
        options.safe = options.element.data('safe') ? 1 : 0;
        options.types = options.type ? options.type.split(',') : [];
        options.field = options.element.data('field') || 'file';
        options.input = $('[name="_field_"]'.replace('_field_', options.field));
        options.uptype = options.safe ? 'local' : options.element.attr('data-uptype') || '';
        options.multiple = options.element.attr('data-multiple') > 0;
        /*! 文件的选择筛选 */
        for (var index in options.types) if (allowExtsMimes[options.types[index]]) {
            options.exts.push(options.types[index]), options.mimes.push(allowExtsMimes[options.types[index]]);
        }
        /*! 初始化上传组件 */
        options.uploader = layui.upload.render({
            auto: false, multiple: options.multiple, accept: 'file', elem: element,
            exts: options.exts.join('|'), acceptMime: options.mimes.join(','), choose: function (obj) {
                for (var index in options.files = obj.pushFile()) {
                    options.loading = $.msg.loading('上传进度 <span data-upload-progress>0%</span>');
                    options.count.total++, options.files[index].index = index, options.cache[index] = options.files[index], delete options.files[index];
                    md5file(options.cache[index]).then(function (file) {
                        jQuery.ajax("{:url('admin/api.upload/state')}", {
                            data: {xkey: file.xkey, uptype: options.uptype, safe: options.safe, name: file.name}, method: 'post', success: function (ret) {
                                file.xurl = ret.data.url;
                                if (parseInt(ret.code) === 404) {
                                    options.uploader.config.url = ret.data.server;
                                    options.uploader.config.data.key = ret.data.xkey;
                                    options.uploader.config.data.safe = ret.data.safe;
                                    options.uploader.config.data.uptype = ret.data.uptype;
                                    if (ret.data.uptype === 'qiniu') {
                                        options.uploader.config.data.token = ret.data.token;
                                    } else if (ret.data.uptype === 'alioss') {
                                        options.uploader.config.data.policy = ret.data.policy;
                                        options.uploader.config.data.signature = ret.data.signature;
                                        options.uploader.config.data.OSSAccessKeyId = ret.data.OSSAccessKeyId;
                                        options.uploader.config.data.success_action_status = 200;
                                        options.uploader.config.data['Content-Disposition'] = 'inline;filename=' + encodeURIComponent(file.name);
                                    }
                                    obj.upload(file.index, file);
                                } else if (parseInt(ret.code) === 200) {
                                    options.uploader.config.done({uploaded: true, url: file.xurl}, file.index);
                                } else {
                                    $.msg.tips(ret.info || ret.error.message || '文件上传出错！');
                                }
                            }
                        });
                    });
                }
            }, progress: function (n) {
                $('[data-upload-progress]').html(n + '%');
            }, done: function (ret, index, file) {
                if (++options.count.uploaded >= options.count.total) {
                    layer.close(options.loading);
                }
                if (typeof ret.code === 'number' && parseInt(ret.code) === 0) {
                    return $.msg.tips(ret.info || '文件上传失败！');
                }
                file = options.cache[index];
                if (typeof file.xurl !== 'string') return $.msg.tips('无效的文件对象！');
                if (typeof ret.uploaded === 'undefined' && typeof file.xurl === 'string') {
                    ret = {uploaded: true, url: file.xurl};
                }
                if (ret.uploaded) {
                    if (typeof UploadedHandler === 'function') {
                        UploadedHandler.call(options.element, ret.url, file);
                    } else {
                        options.input.val(ret.url).trigger('change');
                    }
                } else {
                    $.msg.tips(ret.info || ret.error.message || '文件上传出错！');
                }
            }, allDone: function () {
                $.msg.close(options.loading);
                options.element.html(options.element.data('html'));
            }
        });
    };

    function md5file(file) {
        var deferred = jQuery.Deferred();
        file.xext = file.name.indexOf('.') > -1 ? file.name.split('.').pop() : 'tmp';

        /*! 兼容不能计算文件 HASH 的情况 */
        if (!window.FileReader) return jQuery.when((function (date, chars) {
            date = new Date(), chars = 'abcdefhijkmnprstwxyz0123456789';
            this.xmd5 = '' + date.getFullYear() + (date.getMonth() + 1) + date.getDay() + date.getHours() + date.getMinutes() + date.getSeconds();
            while (this.xmd5.length < 32) this.xmd5 += chars.charAt(Math.floor(Math.random() * chars.length));
            return setFileXdata(file, this.xmd5), deferred.resolve(file, file.xmd5, file.xkey), deferred;
        }).call(this));

        /*! 读取文件并计算 HASH 值 */
        var spark = new SparkMD5.ArrayBuffer();
        var slice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;
        file.chunk_idx = 0, file.chunk_size = 2097152, file.chunk_total = Math.ceil(this.size / this.chunk_size);
        return jQuery.when(loadNextChunk(file));

        function setFileXdata(file, xmd5) {
            file.xmd5 = xmd5;
            file.xkey = file.xmd5.substr(0, 2) + '/' + file.xmd5.substr(2, 30) + '.' + file.xext;
            delete file.chunk_idx, delete file.chunk_size, delete file.chunk_total;
            return file;
        }

        function loadNextChunk(file) {
            this.reader = new FileReader();
            this.reader.onload = function (e) {
                spark.append(e.target.result);
                if (++file.chunk_idx < file.chunk_total) {
                    loadNextChunk(file);
                } else {
                    setFileXdata(file, spark.end());
                    deferred.resolve(file, file.xmd5, file.xkey);
                }
            };
            this.reader.onerror = function () {
                deferred.reject();
            };
            this.start = file.chunk_idx * file.chunk_size;
            this.loaded = (this.start + file.chunk_size >= file.size) ? file.size : this.start + file.chunk_size;
            this.reader.readAsArrayBuffer(slice.call(file, this.start, this.loaded));
            return deferred.notify(file, (this.loaded / file.size * 100).toFixed(2)), deferred;
        }
    }
});