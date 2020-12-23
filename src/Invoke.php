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
use Dependency\Exception\FunctionException;
use Dependency\Exception\NotFoundException;
use Dependency\Initiation\SystemInitiation;
use Dependency\Internal\ContainerInterface;
use Dependency\Internal\InvokeInterface;

/**
 * Class AbstractContainer
 * @package Container\Dependency
 */
class Invoke implements InvokeInterface
{
    /**
     * @var
     */
    public static $_invoke;

    /**
     * @var mixed|object
     */
    public $class;

    /**
     * @param string $class
     * @return Invoke
     * @throws NotFoundException
     */
    public static function getInstance($class = '')
    {
        if (!empty($class)) {
            $temp = explode("\\", $class);
            $class = end($temp);
        }
        return self::$_invoke = new Invoke($class);
    }

    /**
     * Invoke constructor.
     * @param string $class
     * @param $params
     * @throws ContainerException
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function __construct($class = '', $params = [])
    {
        $class && $this->class = $this->getByCalledClass($class, $params);
    }

    /**
     * @param $class
     * @param array $params
     * @return $this|mixed|object
     * @throws ContainerException
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    public function make($class, $params = [])
    {
        if (!empty($class)) {
            if (!empty($class)) {
                $temp = explode("\\", $class);
                $class = end($temp);
            }
            $this->class = $this->getByCalledClass($class, $params);
            return $this;
        } else {
            throw  new NotFoundException("The instantiated class does not exist！");
        }
    }


    /**
     * @param $propertyName
     * @param array $params
     * @return mixed|object
     * @throws ContainerException
     * @throws NotFoundException
     * @throws \ReflectionException
     */
    protected function getByCalledClass($propertyName, $params = [])
    {
        $className = ucwords($propertyName);
        $spaceList = SystemInitiation::getNameSpaceList();
        foreach ($spaceList as $namespace) {
            if (class_exists("{$namespace}\\{$className}")) {
                return app()->make("{$namespace}\\{$className}", $params);
            }
        }
        throw new NotFoundException("No entry or class found for {$propertyName}");
    }

    /**
     * @param $concrete
     * @param $function
     * @return array
     * @throws ContainerException
     * @throws \ReflectionException
     */
    private function getRunParams($concrete, $function)
    {
        $reflection = new \ReflectionClass($concrete);
        $method = $reflection->getMethod($function);
        $parameters = $method->getParameters();
        return app()->getParametersByDependencies($parameters);
    }

    /**
     * @param $function
     * @return mixed
     * @throws ContainerException
     * @throws FunctionException
     * @throws \ReflectionException
     */
    public function run($function)
    {
        $params = $this->getRunParams($this->class, $function);
        $method = (new \ReflectionClass ($this->class))->getMethod($function);
        if ($method->isPublic() && !$method->isAbstract()) {
            return $method->invokeArgs($this->class, $params);
        } else {
            throw  new FunctionException("Methods are not advertised or instantiated");
        }
    }

    /**
     * @param $function
     * @return mixed
     * @throws ContainerException
     * @throws FunctionException
     * @throws \ReflectionException
     */
    public function execute($function)
    {
        return $this->run($function);
    }

    /**
     * @param $name
     * @param $arguments
     * @throws ContainerException
     * @throws FunctionException
     * @throws \ReflectionException
     */
    public function __call($name, $arguments)
    {
        $name = str_replace("run", '', $name);
        $this->run($name);
    }
}
