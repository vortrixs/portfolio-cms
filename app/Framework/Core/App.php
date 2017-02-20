<?php

/**
 * The core class of the MVC
 * Handles controllers and routing
 *
 * @author Alex Garret
 * @link https://www.youtube.com/playlist?list=PLfdtiltiRHWF5Rhuk7k4UAU1_yLAZzhWc Tutorial videos from Alex Garret (phpacademy)
 */

namespace Framework\Core;

use Framework\Core\View;

class App {

    protected $_controller = 'home',
            $_method = 'index',
            $_params = array();

    /**
     * Takes a parsed url and loads the right controller and method for the view
     */
    public function __construct(View $view) {
        if (!empty($_GET['url'])) {
            $url = parseUrl($_GET['url']);

            if (file_exists(CONTROLLERS . '/' . $url[0] . '.php')) {
                $this->_controller = $url[0];
                unset($url[0]);
            }
        }

        $controller = 'Framework\\Controllers\\' . $this->_controller;

        $this->_controller = new $controller($view);

        if (isset($url[1])) {
            if (method_exists($this->_controller, $url[1])) {
                $this->_method = $url[1];
                unset($url[1]);
            }
        }

        $this->_params = !empty($url) ? array_values($url) : $this->_params;

        call_user_func_array(array($this->_controller, $this->_method), $this->_params);
    }

}
