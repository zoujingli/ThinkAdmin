<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkLibrary
// | github 代码仓库：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace think\admin\service;

use think\admin\extend\HttpExtend;
use think\admin\Service;

/**
 * 百度快递100物流查询
 * Class ExpressService
 * @package think\admin\service
 */
class ExpressService extends Service
{
    /**
     * 网络请求令牌
     * @var string
     */
    protected $token;

    /**
     * 网络请求参数
     * @var array
     */
    protected $options;

    /**
     * 快递服务初始化
     * @return Service
     * @throws \think\Exception
     */
    protected function initialize(): Service
    {
        $id = $this->app->request->ip();
        $this->options = [
            'cookie_file' => $this->app->getRuntimePath() . '_express_kuaidi100_cookie.txt',
            'headers'     => ['Host' => 'express.baidu.com', 'CLIENT-IP' => $id, 'X-FORWARDED-FOR' => $id],
        ];
        $this->token = $this->getExpressToken();
        return $this;
    }

    /**
     * 通过百度快递100应用查询物流信息
     * @param string $code 快递公司编辑
     * @param string $number 快递物流编号
     * @return array
     */
    public function express($code, $number)
    {
        list($list, $cache) = [[], $this->app->cache->get($ckey = md5($code . $number))];
        if (!empty($cache)) return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $cache];
        for ($i = 0; $i < 6; $i++) if (is_array($result = $this->doExpress($code, $number))) {
            if (!empty($result['data']['info']['context'])) {
                foreach ($result['data']['info']['context'] as $vo) $list[] = [
                    'time' => date('Y-m-d H:i:s', $vo['time']), 'context' => $vo['desc'],
                ];
                $this->app->cache->set($ckey, $list, 10);
                return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $list];
            }
        }
        return ['message' => 'ok', 'com' => $code, 'nu' => $number, 'data' => $list];
    }

    /**
     * 执行百度快递100应用查询请求
     * @param string $code 快递公司编号
     * @param string $number 快递单单号
     * @return mixed
     */
    private function doExpress($code, $number)
    {
        $url = "https://express.baidu.com/express/api/express?tokenV2={$this->token}&appid=4001&nu={$number}&com={$code}&qid=&new_need_di=1&source_xcx=0&vcode=&token=&sourceId=4155&cb=callback";
        return json_decode(str_replace('/**/callback(', '', trim(HttpExtend::get($url, [], $this->options), ')')), true);
    }

    /**
     * 获取接口请求令牌
     * @return string
     * @throws \think\Exception
     */
    public function getExpressToken()
    {
        if (preg_match('/express\?tokenV2=(.*?)",/', $this->getWapBaiduHtml(), $matches)) {
            return $matches[1];
        } else {
            throw new \think\Exception('Failed to grab authorization token.');
        }
    }

    /**
     * 获取快递公司列表
     * @return array
     */
    public function getExpressList()
    {
        $data = [];
        if (preg_match('/"currentData":.*?\[(.*?)\],/', $this->getWapBaiduHtml(), $matches)) {
            foreach (json_decode("[{$matches['1']}]") as $item) $data[$item->value] = $item->text;
            unset($data['_auto']);
        }
        return $data;
    }

    /**
     * 获取百度WAP快递HTML（用于后面的抓取关键值）
     * @return string
     */
    protected function getWapBaiduHtml()
    {
        $content = $this->app->cache->get('express_baidu_kuaidi_100');
        while (empty($content) || stristr($content, '百度安全验证') > -1 || stripos($content, 'tokenV2') === -1) {
            $content = HttpExtend::get('https://m.baidu.com/s?word=73124161428372', [], $this->options);
        }
        $this->app->cache->set('express_baidu_kuaidi_100', $content, 3600);
        return $content;
    }

}