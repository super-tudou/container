# 容器

## 环境要求

* PHP >= 5.4

## 安装

``` sh
$ composer require magic-tool/container -vvv
```

## 使用

``` php
<?php
//\App\Controller\GoodsController::getInstance()->index();
include "./vendor/autoload.php";

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

```

## License

[MIT](./LICENSE)
