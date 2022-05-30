define(['md5', 'notify'], function (SparkMD5, Notify, allowMime) {
    allowMime = JSON.parse('{$exts|raw}');

    function UploadAdapter(elem, done) {
        return new (function (elem, done, that) {

            /*! 初始化变量 */
            that = this;
            this.option = {elem: $(elem), exts: [], mimes: []};
            this.option.size = this.option.elem.data('size') || 0;
            this.option.safe = this.option.elem.data('safe') ? 1 : 0;
            this.option.hide = this.option.elem.data('hload') ? 1 : 0;
            this.option.mult = this.option.elem.data('multiple') > 0;
            this.option.type = this.option.safe ? 'local' : this.option.elem.attr('data-uptype') || '';
            this.option.quality = parseFloat(this.option.elem.data('quality') || '1.0');
            this.option.maxWidth = parseInt(this.option.elem.data('max-width') || '0');
            this.option.maxHeight = parseInt(this.option.elem.data('max-height') || '0');

            /*! 查找表单元素, 如果没有找到将不会自动写值 */
            if (!this.option.elem.data('input') && this.option.elem.data('field')) {
                this.$input = $('input[name="' + this.option.elem.data('field') + '"]:not([type=file])');
                this.option.elem.data('input', this.$input.size() > 0 ? this.$input.get(0) : null);
            }

            /*! 文件选择筛选，使用 MIME 规则过滤文件列表 */
            $((this.option.elem.data('type') || '').split(',')).map(function (i, e) {
                if (allowMime[e]) that.option.exts.push(e), that.option.mimes.push(allowMime[e]);
            });

            /*! 初始化上传组件 */
            this.adapter = new Adapter(this.option, layui.upload.render({
                url: '{:url("admin/api.upload/file")}', auto: false, elem: elem, accept: 'file', multiple: this.option.mult, exts: this.option.exts.join('|'), acceptMime: this.option.mimes.join(','), choose: function (object) {
                    object.files = object.pushFile();
                    layui.each(object.files, function (idx, file) {
                        file.quality = that.option.quality;
                        file.maxWidth = that.option.maxWidth;
                        file.maxHeight = that.option.maxHeight;
                    });
                    that.adapter.event('upload.choose', object.files);
                    that.adapter.upload(object.files, done);
                    layui.each(object.files, function (idx) {
                        delete object.files[idx];
                    });
                }
            }));
        })(elem, done)
    }

    // 创建对象
    UploadAdapter.adapter = window.AdminUploadAdapter = Adapter;

    // 上传文件
    function Adapter(option, uploader) {
        this.uploader = uploader, this.config = function (option) {
            return (this.option = Object.assign({}, this.option || {}, option || {})), this;
        }, this.init = function (option) {
            this.uploader && this.uploader.config.elem.next().val('');
            this.files = {}, this.loader = 0, this.count = {total: 0, error: 0, success: 0};
            return this.config(option).config({safe: this.option.safe || 0, type: this.option.type || ''});
        }, this.init(option);
    }

    // 文件推送
    Adapter.prototype.upload = function (files, done) {
        var that = this.init();
        layui.each(files, function (index, file) {
            that.count.total++, file.index = index, that.files[index] = file;
            if (that.option.size && file.size > that.option.size) {
                that.count.error++, file.xstate = -1, file.xstats = '大小超限';
                return $.msg.tips('文件大小超出限制！');
            }
            if (!that.option.hide) {
                file.notify = new NotifyExtend(file);
            }
        }), layui.each(files, function (index, file) {
            // 图片限宽限高压缩
            if (/^image\/*$/.test(file.type) && file.maxWidth > 0 || file.maxHeight > 0 || file.quality !== 1) {
                FileToBase64(file).then(function (base64) {
                    ImageToThumb(base64, file).then(function (base64) {
                        files[index] = Base64ToFile(base64, file.name);
                        files[index].notify = file.notify;
                        that.hash(files[index]).then(function (file) {
                            that.event('upload.hash', file).request(file, done);
                        });
                    });
                });
            } else {
                that.hash(file).then(function (file) {
                    that.event('upload.hash', file).request(file, done);
                });
            }
        });
    };

    // 文件上传
    Adapter.prototype.request = function (file, done) {
        var that = this, data = {key: file.xkey, safe: that.option.safe, uptype: that.option.type};
        data.size = file.size, data.name = file.name, data.hash = file.xmd5;
        jQuery.ajax("{:url('admin/api.upload/state')}", {
            data: data, method: 'post', success: function (ret) {
                file.xurl = ret.data.url, file.xsafe = ret.data.safe, file.xpath = ret.data.key, file.xtype = ret.data.uptype;
                if (parseInt(ret.code) === 404) {
                    var uploader = {};
                    uploader.url = ret.data.server;
                    uploader.form = new FormData();
                    uploader.form.append('key', ret.data.key);
                    uploader.form.append('safe', ret.data.safe);
                    uploader.form.append('uptype', ret.data.uptype);
                    if (ret.data.uptype === 'qiniu') {
                        uploader.form.append('token', ret.data.token);
                    } else if (ret.data.uptype === 'alioss') {
                        uploader.form.append('policy', ret.data['policy']);
                        uploader.form.append('signature', ret.data['signature']);
                        uploader.form.append('OSSAccessKeyId', ret.data['OSSAccessKeyId']);
                        uploader.form.append('success_action_status', '200');
                        uploader.form.append('Content-Disposition', 'inline;filename=' + encodeURIComponent(file.name));
                    } else if (ret.data.uptype === 'txcos') {
                        uploader.form.append('q-ak', ret.data['q-ak']);
                        uploader.form.append('policy', ret.data['policy']);
                        uploader.form.append('q-key-time', ret.data['q-key-time']);
                        uploader.form.append('q-signature', ret.data['q-signature']);
                        uploader.form.append('q-sign-algorithm', ret.data['q-sign-algorithm']);
                        uploader.form.append('success_action_status', '200');
                        uploader.form.append('Content-Disposition', 'inline;filename=' + encodeURIComponent(file.name));
                    } else if (ret.data.uptype === 'upyun') {
                        uploader.form.delete('key');
                        uploader.form.delete('safe');
                        uploader.form.delete('uptype');
                        uploader.form.append('save-key', ret.data['key']);
                        uploader.form.append('policy', ret.data['policy']);
                        uploader.form.append('authorization', ret.data['authorization']);
                        uploader.form.append('Content-Disposition', 'inline;filename=' + encodeURIComponent(file.name));
                    }
                    uploader.form.append('file', file), jQuery.ajax({
                        url: uploader.url, data: uploader.form, type: 'post', xhr: function (xhr) {
                            xhr = new XMLHttpRequest();
                            return xhr.upload.addEventListener('progress', function (event) {
                                file.xtotal = event.total, file.xloaded = event.loaded || 0;
                                that.progress((file.xloaded / file.xtotal * 100).toFixed(2), file)
                            }), xhr;
                        }, contentType: false, error: function () {
                            that.event('upload.error', {file: file}, file, '接口异常');
                        }, processData: false, success: function (ret) {
                            // 兼容数据格式
                            if (typeof ret === 'string' && ret.length > 0) try {
                                ret = JSON.parse(ret) || ret;
                            } catch (e) {
                                console.log(e)
                            }
                            if (typeof ret !== 'object') {
                                ret = {code: 1, url: file.xurl, info: '上传成功'};
                            }
                            /*! 检查单个文件上传返回的结果 */
                            if (typeof ret === 'object' && ret.code < 1) {
                                that.event('upload.error', {file: file}, file, ret.info || '上传失败');
                            } else {
                                that.done(ret, file.index, file, done, '上传成功');
                            }
                        }
                    });
                } else if (parseInt(ret.code) === 200) {
                    (file.xurl = ret.data.url), that.progress('100.00', file);
                    that.done({code: 1, url: file.xurl, info: file.xstats}, file.index, file, done, '秒传成功');
                } else {
                    that.event('upload.error', {file: file}, file, ret.info || ret.error.message || '上传出错！');
                }
            }
        });
    };

    // 上传进度
    Adapter.prototype.progress = function (number, file) {
        this.event('upload.progress', {number: number, file: file});
        if (file.notify) file.notify.setProgress(number);
    };

    // 上传结果
    Adapter.prototype.done = function (ret, idx, file, done, message) {
        /*! 检查单个文件上传返回的结果 */
        if (ret.code < 1) return $.msg.tips(ret.info || '文件上传失败！');
        if (typeof file.xurl !== 'string') return $.msg.tips('无效的文件上传对象！');
        /*! 单个文件上传成功结果处理 */
        if (typeof done === 'function') {
            done.call(this.option.elem, file.xurl, this.files['id']);
        } else if (this.option.mult < 1 && this.option.elem.data('input')) {
            $(this.option.elem.data('input')).val(file.xurl).trigger('change', file);
        }
        // 文件上传成功事件
        this.event('upload.done', {file: file, data: ret}, file, message);
        /*! 所有文件上传完成后结果处理 */
        if (this.count.success + this.count.error >= this.count.total) {
            this.option.hide || $.msg.close(this.loader);
            if (this.option.mult > 0 && this.option.elem.data('input')) {
                var urls = this.option.elem.data('input').value || [];
                if (typeof urls === 'string') urls = urls.split('|');
                for (var i in this.files) urls.push(this.files[i].xurl);
                $(this.option.elem.data('input')).val(urls.join('|')).trigger('change', files);
            }
            this.event('upload.complete', {file: this.files}, file).init().uploader && this.uploader.reload();
        }
    };

    /*! 触发事件过程 */
    Adapter.prototype.event = function (name, data, file, message) {
        if (name === 'upload.error') {
            this.count.error++, file.xstate = -1, file.xstats = message;
            if (file.notify) file.notify.setError(message || file.xstats || '');
        } else if (name === 'upload.done') {
            this.count.success++, file.xstate = 1, file.xstats = message;
            if (file.notify) file.notify.setSuccess(message || file.xstats || '')
        }
        if (this.option.elem) {
            this.option.elem.triggerHandler(name, data);
        }
        return this;
    };

    /**
     * 计算文件 HASH 值
     * @param {File} file 文件对象
     * @return {Promise}
     */
    Adapter.prototype.hash = function (file) {
        var defer = jQuery.Deferred();
        file.xext = file.name.indexOf('.') > -1 ? file.name.split('.').pop() : 'tmp';

        /*! 兼容不能计算文件 HASH 的情况 */
        var IsDate = '{$nameType|default=""}'.indexOf('date') > -1;
        if (!window.FileReader || IsDate) return jQuery.when((function (xmd5, chars) {
            while (xmd5.length < 32) xmd5 += chars.charAt(Math.floor(Math.random() * chars.length));
            return SetFileXdata(file, xmd5, 6), defer.promise();
        })(layui.util.toDateString(Date.now(), 'yyyyMMddHHmmss-'), '0123456789'));

        /*! 读取文件并计算 HASH 值 */
        return new LoadNextChunk(file).ReadAsChunk();

        function SetFileXdata(file, xmd5, slice) {
            file.xmd5 = xmd5, file.xstate = 0, file.xstats = '';
            file.xkey = file.xmd5.substring(0, slice || 2) + '/' + file.xmd5.substring(slice || 2) + '.' + file.xext;
            return defer.resolve(file, file.xmd5, file.xkey), file;
        }

        function LoadNextChunk(file) {
            var that = this, reader = new FileReader(), spark = new SparkMD5.ArrayBuffer();
            var slice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;
            this.chunkIdx = 0, this.chunkSize = 2097152, this.chunkTotal = Math.ceil(file.size / this.chunkSize);
            reader.onload = function (event) {
                spark.append(event.target.result);
                ++that.chunkIdx < that.chunkTotal ? that.ReadAsChunk() : SetFileXdata(file, spark.end());
            }, reader.onerror = function () {
                defer.reject();
            }, this.ReadAsChunk = function () {
                this.start = that.chunkIdx * that.chunkSize;
                this.loaded = this.start + that.chunkSize >= file.size ? file.size : this.start + that.chunkSize;
                reader.readAsArrayBuffer(slice.call(file, this.start, this.loaded));
                defer.notify(file, (this.loaded / file.size * 100).toFixed(2));
                return defer.promise();
            };
        }
    };

    return UploadAdapter;

    /**
     * Base64 转 File 对象
     * @param {String} base64 Base64内容
     * @param {String} filename 新文件名称
     * @return {File}
     */
    function Base64ToFile(base64, filename) {
        var arr = base64.split(',');
        var mime = arr[0].match(/:(.*?);/)[1], suffix = mime.split('/')[1];
        var bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while (n--) u8arr[n] = bstr.charCodeAt(n);
        return new File([u8arr], filename + '.' + suffix, {type: mime});
    }

    /**
     * File 对象转 Base64
     * @param {File} file 文件对象
     * @return {Promise}
     */
    function FileToBase64(file) {
        var defer = jQuery.Deferred(), reader = new FileReader();
        return (reader.onload = function () {
            defer.resolve(this.result);
        }), reader.readAsDataURL(file), defer.promise();
    }

    /**
     * 图片压缩处理
     * @param {String} url 图片链接
     * @param {Object} option 压缩参数
     * @return {Promise}
     */
    function ImageToThumb(url, option) {
        var defer = jQuery.Deferred(), image = new Image();
        image.src = url, image.onload = function () {
            var canvas = document.createElement('canvas'), context = canvas.getContext('2d');
            option.maxWidth = option.maxWidth || this.width, option.maxHeight = option.maxHeight || this.height;
            var originWidth = this.width, originHeight = this.height, targetWidth = originWidth, targetHeight = originHeight;
            if (originWidth > option.maxWidth || originHeight > option.maxHeight) {
                if (originWidth / option.maxWidth > option.maxWidth / option.maxHeight) {
                    targetWidth = option.maxWidth;
                    targetHeight = Math.round(option.maxWidth * (originHeight / originWidth));
                } else {
                    targetHeight = option.maxHeight;
                    targetWidth = Math.round(option.maxHeight * (originWidth / originHeight));
                }
            }
            canvas.width = targetWidth, canvas.height = targetHeight;
            context.clearRect(0, 0, targetWidth, targetHeight);
            context.drawImage(this, 0, 0, targetWidth, targetHeight);
            defer.resolve(canvas.toDataURL('image/jpeg', option.quality || 0.9));
        };
        return defer.promise();
    }

    /**
     * 上传状态提示扩展插件
     * @param {File} file 文件对象
     * @constructor
     */
    function NotifyExtend(file) {
        var that = this;
        this.notify = Notify.notify({width: 260, title: file.name, showProgress: true, description: '上传进度 <span data-upload-progress>0%</span>', type: 'default', position: 'top-right', closeTimeout: 0});
        this.$elem = $(this.notify.notification.nodes);
        this.$elem.find('.growl-notification__progress').addClass('is-visible');
        this.$elem.find('.growl-notification__progress-bar').addClass('transition');
        this.setProgress = function (number) {
            this.$elem.find('[data-upload-progress]').html(number + '%');
            this.$elem.find('.growl-notification__progress-bar').css({width: number + '%'});
            return this;
        }, this.setError = function (message) {
            this.$elem.find('.growl-notification__desc').html(message || '文件上传失败！');
            this.$elem.removeClass('growl-notification--default').addClass('growl-notification--error')
            return this.close();
        }, this.setSuccess = function (message) {
            this.setProgress('100.00');
            this.$elem.find('.growl-notification__desc').html(message || '文件上传成功！');
            this.$elem.removeClass('growl-notification--default').addClass('growl-notification--success');
            return this.close();
        }, this.close = function (timeout) {
            return setTimeout(function () {
                that.notify.close();
            }, timeout || 2000), this;
        };
    }
});