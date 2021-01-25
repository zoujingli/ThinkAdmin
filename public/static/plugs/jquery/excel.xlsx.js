define(['xlsx'], function () {

    function excel(data, filename, sheetname) {
        this.name = sheetname || 'sheet1';
        this.work = {SheetNames: [this.name], Sheets: {}};
        this.work.Sheets[this.name] = XLSX.utils.aoa_to_sheet(data);
        if (filename.substr(-5).toLowerCase() !== '.xlsx') filename += '.xlsx';
        XLSX.writeFile(this.work, filename);
    }

    /*! 绑定导出的事件 */
    excel.bind = function (done, filename) {
        $('body').off('click', '[data-form-export]').on('click', '[data-form-export]', function () {
            var form = $(this).parents('form');
            var method = this.dataset.method || form.attr('method') || 'get';
            var location = this.dataset.excel || this.dataset.formExport || form.attr('action') || '';
            excel.load(location, form.serialize(), done, this.dataset.filename || filename, method);
        });
    };

    /*! 加载导出的文档 */
    excel.load = function (url, data, done, name, method) {
        var alldata = [];
        var loading = $.msg.loading('正在加载 <span data-upload-page></span>，完成 <span data-upload-progress>0</span>%');
        nextPage(1, 1);

        function nextPage(curPage, maxPage) {
            if (curPage > maxPage) {
                if (typeof done === 'function') {
                    if ((this.result = done(alldata)) !== false) {
                        excel(this.result, name || '文件下载.xlsx');
                    } else {
                        console.log('格式化函数返回`false`，已终止数据导出操作', alldata, this.result);
                    }
                } else {
                    console.log('格式化函数未绑定，已终止数据导出操作', alldata);
                }
                $.msg.close(loading);
            } else {
                $('[data-upload-page]').html(curPage + ' / ' + maxPage);
                $('[data-upload-progress]').html((curPage / maxPage * 100).toFixed(2));
                $.form.load(url + (url.indexOf('?') > -1 ? '&' : '?') + 'output=json&page=' + curPage, data, method || 'get', function (ret) {
                    if (ret.code) {
                        alldata = alldata.concat(ret.data.list);
                        return nextPage((ret.data.page.current || 1) + 1, ret.data.page.pages || 1), false;
                    }
                }, false);
            }
        }
    };

    /*! 读取本地的表格文件 */
    excel.read = function (file, filterCallback) {
        return (function (defer, reader, loaded, Work) {
            reader.onload = function (event) {
                Work = XLSX.read(event.target.result, {type: 'binary'});
                for (var sheet in Work.Sheets) if (Work.Sheets.hasOwnProperty(sheet)) {
                    var object = {}, data = Work.Sheets[sheet], k = '', as = '';
                    console.log(data)
                    for (k in data) if ((as = k.match(/^([A-Z]+)(\d+)$/i))) {
                        object[as[2]] = object[as[2]] || {};
                        object[as[2]][as[1]] = excel.read.CellToValue(data[k].v);
                    }
                    jQuery.msg.close(loaded);
                    return defer.resolve(filterCallback ? excel.read.filter(object, filterCallback) : object);
                }
                jQuery.msg.close(loaded)
            };
            reader.onerror = function () {
                defer.reject('读取文件失败');
            };
            reader.onprogress = function (event) {
                defer.notify((event.loaded / event.total).toFixed(4) * 100);
            };
            if (typeof file === 'object') {
                return reader.readAsBinaryString(file), defer.promise();
            } else {
                defer.reject('只能读取 file 文件对象');
                return defer.promise();
            }
        })(jQuery.Deferred(), new FileReader());
    };

    /*! 表格单元内容转换 */
    excel.read.CellToValue = function (v) {
        if (typeof v !== 'undefined' && /^\d+\.\d{12}$/.test(v)) {
            var d = XLSX.SSF.parse_date_code(v);
            return d.y + '-' + d.m + '-' + d.d + ' ' + d.H + ':' + d.M + ':' + d.S;
        } else {
            return typeof v !== 'undefined' ? v : '';
        }
    }

    /*! 直接推送表格内容 */
    excel.read.push = function (url, filterCf, filterFn) {
        return (function (defer, $input, loaded) {
            $input.appendTo($('body')).click();
            $input.on('change', function (event) {
                if (!event.target.files || event.target.files.length < 1) return $.msg.tips('没有可操作文件');
                loaded = jQuery.msg.loading('<span data-load-name>读取</span> <span data-load-count>0.00%</span>');
                excel.read(event.target.files[0], filterCf).then(function (items, total, ers, oks, idx) {
                    if ((total = items.length) < 1) return closeAll(), jQuery.msg.tips('未读取到有效数据')
                    ers = 0, oks = 0, idx = 0;
                    jQuery('[data-load-name]').html('更新数据 ');
                    doPostItem(idx, items[idx]);

                    /*! 执行导入的数据 */
                    function doPostItem(idx, item, info, result) {
                        if (idx >= total) {
                            info = '共处理' + total + '条记录' + '（ 成功 ' + oks + ' 条, 失败 ' + ers + ' 条 ）';
                            return closeAll(), jQuery.msg.success(info, 3, function () {
                                jQuery.form.reload();
                            });
                        } else {
                            info = (idx * 100 / total).toFixed(2) + '%（ 成功 ' + oks + ' 条, 失败 ' + ers + ' 条 ）';
                            jQuery('[data-load-count]').html(info);
                            /*! 单元数据过滤 */
                            result = item;
                            if (filterFn && (result = filterFn(item)) === false) {
                                return (ers++), doPostItem(idx + 1, items[idx + 1]);
                            }
                            /*! 提交单个数据 */
                            doUpdate(url, result).then(function (ret) {
                                ret.code ? oks++ : ers++;
                                doPostItem(idx + 1, items[idx + 1]);
                            });
                        }
                    }
                }).progress(function (progress) {
                    jQuery('[data-load-count]').html(progress + '%')
                }).fail(function () {
                    closeAll();
                });
            });
            return defer;

            /*! 清理文件选择器 */
            function closeAll() {
                $input.remove();
                jQuery.msg.close(loaded);
            }

            /*! 队列方式上传数据 */
            function doUpdate(url, item) {
                return (function (defer) {
                    return jQuery.form.load(url, item, 'post', function (ret) {
                        return defer.resolve(ret), false;
                    }, false), defer.promise();
                })(jQuery.Deferred());
            }
        })(jQuery.Deferred(), $('<input class="layui-hide" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">'));
    }

    /*! 解析读取的数据 */
    excel.read.filter = function (data, cols) {
        return (function (items, item, r, c, k) {
            for (r in data) if (r <= 1) {
                for (c in data[r]) for (k in cols) {
                    if (data[r][c] === cols[k].name && !cols[k].bind) cols[k].bind = c;
                }
            } else {
                item = {};
                for (k in cols) item[k] = excel.read.CellToValue(data[r][cols[k].bind]);
                items.push(item);
            }
            return items
        })([]);
    }

    return excel;
});