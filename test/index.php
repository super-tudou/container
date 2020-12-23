<?php
/**
 * Created by PhpStorm.
 * @file   index.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/5 1:28 下午
 * @desc   index.php
 */

//\App\Controller\GoodsController::getInstance()->index();
include "../../../../vendor/autoload.php";

use App\Controller\GoodsController;
use App\Model\GoodsModel;
use App\Service\OrderService;
use Dependency\Initiation\SystemInitiation;
use App\Facades\Http\Facade\HttpFacade;
use App\Facades\Http\Request;

//初始化命名空间
SystemInitiation::setNameSpaces(function () {
    return [
        'App\Service',
        'App\Controller',
    ];
});
//运行自动加载的后缀
SystemInitiation::setClassSuffixList([
    'Service',
    'Model',
//    'Facade'
]);

SystemInitiation::setNameSpaceList(function () {
    return [
        HttpFacade::class => Request::class
    ];
});

//HttpFacade::swap(Request::class);

//执行调用
try {
    invoke(GoodsController::class)->execute('index');
    echo app(GoodsModel::class)->getGoodsCount();
    app(OrderService::class)->createOrder(10, 20);
    OrderService::getInstance()->createOrder(10, 20);
} catch (Exception $exception) {
    print_r($exception->getMessage());
}


