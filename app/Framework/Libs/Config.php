<?php

/**
 *  Config class used to access the global config array defined in init.php
 * 
 * @author Alex Garret
 * @link https://www.youtube.com/playlist?list=PLfdtiltiRHWF5Rhuk7k4UAU1_yLAZzhWc Tutorial videos from Alex Garret (phpacademy)
 */

namespace Framework\Libs;

class Config {

    /**
     * Gets a path from the global config array defined in init.php
     * 
     * @param string $path Path defined in the config array
     * @return boolean|string Returns the value of the path or false
     */
    public static function get($path = null) {
        if ($path) {
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
        return false;
    }

}
