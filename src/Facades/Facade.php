<?php
/**
 * Created by PhpStorm.
 * @file   Facade.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/7 2:15 下午
 * @desc   Facade.php
 */

namespace Dependency\Facades;

use Dependency\Exception\RuntimeException;

abstract class Facade
{
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;

    /**
     * Hot swap the underlying instance behind the facade.
     *
     * @param mixed $instance
     * @return void
     */
    public static function swap($instance)
    {
        static::$resolvedInstance[static::getFacadeAccessor()] = $instance;
    }

    /**
     * Get the root object behind the facade.
     * @return \Dependency\Container\Container|mixed|object
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }

    /**
     * Resolve the facade root instance from the container.
     * @param $name
     * @return \Dependency\Container\Container|mixed|object
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) {
            return $name;
        }
        if (isset(static::$resolvedInstance[$name]) && is_object(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }
        if (empty(static::$resolvedInstance[$name])) return null;
        return static::$resolvedInstance[$name] = app(static::$resolvedInstance[$name]);
    }

    /**
     * Clear a resolved facade instance.
     *
     * @param string $name
     * @return void
     */
    public static function clearResolvedInstance($name)
    {
        unset(static::$resolvedInstance[$name]);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = [];
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param $method
     * @param $args
     * @return mixed
     * @throws RuntimeException
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getFacadeRoot();
        if (!$instance) {
            throw new RuntimeException('A facade root has not been set.');
        }
        return $instance->$method(...$args);
    }
}
