define(['md5'], function (SparkMD5) {
    var allowExtsMimes = JSON.parse('{$exts|raw}');
    return function (element, InitHandler, UploadedHandler) {
        var exts = [], mimes = [];
        var safe = $(element).attr('data-safe') || '';
        var uptype = $(element).attr('data-uptype') || '';
        var multiple = $(element).attr('data-multiple') > 0;
        var types = ($(element).data('type') || '').split(',');
        for (var i in types) if (allowExtsMimes[types[i]]) {
            mimes.push(allowExtsMimes[types[i]]), exts.push(types[i]);
        }

        renderUploader({exts: exts.join('|'), acceptMime: mimes.join(',')});

        // 初始化上传组件
        function renderUploader(options, headers, uploader) {
            uploader = layui.upload.render({
                idx: 0, urls: {}, auto: false, elem: element,
                exts: options.exts, acceptMime: options.acceptMime,
                headers: headers || {}, multiple: multiple, accept: 'file',
                choose: function (object, files) {
                    files = object.pushFile();
                    for (var index in files) {
                        md5file(files[index]).then(function (file) {
                            jQuery.ajax("?s=admin/api.upload/state", {
                                data: {xkey: file.xkey, uptype: uptype, safe: safe}, method: 'POST', success: function (ret) {
                                    if (ret.code === 404) {
                                        uploader.config.data.safe = safe;
                                        uploader.config.url = ret.data.server;
                                        uploader.config.urls[index] = ret.data.url;
                                        if (ret.data.uptype === 'qiniu') {
                                            uploader.config.data.key = ret.data.xkey;
                                            uploader.config.data.token = ret.data.token;
                                        }
                                        if (ret.data.uptype === 'alioss') {
                                            uploader.config.data.key = ret.data.xkey;
                                            uploader.config.data.policy = ret.data.policy;
                                            uploader.config.data.signature = ret.data.signature;
                                            uploader.config.data.OSSAccessKeyId = ret.data.OSSAccessKeyId;
                                            uploader.config.data.success_action_status = 200;
                                        }
                                        object.upload(index, file);
                                    } else if (ret.code === 200) {
                                        UploadedHandler(ret.data.url, file.xkey);
                                    } else {
                                        $.msg.error(ret.info || ret.error.message || '文件上传出错！');
                                    }
                                }
                            });
                        });
                        delete files[index];
                    }
                },
                before: function () {
                    this.idx = $.msg.loading('上传进度 <span data-upload-progress>0%</span>');
                },
                progress: function (n) {
                    $('[data-upload-progress]').html(n + '%');
                },
                done: function (ret, index) {
                    this.multiple || $.msg.close(this.idx);
                    if (typeof ret.uploaded === 'undefined' && this.urls[index]) {
                        ret = {uploaded: true, url: this.urls[index]};
                    }
                    if (ret.uploaded) {
                        if (typeof UploadedHandler === 'function') {
                            UploadedHandler(ret.url);
                        } else {
                            $('[name="' + ($(element).data('field') || 'file') + '"]').val(ret.url).trigger('change');
                        }
                    } else {
                        $.msg.error(ret.info || ret.error.message || '文件上传出错！');
                    }
                },
                allDone: function () {
                    $.msg.close(this.idx), $(element).html($(element).data('html'));
                }
            });
        };
    };

    function md5file(file) {
        var deferred = jQuery.Deferred();
        file.xext = file.name.indexOf('.') > -1 ? file.name.split('.').pop() : 'tmp';

        if (!window.FileReader) return jQuery.when((function (date, chars) {
            date = new Date(), chars = 'abcdefhijkmnprstwxyz0123456789';
            this.xmd5 = '' + date.getFullYear() + (date.getMonth() + 1) + date.getDay() + date.getHours() + date.getMinutes() + date.getSeconds();
            while (this.xmd5.length < 32) this.xmd5 += chars.charAt(Math.floor(Math.random() * chars.length));
            setFileXdata(file, this.xmd5);
            deferred.resolve(file, file.xmd5, file.xkey);
            return deferred;
        }).call(this));

        var spark = new SparkMD5.ArrayBuffer();
        var slice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;
        file.chunk_idx = 0;
        file.chunk_size = 2097152;
        file.chunk_total = Math.ceil(this.size / this.chunk_size);
        return jQuery.when(loadNextChunk(file));

        function setFileXdata(file, xmd5) {
            file.xmd5 = xmd5;
            file.xkey = file.xmd5.substr(0, 16) + '/' + file.xmd5.substr(16, 16) + '.' + file.xext;
            delete file.chunk_idx;
            delete file.chunk_size;
            delete file.chunk_total;
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
            this.loaded = ((this.start + file.chunk_size) >= file.size) ? file.size : this.start + file.chunk_size;
            this.reader.readAsArrayBuffer(slice.call(file, this.start, this.loaded));
            deferred.notify(file, (this.loaded / file.size * 100).toFixed(2));
            return deferred;
        }
    }
});