<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

namespace WeOpen;

use WeChat\Contracts\Tools;

/**
 * 公众号小程序授权支持
 * Class MiniApp
 * @package WeOpen
 */
class MiniApp extends Service
{

    /**
     * code换取session_key
     * @param string $appid 小程序的AppID
     * @param string $code 登录时获取的code
     * @return mixed
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     */
    public function session($appid, $code)
    {
        $component_appid = $this->config->get('component_appid');
        $component_access_token = $this->getComponentAccessToken();
        $url = "https://api.weixin.qq.com/sns/component/jscode2session?appid={$appid}&js_code={$code}&grant_type=authorization_code&component_appid={$component_appid}&component_access_token={$component_access_token}";
        return json_decode(Tools::get($url), true);
    }

}
