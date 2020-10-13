define(['xlsx'], function () {

    function excel(data, filename, sheetname) {
        this.name = sheetname || 'sheet1';
        this.work = {SheetNames: [this.name], Sheets: {}};
        this.work.Sheets[this.name] = XLSX.utils.aoa_to_sheet(data);
        if (filename.substr(-5).toLowerCase() !== '.xlsx') filename += '.xlsx';
        XLSX.writeFile(this.work, filename);
    }

    excel.bind = function (done, filename) {
        $('body').off('click', '[data-form-export]').on('click', '[data-form-export]', function () {
            var form = $(this).parents('form');
            var method = this.dataset.method || form.attr('method') || 'get';
            var location = this.dataset.excel || this.dataset.formExport || form.attr('action') || '';
            excel.load(location, form.serialize(), done, this.dataset.filename || filename, method);
        });
    };

    excel.load = function (url, data, done, filename, method) {
        var alldata = [];
        var loading = $.msg.loading('正在加载 <span data-upload-page></span>，完成 <span data-upload-progress>0</span>%');
        nextPage(1, 1);

        function nextPage(curPage, maxPage) {
            if (curPage > maxPage) {
                if (typeof done === 'function') {
                    if ((this.result = done(alldata)) !== false) {
                        excel(this.result, filename || '文件下载.xlsx');
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
    }
    return excel;
});