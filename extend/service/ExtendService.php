<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace service;

use think\Db;
use think\Request;

/**
 * 扩展服务
 * Class ExtendService
 * @package service
 */
class ExtendService
{

    /**
     * 发送短信验证码
     * @param string $phone 手机号
     * @param string $content 短信内容
     * @param string $productid 短信通道ID
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function sendSms($phone, $content, $productid = '676767')
    {
        $tkey = date("YmdHis");
        $data = [
            'tkey'      => $tkey,
            'mobile'    => $phone,
            'content'   => $content,
            'username'  => sysconf('sms_username'),
            'productid' => $productid,
            'password'  => md5(md5(sysconf('sms_password')) . $tkey),
        ];
        $result = HttpService::post('http://www.ztsms.cn/sendNSms.do', $data);
        list($code, $msg) = explode(',', $result . ',');
        $insert = ['phone' => $phone, 'content' => $content, 'result' => $result];
        Db::name('MemberSmsHistory')->insert($insert);
        return intval($code) === 1;
    }

    /**
     * 查询短信余额
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function querySmsBalance()
    {
        $tkey = date("YmdHis");
        $data = [
            'tkey'     => $tkey,
            'username' => sysconf('sms_username'),
            'password' => md5(md5(sysconf('sms_password')) . $tkey),
        ];
        $result = HttpService::post('http://www.ztsms.cn/balanceN.do', $data);
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
     * 通用物流单查询
     * @param string $code 快递物流编号
     * @return array
     */
    public static function expressByAuto($code)
    {
        list($result, $client_ip) = [[], Request::instance()->ip()];
        $header = ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $client_ip, 'X-FORWARDED-FOR' => $client_ip];
        $autoResult = HttpService::get("http://www.kuaidi100.com/autonumber/autoComNum?text={$code}", [], ['header' => $header, 'timeout' => 30]);
        foreach (json_decode($autoResult)->auto as $vo) {
            $result[$vo->comCode] = self::express($vo->comCode, $code);
        }
        return $result;
    }

    /**
     * 查询物流信息
     * @param string $express_code 快递公司编辑
     * @param string $express_no 快递物流编号
     * @return array
     */
    public static function express($express_code, $express_no)
    {
        list($microtime, $client_ip) = [microtime(true), Request::instance()->ip()];
        $header = ['Host' => 'www.kuaidi100.com', 'CLIENT-IP' => $client_ip, 'X-FORWARDED-FOR' => $client_ip];
        $location = "http://www.kuaidi100.com/query?type={$express_code}&postid={$express_no}&id=1&valicode=&temp={$microtime}";
        return json_decode(HttpService::get($location, [], ['header' => $header, 'timeout' => 30]), true);
    }

    /**
     * 下载CSV文件
     * @param string $filename 导出文件名
     * @param array $options 数据规则,如：['用户名'=>'username','性别'=>'sex']
     * @param \think\Db\Query $query
     * @throws \think\exception\DbException
     */
    public static function downloadCsv($filename, $options, $query)
    {
        self::downloadCsvHeader($filename, array_keys($options));
        $query->chunk(1000, function ($list) use ($options) {
            self::downloadCsvBody($list, array_values($options));
        });
    }

    /**
     * 写入CSV文件头部
     * @param string $filename 导出文件
     * @param array $headers CSV 头部(一级数组)
     */
    public static function downloadCsvHeader($filename, $headers)
    {
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename=" . iconv('utf-8', 'gbk//TRANSLIT', $filename));
        echo @iconv('utf-8', 'gbk//TRANSLIT', '"' . implode('","', $headers) . "\"\n");
    }

    /**
     * 写入CSV文件内容
     * @param array $list 数据列表(二维数组或多维数组)
     * @param array $rules 数据规则(一维数组)
     */
    public static function downloadCsvBody($list, $rules)
    {
        foreach ($list as $data) {
            $rows = [];
            foreach ($rules as $rule) {
                $item = self::parseKeyDot($data, $rule);
                $rows[] = $item === $data ? '' : $item;
            }
            echo @iconv('utf-8', 'gbk//TRANSLIT', '"' . implode('","', $rows) . "\"\n");
            flush();
        }
    }

    /**
     * 根据数组key查询(可带点规则)
     * @param array $data 数据
     * @param string $rule 规则，如: order.order_no
     * @return mixed
     */
    private static function parseKeyDot($data, $rule)
    {
        list($temp, $attr) = [$data, explode('.', trim($rule, '.'))];
        while ($key = array_shift($attr)) {
            $temp = isset($temp[$key]) ? $temp[$key] : $temp;
        }
        return is_string($temp) ? $temp : '';
    }

}
