<?php
/**
 * Created by PhpStorm.
 * @file   AutoLoad.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 11:30 上午
 * @desc   AutoLoad.php
 */

namespace Dependency;

use Dependency\Exception\NotFoundException;
use Dependency\Initiation\SystemInitiation;
use Dependency\Internal\AutoLocatorTraitInterface;

trait  AutoLocatorTrait
{
    /**
     * @param $name
     * @return mixed|object
     * @throws NotFoundException
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    public function __get($name)
    {
        if ($this->isSupportedClassSuffix($name)) {
            return $this->getByCalledClass($name);
        }
        //解析注释数据
        if ($name = $this->analysisDocument($name)) {
            return $this->getByCalledClass($name);
        }
    }

    /**
     * @param $name
     * @return mixed|string|null
     * @throws \ReflectionException
     */
    public function analysisDocument($name)
    {
        $class = new \ReflectionClass($this); //建立Person这个类的反射类
        $document = $class->getDocComment();
        $documentList = explode("\n", $document);
        array_walk($documentList, function (&$item) {
            $item = trim(str_replace(["/", '*', '@', 'package', 'property'], '', $item));
        });
        $documentList = array_filter($documentList);
        foreach ($documentList as $item) {
            $params = preg_split('/\s/', $item);
            if (count($params) > 1) {
                if (str_replace(['$'], '', $params[1]) == $name) {
                    return $params[0];
                }
            }
        }
        return null;
    }


    /**
     * @param $propertyName
     * @return mixed|object
     * @throws NotFoundException
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    private function getByCalledClass($propertyName)
    {
        if (count(explode("\\", $propertyName)) > 1) {
            return app()->make($propertyName);
        } else {
            $className = ucwords($propertyName);
            foreach (SystemInitiation::getNameSpaceList() as $namespace) {
                if (class_exists("{$namespace}\\{$className}")) {
                    return app()->make("{$namespace}\\{$className}");
                }
            }
        }
        throw new NotFoundException("No entry or class found for {$propertyName}");
    }

    /**
     * 是否支持以属性的方式加载
     * @param $name
     * @return bool
     */
    private function isSupportedClassSuffix($name)
    {
        $suffixList = SystemInitiation::getClassSuffixList();
        if (!in_array($name, $suffixList)) {
            foreach ($suffixList as $item) {
                if ($item == substr($name, -strlen($item))) {
                    return true;
                }
            }
        }
        return false;
    }
}
