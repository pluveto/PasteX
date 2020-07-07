<?php

namespace App\Api;

use App\Type\Exception\BadRequestException;

class Welcome
{
    /**
     * @api {get} / 欢迎界面
     * @apiName Welcome
     * @apiGroup Welcome
     *
     * @apiSuccess {String} firstname Firstname of the User.
     * @apiSuccess {String} lastname  Lastname of the User.
     */
    public function index()
    {
        $ret = [
            "name" => "Paste X",
            "version" => "2020-3-15"
        ];
        \Flight::json($ret);
        return;
    }
}
