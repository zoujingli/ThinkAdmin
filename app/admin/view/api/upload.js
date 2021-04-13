define(['md5'], function (SparkMD5, allowMime) {
    allowMime = JSON.parse('{$exts|raw}');
    return function (element, callable, option) {
        /*! 初始化变量 */
        option = {element: $(element), exts: [], mimes: [], files: {}, cache: {}, load: 0};
        option.count = {total: 0, uploaded: 0}, option.size = option.element.data('size') || 0;
        option.safe = option.element.data('safe') ? 1 : 0, option.hload = option.element.data('hide-load') ? 1 : 0;
        option.field = option.element.data('field') || 'file', option.input = $('[name="_field_"]'.replace('_field_', option.field));
        option.uptype = option.safe ? 'local' : option.element.attr('data-uptype') || '', option.multiple = option.element.data('multiple') > 0;
        /*! 文件选择筛选 */
        $((option.element.data('type') || '').split(',')).map(function (i, ext) {
            if (allowMime[ext]) option.exts.push(ext), option.mimes.push(allowMime[ext]);
        });
        /*! 初始化上传组件 */
        option.uploader = layui.upload.render({
            url: '{:url("admin/api.upload/file")}',
            auto: false, elem: element, accept: 'file', multiple: option.multiple,
            exts: option.exts.join('|'), acceptMime: option.mimes.join(','), choose: function (object) {
                option.element.triggerHandler('upload.choose', option.files = object.pushFile());
                option.uploader.config.elem.next().val(''), layui.each(option.files, function (index, file) {
                    if (option.size > 0 && file.size > option.size) {
                        return delete option.files[index], $.msg.tips('文件大小超出上传限制！');
                    }
                    option.load = option.hload || $.msg.loading('上传进度 <span data-upload-progress>0%</span>');
                    option.count.total++, file.index = index, option.cache[index] = file, delete option.files[index];
                    md5file(file).then(function (file) {
                        option.element.triggerHandler('upload.hash', file);
                        jQuery.ajax("{:url('admin/api.upload/state')}", {
                            data: {key: file.xkey, uptype: option.uptype, safe: option.safe, name: file.name}, method: 'post', success: function (ret) {
                                if (parseInt(ret.code) === 404) {
                                    file.xurl = ret.data.url;
                                    option.uploader.config.url = ret.data.server;
                                    option.uploader.config.data.key = ret.data.key;
                                    option.uploader.config.data.safe = ret.data.safe;
                                    option.uploader.config.data.uptype = ret.data.uptype;
                                    if (ret.data.uptype === 'qiniu') {
                                        option.uploader.config.data.token = ret.data.token;
                                    } else if (ret.data.uptype === 'alioss') {
                                        option.uploader.config.data['policy'] = ret.data.policy;
                                        option.uploader.config.data['signature'] = ret.data.signature;
                                        option.uploader.config.data['OSSAccessKeyId'] = ret.data.OSSAccessKeyId;
                                        option.uploader.config.data['success_action_status'] = 200;
                                        option.uploader.config.data['Content-Disposition'] = 'inline;filename=' + encodeURIComponent(file.name);
                                    } else if (ret.data.uptype === 'txcos') {
                                        option.uploader.config.data['q-ak'] = ret.data['q-ak'];
                                        option.uploader.config.data['policy'] = ret.data.policy;
                                        option.uploader.config.data['q-key-time'] = ret.data['q-key-time'];
                                        option.uploader.config.data['q-signature'] = ret.data['q-signature'];
                                        option.uploader.config.data['q-sign-algorithm'] = ret.data['q-sign-algorithm'];
                                        option.uploader.config.data['success_action_status'] = 200;
                                        option.uploader.config.data['Content-Disposition'] = 'inline;filename=' + encodeURIComponent(file.name);
                                    }
                                    object.upload(file.index, file);
                                } else if (parseInt(ret.code) === 200) {
                                    file.xurl = ret.data.url;
                                    option.uploader.config.done({uploaded: true, url: file.xurl}, file.index);
                                } else {
                                    $.msg.tips(ret.info || ret.error.message || '文件上传出错！');
                                }
                            }
                        });
                    });
                });
            }, progress: function (number) {
                $('[data-upload-progress]').html(number + '%');
                option.element.triggerHandler('upload.progress', {number: number, event: arguments[2], file: arguments[3]});
            }, done: function (ret, index) {
                option.element.triggerHandler('upload.done', {file: option.cache[index], data: ret});
                if (++option.count.uploaded >= option.count.total) {
                    option.element.triggerHandler('upload.complete', {});
                    option.element.html(option.element.data('html'));
                    option.hload || $.msg.close(option.load);
                    option.uploader.reload();
                }
                if (typeof ret.code === 'number' && parseInt(ret.code) === 0) {
                    return $.msg.tips(ret.info || '文件上传失败！');
                }
                if (typeof option.cache[index].xurl !== 'string') {
                    return $.msg.tips('无效的文件对象！');
                }
                if (typeof ret.uploaded === 'undefined' && typeof option.cache[index].xurl === 'string') {
                    ret = {uploaded: true, url: option.cache[index].xurl};
                }
                if (ret.uploaded) {
                    if (typeof callable === 'function') {
                        callable.call(option.element, ret.url, option.cache[index]);
                    } else {
                        option.input.val(ret.url).trigger('change');
                    }
                } else {
                    $.msg.tips(ret.info || ret.error.message || '文件上传出错！');
                }
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
        file.chunkIdx = 0, file.chunkSize = 2097152, file.chunkTotal = Math.ceil(this.size / this.chunkSize);
        return jQuery.when(loadNextChunk(file));

        function setFileXdata(file, xmd5) {
            file.xmd5 = xmd5, file.xkey = file.xmd5.substr(0, 2) + '/' + file.xmd5.substr(2, 30) + '.' + file.xext;
            return delete file.chunkIdx, delete file.chunkSize, delete file.chunkTotal, file;
        }

        function loadNextChunk(file) {
            this.reader = new FileReader();
            this.reader.onload = function (event) {
                spark.append(event.target.result);
                if (++file.chunkIdx < file.chunkTotal) {
                    loadNextChunk(file);
                } else {
                    setFileXdata(file, spark.end());
                    deferred.resolve(file, file.xmd5, file.xkey);
                }
            };
            this.reader.onerror = function () {
                deferred.reject();
            };
            this.start = file.chunkIdx * file.chunkSize;
            this.loaded = (this.start + file.chunkSize >= file.size) ? file.size : this.start + file.chunkSize;
            this.reader.readAsArrayBuffer(slice.call(file, this.start, this.loaded));
            return deferred.notify(file, (this.loaded / file.size * 100).toFixed(2)), deferred;
        }
    }
});