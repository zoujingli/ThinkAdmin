define(function () {

    /*! 下载 Excel 文件 */
    function excel(data, name) {
        if (name.substr(-5).toLowerCase() !== '.xlsx') {
            name += '.xlsx';
        }
        layui.excel.exportExcel(data, name, 'xlsx')
    }

    /*! 绑定导出的事件 */
    excel.bind = function (done, filename) {
        $('body').off('click', '[data-form-export]').on('click', '[data-form-export]', function () {
            var form = $(this).parents('form');
            var name = this.dataset.filename || filename;
            var method = this.dataset.method || form.attr('method') || 'get';
            var location = this.dataset.excel || this.dataset.formExport || form.attr('action') || '';
            excel.load(location, form.serialize(), method).then(function (ret) {
                excel(done(ret), name);
            }).fail(function (ret) {
                $.msg.tips(ret || '文件导出失败');
            });
        });
    };

    /*! 加载导出的文档 */
    excel.load = function (url, data, method) {
        return (function (defer, lists, loaded) {
            loaded = $.msg.loading("正在加载 <span data-upload-count>0.00</span>%");
            return (lists = []), LoadNextPage(1, 1), defer;

            function LoadNextPage(curPage, maxPage, urlParams) {
                $('[data-upload-count]').html((curPage / maxPage * 100).toFixed(2));
                if (curPage > maxPage) return $.msg.close(loaded), defer.resolve(lists);
                urlParams = (url.indexOf('?') > -1 ? '&' : '?') + 'output=json&not_cache_limit=1&limit=100&page=' + curPage;
                $.form.load(url + urlParams, data, method, function (ret) {
                    if (ret.code) {
                        lists = lists.concat(ret.data.list);
                        if (ret.data.page) {
                            LoadNextPage((ret.data.page.current || 1) + 1, ret.data.page.pages || 1);
                        }
                    } else {
                        defer.reject('数据加载异常');
                    }
                    return false;
                }, false);
            }
        })($.Deferred());
    };

    /*! 读取本地的表格文件 */
    excel.read = function (file, filterCallback) {
        return (function (defer, reader, loaded, Work) {
            reader.onload = function (event) {
                Work = XLSX.read(event.target.result, {type: 'binary'});
                for (var sheet in Work.Sheets) if (Work.Sheets.hasOwnProperty(sheet)) {
                    var object = {}, data = Work.Sheets[sheet], k = '', as = '';
                    for (k in data) if ((as = k.match(/^([A-Z]+)(\d+)$/i))) {
                        object[as[2]] = object[as[2]] || {};
                        object[as[2]][as[1]] = excel.read.CellToValue(data[k].v);
                    }
                    $.msg.close(loaded);
                    return defer.resolve(filterCallback ? excel.read.filter(object, filterCallback) : object);
                }
                $.msg.close(loaded)
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
        })($.Deferred(), new FileReader());
    };

    /*! 直接推送表格内容 */
    excel.read.push = function (url, filterCf, filterFn) {
        return (function (defer, $input, loaded) {
            $input.appendTo($('body')).click();
            $input.on('change', function (event) {
                if (!event.target.files || event.target.files.length < 1) return $.msg.tips('没有可操作文件');
                loaded = $.msg.loading('<span data-load-name>读取</span> <span data-load-count>0.00%</span>');
                excel.read(event.target.files[0], filterCf).then(function (items, total, ers, oks, idx) {
                    if ((total = items.length) < 1) return cleanAll(), $.msg.tips('未读取到有效数据');
                    return (ers = 0, oks = 0, idx = 0), $('[data-load-name]').html('更新'), doPostItem(idx, items[idx]);

                    /*! 执行导入的数据 */
                    function doPostItem(idx, item, data) {
                        if (idx >= total) {
                            return cleanAll(), $.msg.success('共处理' + total + '条记录（ 成功 ' + oks + ' 条, 失败 ' + ers + ' 条 ）', 3, function () {
                                $.form.reload();
                            });
                        } else {
                            $('[data-load-count]').html((idx * 100 / total).toFixed(2) + '%（ 成功 ' + oks + ' 条, 失败 ' + ers + ' 条 ）');
                            /*! 单元数据过滤 */
                            data = item;
                            if (filterFn && (data = filterFn(item)) === false) {
                                return (ers++), doPostItem(idx + 1, items[idx + 1]);
                            }
                            /*! 提交单个数据 */
                            doUpdate(url, data).then(function (ret) {
                                (ret.code ? oks++ : ers++), doPostItem(idx + 1, items[idx + 1]);
                            });
                        }
                    }
                }).progress(function (progress) {
                    $('[data-load-count]').html(progress + '%')
                }).fail(function () {
                    cleanAll();
                });
            });
            return defer;

            /*! 清理文件选择器 */
            function cleanAll() {
                $input.remove(), $.msg.close(loaded);
            }

            /*! 队列方式上传数据 */
            function doUpdate(url, item) {
                return (function (defer) {
                    return $.form.load(url, item, 'post', function (ret) {
                        return defer.resolve(ret), false;
                    }, false), defer.promise();
                })($.Deferred());
            }
        })($.Deferred(), $('<input class="layui-hide" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">'));
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

    /*! 表格单元内容转换 */
    excel.read.CellToValue = function (v) {
        if (typeof v !== 'undefined' && /^\d+\.\d{12}$/.test(v)) {
            return LAY_EXCEL.dateCodeFormat(v, 'YYYY-MM-DD HH:ii:ss');
        } else {
            return typeof v !== 'undefined' ? v : '';
        }
    }

    return excel;
});