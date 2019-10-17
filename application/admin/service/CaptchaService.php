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

namespace app\admin\service;

use think\facade\Cache;

/**
 * 图形验证码服务
 * Class CaptchaService
 * @package app\data\service
 */
class CaptchaService
{
    private $code; // 验证码
    private $uniqid; // 唯一序号
    private $charset = 'ABCDEFGHKMNPRSTUVWXYZ23456789'; // 随机因子
    private $codelen = 4; // 验证码长度
    private $width = 130; // 宽度
    private $height = 50; // 高度
    private $img; // 图形资源句柄
    private $font; // 指定的字体
    private $fontsize = 20; // 指定字体大小
    private $fontcolor; // 指定字体颜色

    /**
     * 构造方法初始化
     * CaptchaService constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        // 动态配置属性
        foreach ($config as $k => $v) if (isset($this->$k)) $this->$k = $v;
        // 生成验证码序号
        $this->uniqid = uniqid('captcha') . mt_rand(1000, 9999);
        // 生成验证码字符串
        $length = strlen($this->charset) - 1;
        for ($i = 0; $i < $this->codelen; $i++) {
            $this->code .= $this->charset[mt_rand(0, $length)];
        }
        // 缓存验证码字符串
        Cache::tag('captcha')->set($this->uniqid, $this->code, 360);
        // 设置字体文件路径
        $this->font = __DIR__ . '/font/icon.ttf';
    }

    /**
     * 创建验证码图片
     * @return string
     */
    private function createImage()
    {
        // 生成背景
        $this->img = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($this->img, mt_rand(220, 255), mt_rand(220, 255), mt_rand(220, 255));
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
        // 生成线条
        for ($i = 0; $i < 6; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(0, 50), mt_rand(0, 50), mt_rand(0, 50));
            imageline($this->img, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
        }
        // 生成雪花
        for ($i = 0; $i < 100; $i++) {
            $color = imagecolorallocate($this->img, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
            imagestring($this->img, mt_rand(1, 5), mt_rand(0, $this->width), mt_rand(0, $this->height), '*', $color);
        }
        // 生成文字
        $_x = $this->width / $this->codelen;
        for ($i = 0; $i < $this->codelen; $i++) {
            $this->fontcolor = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
            imagettftext($this->img, $this->fontsize, mt_rand(-30, 30), $_x * $i + mt_rand(1, 5), $this->height / 1.4, $this->fontcolor, $this->font, $this->code[$i]);
        }
        ob_start();
        imagepng($this->img);
        $data = ob_get_contents();
        ob_end_clean();
        imagedestroy($this->img);
        return base64_encode($data);
    }

    /**
     * 获取验证码
     * @return array
     */
    public function getAttr()
    {
        return [
            'code' => $this->code,
            'uniq' => $this->uniqid,
            'data' => $this->getData()
        ];
    }

    /**
     * 获取验证码值
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * 获取图片内容
     * @return string
     */
    public function getData()
    {
        return "data:image/png;base64,{$this->createImage()}";
    }

    /**
     * 获取验证码编号
     * @return string
     */
    public function getUniqid()
    {
        return $this->uniqid;
    }

    /**
     * 检查验证码是否正确
     * @param string $code 需要验证的值
     * @param string $uniqid 验证码编号
     * @return boolean
     */
    public static function check($code, $uniqid = null)
    {
        $_uni = is_string($uniqid) ? $uniqid : input('uniqid', '-');
        $_val = Cache::tag('captcha')->get($_uni);
        Cache::tag('captcha')->rm($_uni);
        return is_string($_val) && strtolower($_val) === strtolower($code);
    }
}
