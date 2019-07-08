<?php

// +----------------------------------------------------------------------
// | Library for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://library.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/zoujingli/ThinkLibrary
// +----------------------------------------------------------------------

namespace library\tools;

/**
 * 数据访问对象
 * Class Object
 * @package library\tools
 */
class Options implements \ArrayAccess
{
    /**
     * 当前数据对象
     * @var array
     */
    private $data = [];

    /**
     * Object constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * 判断数据是否已经设置
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * 设置数据对象
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * 获取数据内容
     * @param string|null $name
     * @return mixed|null
     */
    public function get($name = null)
    {
        if (is_null($name)) return $this->data;
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * 删除数据内容
     * @param string $name
     */
    public function del($name)
    {
        unset($this->data[$name]);
    }

    /**
     * 清理所有配置
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * 增加合并数据
     * @param array $data
     * @param boolean $append
     * @return array
     */
    public function merge($data, $append = false)
    {
        $result = array_merge($this->data, $data);
        return $append ? ($this->data = $result) : $result;
    }

    /**
     * 判断数据是否已经设置
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * 获取数据内容
     * @param string|null $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * 设置数据对象
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * 删除数据内容
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        $this->del($offset);
    }
}