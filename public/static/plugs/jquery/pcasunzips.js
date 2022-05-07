/********************************************************
 *** 加载脚本文件 ***
 <script src="pcasunzip.js"></script>

 *** 省市联动 ***
 new PCAS("Province","City")
 new PCAS("Province","City","吉林省")
 new PCAS("Province","City","吉林省","吉林市")

 *** 省市区联动 ***
 new PCAS("Province","City","Area")
 new PCAS("Province","City","Area","吉林省")
 new PCAS("Province","City","Area","吉林省","松原市")
 new PCAS("Province","City","Area","吉林省","松原市","宁江区")

 省、市、地区对象取得的值均为实际值。
 注：省、市、地区提示信息选项的值为""(空字符串)
 *********************************************************/

SPT = window.SPT || "-省份-";
SCT = window.SCT || "-城市-";
SAT = window.SAT || "-地区-";
SWT = window.SWT || 0; // 提示文字 0:不显示 1:显示

function PCAS() {
    this.SelP = document.getElementsByName(arguments[0])[0];
    this.SelC = document.getElementsByName(arguments[1])[0];
    this.SelA = document.getElementsByName(arguments[2])[0];
    this.DefP = this.SelA ? arguments[3] : arguments[2];
    this.DefC = this.SelA ? arguments[4] : arguments[3];
    this.DefA = this.SelA ? arguments[5] : arguments[4];
    if (this.SelP) this.SelP.PCA = this;
    if (this.SelC) this.SelC.PCA = this;
    if (this.SelA) this.SelA.PCA = this;
    if (this.SelP && this.SelC) {
        this.SelP.onchange = function () {
            PCAS.SetC(this.PCA)
        };
        if (this.SelA) this.SelC.onchange = function () {
            PCAS.SetA(this.PCA)
        };
    }
    PCAS.init(this).SetP(this)
}

PCAS.init = function (PCA) {
    PCA.PCAP = [], PCA.PCAC = [], PCA.PCAA = [], PCA.PCAD = "北京$北京,东城,西城,朝阳,丰台,石景山,海淀,门头沟,房山,通州,顺义,昌平,大兴,怀柔,平谷,密云,延庆#天津$天津,和平,河东,河西,南开,河北,红桥,东丽,西青,津南,北辰,武清,宝坻,滨海,宁河,静海,蓟州#河北$石家庄,|唐山,|秦皇岛,|邯郸,|邢台,|保定,|张家口,|承德,|沧州,|廊坊,|衡水,#山西$太原,|大同,|阳泉,|长治,|晋城,|朔州,|晋中,|运城,|忻州,|临汾,|吕梁,#内蒙古$呼和浩特,|包头,|乌海,|赤峰,|通辽,|鄂尔多斯,|呼伦贝尔,|巴彦淖尔,|乌兰察布,|兴安,|锡林郭勒,|阿拉善,#辽宁$沈阳,|大连,|鞍山,|抚顺,|本溪,|丹东,|锦州,|营口,|阜新,|辽阳,|盘锦,|铁岭,|朝阳,|葫芦岛,#吉林$长春,|吉林,|四平,|辽源,|通化,|白山,|松原,|白城,|延边,#黑龙江$哈尔滨,|齐齐哈尔,|鸡西,|鹤岗,|双鸭山,|大庆,|伊春,|佳木斯,|七台河,|牡丹江,|黑河,|绥化,|大兴安岭,#上海$上海,黄浦,徐汇,长宁,静安,普陀,虹口,杨浦,闵行,宝山,嘉定,浦东,金山,松江,青浦,奉贤,崇明#江苏$南京,|无锡,|徐州,|常州,|苏州,|南通,|连云港,|淮安,|盐城,|扬州,|镇江,|泰州,|宿迁,#浙江$杭州,|宁波,|温州,|嘉兴,|湖州,|绍兴,|金华,|衢州,|舟山,|台州,|丽水,#安徽$合肥,|芜湖,|蚌埠,|淮南,|马鞍山,|淮北,|铜陵,|安庆,|黄山,|滁州,|阜阳,|宿州,|六安,|亳州,|池州,|宣城,#福建$福州,|厦门,|莆田,|三明,|泉州,|漳州,|南平,|龙岩,|宁德,#江西$南昌,|景德镇,|萍乡,|九江,|新余,|鹰潭,|赣州,|吉安,|宜春,|抚州,|上饶,#山东$济南,|青岛,|淄博,|枣庄,|东营,|烟台,|潍坊,|济宁,|泰安,|威海,|日照,|临沂,|德州,|聊城,|滨州,|菏泽,#河南$郑州,|开封,|洛阳,|平顶山,|安阳,|鹤壁,|新乡,|焦作,|濮阳,|许昌,|漯河,|三门峡,|南阳,|商丘,|信阳,|周口,|驻马店,|河南,郑州,开封,洛阳,平顶山,安阳,鹤壁,新乡,焦作,濮阳,许昌,漯河,三门峡,南阳,商丘,信阳,周口,驻马店,济源#湖北$武汉,|黄石,|十堰,|宜昌,|襄阳,|鄂州,|荆门,|孝感,|荆州,|黄冈,|咸宁,|随州,|恩施,|湖北,武汉,黄石,十堰,宜昌,襄阳,鄂州,荆门,孝感,荆州,黄冈,咸宁,随州,恩施,仙桃,潜江,天门,神农架#湖南$长沙,|株洲,|湘潭,|衡阳,|邵阳,|岳阳,|常德,|张家界,|益阳,|郴州,|永州,|怀化,|娄底,|湘西,#广东$广州,|韶关,|深圳,|珠海,|汕头,|佛山,|江门,|湛江,|茂名,|肇庆,|惠州,|梅州,|汕尾,|河源,|阳江,|清远,|东莞,|中山,|潮州,|揭阳,|云浮,#广西$南宁,|柳州,|桂林,|梧州,|北海,|防城港,|钦州,|贵港,|玉林,|百色,|贺州,|河池,|来宾,|崇左,#海南$海口,|三亚,|三沙,|儋州,|海南,海口,三亚,三沙,儋州,五指山,琼海,文昌,万宁,东方,定安,屯昌,澄迈,临高,白沙,昌江,乐东,陵水,保亭,琼中#重庆$重庆,万州,涪陵,渝中,大渡口,江北,沙坪坝,九龙坡,南岸,北碚,綦江,大足,渝北,巴南,黔江,长寿,江津,合川,永川,南川,璧山,铜梁,潼南,荣昌,开州,梁平,武隆,城口,丰都,垫江,忠县,云阳,奉节,巫山,巫溪,石柱,秀山,酉阳,彭水#四川$成都,|自贡,|攀枝花,|泸州,|德阳,|绵阳,|广元,|遂宁,|内江,|乐山,|南充,|眉山,|宜宾,|广安,|达州,|雅安,|巴中,|资阳,|阿坝,|甘孜,|凉山,#贵州$贵阳,|六盘水,|遵义,|安顺,|毕节,|铜仁,|黔西南,|黔东南,|黔南,#云南$昆明,|曲靖,|玉溪,|保山,|昭通,|丽江,|普洱,|临沧,|楚雄,|红河,|文山,|西双版纳,|大理,|德宏,|怒江,|迪庆,#西藏$拉萨,|日喀则,|昌都,|林芝,|山南,|那曲,|阿里,#陕西$西安,|铜川,|宝鸡,|咸阳,|渭南,|延安,|汉中,|榆林,|安康,|商洛,#甘肃$兰州,|嘉峪关,|金昌,|白银,|天水,|武威,|张掖,|平凉,|酒泉,|庆阳,|定西,|陇南,|临夏,|甘南,#青海$西宁,|海东,|海北,|黄南,|海南,|果洛,|玉树,|海西,#宁夏$银川,|石嘴山,|吴忠,|固原,|中卫,#新疆$乌鲁木齐,|克拉玛依,|吐鲁番,|哈密,|昌吉,|博州,|巴州,|阿克苏,|克州,|喀什,|和田,|伊犁,|塔城,|阿勒泰,|新疆,乌鲁木齐,克拉玛依,吐鲁番,哈密,昌吉,博州,巴州,阿克苏,克州,喀什,和田,伊犁,塔城,阿勒泰,石河子,阿拉尔,图木舒克,五家渠,北屯,铁门关,双河,可克达拉,昆玉,胡杨河#台湾$台北,|高雄,|台南,|台中,|南投,|基隆,|新竹,|嘉义,|新北,|宜兰,|新竹,|桃园,|苗栗,|彰化,|嘉义,|云林,|屏东,|台东,|花莲,|澎湖,#香港$香港,中西区,东区,九龙,观塘区,南区,深水埗区,湾仔区,黄大仙区,油尖旺区,离岛区,葵青区,北区,西贡区,沙田区,屯门区,大埔区,荃湾区,元朗区#澳门$澳门,澳门半岛,凼仔,路凼城,路环";
    if (SWT) PCA.PCAD = SPT + "$" + SCT + "," + SAT + "#" + PCA.PCAD;
    PCA.PCAD.split("#").forEach(function (VAL1, ID1) {
        PCA.PCAP[ID1] = VAL1.split("$")[0], PCA.PCAC[ID1] = [], PCA.PCAA[ID1] = [];
        VAL1.split("$")[1].split("|").forEach(function (VAL2, ID2) {
            PCA.PCAC[ID1].push((PCA.PCAR = VAL2.split(",")).shift()), PCA.PCAA[ID1][ID2] = PCA.PCAR;
        });
    });
    return this;
};

PCAS.SetP = function (PCA) {
    PCA.PCAP.forEach(function (VAL, IDX) {
        PCA.PCAT = PCA.PCAV = VAL;
        if (PCA.PCAT === SPT) PCA.PCAV = "";
        PCA.SelP.options.add(new Option(PCA.PCAT, PCA.PCAV));
        if (PCA.DefP === PCA.PCAV) PCA.SelP[IDX].selected = true
    }), PCA.SelC ? PCAS.SetC(PCA) : $(PCA.SelP).trigger('change');
};

PCAS.SetC = function (PCA) {
    PCA.SelC.length = 0;
    PCA.PCAC[PCA.SelP.selectedIndex].forEach(function (VAL, IDX) {
        PCA.PCAT = PCA.PCAV = VAL;
        if (PCA.PCAT === SCT) PCA.PCAV = "";
        PCA.SelC.options.add(new Option(PCA.PCAT, PCA.PCAV));
        if (PCA.DefC === PCA.PCAV) PCA.SelC[IDX].selected = true
    }), PCA.SelA ? PCAS.SetA(PCA) : $(PCA.SelC).trigger('change');
};

PCAS.SetA = function (PCA) {
    PCA.SelA.length = 0;
    PCA.PCAA[PCA.SelP.selectedIndex][PCA.SelC.selectedIndex].forEach(function (VAL, IDX) {
        PCA.PCAT = PCA.PCAV = VAL;
        if (PCA.PCAT === SAT) PCA.PCAV = "";
        PCA.SelA.options.add(new Option(PCA.PCAT, PCA.PCAV));
        if (PCA.DefA === PCA.PCAV) PCA.SelA[IDX].selected = true
    }), $(PCA.SelA).trigger('change')
};