<?php

namespace App\Middleware;

use App;

class CORSHandler
{
    public function init()
    {
        App::$api->before('start', function () {
            header("Access-Control-Allow-Origin: " . "*");
            header("Access-Control-Allow-Methods: " . "OPTIONS, GET, POST, PUT, DELETE");
            header("Access-Control-Allow-Headers: " . "*");
            if(App::$api->request()->method === "OPTIONS"){
                App::$api->halt(200);
            }
            
        });
    }
}
