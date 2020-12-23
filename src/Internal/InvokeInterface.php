<?php
/**
 * Created by PhpStorm.
 * @file   ContainerInterface.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/4 5:03 下午
 * @desc   ContainerInterface.php
 */

namespace Dependency\Internal;

use Dependency\Container\Container;
use Dependency\Exception\ContainerException;
use Dependency\Exception\FunctionException;

/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
interface InvokeInterface
{
    /**
     * 直接创建
     * @param $concrete
     * @param array $params
     * @return mixed|object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    public function make($concrete, $params = []);

    /**
     * @param $function
     * @return mixed
     * @throws ContainerException
     * @throws FunctionException
     * @throws \ReflectionException
     */
    public function run($function);

    /**
     * @param $function
     * @return mixed
     * @throws ContainerException
     * @throws FunctionException
     * @throws \ReflectionException
     */
    public function execute($function);

    /**
     * @param $name
     * @param $arguments
     * @throws ContainerException
     * @throws FunctionException
     * @throws \ReflectionException
     */
    public function __call($name, $arguments);
}
