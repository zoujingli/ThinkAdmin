<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\service;

use think\admin\extend\HttpExtend;
use think\admin\Service;

/**
 * 旧助通短信接口服务
 * Class MessageService
 * @package app\store\service
 * =================================
 *
 *  CREATE TABLE `system_message_history` (
 *     `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 *     `phone` varchar(100) DEFAULT '' COMMENT '目标手机',
 *     `region` varchar(100) DEFAULT '' COMMENT '国家编号',
 *     `result` varchar(100) DEFAULT '' COMMENT '返回结果',
 *     `content` varchar(512) DEFAULT '' COMMENT '短信内容',
 *     `create_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
 *     PRIMARY KEY (`id`) USING BTREE,
 *     KEY `idx_system_message_history_phone` (`phone`) USING BTREE
 *  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统-短信';
 *
 * =================================
 * 发送国内短信需要给产品码 [productid]
 * --- 验证短信的产品码为：676767
 * --- 营销短信的产品码为：333333
 * ---------------------------------
 * ---------------------------------
 * 发送国际短信需要给国家代码 [code]
 * --- 国家代码见 getGlobeRegionMap
 * ---------------------------------
 * ---------------------------------
 * 需要开通短信账号请联系客服
 * --- 客服电话：18122377655
 * =================================
 */
class MessageService extends Service
{

    private $table;

    private $chinaUsername;
    private $chinaPassword;

    private $globeUsername;
    private $globePassword;

    /**
     * @return $this
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize(): MessageService
    {
        $this->table = 'SystemMessageHistory';
        $this->chinaUsername = sysconf('sms_zt.china_username');
        $this->chinaPassword = sysconf('sms_zt.china_password');
        $this->globeUsername = sysconf('sms_zt.globe_username');
        $this->globePassword = sysconf('sms_zt.globe_password');
        return $this;
    }

    /**
     * 配置内陆短信认证
     * @param string $username 账号名称
     * @param string $password 账号密码
     * @return $this
     */
    public function configChina(string $username, string $password): MessageService
    {
        $this->chinaUsername = $username;
        $this->chinaPassword = $password;
        return $this;
    }

    /**
     * 配置国际短信认证
     * @param string $username 账号名称
     * @param string $password 账号密码
     * @return $this
     */
    public function configGlobe(string $username, string $password): MessageService
    {
        $this->globeUsername = $username;
        $this->globePassword = $password;
        return $this;
    }

    /**
     * 设置存储数据表
     * @param string $table
     * @return $this
     */
    public function setSaveTable(string $table): MessageService
    {
        $this->table = $table;
        return $this;
    }

    /**
     * 生成短信内容
     * @param string $content
     * @param array $params
     * @return string
     */
    public function buildContent(string $content, array $params = []): string
    {
        foreach ($params as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }
        return $content;
    }

    /**
     * 发送国内短信验证码
     * @param integer|string $phone 手机号
     * @param integer|string $content 短信内容
     * @param integer|string $productid 短信通道
     * @return boolean
     */
    public function sendChinaSms($phone, $content, $productid = '676767'): bool
    {
        $tkey = date("YmdHis");
        $result = HttpExtend::get('http://www.ztsms.cn/sendNSms.do', [
            'tkey'      => $tkey,
            'mobile'    => $phone,
            'content'   => $content,
            'username'  => $this->chinaUsername,
            'productid' => $productid,
            'password'  => md5(md5($this->chinaPassword) . $tkey),
        ]);
        [$code, $message] = explode(',', $result . ',');
        $this->app->db->name($this->table)->insert([
            'phone' => $phone, 'region' => '860', 'content' => $content, 'result' => $result,
        ]);
        return intval($code) === 1;
    }

    /**
     * 发送国内短信验证码
     * @param integer|string $phone 目标手机
     * @param integer $wait 等待时间
     * @param string $type 短信模板
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sendChinaSmsByCode($phone, int $wait = 120, string $type = 'sms_reg_template'): array
    {
        $cache = $this->app->cache->get($ckey = "{$type}_{$phone}", []);
        if (is_array($cache) && isset($cache['time']) && $cache['time'] > time() - $wait) {
            $dtime = ($cache['time'] + $wait < time()) ? 0 : ($wait - time() + $cache['time']);
            return [1, '短信验证码已经发送！', ['time' => $dtime]];
        }
        [$code, $content] = [rand(1000, 9999), sysconf($type)];
        if (empty($content) || stripos($content, '{code}') === false) {
            $content = '您的验证码为{code}，请在十分钟内完成操作！';
        }
        $this->app->cache->set($ckey, $cache = ['code' => $code, 'time' => time()], 600);
        if ($this->sendChinaSms($phone, str_replace('{code}', $code, $content))) {
            $dtime = ($cache['time'] + $wait < time()) ? 0 : ($wait - time() + $cache['time']);
            return [1, '短信验证码发送成功！', ['time' => $dtime]];
        } else {
            return [0, '短信发送失败，请稍候再试！', []];
        }
    }

    /**
     * 验证手机短信验证码
     * @param integer|string $phone 目标手机
     * @param integer|string $code 短信验证码
     * @param string $type 短信模板
     * @return boolean
     */
    public function check($phone, $code, string $type = 'sms_reg_template'): bool
    {
        $cache = $this->app->cache->get($cachekey = "{$type}_{$phone}", []);
        return is_array($cache) && isset($cache['code']) && $cache['code'] == $code;
    }

    /**
     * 查询国内短信余额
     * @return array
     */
    public function queryChinaSmsBalance()
    {
        $tkey = date("YmdHis");
        $result = HttpExtend::get('http://www.ztsms.cn/balanceN.do', [
            'username' => $this->chinaUsername, 'tkey' => $tkey,
            'password' => md5(md5($this->chinaPassword) . $tkey),
        ]);
        if ($result > -1) {
            return ['code' => 1, 'num' => $result, 'msg' => '获取短信剩余条数成功！'];
        } elseif ($result > -2) {
            return ['code' => 0, 'num' => '0', 'msg' => '用户名或者密码不正确！'];
        } elseif ($result > -3) {
            return ['code' => 0, 'num' => '0', 'msg' => 'tkey不正确！'];
        } elseif ($result > -4) {
            return ['code' => 0, 'num' => '0', 'msg' => '用户不存在或用户停用！'];
        }
    }

    /**
     * 错误消息处理
     * @var array
     */
    private $globeMessageMap = [
        2  => '用户账号为空',
        3  => '用户账号错误',
        4  => '授权密码为空',
        5  => '授权密码错误',
        6  => '当前时间为空',
        7  => '当前时间错误',
        8  => '用户类型错误',
        9  => '用户鉴权错误',
        10 => '请求IP已被列入黑名单',
    ];

    /**
     * 发送国际短信内容
     * @param integer|string $code 国家代码
     * @param integer|string $mobile 手机号码
     * @param string $content 发送内容
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function sendGlobeSms($code, $mobile, string $content): bool
    {
        $tkey = date("YmdHis");
        $result = HttpExtend::get('http://intl.zthysms.com/intSendSms.do', [
            'tkey'     => $tkey, 'code' => $code, 'mobile' => $mobile,
            'content'  => $content, 'username' => sysconf('sms_zt_username2'),
            'password' => md5(md5(sysconf('sms_zt_password2')) . $tkey),
        ]);
        $this->app->db->name($this->table)->insert([
            'region' => $code, 'phone' => $mobile, 'content' => $content, 'result' => $result,
        ]);
        return intval($result) === 1;
    }

    /**
     * 查询国际短信余额
     * @return array
     */
    public function queryGlobeSmsBalance(): array
    {
        $tkey = date("YmdHis");
        $result = HttpExtend::get('http://intl.zthysms.com/intBalance.do', [
            'username' => $this->globeUsername, 'tkey' => $tkey, 'password' => md5(md5($this->globePassword) . $tkey),
        ]);
        if (!is_numeric($result) && ($state = intval($result)) && isset($this->globeMessageMap[$state])) {
            return ['code' => 0, 'num' => 0, 'msg' => $this->globeMessageMap[$state]];
        } else {
            return ['code' => 1, 'num' => $result, 'msg' => '查询成功'];
        }
    }

    /**
     * 获取国际地域编号
     * @return array
     */
    public function getGlobeRegionMap(): array
    {
        return [
            ['title' => '中国 台湾', 'english' => 'Taiwan', 'code' => 886],
            ['title' => '东帝汶民主共和国', 'english' => 'DEMOCRATIC REPUBLIC OF TIMORLESTE', 'code' => 670],
            ['title' => '中非共和国', 'english' => 'Central African Republic', 'code' => 236],
            ['title' => '丹麦', 'english' => 'Denmark', 'code' => 45],
            ['title' => '乌克兰', 'english' => 'Ukraine', 'code' => 380],
            ['title' => '乌兹别克斯坦', 'english' => 'Uzbekistan', 'code' => 998],
            ['title' => '乌干达', 'english' => 'Uganda', 'code' => 256],
            ['title' => '乌拉圭', 'english' => 'Uruguay', 'code' => 598],
            ['title' => '乍得', 'english' => 'Chad', 'code' => 235],
            ['title' => '也门', 'english' => 'Yemen', 'code' => 967],
            ['title' => '亚美尼亚', 'english' => 'Armenia', 'code' => 374],
            ['title' => '以色列', 'english' => 'Israel', 'code' => 972],
            ['title' => '伊拉克', 'english' => 'Iraq', 'code' => 964],
            ['title' => '伊朗', 'english' => 'Iran', 'code' => 98],
            ['title' => '伯利兹', 'english' => 'Belize', 'code' => 501],
            ['title' => '佛得角', 'english' => 'Cape Verde', 'code' => 238],
            ['title' => '俄罗斯', 'english' => 'Russia', 'code' => 7],
            ['title' => '保加利亚', 'english' => 'Bulgaria', 'code' => 359],
            ['title' => '克罗地亚', 'english' => 'Croatia', 'code' => 385],
            ['title' => '关岛', 'english' => 'Guam', 'code' => 1671],
            ['title' => '冈比亚', 'english' => 'The Gambia', 'code' => 220],
            ['title' => '冰岛', 'english' => 'Iceland', 'code' => 354],
            ['title' => '几内亚', 'english' => 'Guinea', 'code' => 224],
            ['title' => '几内亚比绍', 'english' => 'Guinea - Bissau', 'code' => 245],
            ['title' => '列支敦士登', 'english' => 'Liechtenstein', 'code' => 423],
            ['title' => '刚果共和国', 'english' => 'The Republic of Congo', 'code' => 242],
            ['title' => '刚果民主共和国', 'english' => 'Democratic Republic of the Congo', 'code' => 243],
            ['title' => '利比亚', 'english' => 'Libya', 'code' => 218],
            ['title' => '利比里亚', 'english' => 'Liberia', 'code' => 231],
            ['title' => '加拿大', 'english' => 'Canada', 'code' => 1],
            ['title' => '加纳', 'english' => 'Ghana', 'code' => 233],
            ['title' => '加蓬', 'english' => 'Gabon', 'code' => 241],
            ['title' => '匈牙利', 'english' => 'Hungary', 'code' => 36],
            ['title' => '南非', 'english' => 'South Africa', 'code' => 27],
            ['title' => '博茨瓦纳', 'english' => 'Botswana', 'code' => 267],
            ['title' => '卡塔尔', 'english' => 'Qatar', 'code' => 974],
            ['title' => '卢旺达', 'english' => 'Rwanda', 'code' => 250],
            ['title' => '卢森堡', 'english' => 'Luxembourg', 'code' => 352],
            ['title' => '印尼', 'english' => 'Indonesia', 'code' => 62],
            ['title' => '印度', 'english' => 'India', 'code' => 91918919],
            ['title' => '危地马拉', 'english' => 'Guatemala', 'code' => 502],
            ['title' => '厄瓜多尔', 'english' => 'Ecuador', 'code' => 593],
            ['title' => '厄立特里亚', 'english' => 'Eritrea', 'code' => 291],
            ['title' => '叙利亚', 'english' => 'Syria', 'code' => 963],
            ['title' => '古巴', 'english' => 'Cuba', 'code' => 53],
            ['title' => '吉尔吉斯斯坦', 'english' => 'Kyrgyzstan', 'code' => 996],
            ['title' => '吉布提', 'english' => 'Djibouti', 'code' => 253],
            ['title' => '哥伦比亚', 'english' => 'Colombia', 'code' => 57],
            ['title' => '哥斯达黎加', 'english' => 'Costa Rica', 'code' => 506],
            ['title' => '喀麦隆', 'english' => 'Cameroon', 'code' => 237],
            ['title' => '图瓦卢', 'english' => 'Tuvalu', 'code' => 688],
            ['title' => '土库曼斯坦', 'english' => 'Turkmenistan', 'code' => 993],
            ['title' => '土耳其', 'english' => 'Turkey', 'code' => 90],
            ['title' => '圣卢西亚', 'english' => 'Saint Lucia', 'code' => 1758],
            ['title' => '圣基茨和尼维斯', 'english' => 'Saint Kitts and Nevis', 'code' => 1869],
            ['title' => '圣多美和普林西比', 'english' => 'Sao Tome and Principe', 'code' => 239],
            ['title' => '圣文森特和格林纳丁斯', 'english' => 'Saint Vincent and the Grenadines', 'code' => 1784],
            ['title' => '圣皮埃尔和密克隆群岛', 'english' => 'Saint Pierre and Miquelon', 'code' => 508],
            ['title' => '圣赫勒拿岛', 'english' => 'Saint Helena', 'code' => 290],
            ['title' => '圣马力诺', 'english' => 'San Marino', 'code' => 378],
            ['title' => '圭亚那', 'english' => 'Guyana', 'code' => 592],
            ['title' => '坦桑尼亚', 'english' => 'Tanzania', 'code' => 255],
            ['title' => '埃及', 'english' => 'Egypt', 'code' => 20],
            ['title' => '埃塞俄比亚', 'english' => 'Ethiopia', 'code' => 251],
            ['title' => '基里巴斯', 'english' => 'Kiribati', 'code' => 686],
            ['title' => '塔吉克斯坦', 'english' => 'Tajikistan', 'code' => 992],
            ['title' => '塞内加尔', 'english' => 'Senegal', 'code' => 221],
            ['title' => '塞尔维亚', 'english' => 'Serbia and Montenegro', 'code' => 381],
            ['title' => '塞拉利昂', 'english' => 'Sierra Leone', 'code' => 232],
            ['title' => '塞浦路斯', 'english' => 'Cyprus', 'code' => 357],
            ['title' => '塞舌尔', 'english' => 'Seychelles', 'code' => 248],
            ['title' => '墨西哥', 'english' => 'Mexico', 'code' => 52],
            ['title' => '多哥', 'english' => 'Togo', 'code' => 228],
            ['title' => '多米尼克', 'english' => 'Dominica', 'code' => 1767],
            ['title' => '奥地利', 'english' => 'Austria', 'code' => 43],
            ['title' => '委内瑞拉', 'english' => 'Venezuela', 'code' => 58],
            ['title' => '孟加拉', 'english' => 'Bangladesh', 'code' => 880],
            ['title' => '安哥拉', 'english' => 'Angola', 'code' => 244],
            ['title' => '安圭拉岛', 'english' => 'Anguilla', 'code' => 1264],
            ['title' => '安道尔', 'english' => 'Andorra', 'code' => 376],
            ['title' => '密克罗尼西亚', 'english' => 'Federated States of Micronesia', 'code' => 691],
            ['title' => '尼加拉瓜', 'english' => 'Nicaragua', 'code' => 505],
            ['title' => '尼日利亚', 'english' => 'Nigeria', 'code' => 234],
            ['title' => '尼日尔', 'english' => 'Niger', 'code' => 227],
            ['title' => '尼泊尔', 'english' => 'Nepal', 'code' => 977],
            ['title' => '巴勒斯坦', 'english' => 'Palestine', 'code' => 970],
            ['title' => '巴哈马', 'english' => 'The Bahamas', 'code' => 1242],
            ['title' => '巴基斯坦', 'english' => 'Pakistan', 'code' => 92],
            ['title' => '巴巴多斯', 'english' => 'Barbados', 'code' => 1246],
            ['title' => '巴布亚新几内亚', 'english' => 'Papua New Guinea', 'code' => 675],
            ['title' => '巴拉圭', 'english' => 'Paraguay', 'code' => 595],
            ['title' => '巴拿马', 'english' => 'Panama', 'code' => 507],
            ['title' => '巴林', 'english' => 'Bahrain', 'code' => 973],
            ['title' => '巴西', 'english' => 'Brazil', 'code' => 55],
            ['title' => '布基纳法索', 'english' => ' Burkina Faso', 'code' => 226],
            ['title' => '布隆迪', 'english' => 'Burundi', 'code' => 257],
            ['title' => '希腊', 'english' => ' Greece', 'code' => 30],
            ['title' => '帕劳', 'english' => 'Palau', 'code' => 680],
            ['title' => '库克群岛', 'english' => ' Cook Islands', 'code' => 682],
            ['title' => '开曼群岛', 'english' => 'Cayman Islands', 'code' => 1345],
            ['title' => '德国', 'english' => ' Germany', 'code' => 49],
            ['title' => '意大利', 'english' => 'Italy', 'code' => 39],
            ['title' => '所罗门群岛', 'english' => ' Solomon Islands', 'code' => 677],
            ['title' => '托克劳', 'english' => 'Tokelau', 'code' => 690],
            ['title' => '拉脱维亚', 'english' => 'Latvia', 'code' => 371],
            ['title' => '挪威', 'english' => 'Norway', 'code' => 47],
            ['title' => '捷克共和国', 'english' => 'Czech Republic', 'code' => 420],
            ['title' => '摩尔多瓦', 'english' => 'Moldova', 'code' => 373],
            ['title' => '摩洛哥', 'english' => 'Morocco', 'code' => 212],
            ['title' => '摩纳哥', 'english' => 'Monaco', 'code' => 377],
            ['title' => '文莱', 'english' => 'Brunei Darussalam', 'code' => 673],
            ['title' => '斐济', 'english' => 'Fiji', 'code' => 679],
            ['title' => '斯威士兰王国', 'english' => 'The Kingdom of Swaziland', 'code' => 268],
            ['title' => '斯洛伐克', 'english' => 'Slovakia', 'code' => 421],
            ['title' => '斯洛文尼亚', 'english' => 'Slovenia', 'code' => 386],
            ['title' => '斯里兰卡', 'english' => 'Sri Lanka', 'code' => 94],
            ['title' => '新加坡', 'english' => 'Singapore ', 'code' => 65],
            ['title' => '新喀里多尼亚', 'english' => 'New Caledonia', 'code' => 687],
            ['title' => '新西兰', 'english' => 'New Zealand', 'code' => 64],
            ['title' => '日本', 'english' => 'Japan', 'code' => 81],
            ['title' => '智利', 'english' => 'Chile', 'code' => 56],
            ['title' => '朝鲜', 'english' => 'Korea, North', 'code' => 850],
            ['title' => '柬埔寨 ', 'english' => 'Cambodia', 'code' => 855],
            ['title' => '格林纳达', 'english' => 'Grenada', 'code' => 1473],
            ['title' => '格陵兰', 'english' => 'Greenland', 'code' => 299],
            ['title' => '格鲁吉亚', 'english' => 'Georgia', 'code' => 995],
            ['title' => '比利时', 'english' => 'Belgium', 'code' => 32],
            ['title' => '毛里塔尼亚', 'english' => 'Mauritania', 'code' => 222],
            ['title' => '毛里求斯', 'english' => 'Mauritius', 'code' => 230],
            ['title' => '汤加', 'english' => 'Tonga', 'code' => 676],
            ['title' => '沙特阿拉伯', 'english' => 'Saudi Arabia', 'code' => 966],
            ['title' => '法国', 'english' => 'France', 'code' => 33],
            ['title' => '法属圭亚那', 'english' => 'French Guiana', 'code' => 594],
            ['title' => '法属波利尼西亚', 'english' => 'French Polynesia', 'code' => 689],
            ['title' => '法属西印度群岛', 'english' => 'french west indies', 'code' => 596],
            ['title' => '法罗群岛', 'english' => 'Faroe Islands', 'code' => 298],
            ['title' => '波兰', 'english' => 'Poland', 'code' => 48],
            ['title' => '波多黎各', 'english' => 'The Commonwealth of Puerto Rico', 'code' => 17871939],
            ['title' => '波黑', 'english' => 'Bosnia and Herzegovina ', 'code' => 387],
            ['title' => '泰国', 'english' => 'Thailand', 'code' => 66],
            ['title' => '津巴布韦', 'english' => 'Zimbabwe', 'code' => 263],
            ['title' => '洪都拉斯', 'english' => 'Honduras', 'code' => 504],
            ['title' => '海地', 'english' => 'Haiti', 'code' => 509],
            ['title' => '澳大利亚', 'english' => 'Australia', 'code' => 61],
            ['title' => '澳门', 'english' => 'Macao', 'code' => 853],
            ['title' => '爱尔兰', 'english' => 'Ireland', 'code' => 353],
            ['title' => '爱沙尼亚', 'english' => 'Estonia', 'code' => 372],
            ['title' => '牙买加 ', 'english' => 'Jamaica', 'code' => 1876],
            ['title' => '特克斯和凯科斯群岛', 'english' => 'Turks and Caicos Islands', 'code' => 1649],
            ['title' => '特立尼达和多巴哥', 'english' => 'Trinidad and Tobago', 'code' => 1868],
            ['title' => '玻利维亚', 'english' => 'Bolivia', 'code' => 591],
            ['title' => '瑙鲁', 'english' => 'Nauru', 'code' => 674],
            ['title' => '瑞典', 'english' => 'Sweden', 'code' => 46],
            ['title' => '瑞士', 'english' => 'Switzerland', 'code' => 41],
            ['title' => '瓜德罗普', 'english' => 'Guadeloupe', 'code' => 590],
            ['title' => '瓦利斯和富图纳群岛', 'english' => 'Wallis et Futuna', 'code' => 681],
            ['title' => '瓦努阿图', 'english' => 'Vanuatu', 'code' => 678],
            ['title' => '留尼汪 ', 'english' => 'Reunion', 'code' => 262],
            ['title' => '白俄罗斯', 'english' => 'Belarus', 'code' => 375],
            ['title' => '百慕大', 'english' => 'Bermuda', 'code' => 1441],
            ['title' => '直布罗陀', 'english' => 'Gibraltar', 'code' => 350],
            ['title' => '福克兰群岛', 'english' => 'Falkland', 'code' => 500],
            ['title' => '科威特', 'english' => 'Kuwait', 'code' => 965],
            ['title' => '科摩罗和马约特', 'english' => 'Comoros', 'code' => 269],
            ['title' => '科特迪瓦', 'english' => 'Cote d’Ivoire', 'code' => 225],
            ['title' => '秘鲁', 'english' => 'Peru', 'code' => 51],
            ['title' => '突尼斯', 'english' => 'Tunisia', 'code' => 216],
            ['title' => '立陶宛', 'english' => 'Lithuania', 'code' => 370],
            ['title' => '索马里', 'english' => 'Somalia', 'code' => 252],
            ['title' => '约旦', 'english' => 'Jordan', 'code' => 962],
            ['title' => '纳米比亚', 'english' => 'Namibia', 'code' => 264],
            ['title' => '纽埃岛', 'english' => 'Island of Niue', 'code' => 683],
            ['title' => '缅甸  ', 'english' => 'Burma', 'code' => 95],
            ['title' => '罗马尼亚', 'english' => 'Romania', 'code' => 40],
            ['title' => '美国', 'english' => 'United States of America', 'code' => 1],
            ['title' => '美属维京群岛', 'english' => 'Virgin Islands', 'code' => 1340],
            ['title' => '美属萨摩亚', 'english' => 'American Samoa', 'code' => 1684],
            ['title' => '老挝', 'english' => 'Laos', 'code' => 856],
            ['title' => '肯尼亚', 'english' => 'Kenya', 'code' => 254],
            ['title' => '芬兰', 'english' => 'Finland', 'code' => 358],
            ['title' => '苏丹', 'english' => 'Sudan', 'code' => 249],
            ['title' => '苏里南', 'english' => 'Suriname', 'code' => 597],
            ['title' => '英国', 'english' => 'United Kingdom', 'code' => 44],
            ['title' => '英属维京群岛', 'english' => 'British Virgin Islands', 'code' => 1284],
            ['title' => '荷兰', 'english' => 'Netherlands', 'code' => 31],
            ['title' => '荷属安的列斯', 'english' => 'Netherlands Antilles', 'code' => 599],
            ['title' => '莫桑比克', 'english' => 'Mozambique', 'code' => 258],
            ['title' => '莱索托', 'english' => 'Lesotho', 'code' => 266],
            ['title' => '菲律宾', 'english' => 'Philippines', 'code' => 63],
            ['title' => '萨尔瓦多', 'english' => 'El Salvador', 'code' => 503],
            ['title' => '萨摩亚', 'english' => 'Samoa', 'code' => 685],
            ['title' => '葡萄牙', 'english' => 'Portugal', 'code' => 351],
            ['title' => '蒙古', 'english' => 'Mongolia', 'code' => 976],
            ['title' => '西班牙', 'english' => 'Spain', 'code' => 34],
            ['title' => '贝宁', 'english' => 'Benin', 'code' => 229],
            ['title' => '赞比亚', 'english' => 'Zambia', 'code' => 260],
            ['title' => '赤道几内亚', 'english' => 'Equatorial Guinea', 'code' => 240],
            ['title' => '越南', 'english' => 'Vietnam', 'code' => 84],
            ['title' => '阿塞拜疆', 'english' => 'Azerbaijan', 'code' => 994],
            ['title' => '阿富汗', 'english' => 'Afghanistan', 'code' => 93],
            ['title' => '阿尔及利亚', 'english' => 'Algeria', 'code' => 213],
            ['title' => '阿尔巴尼亚', 'english' => 'Albania', 'code' => 355],
            ['title' => '阿拉伯联合酋长国', 'english' => 'United Arab Emirates', 'code' => 971],
            ['title' => '阿曼', 'english' => 'Oman', 'code' => 968],
            ['title' => '阿根廷', 'english' => 'Argentina', 'code' => 54],
            ['title' => '阿鲁巴', 'english' => 'Aruba', 'code' => 297],
            ['title' => '韩国', 'english' => 'Korea, South)', 'code' => 82],
            ['title' => '香港', 'english' => 'Hong Kong(SAR)', 'code' => 852],
            ['title' => '马其顿', 'english' => 'Macedonia', 'code' => 389],
            ['title' => '马尔代夫', 'english' => 'Maldives  ', 'code' => 960],
            ['title' => '马拉维', 'english' => ' Malawi', 'code' => 265],
            ['title' => '马来西亚', 'english' => 'Malaysia', 'code' => 60],
            ['title' => '马绍尔群岛', 'english' => 'Marshall Islands', 'code' => 692],
            ['title' => '马耳他', 'english' => 'Malta', 'code' => 356],
            ['title' => '马达加斯加', 'english' => 'Madagascar', 'code' => 261],
            ['title' => '马里', 'english' => 'Mali', 'code' => 223],
            ['title' => '黎巴嫩', 'english' => 'Lebanon', 'code' => 961],
            ['title' => '黑山共和国', 'english' => 'The Republic of Montenegro', 'code' => 382],
        ];
    }

}
