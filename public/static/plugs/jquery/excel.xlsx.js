define(function () {

    /*! 定义构造函数 */
    function Excel(data, name) {
        if (data && name) this.export(data, name);
    }

    /*! 默认导出配置 */
    Excel.prototype.options = {writeOpt: {bookSST: true}};

    /*! 导出 Excel 文件 */
    Excel.prototype.export = function (data, name) {
        if (name.substring(0, -5).toLowerCase() !== '.xlsx') name += '.xlsx';
        layui.excel.exportExcel(data, name, 'xlsx', this.options || {writeOpt: {bookSST: true}});
    };

    /*! 绑定导出的事件 */
    Excel.prototype.bind = function (done, filename) {
        var that = this;
        this.options = {}; // {writeOpt: {bookSST: true}};
        $('body').off('click', '[data-form-export]').on('click', '[data-form-export]', function () {
            var form = $(this).parents('form');
            var name = this.dataset.filename || filename;
            var method = this.dataset.method || form.attr('method') || 'get';
            var location = this.dataset.excel || this.dataset.formExport || form.attr('action') || '';
            var sortType = $(this).attr('data-sort-type') || '', sortField = $(this).attr('data-sort-field') || '';
            if (sortField.length > 0 && sortType.length > 0) {
                location += (location.indexOf('?') > -1 ? '&' : '?') + '_order_=' + sortType + '&_field_=' + sortField;
            }
            that.load(location, form.serialize(), method).then(function (ret) {
                that.export(done.call(that, ret, []), name);
            }).fail(function (ret) {
                $.msg.tips(ret || '文件导出失败');
            });
        });
    };

    /*! 加载导出的文档 */
    Excel.prototype.load = function (url, data, method) {
        return (function (defer, lists, loaded) {
            loaded = $.msg.loading("正在加载 <span data-upload-count>0.00</span>%");
            return (lists = []), LoadNextPage(1, 1), defer;

            function LoadNextPage(curPage, maxPage, urlParams) {
                var proc = (curPage / maxPage * 100).toFixed(2);
                $('[data-upload-count]').html(proc > 100 ? '100.00' : proc);
                if (curPage > maxPage) return $.msg.close(loaded), defer.resolve(lists);
                urlParams = (url.indexOf('?') > -1 ? '&' : '?') + 'output=json&not_cache_limit=1&limit=100&page=' + curPage;
                $.form.load(url + urlParams, data, method, function (ret) {
                    if (ret.code) {
                        lists = lists.concat(ret.data.list);
                        if (ret.data.page) LoadNextPage((ret.data.page.current || 1) + 1, ret.data.page.pages || 1);
                    } else {
                        defer.reject('数据加载异常');
                    }
                    return false;
                }, false);
            }
        })($.Deferred());
    };

    /*! 直接推送表格内容 */
    Excel.prototype.push = function (url, sheet, cols, filter) {
        var loaded, $input;
        $input = $('<input class="layui-hide" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">');
        $input.appendTo($('body')).click().on('change', function (event) {
            if (!event.target.files || event.target.files.length < 1) return $.msg.tips('没有可操作文件');
            loaded = $.msg.loading('<span data-load-name>读取</span> <span data-load-count>0.00%</span>');
            try {
                // 导入Excel数据，并逐行上传处理
                layui.excel.importExcel(event.target.files, {}, function (data) {
                    if (!data[0][sheet]) return $.msg.tips('未读取到表[' + sheet + ']的数据');
                    var _cols = {}, _data = data[0][sheet], items = [], row, col, key, item;
                    for (row in _data) if (parseInt(row) + 1 === parseInt(cols._ || '1')) {
                        for (col in _data[row]) for (key in cols) if (_data[row][col] === cols[key]) _cols[key] = col;
                    } else if (parseInt(row) + 1 > cols._ || 1) {
                        item = {};
                        for (key in _cols) item[key] = CellToValue(_data[row][_cols[key]]);
                        items.push(item);
                    }
                    PushQueue(items, items.length, 0, 0, 1);
                });
            } catch (e) {
                $.msg.error('读取 Excel 文件失败！')
            }
        });

        /*! 单项推送数据 */
        function PushQueue(items, total, ers, oks, idx) {
            if ((total = items.length) < 1) return CleanAll(), $.msg.tips('未读取到有效数据');
            return (ers = 0, oks = 0, idx = 0), $('[data-load-name]').html('更新'), DoPostItem(idx, items[idx]);

            /*! 执行导入的数据 */
            function DoPostItem(idx, item, data) {
                if (idx >= total) {
                    return CleanAll(), $.msg.success('共处理' + total + '条记录（ 成功 ' + oks + ' 条, 失败 ' + ers + ' 条 ）', 3, function () {
                        $.form.reload();
                    });
                } else {
                    var proc = (idx * 100 / total).toFixed(2);
                    $('[data-load-count]').html((proc > 100 ? '100.00' : proc) + '%（ 成功 ' + oks + ' 条, 失败 ' + ers + ' 条 ）');
                    /*! 单元数据过滤 */
                    data = item;
                    if (filter && (data = filter(item)) === false) {
                        return (ers++), DoPostItem(idx + 1, items[idx + 1]);
                    }
                    /*! 提交单个数据 */
                    DoUpdate(url, data).then(function (ret) {
                        (ret.code ? oks++ : ers++), DoPostItem(idx + 1, items[idx + 1]);
                    });
                }
            }
        }

        /*! 清理文件选择器 */
        function CleanAll() {
            $input.remove();
            if (loaded) $.msg.close(loaded);
        }

        /*! 表格单元内容转换 */
        function CellToValue(v) {
            if (typeof v !== 'undefined' && /^\d+\.\d{12}$/.test(v)) {
                return LAY_EXCEL.dateCodeFormat(v, 'YYYY-MM-DD HH:ii:ss');
            } else {
                return typeof v !== 'undefined' ? v : '';
            }
        }

        /*! 队列方式上传数据 */
        function DoUpdate(url, item) {
            return (function (defer) {
                return $.form.load(url, item, 'post', function (ret) {
                    return defer.resolve(ret), false;
                }, false), defer.promise();
            })($.Deferred());
        }
    }

    /*! 返回对象实例 */
    return new Excel;
});