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
    PCA.PCAP = [], PCA.PCAC = [], PCA.PCAA = [], PCA.PCAD = "__STRING__";
    if (SWT) PCA.PCAD = SPT + "$" + SCT + "," + SAT + "#" + PCA.PCAD;
    PCA.PCAD.split("#").forEach(function (VAL1, ID1) {
        PCA.PCAP[ID1] = VAL1.split("$")[0], PCA.PCAC[ID1] = [], PCA.PCAA[ID1] = [];
        VAL1.split("$")[1].split("|").forEach(function (VAL2, ID2) {
            PCA.PCAC[ID1].push((PCA.PCAR = VAL2.split(",")).shift()), PCA.PCAA[ID1][ID2] = PCA.PCAR;
            if (PCA.PCAA[ID1][ID2].length === 1) PCA.PCAA[ID1][ID2][1] = SAT;
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