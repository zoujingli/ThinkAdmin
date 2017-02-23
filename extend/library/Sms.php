<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

namespace library;

use think\Db;
use think\Log;

/**
 * 助通短信接口（旧版API）
 *
 * @package library
 * @author Anyon <zoujingli@qq.com>
 * @date 2016/11/15 10:01
 */
class Sms {

    /**
     * 接口URI地址
     * @var string
     */
    protected $uri = 'http://www.ztsms.cn:8800/sendSms.do';

    /**
     * 短信内容
     * @var string
     */
    protected $content;

    /**
     * 发送短信
     * @param string $mobile
     * @return bool
     */
    public function send($mobile) {
        $data = $this->createPack($mobile, $this->content);
        $result = Http::get($this->uri, $data);
        $data['status'] = $result;
        $data['create_by'] = get_user_id();
        Db::table('system_sms_history')->insert($data);
        list($status, $msg) = explode(',', "{$result},-1");
        if ($status === '1') {
            return TRUE;
        }
        Log::error("给[{$mobile}]短信发送失败，{$msg}");
        return FALSE;
    }

    /**
     * 内容模板数据解析
     * @param string $tpl 短信模板内容
     * @param array $data 短信模板值
     * @return $this
     */
    public function render($tpl, $data) {
        $content = !sysconf($tpl) ? $tpl : sysconf($tpl);
        foreach ($data as $key => $value) {
            $content = str_replace("{{$key}}", $value, $content);
        }
        $this->content = $content;
        return $this;
    }

    /**
     * 创建短信接口数据
     * @param string $mobile
     * @param string $content
     * @return array
     */
    protected function createPack($mobile, $content) {
        $data = array();
        $data['username'] = sysconf('sms_username');
        $data['password'] = md5(sysconf('sms_password'));
        $data['mobile'] = $mobile;
        $data['content'] = $content;
        $data['productid'] = sysconf('sms_product');
        return $data;
    }

}
