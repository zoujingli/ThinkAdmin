define(['md5'], function (SparkMD5, allowMime) {
    allowMime = JSON.parse('{$exts|raw}');
    return function (element, callable) {

        /*! 初始化变量 */
        var opt = {elem: $(element), exts: [], mimes: [], files: {}, cache: {}, load: 0, count: {total: 0, uploaded: 0}};
        opt.size = opt.elem.data('size') || 0, opt.mult = opt.elem.data('multiple') > 0;
        opt.safe = opt.elem.data('safe') ? 1 : 0, opt.hide = opt.elem.data('hide-load') ? 1 : 0;
        opt.type = opt.safe ? 'local' : opt.elem.attr('data-uptype') || '';

        /*! 查找表单元素, 如果没有找到将不会自动写值 */
        if (!opt.elem.data('input') && opt.elem.data('field')) {
            var $input = $('input[name="' + opt.elem.data('field') + '"]:not([type=file])');
            opt.elem.data('input', $input.size() > 0 ? $input.get(0) : null);
        }

        /*! 文件选择筛选，使用 MIME 规则过滤文件列表 */
        $((opt.elem.data('type') || '').split(',')).map(function (i, e) {
            if (allowMime[e]) opt.exts.push(e), opt.mimes.push(allowMime[e]);
        });

        /*! 初始化上传组件 */
        opt.uploader = layui.upload.render({
            url: '{:sysuri("admin/api.upload/file")}', auto: false, elem: element, accept: 'file', multiple: opt.mult,
            exts: opt.exts.join('|'), acceptMime: opt.mimes.join(','), choose: function (object) {
                opt.elem.triggerHandler('upload.choose', opt.files = object.pushFile());
                opt.uploader.config.elem.next().val(''), layui.each(opt.files, function (index, file) {
                    if (opt.size > 0 && file.size > opt.size) return delete opt.files[index], $.msg.tips('文件大小超出限制！');
                    opt.load = opt.hide || $.msg.loading('上传进度 <span data-upload-progress>0%</span>');
                    opt.count.total++, file.index = index, opt.cache[index] = file, delete opt.files[index];
                    md5file(file).then(function (file) {
                        opt.elem.triggerHandler('upload.hash', file), jQuery.ajax("{:sysuri('admin/api.upload/state')}", {
                            data: {key: file.xkey, uptype: opt.type, safe: opt.safe, name: file.name}, method: 'post', success: function (ret) {
                                file.xurl = ret.data.url, file.xsafe = ret.data.safe;
                                file.xpath = ret.data.key, file.xtype = ret.data.uptype;
                                if (parseInt(ret.code) === 404) {
                                    opt.uploader.config.url = ret.data.server;
                                    opt.uploader.config.data.key = ret.data.key;
                                    opt.uploader.config.data.safe = ret.data.safe;
                                    opt.uploader.config.data.uptype = ret.data.uptype;
                                    if (ret.data.uptype === 'qiniu') {
                                        opt.uploader.config.data.token = ret.data.token;
                                    } else if (ret.data.uptype === 'alioss') {
                                        opt.uploader.config.data['policy'] = ret.data.policy;
                                        opt.uploader.config.data['signature'] = ret.data.signature;
                                        opt.uploader.config.data['OSSAccessKeyId'] = ret.data.OSSAccessKeyId;
                                        opt.uploader.config.data['success_action_status'] = 200;
                                        opt.uploader.config.data['Content-Disposition'] = 'inline;filename=' + encodeURIComponent(file.name);
                                    } else if (ret.data.uptype === 'txcos') {
                                        opt.uploader.config.data['q-ak'] = ret.data['q-ak'];
                                        opt.uploader.config.data['policy'] = ret.data['policy'];
                                        opt.uploader.config.data['q-key-time'] = ret.data['q-key-time'];
                                        opt.uploader.config.data['q-signature'] = ret.data['q-signature'];
                                        opt.uploader.config.data['q-sign-algorithm'] = ret.data['q-sign-algorithm'];
                                        opt.uploader.config.data['success_action_status'] = 200;
                                        opt.uploader.config.data['Content-Disposition'] = 'inline;filename=' + encodeURIComponent(file.name);
                                    }
                                    object.upload(file.index, file);
                                } else if (parseInt(ret.code) === 200) {
                                    file.xurl = ret.data.url;
                                    opt.uploader.config.done({code: 1, url: file.xurl, info: '文件秒传成功！'}, file.index);
                                } else {
                                    $.msg.tips(ret.info || ret.error.message || '文件上传出错！');
                                }
                            }
                        });
                    });
                });
            }, progress: function (number) {
                /*! 文件上传进度处理 */
                opt.elem.triggerHandler('upload.progress', {number: number, event: arguments[2], file: arguments[3]});
                if (opt.count.total > 1) {
                    $('[data-upload-progress]').html(number + '%' + ' ' + (opt.count.uploaded + 1) + '/' + opt.count.total);
                } else {
                    $('[data-upload-progress]').html(number + '%');
                }
            }, done: function (ret, idx) {
                /*! 检查单个文件上传返回的结果 */
                if (ret.code < 1) return $.msg.tips(ret.info || '文件上传失败！');
                if (typeof opt.cache[idx].xurl !== 'string') return $.msg.tips('无效的文件上传对象！');
                /*! 单个文件上传成功结果处理 */
                if (typeof callable === 'function') {
                    callable.call(opt.elem, opt.cache[idx].xurl, opt.cache['id']);
                } else if (opt.mult < 1 && opt.elem.data('input')) {
                    $(opt.elem.data('input')).val(opt.cache[idx].xurl).trigger('change', opt.cache[idx]);
                }
                opt.elem.html(opt.elem.data('html')).triggerHandler('upload.done', {file: opt.cache[idx], data: ret});
                /*! 所有文件上传完成后结果处理 */
                if (++opt.count.uploaded >= opt.count.total) {
                    opt.hide || $.msg.close(opt.load);
                    if (opt.mult > 0 && opt.elem.data('input')) {
                        var urls = opt.elem.data('input').value || [];
                        if (typeof urls === 'string') urls = urls.split('|');
                        for (var i in opt.cache) urls.push(opt.cache[i].xurl);
                        $(opt.elem.data('input')).val(urls.join('|')).trigger('change', opt.cache);
                    }
                    opt.elem.triggerHandler('upload.complete', {file: opt.cache});
                    (opt.cache = [], opt.files = [], opt.count = {uploaded: 0, total: 0}), opt.uploader.reload();
                }
            }
        });
    };

    function md5file(file) {
        var deferred = jQuery.Deferred();
        file.xext = file.name.indexOf('.') > -1 ? file.name.split('.').pop() : 'tmp';

        /*! 兼容不能计算文件 HASH 的情况 */
        var IsDate = '{$nameType|default=""}'.indexOf('date') > -1;
        if (!window.FileReader || IsDate) return jQuery.when((function (xmd5, chars) {
            while (xmd5.length < 32) xmd5 += chars.charAt(Math.floor(Math.random() * chars.length));
            return setFileXdata(file, xmd5, 6), deferred.resolve(file, file.xmd5, file.xkey), deferred;
        })(layui.util.toDateString(Date.now(), 'yyyyMMddHHmmss-'), '0123456789'));

        /*! 读取文件并计算 HASH 值 */
        var spark = new SparkMD5.ArrayBuffer();
        var slice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;
        file.chunkIdx = 0, file.chunkSize = 2097152, file.chunkTotal = Math.ceil(this.size / this.chunkSize);
        return jQuery.when(loadNextChunk(file));

        function setFileXdata(file, xmd5, slice) {
            file.xmd5 = xmd5, file.xkey = file.xmd5.substr(0, slice || 2) + '/' + file.xmd5.substr(slice || 2, 30) + '.' + file.xext;
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