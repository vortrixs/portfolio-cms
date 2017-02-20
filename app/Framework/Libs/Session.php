<?php

/**
 * Class for easy handling of sessions
 *
 * @author Alex Garret
 * @link https://www.youtube.com/playlist?list=PLfdtiltiRHWF5Rhuk7k4UAU1_yLAZzhWc Tutorial videos from Alex Garret (phpacademy)
 */

namespace Framework\Libs;

class Session {

    /**
     * Checks if session exists
     *
     * @param string $name Name of the session
     * @return boolean Returns true||false
     */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Assign a value to your session
     *
     * @param string $name Name of your session
     * @param mixed $value Value of your session
     * @return mixed Returns the created session
     */
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
     * Get value from session
     *
     * @param string $name Name of the session
     * @return mixed Returns the value of the session
     */
    public static function get($name) {
        return $_SESSION[$name];
    }

    /**
     * Deletes a session
     *
     * @param string $name Name of the session
     */
    public static function delete($name) {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Create a session for displaying messages
     *
     * Use this method to store and display messages between page loads
     * When creating the session fill out both parameters
     * When displaying the session only fill out the $name parameter
     *
     * @param string $name Name of the session
     * @param string $string Message to be displayed (only set this when creating the session)
     * @return string Returns the value of the session
     */
    public static function flash($name, $string = '') {
        if ((self::exists($name))) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }

}
