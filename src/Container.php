<?php
/**
 * Created by PhpStorm.
 * @file   AbstractContainer.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/4 5:07 下午
 * @desc   AbstractContainer.php
 */

namespace Dependency;

use Dependency\Exception\ContainerException;
use Dependency\Exception\NotFoundException;
use Dependency\Internal\ContainerInterface;

/**
 * Class AbstractContainer
 * @package Container\Dependency
 */
class Container implements ContainerInterface
{
    public static $container;
    /**
     * 获取的class实体
     * @var array
     */
    public $resolvedEntries = [];
    /**
     * class 注入定义
     * @var array
     */
    public $definitions = [];

    /**
     * @param array $definitions
     * @return Container
     * @throws ContainerException
     */
    public static function getInstance(array $definitions = [])
    {
        if (self::$container && self::$container instanceof self) {
            return self::$container;
        }
        return self::$container = new Container($definitions);
    }

    /**
     * AbstractContainer constructor.
     * @param array $definitions
     * @throws ContainerException
     */
    public function __construct(array $definitions = [])
    {
        if ($definitions) foreach ($definitions as $identity => $definition) {
            $this->bind($identity, $definition);
        }
    }

    /**
     * @param string $identity
     * @return bool
     */
    public function has($identity)
    {
        return isset($this->definitions[$identity]);
    }

    /**
     * @param $identity
     * @param $concrete
     * @return $this
     * @throws ContainerException
     */
    public function bind($identity, $concrete)
    {
        if (!is_string($identity)) {
            throw new \InvalidArgumentException(sprintf(
                "The identity must be of type string %s given",
                is_object($identity) ? get_class($identity) : gettype($identity)
            ));
        }
        if (is_array($concrete) && !isset($concrete['class'])) {
            throw  new ContainerException("Array must contain a class definition！");
        }
        $this->definitions[$identity] = $concrete;
        return $this;
    }

    /**
     * @param $name
     * @return mixed|object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    public function reflector($name)
    {
        if (isset($this->resolvedEntries[$name])) {
            return $this->resolvedEntries[$name];
        }
        $definition = $this->definitions[$name];
        if (empty($definition)) {
            throw new ContainerException("Instantiated class not found");
        }
        $params = [];
        if (is_array($definition) && isset($definition['class'])) {
            $params = $definition;
            $definition = $definition['class'];
            unset($params['class']);
        }
        $object = $this->make($definition, $params);
        return $this->resolvedEntries[$name] = $object;
    }

    /**
     * 直接创建
     * @param $concrete
     * @param array $params
     * @return mixed|object
     * @throws ContainerException
     * @throws \ReflectionException
     */
    public function make($concrete, $params = [])
    {
        if ($concrete instanceof \Closure) { //注入闭包
            return $concrete($params);
        } elseif (is_string($concrete)) {
            $reflection = new \ReflectionClass($concrete);
            $dependencies = $this->getDependencies($reflection);
            if ($params) foreach ($params as $key => $param) {
                $dependencies[$key] = $params;
            }
            return $reflection->newInstanceArgs($dependencies);
        } elseif (is_object($concrete)) {
            return $concrete;
        }
        throw  new ContainerException("Failed to get object instance!");
    }

    /**
     * @param \ReflectionClass $reflection
     * @return array
     * @throws ContainerException
     */
    private function getDependencies($reflection)
    {
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            $parameters = $constructor->getParameters();
            return $this->getParametersByDependencies($parameters);
        } else {
            return [];
        }
    }

    /**
     * @param \ReflectionParameter[] $dependencies
     * @return array
     * @throws ContainerException
     */
    public function getParametersByDependencies(array $dependencies)
    {
        $parameters = [];
        foreach ($dependencies as $param) {
            if ($param->getClass()) {
                $paramName = $param->getClass()->name;
                $paramObject = $this->make($paramName);
                $parameters[] = $paramObject;
            } elseif ($param->isArray()) {
                if ($param->isDefaultValueAvailable()) {
                    $parameters[] = $param->getDefaultValue();
                } else {
                    $parameters[] = [];
                }
            } elseif ($param->isCallable()) {
                if ($param->isDefaultValueAvailable()) {
                    $parameters[] = $param->getDefaultValue();
                } else {
                    $parameters[] = function ($avg) {
                    };
                }
            } else {
                if ($param->isDefaultValueAvailable()) {
                    $parameters[] = $param->getDefaultValue();
                } else {
                    if ($param->allowsNull()) {
                        $parameters[] = null;
                    } else {
                        $parameters[] = false;
                    }
                }
            }
        }
        return $parameters;
    }

    /**
     * @param string $id
     * @return mixed|object
     * @throws ContainerException
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new NotFoundException("No entry or class found for {$id}");
        }
        return $this->reflector($id);
    }
}
