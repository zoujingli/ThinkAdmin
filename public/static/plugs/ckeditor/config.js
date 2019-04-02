// 定义编辑器标准配置
CKEDITOR.editorConfig = function (config) {
    config.language = 'zh-cn';
    config.toolbar = [
        {name: 'document', items: ['Source']},
        {name: 'styles', items: ['Font', 'FontSize']},
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'TextColor', 'BGColor', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList']},
        {name: 'uimage', items: ['Link', 'Unlink', 'Table', 'UploadImage', 'UploadMusic', 'UploadVideo', 'UploadHtml']},
        {name: 'tools', items: ['Maximize']}
    ];
    config.allowedContent = true;
    config.format_tags = 'p;h1;h2;h3;pre';
    config.extraPlugins = 'uimage,umusic,uhtml,uvideo';
    config.removeButtons = 'Underline,Subscript,Superscript';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.font_names = '微软雅黑/Microsoft YaHei;宋体/SimSun;新宋体/NSimSun;仿宋/FangSong;楷体/KaiTi;黑体/SimHei;' + config.font_names;
};

// 自定义图片上传插件
CKEDITOR.plugins.add("uimage", {
    init: function (editor) {
        editor.ui.addButton("UploadImage", {label: "上传本地图片", command: 'uimage', icon: 'image', toolbar: 'insert,10'});
        setTimeout(function () {
            $('.cke_button__uploadimage_label').parent().map(function () {
                $(this).attr('data-type', 'png,jpg,gif').uploadFile(function (url) {
                    editor.insertElement(CKEDITOR.dom.element.createFromHtml('<img style="max-width:100%" src="' + url + '" border="0" title="image">'));
                });
            });
        }, 100);
    }
});

// 自定义视频插入插件
CKEDITOR.plugins.add('umusic', {
    init: function (editor) {
        editor.ui.addButton("UploadMusic", {label: "上传MP3文件", command: 'umusic', icon: 'specialchar', toolbar: 'insert,10'});
        setTimeout(function () {
            $('.cke_button__uploadmusic_label').parent().map(function () {
                $(this).attr('data-type', 'mp3').uploadFile(function (url) {
                    editor.insertElement(CKEDITOR.dom.element.createFromHtml('<audio controls="controls"><source src="' + url + '" type="audio/mpeg"></audio>'));
                });
            });
        }, 100);
    }
});

// 自定义视频插入插件
CKEDITOR.plugins.add('uvideo', {
    init: function (editor) {
        editor.ui.addButton("UploadVideo", {label: "上传MP4文件", command: 'uvideo', icon: 'flash', toolbar: 'insert,10'});
        setTimeout(function () {
            $('.cke_button__uploadvideo_label').parent().map(function () {
                $(this).attr('data-type', 'mp4').uploadFile(function (url) {
                    editor.insertElement(CKEDITOR.dom.element.createFromHtml('<video width="100%" controls="controls"><source src="' + url + '" type="audio/mp4"></video>'));
                });
            });
        }, 100);
    }
});

// 自定义视频插入插件
CKEDITOR.plugins.add('uhtml', {
    init: function (editor) {
        editor.ui.addButton("UploadHtml", {label: "插入HTML代码", command: 'uhtml', icon: 'creatediv', toolbar: 'insert,10'});
        editor.addCommand('uhtml', {
            exec: function (editor) {
                layer.prompt({title: '插入HTML代码', formType: 2, area: ['600px', '300px']}, function (html, index) {
                    var element = CKEDITOR.dom.element.createFromHtml('<div data-type="insert-html">' + html + '</div>');
                    editor.insertElement(element), layer.close(index);
                });
            }
        });
    }
});

