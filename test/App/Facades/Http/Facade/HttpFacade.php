<?php
/**
 * Created by PhpStorm.
 * @file   HttpFacade.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/7 2:19 下午
 * @desc   HttpFacade.php
 */

namespace App\Facades\Http\Facade;

use Dependency\Facades\Facade;

/**
 * Class HttpFacade
 * @package App\Facades\Http\Facade
 * @method static string ip();
 * @method static string getClient();
 *
 */
class HttpFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return "request";
    }
}
