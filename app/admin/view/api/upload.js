define(['md5', 'notify'], function (SparkMD5, Notify, allowMime) {
    allowMime = JSON.parse('{$exts|raw}');

    function UploadAdapter(elem, done) {
        return new (function (elem, done) {
            let that = this;

            /*! 初始化变量 */
            this.option = {elem: $(elem), exts: [], mimes: []};
            this.option.size = this.option.elem.data('size') || 0;
            this.option.safe = this.option.elem.data('safe') ? 1 : 0;
            this.option.hide = this.option.elem.data('hload') ? 1 : 0;
            this.option.mult = this.option.elem.data('multiple') > 0;
            this.option.path = (this.option.elem.data('path') || '').replace(/\W/g, '');
            this.option.type = this.option.safe ? 'local' : this.option.elem.attr('data-uptype') || '';
            this.option.quality = parseFloat(this.option.elem.data('quality') || '1.0');
            this.option.maxWidth = parseInt(this.option.elem.data('max-width') || '0');
            this.option.maxHeight = parseInt(this.option.elem.data('max-height') || '0');
            this.option.cutWidth = parseInt(this.option.elem.data('cut-width') || '0');
            this.option.cutHeight = parseInt(this.option.elem.data('cut-height') || '0');

            /*! 查找表单元素, 如果没有找到将不会自动写值 */
            if (this.option.elem.data('input')) {
                this.option.input = $(this.option.elem.data('input'))
            } else if (this.option.elem.data('field')) {
                this.option.input = $('input[name="' + this.option.elem.data('field') + '"]:not([type=file])');
                this.option.elem.data('input', this.option.input.length > 0 ? this.option.input.get(0) : null);
            }

            /*! 文件选择筛选，使用 MIME 规则过滤文件列表 */
            $((this.option.elem.data('type') || '').split(',')).map(function (i, e) {
                if (allowMime[e]) that.option.exts.push(e), that.option.mimes.push(allowMime[e]);
            });

            /*! 初始化上传组件 */
            this.adapter = new Adapter(this.option, layui.upload.render({
                url: '{:url("admin/api.upload/file",[],false,true)}', auto: false, elem: elem, accept: 'file', multiple: this.option.mult, exts: this.option.exts.join('|'), acceptMime: this.option.mimes.join(','), choose: function (obj) {
                    obj.items = [], obj.files = obj.pushFile();
                    layui.each(obj.files, function (idx, file) {
                        obj.items.push(file);
                        file.path = that.option.path;
                        file.quality = that.option.quality;
                        file.maxWidth = that.option.maxWidth;
                        file.maxHeight = that.option.maxHeight;
                        file.cutWidth = that.option.cutWidth;
                        file.cutHeight = that.option.cutHeight;
                    });
                    that.adapter.event('upload.choose', obj.items);
                    that.adapter.upload(obj.items, done);
                    layui.each(obj.files, function (idx) {
                        delete obj.files[idx];
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
        let that = this.init();
        layui.each(files, function (index, file) {
            that.count.total++, file.index = index, that.files[index] = file;
            if (!that.option.hide && !file.notify) {
                file.notify = new NotifyExtend(file);
            }
            if (that.option.size && file.size > that.option.size) {
                that.event('upload.error', {file: file}, file, '{:lang("大小超出限制！")}');
            }
        });
        layui.each(files, function (index, file) {
            // 禁传异常状态文件
            if (typeof file.xstate === 'number' && file.xstate === -1) return;
            // 图片限宽限高压缩
            let isGif = /^image\/gif/.test(file.type);
            if (!isGif && /^image\//.test(file.type) && (file.maxWidth + file.maxHeight + file.cutWidth + file.cutHeight > 0 || file.quality !== 1)) {
                require(['compressor'], function (Compressor) {
                    let options = {quality: file.quality, resize: 'cover'};
                    if (file.cutWidth) options.width = file.cutWidth;
                    if (file.cutHeight) options.height = file.cutHeight;
                    if (file.maxWidth) options.maxWidth = file.maxWidth;
                    if (file.maxHeight) options.maxHeight = file.maxHeight;
                    new Compressor(file, Object.assign(options, {
                        success(blob) {
                            blob.index = file.index, blob.notify = file.notify, blob.path = file.path, files[index] = blob;
                            that.hash(files[index]).then(function (file) {
                                that.event('upload.hash', file).request(file, done);
                            });
                        }, error: function () {
                            that.event('upload.error', {file: file}, file, '{:lang("图片压缩失败！")}');
                        }
                    }));
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
        let that = this, data = {key: file.xkey, safe: that.option.safe, uptype: that.option.type};
        data.size = file.size, data.name = file.name, data.hash = file.xmd5, data.mime = file.type, data.xext = file.xext;
        jQuery.ajax("{:url('admin/api.upload/state',[],false,true)}", {
            data: data, method: 'post', success: function (ret) {
                file.id = ret.data.id || 0, file.xurl = ret.data.url;
                file.xsafe = ret.data.safe, file.xpath = ret.data.key, file.xtype = ret.data.uptype;
                if (parseInt(ret.code) === 404) {
                    let uploader = {};
                    uploader.uptype = ret.data.uptype;
                    uploader.url = ret.data.server;
                    uploader.head = {};
                    uploader.form = new FormData();
                    uploader.form.append('key', ret.data.key);
                    uploader.form.append('safe', ret.data.safe);
                    uploader.form.append('uptype', ret.data.uptype);
                    if (ret.data.uptype === 'qiniu') {
                        uploader.form.append('token', ret.data.token);
                    } else if (ret.data.uptype === 'alist') {
                        uploader.type = 'put';
                        uploader.head['file-path'] = ret.data['filepath'];
                        uploader.head['authorization'] = ret.data['authorization'];
                        uploader.form = new FormData();
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
                    uploader.form.append('file', file, file.name), jQuery.ajax({
                        xhrFields: {withCredentials: ret.data.uptype === 'local'}, headers: uploader.head, url: uploader.url, data: uploader.form, type: uploader.type || 'post', xhr: function (xhr) {
                            xhr = new XMLHttpRequest();
                            return xhr.upload.addEventListener('progress', function (event) {
                                file.xtotal = event.total, file.xloaded = event.loaded || 0;
                                that.progress((file.xloaded / file.xtotal * 100).toFixed(2), file)
                            }), xhr;
                        }, contentType: false, error: function () {
                            that.event('upload.error', {file: file}, file, '{:lang("上传接口异常！")}');
                        }, processData: false, success: function (ret) {
                            // 兼容数据格式
                            if (typeof ret === 'string' && ret.length > 0) try {
                                ret = JSON.parse(ret) || ret;
                            } catch (e) {
                                console.log(e)
                            }
                            if (typeof ret !== 'object') {
                                ret = {code: 1, url: file.xurl, info: '{:lang("文件上传成功！")}'};
                            }
                            /*! 检查单个文件上传返回的结果 */
                            if (typeof ret === 'object' && ret.code < 1) {
                                that.event('upload.error', {file: file}, file, ret.info || '{:lang("文件上传失败！")}');
                            } else if (uploader.uptype === 'alist' && parseInt(ret.code) !== 200) {
                                that.event('upload.error', {file: file}, file, ret.message || '{:lang("文件上传失败！")}');
                            } else {
                                that.done(ret, file.index, file, done, '{:lang("文件上传成功！")}');
                            }
                        }
                    });
                } else if (parseInt(ret.code) === 200) {
                    (file.xurl = ret.data.url), that.progress('100.00', file);
                    that.done({code: 1, url: file.xurl, info: file.xstats, data: {code: 200, url: file.xurl}}, file.index, file, done, '{:lang("文件秒传成功！")}');
                } else {
                    that.event('upload.error', {file: file}, file, ret.info || ret.error.message || '{:lang("文件上传出错！")}');
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
        if (ret.code < 1) return $.msg.tips(ret.info || '{:lang("文件上传失败！")}');
        if (typeof file.xurl !== 'string') return $.msg.tips('{:lang("无效的文件上传对象！")}');
        jQuery.post("{:url('admin/api.upload/done',[],false,true)}", {id: file.id, hash: file.xmd5});
        /*! 单个文件上传成功结果处理 */
        if (typeof done === 'function') {
            done.call(this.option.elem, file.xurl, this.files['id']);
        } else if (this.option.mult < 1 && this.option.elem.data('input')) {
            $(this.option.elem.data('input')).val(file.xurl).trigger('change', file);
        }
        // 文件上传成功事件
        this.event('push', file.xurl).event('upload.done', {file: file, data: ret}, file, message);
        /*! 所有文件上传完成后结果处理 */
        if (this.count.success + this.count.error >= this.count.total) {
            this.option.hide || $.msg.close(this.loader);
            if (this.option.mult > 0 && this.option.elem.data('input')) {
                let urls = this.option.elem.data('input').value || [];
                if (typeof urls === 'string') urls = urls.split('|');
                for (let i in this.files) urls.push(this.files[i].xurl);
                $(this.option.elem.data('input')).val(urls.join('|')).trigger('change', this.files);
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
            if (this.option.input) this.option.input.triggerHandler(name, data);
        }
        return this;
    };

    /**
     * 计算文件 HASH 值
     * @param {File} file 文件对象
     * @return {Promise}
     */
    Adapter.prototype.hash = function (file) {
        let defer = jQuery.Deferred();
        file.xext = file.name.indexOf('.') > -1 ? file.name.split('.').pop() : 'tmp';

        /*! 兼容不能计算文件 HASH 的情况 */
        let IsDate = '{$nameType|default=""}'.indexOf('date') > -1;
        if (!window.FileReader || IsDate) return jQuery.when((function (xmd5, chars) {
            while (xmd5.length < 32) xmd5 += chars.charAt(Math.floor(Math.random() * chars.length));
            return SetFileXdata(file, xmd5, 6), defer.promise();
        })(layui.util.toDateString(Date.now(), 'yyyyMMddHHmmss-'), '0123456789'));

        /*! 读取文件并计算 HASH 值 */
        return new LoadNextChunk(file).ReadAsChunk();

        function SetFileXdata(file, xmd5, slice) {
            file.xmd5 = xmd5, file.xstate = 0, file.xstats = '';
            file.xkey = file.xmd5.substring(0, slice || 2) + '/' + file.xmd5.substring(slice || 2) + '.' + file.xext;
            if (file.path) file.xkey = file.path + '/' + file.xkey;
            return defer.resolve(file, file.xmd5, file.xkey), file;
        }

        function LoadNextChunk(file) {
            let that = this, reader = new FileReader(), spark = new SparkMD5.ArrayBuffer();
            let slice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice;
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
     * 上传状态提示扩展插件
     * @param {File} file 文件对象
     * @constructor
     */
    function NotifyExtend(file) {
        let that = this, message = "{:lang('上传进度 %s', ['<span data-upload-progress>0%</span>'])}";
        this.notify = Notify.notify({width: 260, title: file.name, showProgress: true, description: message, type: 'default', position: 'top-right', closeTimeout: 0});
        this.$elem = $(this.notify.notification.nodes);
        this.$elem.find('.growl-notification__progress').addClass('is-visible');
        this.$elem.find('.growl-notification__progress-bar').addClass('transition');
        this.setProgress = function (number) {
            this.$elem.find('[data-upload-progress]').html(number + '%');
            this.$elem.find('.growl-notification__progress-bar').css({width: number + '%'});
            return this;
        }, this.setError = function (message) {
            this.$elem.find('.growl-notification__desc').html(message || '{:lang("文件上传失败！")}');
            this.$elem.removeClass('growl-notification--default').addClass('growl-notification--error')
            return this.close();
        }, this.setSuccess = function (message) {
            this.setProgress('100.00');
            this.$elem.find('.growl-notification__desc').html(message || '{:lang("文件上传成功！")}');
            this.$elem.removeClass('growl-notification--default').addClass('growl-notification--success');
            return this.close();
        }, this.close = function (timeout) {
            return setTimeout(function () {
                that.notify.close();
            }, timeout || 2000), this;
        };
    }
});