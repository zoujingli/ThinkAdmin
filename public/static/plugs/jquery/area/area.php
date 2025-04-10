<?php

// 禁止 HTTP 访问脚本文件
PHP_SAPI === 'cli' or die('Can only run in CLI mode.');

new class() {

    private $tree = [];

    public function __construct()
    {
        $this->debug($this->initBd())->write();
    }

    /**
     * 初始化百度地址行政数据
     * @return void
     */
    protected function initBd(): array
    {
        $url = 'https://api.map.baidu.com/api_region_search/v1/?keyword=%E5%85%A8%E5%9B%BD&sub_admin=3&ak=S7I1ewwAVr8r2MI3rnSKeF3R6GTCZiOo&extensions_code=1';
        $context = stream_context_create(["ssl" => ["verify_peer" => false, "verify_peer_name" => false]]);
        $provs = json_decode(file_get_contents($url, false, $context), true)['districts'][0]['districts'];
        usort($provs, function ($a, $b) {
            return $a['code'] > $b['code'] ? 1 : -1;
        });
        foreach ($provs as &$prov) {
            $prov['list'] = $prov['districts'];
            usort($prov['list'], function ($a, $b) {
                return $a['code'] > $b['code'] ? 1 : -1;
            });
            foreach ($prov['list'] as &$city) {
                $city['list'] = $city['districts'];
                usort($city['list'], function ($a, $b) {
                    return $a['code'] > $b['code'] ? 1 : -1;
                });
                foreach ($city['list'] as &$area) {
                    unset($area['level'], $area['list'], $area['districts']);
                }
                unset($city['level'], $city['districts']);
            }
            unset($prov['level'], $prov['districts']);
        }
        return $this->tree = $provs;
    }

    /**
     * 初始化腾讯地址行政
     * @param array $data
     * @return array
     */
    protected function initQq(array $data = []): array
    {
        $url = 'https://apis.map.qq.com/ws/district/v1/list?key=AVDBZ-VXMC6-VD2SU-M7DX2-TGSV7-WVF3U';
        foreach (json_decode(file_get_contents($url), true)['result'] as $items) foreach ($items as $item) {
            $data[$item['id']] = ['code' => $item['id'], 'name' => $item['fullname'], 'list' => []];
        }
        ksort($data);
        foreach ($data as $item) {
            [$k1, $k2, $k3] = str_split($item['code'], 2);
            // 整合省份数据
            if ($k2 + $k3 == 0) {
                $this->tree[$k1] = $item;
            }
            // 整合城市
            if ($k2 > 0 && $k3 == 0) {
                $this->tree[$k1]['list'][$k1 . $k2] = $item;
                ksort($this->tree[$k1]['list']);
            }
            // 整合区域
            if ($k2 > 0 && $k3 > 0) {
                unset($item['list']);
                if (!isset($this->tree[$k1]['list'][$k1 . $k2])) {
                    $this->tree[$k1]['list'][$k1 . $k2] = array_merge($this->tree[$k1], ['list' => []]);
                }
                $this->tree[$k1]['list'][$k1 . $k2]['list'][$k1 . $k2 . $k3] = $item;
                ksort($this->tree[$k1]['list'][$k1 . $k2]['list']);
            }
        }
        return $this->tree;
    }

    /**
     * 打印输出日志
     * @param array $data
     * @return $this
     */
    private function debug(array $data)
    {
        ob_clean();
        header('Content-type:application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        return $this;
    }

    /**
     * 写入更新文件
     * @return bool
     */
    private function write(): bool
    {
        $data = [];
        $items = array_values($this->tree);
        foreach ($items as &$prov) {
            $line = [];
            $prov['list'] = array_values($prov['list']);
            foreach ($prov['list'] as &$city) {
                $city['list'] = array_values($city['list']);
                $line[] = $city['name'] . ',' . join(',', array_column($city['list'], 'name'));
            }
            $data[] = $prov['name'] . '$' . join('|', $line);
        }

        // 数据写入文件
        $jsonFile = __DIR__ . '/data.json';
        $scriptFile = dirname(__DIR__) . '/pcasunzips.js';
        $jsonContent = json_encode($items, JSON_UNESCAPED_UNICODE);
        $scriptContent = str_replace('__STRING__', join('#', $data), <<<EOL
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
EOL
        );

        // 写入区域文件
        return file_put_contents($scriptFile, $scriptContent) && file_put_contents($jsonFile, $jsonContent);
    }
};