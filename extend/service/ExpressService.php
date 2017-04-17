<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2014~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace service;

/**
 * 物流查询服务
 * Class ExpressService
 * @package service
 * @author Anyon <zoujingli@qq.com>
 * @date 2017/03/15 15:17
 */
class ExpressService {

    const APPID = '1232779';
    const APPKEY = 'ac45f461-8c1a-4518-87b1-bb8e835a2f9d';
    const APIURI = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

    /**
     * @brief 获取物流轨迹线路
     * @param $ShipperCode string 物流公司代号
     * @param $LogisticCode string 物流单号
     * @return string array 轨迹数据
     */
    public static function line($ShipperCode, $LogisticCode) {
        $sendData = json_encode(array('ShipperCode' => $ShipperCode, 'LogisticCode' => $LogisticCode), JSON_UNESCAPED_UNICODE);
        $data = array(
            'RequestData' => $sendData,
            'EBusinessID' => self::APPID,
            'RequestType' => '1002',
            'DataType'    => 2,
            'DataSign'    => base64_encode(md5($sendData . self::APPKEY)),
        );
        $result = HttpService::post(self::APIURI, $data);
        $resultJson = json_decode($result, true);
        if (!$resultJson) {
            die(var_export($result));
        }
        return self::response($resultJson);
    }

    /**
     * 处理返回数据统一数据格式
     * @param $result 结果处理
     * @return array 通用的结果集 array('result' => 'success或者fail','data' => array( array('time' => '时间','info' => '地点'),......),'reason' => '失败原因')
     */
    public static function response($result) {
        $status = "fail";
        $data = array();
        $message = "此单号无跟踪记录";
        if (isset($result['Message'])) {
            $message = $result['Message'];
        } else if (isset($result['Reason'])) {
            $message = $result['Reason'];
        }
        if (isset($result['Traces']) && $result['Traces']) {
            foreach ($result['Traces'] as $key => $val) {
                $data[$key]['time'] = $val['AcceptTime'];
                $data[$key]['info'] = $val['AcceptStation'];
            }
            $status = "success";
            $message = '此订单号有' . count($data) . '条跟踪记录';
        }

        return array('result' => $status, 'data' => $data, 'message' => $message);
    }

    /**
     * CURL模拟提交数据
     * @param $url string 提交的url
     * @param $data array 要发送的数据
     * @return mixed 返回的数据
     */
    private static function curl_post($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, self::_encode_data($data));
        return curl_exec($ch);
    }

    /**
     * 进行数据的string字符串编码
     * @param type $datas
     * @return type
     */
    private static function _encode_data($datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        return join('&', $temps);
    }

}
