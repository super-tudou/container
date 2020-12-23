<?php
/**
 * Created by PhpStorm.
 * @file   AbstractClass.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 1:13 下午
 * @desc   AbstractClass.php
 */

namespace App\Common;


class AbstractClass
{
    public static $_instance;/*服务单例对象*/

    /**
     * @return static
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance) || !self::$_instance instanceof static) {
            self::$_instance = app(static::class);
        }
        return self::$_instance;
    }
}
