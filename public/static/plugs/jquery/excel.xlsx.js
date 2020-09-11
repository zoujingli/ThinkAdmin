define(['xlsx'], function () {

    function excel(data, filename, sheetname) {
        this.name = sheetname || 'sheet1';
        this.sheet = XLSX.utils.aoa_to_sheet(data);
        if (filename.substr(-5).toLowerCase() !== '.xlsx') {
            filename += '.xlsx';
        }
        openDownloadDialog(sheet2blob(this.sheet, this.name), filename);
    }

    excel.bind = function (done, filename) {
        $('body').off('click', '[data-form-export]').on('click', '[data-form-export]', function () {
            var form = $(this).parents('form');
            var method = $(this).attr('data-method') || 'get';
            var location = $(this).attr('data-form-export') || form.get(0).action || '';
            excel.load(location, form.serialize(), done, filename, method);
        })
    };

    excel.load = function (url, data, done, filename, method) {
        var alldata = [];
        var loading = $.msg.loading('正在加载 <span data-upload-page></span>，完成<span data-upload-progress>0</span>%');
        nextPage(1, 1);

        function nextPage(curPage, maxPage) {
            if (curPage > maxPage) {
                if (typeof done === 'function') {
                    this.result = done(alldata);
                    if (this.result !== false) {
                        excel(this.result, filename || '文件下载.xlsx');
                    } else {
                        console.log('格式化函数返回`false`，已终止数据导出操作', alldata, this.result);
                    }
                } else {
                    console.log('格式化函数未绑定，已终止数据导出操作', alldata);
                }
                $.msg.close(loading);
            } else {
                $('[data-upload-page]').html(curPage + '/' + maxPage);
                $('[data-upload-progress]').html((curPage / maxPage * 100).toFixed(2));
                $.form.load(url + (url.indexOf('?') > -1 ? '&' : '?') + 'output=json&page=' + curPage, data, method || 'get', function (ret) {
                    if (ret.code) {
                        alldata = alldata.concat(ret.data.list);
                        return nextPage((ret.data.page.current || 1) + 1, ret.data.page.pages || 1), false;
                    }
                }, false);
            }
        }
    }

    return excel;

    /*! Sheet 转下载对象 */
    function sheet2blob(sheet, name) {
        this.workbook = {SheetNames: [name], Sheets: {}};
        this.workbook.Sheets[name] = sheet;
        this.content = XLSX.write(this.workbook, {
            type: 'binary', bookSST: false, bookType: 'xlsx',
        });
        return new Blob([toArrayBuffer(this.content)], {
            type: "application/octet-stream"
        });
    }

    /*! 字符串转 ArrayBuffer */
    function toArrayBuffer(s) {
        this.buff = new ArrayBuffer(s.length);
        this.view = new Uint8Array(this.buff);
        for (this.index = 0; this.index !== s.length; ++this.index) {
            this.view[this.index] = s.charCodeAt(this.index) & 0xFF;
        }
        return this.buff;
    }

    /*! 通用的打开下载对话框方法 */
    function openDownloadDialog(location, filename) {
        if (typeof location == 'object' && location instanceof Blob) {
            location = URL.createObjectURL(location);
        }
        this.link = document.createElement('a');
        this.link.download = filename || Date.now() + '.xlsx';
        this.link.href = location;
        if (window.MouseEvent) {
            this.event = new MouseEvent('click');
        } else {
            this.event = document.createEvent('MouseEvents');
            this.event.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        }
        this.link.dispatchEvent(this.event);
    }
});