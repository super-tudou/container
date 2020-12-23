<?php
/**
 * Created by PhpStorm.
 * @file   NamespaceLoad.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 11:49 上午
 * @desc   NamespaceLoad.php
 */

namespace Dependency\Initiation;


use App\Facades\Http\Facade\HttpFacade;
use App\Facades\Http\Request;
use Dependency\Exception\ParamsTypeException;

class SystemInitiation
{
    /**
     * 命名空间加载
     * @var array
     */
    private static $nameSpaceList = [];
    /**
     * @var array 加载的class 后缀
     */
    private static $classSuffixList = [];

    /**
     * 门面模式映射
     * @var array
     */
    private static $facadeMap = [];

    /**
     * @param $params
     * @throws ParamsTypeException
     */
    public static function setNameSpaces($params): void
    {
        if ($params instanceof \Closure) {
            self::$nameSpaceList = $params();
        } elseif (is_array($params)) {
            self::$nameSpaceList = $params;
        } else {
            throw  new ParamsTypeException("Parameter format or type error！");
        }
    }

    /**
     * @return array
     */
    public static function getNameSpaceList(): array
    {
        $spaceList = self::$nameSpaceList;
        $spaceList || $spaceList = [__NAMESPACE__];
        return $spaceList;
    }

    /**
     * 运行自动加载的后缀
     * @param $params
     * @throws ParamsTypeException
     */
    public static function setClassSuffixList($params): void
    {
        if ($params instanceof \Closure) {
            self::$classSuffixList = $params();
        } elseif (is_array($params)) {
            self::$classSuffixList = $params;
        } else {
            throw  new ParamsTypeException("Parameter format or type error！");
        }
    }

    /**
     * @return array
     */
    public static function getClassSuffixList(): array
    {
        return self::$classSuffixList;
    }

    /**
     * @param $params
     * @throws ParamsTypeException
     */
    public static function setNameSpaceList($params): void
    {
        if ($params instanceof \Closure) {
            self::$facadeMap = $params();
        } elseif (is_array($params)) {
            self::$facadeMap = $params;
        } else {
            throw  new ParamsTypeException("Parameter format or type error！");
        }

        foreach (self::$facadeMap as $facade => $object) {
            $facade::swap($object);
        }
    }

    /**
     * @return array
     */
    public static function getFacadeMap(): array
    {
        return self::$facadeMap;
    }
}
