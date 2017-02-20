<?php
/**
 * Collection of functions to encrypt/hash & verify passwords
 * For use with PHP versions below 5.5
 *
 * @author Hans Erik Jepsen
 */

namespace Framework\Libs;

class Password {

    /**
     * Hashed a password using Blowfish
     *
     * @param string $entered_password
     * @param array $options
     * @return string(60)
     * @throws Exception
     */
    public static function my_password_hash($entered_password, $options = array()) {
        if (!empty($entered_password) && !empty($options)) {
            $salt = $options['Salt'];
            $cost = $options['Cost'];
            return crypt($entered_password, '$2y$' . $cost . '$' . $salt);
        }
        throw new Exception('Error');
    }

    /**
     * Check if the stored password is hashed with blowfish correctly
	 *
     * @param string $stored_password
     * @return boolean
     * @throws Exception
     */
    public static function my_password_needs_rehash($stored_password) {
        if (!empty($stored_password)) {
            return ((!(substr($stored_password, 0, 4) === '$2y$')) || (!(strlen($stored_password) === 60)) ? true : false);
        }
        throw new Exception('Error');
    }

    /**
     * Checks if the entered password matches the stored password
	 *
     * @param string $entered_password
     * @param string $stored_password
     * @return boolean
     * @throws Exception
     */
    public static function my_password_verify($entered_password, $stored_password) {
        if (!empty($entered_password) && !empty($stored_password)) {
            return ((crypt($entered_password, $stored_password)) === $stored_password ? true : false);
        }
        throw new Exception('Error');
    }

}