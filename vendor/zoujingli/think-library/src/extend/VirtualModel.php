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

namespace think\admin\extend;

use think\Model;
use function Composer\Autoload\includeFile;

/**
 * 虚拟模型构建协议
 * Class VirtualModel
 * @package think\admin\extend
 */
class VirtualModel
{
    /**
     * 虚拟模型模板
     * @var string
     */
    private $template;

    /**
     * 读取进度标量
     * @var integer
     */
    private $position;

    public function stream_open($path, $mode, $options, &$opened_path): bool
    {
        $uri = parse_url($path);
        $this->position = 0;
        $this->template = '<?php ';
        $this->template .= 'namespace virtual\\model; ';
        $this->template .= "class {$uri['host']} extends \\think\\Model{ ";
        if (isset($uri['fragment']) && !empty($uri['fragment'])) {
            $this->template .= 'protected $connection="' . $uri['fragment'] . '"; ';
        }
        $this->template .= '}';
        return true;
    }

    public function stream_read($count)
    {
        $content = substr($this->template, $this->position, $count);
        $this->position += strlen($content);
        return $content;
    }

    public function stream_eof(): bool
    {
        return $this->position >= strlen($this->template);
    }

    public function stream_stat()
    {
    }

    public function stream_set_option()
    {
    }

    /**
     * 创建虚拟模型
     * @param mixed $name 模型名称
     * @param array $data 模型数据
     * @param mixed $conn 默认链接
     * @return Model
     */
    public static function mk(string $name, array $data = [], string $conn = ''): Model
    {
        if (!class_exists($class = "\\virtual\\model\\{$name}")) {
            if (!in_array('model', stream_get_wrappers())) {
                stream_wrapper_register('model', self::class);
            }
            includeFile('model://' . $name . '#' . $conn);
        }
        return new $class($data);
    }
}