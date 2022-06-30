/*! 定义编辑器标准配置 */
CKEDITOR.editorConfig = function (config) {
    config.toolbar = [
        {name: 'document', items: ['Source']},
        {name: 'styles', items: ['Font', 'FontSize']},
        {name: 'basicstyles', items: ['lineheight', 'Indent', 'Outdent', 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'TextColor', 'BGColor', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList']},
        {name: 'element', items: ['Link', 'Unlink', 'Table', 'UploadImage', 'UploadMusic', 'UploadVideo', 'UploadHtml']},
        {name: 'tools', items: ['Print', 'Maximize']}
    ];
    config.language = 'zh-cn';
    config.format_tags = 'p;h1;h2;h3;pre';
    config.extraPlugins = 'uimage,umusic,uhtml,uvideo,lineheight';
    config.removePlugins = 'easyimage,cloudservices,exportpdf';
    config.removeButtons = 'Underline,Subscript,Superscript';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    // 内容过滤
    config.disallowedContent = 'script; *[on*]';
    config.allowedContent = {$1: {elements: CKEDITOR.dtd, attributes: true, styles: true, classes: true}};
    config.font_names = '微软雅黑/Microsoft YaHei;宋体/SimSun;新宋体/NSimSun;仿宋/FangSong;楷体/KaiTi;黑体/SimHei;' + config.font_names;
};

/*! 自定义图片上传插件 */
CKEDITOR.plugins.add("uimage", {
    init: function (editor) {
        editor.ui.addButton("UploadImage", {label: "上传本地图片", command: 'uimage', icon: 'image', toolbar: 'insert,10'});
        setTimeout(function () {
            $('#cke_' + editor.name).find('.cke_button__uploadimage_label').parent().map(function () {
                $(this).attr('data-type', 'png,jpg,gif,jpeg').attr('data-file', 'images').on('push', function (e, url) {
                    editor.insertElement(CKEDITOR.dom.element.createFromHtml('<div><img style="border:0;max-width:100%;" alt="" src="' + url + '"></div>'));
                });
            });
        }, 100);
    }
});

/*! 自定义视频插入插件 */
CKEDITOR.plugins.add('umusic', {
    init: function (editor) {
        editor.ui.addButton("UploadMusic", {label: "上传MP3文件", command: 'umusic', icon: 'specialchar', toolbar: 'insert,10'});
        setTimeout(function () {
            $('#cke_' + editor.name).find('.cke_button__uploadmusic_label').parent().map(function () {
                $(this).attr('data-type', 'mp3').attr('data-file', 'mul').uploadFile(function (url) {
                    editor.insertElement(CKEDITOR.dom.element.createFromHtml('<div><audio controls="controls"><source src="' + url + '" type="audio/mpeg"></audio></div>'));
                });
            });
        }, 100);
    }
});

/*! 自定义视频插入插件 */
CKEDITOR.plugins.add('uvideo', {
    init: function (editor) {
        editor.ui.addButton("UploadVideo", {label: "上传MP4文件", command: 'uvideo', icon: 'iframe', toolbar: 'insert,10'});
        setTimeout(function () {
            $('#cke_' + editor.name).find('.cke_button__uploadvideo_label').parent().map(function () {
                $(this).attr('data-type', 'mp4').attr('data-file', 'mul').uploadFile(function (url) {
                    editor.insertElement(CKEDITOR.dom.element.createFromHtml('<div><video width="100%" controls="controls"><source src="' + url + '" type="audio/mp4"></video></div>'));
                    // 小程序不支持
                    // editor.insertElement(CKEDITOR.dom.element.createFromHtml('<div><iframe src="' + url + '" style="max-width:100%;max-height:100%;border:0" allowfullscreen="true"></iframe></div>'));
                });
            });
        }, 100);
    }
});

/*! 自定义视频插入插件 */
CKEDITOR.plugins.add('uhtml', {
    init: function (editor) {
        editor.ui.addButton("UploadHtml", {label: "插入HTML代码", command: 'uhtml', icon: 'creatediv', toolbar: 'insert,10'});
        editor.addCommand('uhtml', {
            exec: function (editor) {
                layui.layer.prompt({title: '插入HTML代码', formType: 2, area: ['600px', '300px']}, function (html, index, element) {
                    element = CKEDITOR.dom.element.createFromHtml('<div data-type="insert-html">' + html + '</div>');
                    editor.insertElement(element), layui.layer.close(index);
                });
            }
        });
    }
});