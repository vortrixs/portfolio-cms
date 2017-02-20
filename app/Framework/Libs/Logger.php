<?php

/**
 * Class for for logging and displaying error messages
 *
 * @author Hans Erik Jepsen <hanserikjepsen@hotmail.com>
 */

namespace Framework\Libs;

class Logger {

    private $_errors = [];

    /**
     * Stores error messages in an array
     *
     * @param string $error
     * @return boolean
     */
    public function addError($error) {
        if (!empty($error) && is_string($error)) {
            $this->_errors[] = $error;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the array with errors
     *
     * @return array
     */
    public function displayErrors() {
        return $this->_errors;
    }

}
