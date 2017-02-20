<?php

/**
 * Static html elements for easy templating
 *
 * @author Hans Erik Jepsen <hanserikjepsen@hotmail.com>
 */

namespace Framework\Core;

class HTMLCore {

    public static function head($url = null) {
        $data = "
        <meta charset='UTF-8' />
        <meta name='viewport' content='width-device-width, initial-scale=1' />
        <link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/bootstrap.min.css' />
        <link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/bootstrap-theme.min.css' />
        <link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/ie10-viewport-bug-workaround.css' />
        <link href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <!--[if lt IE 9]>
        <script src='//html5shiv.googlecode.com/svn/trunk/html5.js'></script>
        <![endif]-->
        ";

        if ($url[0] != 'login' && $url[0] != 'admin') {
            $data .= "<link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/clean-blog.min.css' />";
            $data .= "<link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/main.css' />";
        }
        if ($url[0] == 'login') {
            $data .= "<link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/signin.css' />";
        }
        if ($url[0] == 'admin') {
            $data .= "<link rel='stylesheet' type='text/css' href='". ASSETS_ROOT ."/css/dashboard.css' />";
        }
        $data .= "<title>" . self::title($url) . "</title>";
        return $data;
    }

    public static function title($url) {
        $title = (!is_array($url)) ? explode('/', $url) : $url;
        return "CMS | " . (empty($url) ? 'Home' : ucwords($title[0]));
    }

    public static function nav($list = null, $user = null) {
        $nav = $list;
        return $nav;
    }

    public static function footer($date = null) {
        if (!isset($date)) {
            $date_time = new \DateTime;
            $date = $date_time->format('Y');
        }
        $text = "Hans Erik Jepsen" . HTMLCore::copyright($date);
        return $text;
    }

    public static function copyright($creationDate) {
        $currentDate = date('Y');
        if ($creationDate > $currentDate) {
            throw new Exception('Invalid date supplied');
        }
        return $copy = ($currentDate == $creationDate) ? " &copy; " . $creationDate : " &copy; " . $creationDate . "-" . $currentDate;
    }

}
