<?php
/**
 * Created by PhpStorm.
 * @file   GoodsModel.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 1:17 下午
 * @desc   GoodsModel.php
 */

namespace App\Model;

use App\Common\AbstractClass;

class GoodsModel extends AbstractClass
{
    public function getGoodsCount()
    {
        return rand(100,110);
    }
}
