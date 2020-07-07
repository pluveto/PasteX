<?php

namespace App\Api;

use App\Type\Exception\BadRequestException;
use App\Domain\Post as Domain;

class Post
{
    /**
     * @api {post} /post 欢迎界面
     * @apiPermission none
     * @apiName Welcome
     * @apiGroup Welcome
     * @apiParam {string} lang 语言
     * @apiParam {string} [title] 语言
     * @apiParam {string} content 语言
     * @apiParam {string} [comment] 语言
     */
    public function create()
    {
        $req = \App::$api->request()->data;
        $lang = strtolower(trim($req->lang));
        $title = trim($req->title);
        $content = $req->content;
        $comment = $req->comment;
        if (mb_strlen($title) > 64) {
            throw new BadRequestException("抱歉, 标题太长了, 数据库存不下呀!");
        }
        if (mb_strlen($content) > 16 * 1024) {
            throw new BadRequestException("代码太长了, 小破服务器撑不住啊 QwQ");
        }
        if (mb_strlen($comment) > 16 * 1024) {
            throw new BadRequestException("附注太长了, 小破服务器撑不住啊 QwQ");
        }
        if (!Domain::langSupport($lang)) {
            throw new BadRequestException("对不起, 不支持这种语言.");
        }

        $uuid = Domain::uuidv4();
        $id = Domain::create($lang, $title, $content, $uuid, $comment);
        \Flight::json([
            "id" => $id,
            "uuid" => $uuid
        ]);
        return;
    }
    /**
     * @api {get} /post/@id 欢迎界面
     * @apiPermission none
     * @apiName Welcome
     * @apiParam {bool} [render=false] 语言
     */
    public function get($id)
    {
        $req = \App::$api->request()->query;
        $render = $req->render;
        $data = Domain::get($id);
        if (!$data) {
            throw new BadRequestException("id 无效!");
        }
        if (!$render) {
            \Flight::json($data);
        } else {
            Domain::render($data);
        }
        return;
    }
}
