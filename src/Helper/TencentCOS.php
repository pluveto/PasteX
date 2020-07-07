<?php

namespace App\Helper;

use App;
use App\Type\Exception\BadRequestException;
use Exception;
use Qcloud\Cos\Client;

class TencentCOS
{
    /**
     * COS Client
     *
     * @var Client
     */
    public $client;
    public $config;
    public function __construct()
    {
        $this->init();
    }
    public function getFiles($path)
    {
        $key = ltrim($path, "/");
        $result = $this->client->listObjects(array(
            'Bucket' => $this->config['bucket'], //格式：BucketName-APPID
            'Delimiter' => '/',
            //'EncodingType' => 'url',
            //'Marker' => 'prefix/picture.jpg',
            'Prefix' => $this->config['baseKey'] . $key,
            //'MaxKeys' => 1000,
        ));

        if ($result['Contents'] == null) {
            throw new BadRequestException("路径无效. 注: 对于一个文件夹, 路径需要以 `/` 开头且结尾", 404, 404);
        }
        $folders = $result['CommonPrefixes'];
        $files =  $result['Contents'];
        $ret = [];
        if (!is_null($folders)) {
            foreach ($folders as $folder) {                
                $ret[] = [
                    "type" => "folder",
                    "key" => $folder["Prefix"]
                ];
            }
        }
        if (!is_null($files)) {
            foreach ($files as $file) {
                if($file["Key"] === $key){
                    continue;
                }
                $ret[] = [
                    "type" => "file",
                    "key" => $file["Key"],
                    "updatedAt" => strtotime($file["LastModified"]),
                    "size" => $file["Size"],
                    "eTag" => $file["ETag"]
                ];
            }
        }


        return [
            "baseUrl" => "https://" . $result['Location'],
            "data" => $ret
        ];
    }
    public function init()
    {
        $config = App::$config->get("tencent-cos", null);
        if (is_null($config)) {
            throw new Exception("Tencent COS Not configured");
        }
        $this->client = new Client($config);
        $this->config = $config;
    }
}
