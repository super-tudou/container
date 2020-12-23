<?php
/**
 * Created by PhpStorm.
 * @file   GoodsController.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 1:17 下午
 * @desc   GoodsController.php
 */

namespace App\Controller;

use App\Common\AbstractClass;
use App\Model\GoodsModel;
use App\Service\OrderService;

/**
 * Class GoodsController
 * @package App\Controller
 */
class GoodsController extends AbstractClass
{
    const weightUnit = 'kg';
    const heightUnit = 'cm';
    public $name = 'test';

    public function index(GoodsModel $goodsModel, OrderService $orderService)
    {
        $params = $_REQUEST;
        $goodsCount = $goodsModel->getGoodsCount();
        $orderService->createOrder($goodsCount, $params['goods_id']);
    }
}
