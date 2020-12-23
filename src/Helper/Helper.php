<?php
/**
 * Created by PhpStorm.
 * @file   Helper.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/4 7:59 下午
 * @desc   Helper.php
 */

use Dependency\Container;
use Dependency\Invoke;

if (!function_exists('app')) {
    /**
     * Get the available container instance.
     * @param null $abstract
     * @param array $parameters
     * @return Container|mixed|object
     * @throws ReflectionException
     * @throws \Dependency\Exception\ContainerException
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return Container::getInstance();
        }
        return Container::getInstance()->make($abstract, $parameters);
    }
}
if (!function_exists('invoke')) {
    /**
     * @param null $class
     * @return Invoke|mixed|object
     * @throws ReflectionException
     * @throws \Dependency\Exception\ContainerException
     * @throws \Dependency\Exception\NotFoundException
     */
    function invoke($class = null)
    {
        if (is_null($class)) {
            return Invoke::getInstance();
        }
        return Invoke::getInstance()->make($class);
    }
}
