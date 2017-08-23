// 定义编辑器标准配置
CKEDITOR.editorConfig = function (config) {
    config.language = 'zh-cn';
    config.toolbar = [
        {name: 'document', items: ['Source']},
        {name: 'clipboard', items: ['Undo', 'Redo']},
        {name: 'styles', items: ['Font', 'FontSize']},
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting', 'TextColor', 'BGColor']},
        {name: 'align', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']},
        {name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'Link', 'Unlink']},
        {name: 'uimage', items: ['Table', 'UploadImage']},
        {name: 'tools', items: ['Maximize']}
    ];
    config.allowedContent = true;
    config.extraPlugins = 'uimage';
    config.format_tags = 'p;h1;h2;h3;pre';
    config.removeButtons = 'Underline,Subscript,Superscript';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.font_names = '宋体/SimSun;新宋体/NSimSun;仿宋_GB2312/FangSong_GB2312;楷体_GB2312/KaiTi_GB2312;黑体/SimHei;微软雅黑/Microsoft YaHei;' + config.font_names;
};
// 自定义图片上传插件
CKEDITOR.plugins.add("uimage", {
    init: function (editor) {
        editor.ui.addButton("UploadImage", {label: "上传图片", command: 'uimage', icon: 'image', toolbar: 'insert,10'});
        editor.addCommand('uimage', {
            exec: function (editor) {
                var field = '_editor_upload_' + Math.floor(Math.random() * 100000);
                var url = window.ROOT_URL + '/index.php/admin/plugs/upfile.html?mode=one&type=png,jpg,gif,jpeg&field=' + field;
                $('<input type="hidden">').attr('name', field).appendTo(editor.element.$).on('change', function () {
                    var element = CKEDITOR.dom.element.createFromHtml('<img src="' + this.value + '" style="max-width:500px" border="0" title="image" />');
                    editor.insertElement(element), $(this).remove();
                });
                $.form.iframe(url, '插入图片');
            }
        });
    }
});