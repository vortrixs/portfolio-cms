<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author Hansi
 */

namespace Framework\Core;

class View {

    public function render($view) {
        require_once VIEWS . '/_template/header.php';
        require_once VIEWS . '/' . $view . '.php';
        require_once VIEWS . '/_template/footer.php';
    }

    public function raw($view) {
    	require_once VIEWS . '/' . $view . '.php';
    }

    public function customRender($view, $header = true, $footer = true) {
        if (true === $header) {
            require_once VIEWS . '/_template/header.php';
        }
        require_once VIEWS . '/' . $view . '.php';
        if (true === $footer) {
            require_once VIEWS . '/_template/footer.php';
        }
    }

}
