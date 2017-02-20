<?php
/**
 * Class for easy handling of cookies
 *
 * @author Alex Garret
 * @link https://www.youtube.com/playlist?list=PLfdtiltiRHWF5Rhuk7k4UAU1_yLAZzhWc Tutorial videos from Alex Garret (phpacademy)
 */

namespace Framework\Libs;

class Cookie {

    /**
     * Check if a cookie exists
     * 
     * @param string $name Name of the cookie
     * @return boolean Returns true||false
     */
    public static function exists($name) {
        return (isset($_COOKIE[$name])) ? true : false;
    }

    /**
     * Get value from cookie
     * 
     * @param string $name Name of the cookie
     * @return mixed Returns value of the cookie
     */
    public static function get($name) {
        return $_COOKIE[$name];
    }

    /**
     * Assign a value to a cookie
     * 
     * @param string $name Name of your cookie
     * @param mixed $value Value of the cookie
     * @param int $expiry Expiry time of the cookie
     * @return boolean Returns true||false
     */
    public static function put($name, $value, $expiry) {
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    /**
     * Deletes cookie
     * 
     * @param string $name Name of the cookie
     */
    public static function delete($name) {
        self::put($name, '', time() - 1);
    }

}
