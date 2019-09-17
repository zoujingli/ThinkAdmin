<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\company\controller\api;

use app\company\service\DataService;
use library\Controller;
use think\Db;

/**
 * ARP-SAN 推送内容接收
 * Class Push
 * @package app\company\controller\api
 */
class Push extends Controller
{
    /**
     * ARP-SAN 推送内容接收
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function index()
    {
        // 数据输入检查
        $content = file_get_contents('php://input');
        if (empty($content)) $this->error('没有接收到数据');
        // 企业员工检查
        $where = ['is_deleted' => '0', 'status' => '1'];
        $users = Db::name('CompanyUser')->cache(10)->where($where)->column('id uid,nickname name,mobile_macs mac');
        if (empty($users)) $this->error('没有需要打卡的用户');
        // 企业员工检查
        $macs = [];
        foreach ($users as $user) foreach (explode("\n", preg_replace('/\s+/', "\n", $user['mac'])) as $mac) {
            if (DataService::applyMacValue($mac)) $macs[$mac] = ['uid' => $user['uid'], 'name' => $user['name']];
        }
        // 数据内容解析
        list($s, $e) = [0, 0];
        foreach (explode("\n", $content) as $line) {
            list($ip, $mac, $dsc) = explode(' ', preg_replace('/\s+/', ' ', trim($line)) . '  ');
            if (preg_match('/^(\d+\.?){4}$/', $ip) && DataService::applyMacValue($mac)) {
                if (isset($macs[$mac])) {
                    $s++;
                    $this->writeUser($ip, $mac, strtoupper($dsc), $macs);
                } else {
                    $e++;
                    $this->writeNone($ip, $mac, strtoupper($dsc));
                }
            }
        }
        return "接收到{$s}个已知设备推送，{$e}个未知设备推送。" . PHP_EOL . PHP_EOL;
    }

    /**
     * 已知设备打卡记录
     * @param string $ip 内网地址
     * @param string $mac 设备地址
     * @param string $desc 设备描述
     * @param array $macs 用户MAC列表
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function writeUser($ip, $mac, $desc, $macs)
    {
        if (isset($macs[$mac])) {
            $data = $macs[$mac];
            $data['ip'] = $ip;
            $data['mac'] = $mac;
            $data['desc'] = $desc;
            $data['date'] = date('Y-m-d');
            $data['end_at'] = date('Y-m-d H:i:s');
            data_save('CompanyUserClock', $data, 'uid', ['date' => $data['date']]);
        }
    }

    /**
     * 未知设备额外标识
     * @param string $ip 内网地址
     * @param string $mac 设备地址
     * @param string $desc 设备描述
     */
    private function writeNone($ip, $mac, $desc)
    {
        // @todo 记录未匹配成功的设备标识
    }
}
