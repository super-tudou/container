<?php
/**
 * Created by PhpStorm.
 * @file   OrderService.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 1:12 下午
 * @desc   OrderService.php
 */

namespace App\Service;

use App\Common\AbstractClass;
use App\Facades\Http\Facade\HttpFacade;
use Dependency\AutoLocatorTrait;

/**
 * Class OrderService
 * @package App\Service
 * @property GoodsService $service
 */
class OrderService extends AbstractClass
{
    use AutoLocatorTrait;

    public function createOrder($goodsCount, $goodsId)
    {
        echo HttpFacade::getClient();

        echo PHP_EOL, "--- set orders ,goods count:{$goodsCount}----", PHP_EOL;
        $this->service->setGoods($goodsId);
    }
}
