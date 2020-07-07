<?php
namespace App\Middleware;
use App;
use App\Type\Exception\BadRequestException;

class RequestDataMapper
{
    public function init()
    {        
        $method = App::$api->request()->method;
        // Flight 框架没有把这三种请求的数据映射到 request()->data, 所以得我们手动操作
        if ($method === 'DELETE' || $method === 'PUT' || $method === 'PATCH') {
            $raw =  file_get_contents("php://input");
            // 注意!!! 这里故意解析为数组, 以确保各种情况下和原有 Flight 框架一致.
            $requestBodyDecoded = json_decode($raw, true);
            if (!$requestBodyDecoded) {
                throw new BadRequestException("json_decode 无法解析请求体.");
            }
            App::$api->request()->data->setData($requestBodyDecoded);
        }
    }
}
