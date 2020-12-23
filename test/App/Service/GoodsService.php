<?php
/**
 * Created by PhpStorm.
 * @file   GoodsService.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 1:15 下午
 * @desc   GoodsService.php
 */

namespace App\Service;


use App\Common\AbstractClass;
use App\Model\GoodsModel;

class GoodsService extends AbstractClass
{
    public function __construct(GoodsModel $goodsModel)
    {
        echo $goodsModel->getGoodsCount();
    }

    public function setGoods($goodsId)
    {
        echo PHP_EOL, "--- set goods. count:{$goodsId} ----", PHP_EOL;
    }
}
