<?php
/**
 * Created by PhpStorm.
 * @file   AutoLocatorTraitInterface.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/7 11:05 上午
 * @desc   AutoLocatorTraitInterface.php
 */

namespace Dependency\Internal;

use Dependency\Exception\NotFoundException;

/**
 * 自动加载属性
 * Interface AutoLocatorTraitInterface
 * @package Dependency\Internal
 */
interface AutoLocatorTraitInterface
{
    /**
     * @param $name
     * @return mixed|object
     * @throws NotFoundException
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    public function __get($name);

    /**
     * @param $name
     * @return mixed|string|null
     * @throws \ReflectionException
     */
    public function analysisDocument(string $name);

    /**
     * @param $propertyName
     * @return mixed|object
     * @throws NotFoundException
     * @throws \Dependency\Exception\ContainerException
     * @throws \ReflectionException
     */
    public function getByCalledClass(string $propertyName);

    /**
     * 是否支持以属性的方式加载
     * @param $name
     * @return bool
     */
    public function isSupportedClassSuffix(string $name);

}
