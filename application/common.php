<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------


use service\DataService;
use service\NodeService;
use service\UserService;
use Wechat\Loader;
use think\Db;

/**
 * 打印输出数据到文件
 * @param mixed $data
 * @param bool $replace
 * @param string|null $pathname
 */
function p($data, $replace = false, $pathname = null)
{
    is_null($pathname) && $pathname = RUNTIME_PATH . date('Ymd') . '.txt';
    $str = (is_string($data) ? $data : (is_array($data) || is_object($data)) ? print_r($data, true) : var_export($data, true)) . "\n";
    $replace ? file_put_contents($pathname, $str) : file_put_contents($pathname, $str, FILE_APPEND);
}

/**
 * 获取微信操作对象
 * @param string $type
 * @return \Wechat\WechatReceive|\Wechat\WechatUser|\Wechat\WechatPay|\Wechat\WechatScript|\Wechat\WechatOauth|\Wechat\WechatMenu|\Wechat\WechatMedia
 */
function & load_wechat($type = '')
{
    static $wechat = [];
    $index = md5(strtolower($type));
    if (!isset($wechat[$index])) {
        $config = [
            'token'          => sysconf('wechat_token'),
            'appid'          => sysconf('wechat_appid'),
            'appsecret'      => sysconf('wechat_appsecret'),
            'encodingaeskey' => sysconf('wechat_encodingaeskey'),
            'mch_id'         => sysconf('wechat_mch_id'),
            'partnerkey'     => sysconf('wechat_partnerkey'),
            'ssl_cer'        => sysconf('wechat_cert_cert'),
            'ssl_key'        => sysconf('wechat_cert_key'),
            'cachepath'      => CACHE_PATH . 'wxpay' . DS,
        ];
        $wechat[$index] = Loader::get($type, $config);
    }
    return $wechat[$index];
}

/**
 * UTF8字符串加密
 * @param string $string
 * @return string
 */
function encode($string)
{
    $chars = '';
    $len = strlen($string = iconv('utf-8', 'gbk', $string));
    for ($i = 0; $i < $len; $i++) {
        $chars .= str_pad(base_convert(ord($string[$i]), 10, 36), 2, 0, 0);
    }
    return strtoupper($chars);
}

/**
 * UTF8字符串解密
 * @param string $string
 * @return string
 */
function decode($string)
{
    $chars = '';
    foreach (str_split($string, 2) as $char) {
        $chars .= chr(intval(base_convert($char, 36, 10)));
    }
    return iconv('gbk', 'utf-8', $chars);
}

/**
 * RBAC节点权限验证
 * @param string $node
 * @return bool
 */
function auth($node)
{
    return NodeService::checkAuthNode($node);
}

/**
 * 设备或配置系统参数
 * @param string $name 参数名称
 * @param bool $value 默认是false为获取值，否则为更新
 * @return string|bool
 */
function sysconf($name, $value = false)
{
    static $config = [];
    if ($value !== false) {
        $config = [];
        $data = ['name' => $name, 'value' => $value];
        return DataService::save('SystemConfig', $data, 'name');
    }
    if (empty($config)) {
        foreach (Db::name('SystemConfig')->select() as $vo) {
            $config[$vo['name']] = $vo['value'];
        }
    }
    return isset($config[$name]) ? $config[$name] : '';
}

/**
 * array_column 函数兼容
 */
if (!function_exists("array_column")) {

    function array_column(array &$rows, $column_key, $index_key = null)
    {
        $data = [];
        foreach ($rows as $row) {
            if (empty($index_key)) {
                $data[] = $row[$column_key];
            } else {
                $data[$row[$index_key]] = $row[$column_key];
			}
		}
		return $data;
	}

}

/**
 * 输出时间格式
 *
 * @param string $time
 */
function time_output($time = NULL)
{
	$time = $time === NULL ? NOW_TIME: intval($time);
	return array(
		'timestamp' => $time, 
		'date' => day_format($time), 
		'datetime' => time_format($time), 
		'friendly_time' => time_format($time, 'friendly'), 
		'year' => date('Y', $time), 
		'month' => date('Ym', $time), 
		'day' => date('Ymd', $time), 
		'time' => hour_format($time)
	);
}

/**
 * 时间戳格式化
 *
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL, $format = 'Y-m-d H:i')
{
	$time = $time === NULL ? time(): intval($time);
	if($format == 'friendly')
		return time_friendly_format($time);
	else
		return date($format, $time);
}

/**
 * 友好的日期格式化
 *
 * @param unknown_type $sTime
 */
function time_friendly_format($sTime)
{
	$str_postfix = '前';
	$now_time = time();
	$dur = $now_time - $sTime;
	if($dur < 0)
		$str_postfix = '后';
	$dur = abs($dur);
	
	if($dur < 10)
		return '刚刚';
	if($dur < 60)
		return $dur . '秒' . $str_postfix;
	if($dur < 3600)
		return floor($dur / 60) . '分钟' . $str_postfix;
	if($dur < 86400)
		return floor($dur / 3600) . '小时' . $str_postfix;
	if($dur < 86400 * 30)
		return floor($dur / 86400) . '天' . $str_postfix;
	else
		return date('Y-m-d', $sTime);
}

/**
 * 日期格式化
 *
 * @param unknown $time
 * @return string
 */
function day_format($time = NULL)
{
	return time_format($time, 'Y-m-d');
}

/**
 * 时间格式化
 *
 * @param unknown $time
 */
function hour_format($time = NULL)
{
	return time_format($time, 'H:i:s');
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) 
{
	$type       =  $type ? 1 : 0;
	static $ip  =   NULL;
	if ($ip !== NULL) return $ip[$type];
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos    =   array_search('unknown',$arr);
		if(false !== $pos) unset($arr[$pos]);
		$ip     =   trim($arr[0]);
	}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip     =   $_SERVER['HTTP_CLIENT_IP'];
	}elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip     =   $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$long = sprintf("%u",ip2long($ip));
	$ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	return $ip[$type];
}

/**
 * 获取用户信息
 * @param int $id
 * @param string $field
 * @return mixed
 */
function getUserById($id, $name='*')
{
	// 获取详情
	$data = UserService::getUserById($id, $name);
	if (empty($data)) return;
	return array_key_exists($name, $data) ? $data[$name] : $data;
}

/**
 * 获取用户信息
 * @param int $id
 * @param string $field
 * @return mixed
 */
function getUserByOpenid($openid, $name='*')
{
	// 获取详情
	$data = UserService::getUserByOpenid($openid, $name);
	if (empty($data)) return;
	return array_key_exists($name, $data) ? $data[$name] : $data;
}

/**
 * 获取落地页链接
 *
 * @param int $guid
 * @return string
 */
function getWorksUrl($guid)
{
	return '/works/' . $guid . '.html';
}