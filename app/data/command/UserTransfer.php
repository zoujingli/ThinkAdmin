<?php

namespace app\data\command;

use app\data\service\DataService;
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
        $map = [['type', 'in', ['wechat_banks', 'wechat_wallet']], ['status', '=', 3]];
        foreach ($this->app->db->name('DataUserTransfer')->where($map)->cursor() as $vo) try {
            if ($vo['type'] === 'wechat_banks') {
                $result = $this->transferBank($vo);
            } else {
                $result = $this->transferWallet($vo);
            }
            if ($result['return_code'] === 'SUCCESS' && $result['result_code'] === 'SUCCESS') {
                $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                    'status'      => 4,
                    'trade_no'    => $result['partner_trade_no'],
                    'trade_time'  => $result['payment_time'],
                    'change_time' => date('Y-m-d H:i:s'),
                    'change_desc' => '线上微信提现成功',
                ]);
            } else {
                $this->app->db->name('DataUserTransfer')->where(['code' => $vo['code']])->update([
                    'change_time' => date('Y-m-d H:i:s'), 'change_desc' => $result['err_code_des'] ?? '线上提现失败',
                ]);
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
    private function transferBank(array $item): array
    {
        $wechat = TransfersBank::instance($this->getPayment());
        return $wechat->create([
            'partner_trade_no' => $item['code'],
            'enc_bank_no'      => $item['bank_code'],
            'enc_true_name'    => $item['bank_user'],
            'bank_code'        => '1002',
            'amount'           => $item['amount'] * 100,
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
    private function transferWallet(array $item): array
    {
        $wechat = Transfers::instance($config = $this->getPayment());
        return $wechat->create([
            'openid'           => $this->getUserOpenid($item['uid'], $config),
            'amount'           => $item['amount'] * 100,
            'partner_trade_no' => $item['code'],
            'spbill_create_ip' => '127.0.0.1',
            'check_name'       => 'NO_CHECK',
            'desc'             => '微信余额提现',
        ]);
    }

    /**
     * 根据配置获取用户OPENID
     * @param int $uid
     * @param array $config
     * @return mixed|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function getUserOpenid(int $uid, array $config)
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uid])->find();
        if (empty($user)) return null;
        if ($config['type'] === 'normal') {
            if (!empty($user['openid1'])) return $user['openid1'];
            if (!empty($user['openid2'])) return $user['openid2'];
        }
        if ($config['type'] === 'wxapp' && $user['openid1']) {
            return $user['openid1'];
        }
        if ($config['type'] === 'wechat' && !empty($user['openid2'])) {
            return $user['openid2'];
        }
        return null;
    }

    /**
     * 获取微信提现参数
     * @return array
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function getPayment(): array
    {
        $data = sysdata('TransferWxpay');
        if (empty($data)) throw new Exception('未配置微信提现商户');
        $key1 = LocalStorage::instance()->set("{$data['wechat_mch_id']}_key.pem", $data['wechat_mch_key_text'], true);
        $key2 = LocalStorage::instance()->set("{$data['wechat_mch_id']}_cert.pem", $data['wechat_mch_cert_text'], true);
        return [
            'type'       => $data['wechat_type'],
            'appid'      => $data['wechat_appid'],
            'mch_id'     => $data['wechat_mch_id'],
            'mch_key'    => $data['wechat_mch_key'],
            'ssl_key'    => $key1['file'],
            'ssl_cer'    => $key2['file'],
            'cache_path' => $this->app->getRootPath() . 'runtime' . DIRECTORY_SEPARATOR . 'wechat',
        ];
    }
}