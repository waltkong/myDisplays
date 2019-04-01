<?php
/**
 * Created by PhpStorm.
 * User: kongweitao
 * Date: 2019/3/31
 * Time: 0:41
 */

/**
 * ArrayAccess 是PHP提供的一个预定义接口,用来提供数组式的访问
 * 可以参考http://php.net/manual/zh/class.arrayaccess.php
 */

// 原文  https://blog.csdn.net/qq_20329253/article/details/52202811

class Arguments implements ArrayAccess
{
    private $arguments;

    /**
     * 注册传递的参数
     *
     * Arguments constructor.
     * @param array $param
     */
    public function __construct($param)
    {
        $this->arguments = is_array($param) ? $param : func_get_args();
    }

    /**
     * 获取参数
     *
     * @return array
     */
    public function toArray()
    {
        return $this->arguments;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset,$this->arguments);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->arguments[$offset] : null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->arguments[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->arguments[$offset]);
    }
}