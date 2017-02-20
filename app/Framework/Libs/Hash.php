<?php

namespace Framework\Libs;

class Hash {

    public static function salt($length) {
        return strtr(substr(base64_encode(openssl_random_pseudo_bytes($length)),0,22), '+', '.');
    }

    public static function hash($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function unique() {
        return self::hash(uniqid());
    }

}