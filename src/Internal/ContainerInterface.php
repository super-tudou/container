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

/**
 * Describes the interface of a container that exposes methods to read its entries.
 */
interface ContainerInterface
{
    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return mixed Entry.
     */
    public function get($id);

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return bool
     */
    public function has($id);

    /**
     * @param $identity
     * @param $concrete
     * @return $this
     * @throws ContainerException
     */
    public function bind($identity, $concrete);

    /**
     * @param $name
     * @return mixed|object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    public function reflector($name);

    /**
     * 直接创建
     * @param $concrete
     * @param array $params
     * @return mixed|object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    public function make($concrete, $params = []);
}
