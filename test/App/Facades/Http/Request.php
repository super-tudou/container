<?php
/**
 * Created by PhpStorm.
 * @file   Request.php
 * @author 李锦 <244395692@qq.com>
 * @date   2020/12/7 3:26 下午
 * @desc   Request.php
 */

namespace App\Facades\Http;

class Request
{
    public function ip()
    {
        echo '192.168.0.0.1';
    }

    public function getClient()
    {
        echo "Mac chrome brewer";
    }
}
