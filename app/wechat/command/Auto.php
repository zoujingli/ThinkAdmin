<?php

// +----------------------------------------------------------------------
// | Wechat Plugin for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/think-plugs-wechat
// | github 代码仓库：https://github.com/zoujingli/think-plugs-wechat
// +----------------------------------------------------------------------

namespace app\wechat\command;

use app\wechat\model\WechatAuto;
use app\wechat\service\MediaService;
use app\wechat\service\WechatService;
use think\admin\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

/**
 * 向指定用户推送消息
 * @class Auto
 * @package app\wechat\command
 */
class Auto extends Command
{
    /** @var string */
    private $openid;

    /**
     * 配置消息指令
     */
    protected function configure()
    {
        $this->setName('xadmin:fansmsg');
        $this->addArgument('openid', Argument::OPTIONAL, 'wechat user openid', '');
        $this->addArgument('autocode', Argument::OPTIONAL, 'wechat auto message', '');
        $this->setDescription('Wechat Users Push AutoMessage for ThinkAdmin');
    }

    /**
     * @param Input $input
     * @param Output $output
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function execute(Input $input, Output $output)
    {
        $code = $input->getArgument('autocode');
        $this->openid = $input->getArgument('openid');
        if (empty($code)) $this->setQueueError("Message Code cannot be empty");
        if (empty($this->openid)) $this->setQueueError("Wechat Openid cannot be empty");

        // 查询微信消息对象
        $map = ['code' => $code, 'status' => 1];
        $data = WechatAuto::mk()->where($map)->find();
        if (empty($data)) $this->setQueueError("Message Data Query failed");

        // 发送微信客服消息
        $this->buildMessage($data->toArray());
    }

    /**
     * 关键字处理
     * @param array $data
     * @throws \WeChat\Exceptions\InvalidResponseException
     * @throws \WeChat\Exceptions\LocalCacheException
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function buildMessage(array $data)
    {
        $type = strtolower($data['type']);
        $result = [0, '待发送的消息不符合规则'];
        if ($type === 'text' && !empty($data['content'])) {
            $result = $this->sendMessage('text', ['content' => $data['content']]);
        }
        if ($type === 'voice' && !empty($data['voice_url'])) {
            if ($mediaId = MediaService::upload($data['voice_url'], 'voice')) {
                $result = $this->sendMessage('voice', ['media_id' => $mediaId]);
            }
        }
        if ($type === 'image' && !empty($data['image_url'])) {
            if ($mediaId = MediaService::upload($data['image_url'])) {
                $result = $this->sendMessage('image', ['media_id' => $mediaId]);
            }
        }
        if ($type === 'news') {
            [$item, $news] = [MediaService::news($data['news_id']), []];
            if (isset($item['articles']) && is_array($item['articles'])) {
                $host = sysconf('base.site_host') ?: true;
                foreach ($item['articles'] as $vo) if (empty($news)) $news[] = [
                    'url'   => url("@wechat/api.view/item/id/{$vo['id']}", [], false, $host)->build(),
                    'title' => $vo['title'], 'picurl' => $vo['local_url'], 'description' => $vo['digest'],
                ];
                $result = $this->sendMessage('news', ['articles' => $news]);
            }
        }
        if ($type === 'music' && !empty($data['music_url']) && !empty($data['music_title']) && !empty($data['music_desc'])) {
            $mediaId = $data['music_image'] ? MediaService::upload($data['music_image']) : '';
            $result = $this->sendMessage('music', [
                'hqmusicurl'  => $data['music_url'], 'musicurl' => $data['music_url'],
                'description' => $data['music_desc'], 'title' => $data['music_title'], 'thumb_media_id' => $mediaId,
            ]);
        }
        if ($type === 'video' && !empty($data['video_url']) && !empty($data['video_desc']) && !empty($data['video_title'])) {
            $video = ['title' => $data['video_title'], 'introduction' => $data['video_desc']];
            if ($mediaId = MediaService::upload($data['video_url'], 'video', $video)) {
                $result = $this->sendMessage('video', ['media_id' => $mediaId, 'title' => $data['video_title'], 'description' => $data['video_desc']]);
            }
        }
        if (empty($result[0])) {
            $this->setQueueError($result[1]);
        } else {
            $this->setQueueSuccess($result[1]);
        }
    }

    /**
     * 推送客服消息
     * @param string $type 消息类型
     * @param array $data 消息对象
     * @return array
     */
    private function sendMessage(string $type, array $data): array
    {
        try {
            WechatService::WeChatCustom()->send([
                $type => $data, 'touser' => $this->openid, 'msgtype' => $type,
            ]);
            return [1, '向微信用户推送消息成功'];
        } catch (\Exception $exception) {
            return [0, $exception->getMessage()];
        }
    }
}