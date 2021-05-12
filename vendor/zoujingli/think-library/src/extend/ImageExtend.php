<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2021 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://gitee.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 仓库地址 ：https://gitee.com/zoujingli/ThinkLibrary
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

declare (strict_types=1);

namespace think\admin\extend;

/**
 * Image 压缩工具
 * Class ImageExtend
 * @package think\admin\extend
 */
class ImageExtend
{
    private $src;
    private $image;
    private $imageinfo;
    private $percent = 0.5;

    /**
     * 图片压缩
     * @param string $src 源图
     * @param float $percent 压缩比例
     */
    public function __construct(string $src, float $percent = 1)
    {
        $this->src = $src;
        $this->percent = $percent;
    }

    /**
     * 高清压缩图片
     * @param string $saveName 提供图片名
     * @return array
     */
    public function compress(string $saveName = ''): array
    {
        [$status, $message] = $this->_openImage();
        if (empty($status)) {
            return [0, $message];
        } elseif (empty($saveName)) {
            return $this->_showImage();
        } else {
            return $this->_saveImage($saveName);
        }
    }

    /**
     * 内部：打开图片
     * @return array
     */
    private function _openImage(): array
    {
        [$width, $height, $type, $attr] = getimagesize($this->src);
        if ($width < 1 || $height < 1) return [0, '读取图片尺寸失败！'];
        $this->imageinfo = ['width' => $width, 'height' => $height, 'attr' => $attr, 'type' => image_type_to_extension($type, false)];
        $fun = "imagecreatefrom{$this->imageinfo['type']}";
        $this->image = $fun($this->src);
        return $this->_thumpImage();
    }

    /**
     * 内部：操作图片
     */
    private function _thumpImage(): array
    {
        $newWidth = intval($this->imageinfo['width'] * $this->percent);
        $newHeight = intval($this->imageinfo['height'] * $this->percent);
        $imgThumps = imagecreatetruecolor($newWidth, $newHeight);
        // 将原图复制带图片载体上面，并且按照一定比例压缩，极大的保持了清晰度
        imagecopyresampled($imgThumps, $this->image, 0, 0, 0, 0, $newWidth, $newHeight, $this->imageinfo['width'], $this->imageinfo['height']);
        imagedestroy($this->image);
        $this->image = $imgThumps;
        return [1, '图片压缩成功'];
    }

    /**
     * 输出图片:保存图片则用 saveImage()
     * @return array
     */
    private function _showImage(): array
    {
        header("Content-Type: image/{$this->imageinfo['type']}");
        $funcs = "image{$this->imageinfo['type']}";
        $funcs($this->image);
        return [1, '图片内容输出成功'];
    }

    /**
     * 保存图片到硬盘：
     * @param string $dstImgName
     * @return array
     */
    private function _saveImage(string $dstImgName): array
    {
        if (empty($dstImgName)) return [0, '未指定存储目标路径'];

        // 如果目标图片名有后缀就用目标图片扩展名 后缀，如果没有，则用源图的扩展名
        $allowImgs = ['.jpg', '.jpeg', '.png', '.bmp', '.wbmp', '.gif'];
        [$srcExt, $dstExt] = [strrchr($this->src, "."), strrchr($dstImgName, ".")];
        if (!empty($srcExt)) $srcExt = strtolower($srcExt);
        if (!empty($dstExt)) $dstExt = strtolower($dstExt);

        // 有指定目标名扩展名
        if (!empty($dstExt) && in_array($dstExt, $allowImgs)) {
            $dstName = $dstImgName;
        } elseif (!empty($srcExt) && in_array($srcExt, $allowImgs)) {
            $dstName = $dstImgName . $srcExt;
        } else {
            $dstName = $dstImgName . $this->imageinfo['type'];
        }

        // 图片内容转换存储
        $image = "image{$this->imageinfo['type']}";
        if ($image($this->image, $dstName)) {
            return [1, '图片转换存储成功！'];
        } else {
            return [0, '图片转换存储失败！'];
        }
    }

    /**
     * 销毁图片
     */
    public function __destruct()
    {
        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }
    }
}