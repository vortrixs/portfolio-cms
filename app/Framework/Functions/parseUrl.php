<?php

/**
 * Explodes the url created by the .htaccess rewriting
 * 
 * @return array Returns the url formatted as an array
 */
function parseUrl($url) {
    if (isset($url)) {
        return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
}
