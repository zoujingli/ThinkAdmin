<?php

namespace app\data\command;

use app\data\service\UserRebateService;
use think\admin\Command;
use think\admin\Exception;
use think\admin\storage\LocalStorage;
use think\console\Input;
use think\console\Output;
use WePay\Transfers;
use WePay\TransfersBank;

/**
 * 用户提现处理
 * Class UserTransfer
 * @package app\data\command
 */
class UserTransfer extends Command
{
    protected function configure()
    {
        $this->setName('xdata:UserTransfer');
        $this->setDescription('批量执行线上打款操作');
    }

    /**
     * 执行微信提现操作
     * @param Input $input
     * @param Output $output
     * @return void
     * @throws \think\db\exception\DbException
     */
    protected function execute(Input $input, Output $output)
    {
        $map = [['type', 'in', ['wechat_banks', 'wechat_wallet']], ['status', 'in', [3, 4]]];
        foreach ($this->app->db->name('DataUserTransfer')->where($map)->cursor() as $vo) try {
            if ($vo['status'] === 3) {
                if ($vo['type'] === 'wechat_banks') {
                    $result = $this->createTransferBank($vo);
                } else {
                    $result = $this->createTransferWallet($vo);
                }
                if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
                    $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                        'status'      => 4,
                        'trade_no'    => $result['partner_trade_no'],
                        'trade_time'  => $result['payment_time'] ?? date('Y-m-d H:i:s'),
                        'change_time' => date('Y-m-d H:i:s'),
                        'change_desc' => '创建微信提现成功',
                    ]);
                } else {
                    $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                        'change_time' => date('Y-m-d H:i:s'), 'change_desc' => $result['err_code_des'] ?? '线上提现失败',
                    ]);
                }
            } elseif ($vo['status'] === 4) {
                if ($vo['type'] === 'wechat_banks') {
                    $this->queryTransferBank($vo);
                } else {
                    $this->queryTransferWallet($vo);
                }
            }
        } catch (\Exception $exception) {
            $this->output->writeln("订单 {$vo['code']} 提现失败，{$exception->getMessage()}");
            $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                'change_time' => date('Y-m-d H:i:s'), 'change_desc' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * 尝试提现转账到银行卡
     * @param array $item
     * @return array
     * @throws Exception
     * @throws \WeChat\Exceptions\InvalidDecryptException
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function createTransferBank(array $item): array
    {
        return TransfersBank::instance($this->getConfig($item['uid']))->create([
            'partner_trade_no' => $item['code'],
            'enc_bank_no'      => $item['bank_code'],
            'enc_true_name'    => $item['bank_user'],
            'bank_code'        => $item['bank_wseq'],
            'amount'           => intval($item['amount'] - $item['charge_amount']) * 100,
            'desc'             => '微信银行卡提现',
        ]);
    }

    /**
     * 尝试提现转账到微信钱包
     * @param array $item
     * @return array
     * @throws Exception
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function createTransferWallet(array $item): array
    {
        $config = $this->getConfig($item['uid']);
        return Transfers::instance($config)->create([
            'openid'           => $config['openid'],
            'amount'           => intval($item['amount'] - $item['charge_amount']) * 100,
            'partner_trade_no' => $item['code'],
            'spbill_create_ip' => '127.0.0.1',
            'check_name'       => 'NO_CHECK',
            'desc'             => '微信余额提现',
        ]);
    }

    /**
     * 查询更新提现打款状态
     * @param array $item
     * @throws Exception
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function queryTransferWallet(array $item)
    {
        $result = Transfers::instance($this->getConfig($item['uid']))->query($item['partner_trade_no']);
        if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
            $this->app->db->name('DataUserTransfer')->where(['code' => $item['code']])->update([
                'status'      => 5,
                'trade_time'  => $result['payment_time'],
                'change_time' => date('Y-m-d H:i:s'),
                'change_desc' => '微信提现打款成功',
            ]);
        }
    }

    /**
     * 查询更新提现打款状态
     * @param array $item
     * @throws Exception
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function queryTransferBank(array $item)
    {
        $result = TransfersBank::instance($this->getConfig($item['uid']))->query($item['partner_trade_no']);
        if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
            if ($result['status'] === 'SUCCESS') {
                $this->app->db->name('DataUserTransfer')->where(['code' => $item['code']])->update([
                    'status'      => 5,
                    'trade_time'  => $result['pay_succ_time'] ?: date('Y-m-d H:i:s'),
                    'change_time' => date('Y-m-d H:i:s'),
                    'change_desc' => '微信提现打款成功',
                ]);
            }
            if (in_array($result['status'], ['FAILED', 'BANK_FAIL'])) {
                $this->app->db->name('DataUserTransfer')->where(['code' => $item['code']])->update([
                    'status'      => 0,
                    'change_time' => date('Y-m-d H:i:s'),
                    'change_desc' => '微信提现打款失败',
                ]);
                // 刷新用户可提现余额
                UserRebateService::instance()->amount($item['uid']);
            }
        }
    }

    /**
     * 根据配置获取用户OPENID
     * @param int $uid
     * @param string $type
     * @return mixed|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getWechatInfo(int $uid, string $type): ?array
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uid])->find();
        if (empty($user)) return null;
        $appid1 = sysdata('data.wxapp_appid');
        if (strtolower(sysconf('wechat.type')) === 'api') {
            $appid2 = sysconf('wechat.appid');
        } else {
            $appid2 = sysconf('wechat.thr_appid');
        }
        if ($type === 'normal') {
            if (!empty($user['openid1'])) return [$appid1, $user['openid1']];
            if (!empty($user['openid2'])) return [$appid2, $user['openid2']];
        }
        if ($type === 'wxapp' && !empty($user['openid1'])) {
            return [$appid1, $user['openid1']];
        }
        if ($type === 'wechat' && !empty($user['openid2'])) {
            return [$appid2, $user['openid2']];
        }
        return null;
    }

    /**
     * 获取微信提现参数
     * @param int $uid
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getConfig(int $uid): array
    {
        $data = sysdata('TransferWxpay');
        if (empty($data)) throw new Exception('未配置微信提现商户');
        // 商户证书文件处理
        $local = LocalStorage::instance();
        if (!$local->has($file1 = "{$data['wechat_mch_id']}_key.pem", true)) {
            $local->set($file1, $data['wechat_mch_key_text'], true);
        }
        if (!$local->has($file2 = "{$data['wechat_mch_id']}_cert.pem", true)) {
            $local->set($file2, $data['wechat_mch_cert_text'], true);
        }
        // 获取用户支付信息
        if (is_array($result = $this->getWechatInfo($uid, $data['wechat_type']))) {
            [$appid, $openid] = $result;
        } else {
            throw new Exception('获取用户打款信息失败');
        }
        return [
            'appid'      => $appid,
            'openid'     => $openid,
            'mch_id'     => $data['wechat_mch_id'],
            'mch_key'    => $data['wechat_mch_key'],
            'ssl_key'    => $local->path($file1),
            'ssl_cer'    => $local->path($file2),
            'cache_path' => $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . 'wechat',
        ];
    }
}