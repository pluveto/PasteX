<?php
/*
    API Parameters rules
    Auto generated at 2020-03-15 09:27:47
*/
return [
    '/post' => [
        'POST' => [
            'lang' => [
                'type' => 'string',
                'required' => true,
            ],
            'title' => [
                'type' => 'string',
            ],
            'content' => [
                'type' => 'string',
                'required' => true,
            ],
            'comment' => [
                'type' => 'string',
            ],
        ],
    ],
    '/post/@id' => [
        'GET' => [
            'render' => [
                'type' => 'bool',
                'default' => 'false',
            ],
        ],
    ],
];