<?php

namespace App\Helper;

class Crypto
{
    public static function UrlDecode($input)
    {
        return (strtr($input, '-_.', '+/='));
    }
    public static function UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_.');
    }


    public static function encode($data, $key, $iv)
    {
        // 加密
        $cryptText = openssl_encrypt($data, "aes-256-cbc", $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($cryptText);
    }

    public static function decode($data, $key, $iv)
    {
        // 解密
        $cryptText = base64_decode($data);
        return trim(openssl_decrypt($cryptText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv));
    }
}
