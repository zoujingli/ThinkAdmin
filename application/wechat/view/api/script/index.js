if (typeof wx === 'object') {
    wx.openid = '{$fansinfo.openid|default=""}';
    wx.unionid = '{$fansinfo.unionid|default=""}';
    wx.fansinfo = eval('({$fansinfo|default=[]|json_encode=###,256|raw})');
    wx.config(eval('({$jssdk|default=[]|json_encode=###,256|raw})'));
    wx.ready(function () {
        wx.hideOptionMenu();
        wx.hideAllNonBaseMenuItem();
    });
}
