<?php

namespace Framework\Controllers;

use Framework\Core\ControllerInterface;
use Framework\Core\View;

class Article implements ControllerInterface {

    private $_view;

    public function __construct(View $view) {
        $this->_view = $view;
    }

    public function index() {
        $this->_view->render('article');
    }

}
