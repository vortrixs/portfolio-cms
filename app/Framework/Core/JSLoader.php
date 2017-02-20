<?php

/**
 * Class used for easy loading of javascript assets
 *
 * @author Hans Erik Jepsen <hanserikjepsen@hotmail.com>
 */

namespace Framework\Core;

class JSLoader {

    public static function jQuery() {
        $script = "
                        <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>
                        <script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js'></script>
                        ";
        return $script;
    }

    public static function jQueryValidate() {
        $script = "
                        <script src='http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js'></script>
                        <script src='http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/validator.js'></script>
                        ";
        return $script;
    }

    public static function bootstrap() {
        $script = "
                        <script src='" . ASSETS_ROOT . "/js/bootstrap.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/ie10-viewport-bug-workaround.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/npm.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/submenu.js'></script>
                        ";
        return $script;
    }

    /**
     * For examples
     * @see public/assets/js/jquery.tables/template_table.html
     */
    public static function jQueryTables() {
        $script = "
                        <script src='" . ASSETS_ROOT . "/js/jquery.metadata.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/jquery.tablesorter.min.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/tablesorter.js'></script>
                        <script src='" . ASSETS_ROOT . "/js/tablesearch.js'></script>
                        ";
        return $script;
    }

    public static function Pagination() {
        $script = "
                    <script src='" . ASSETS_ROOT . "/js/pagination.js'></script>
                    ";
        return $script;
    }

    public static function TinyMCE() {
        $script = "
                <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
                <script>tinymce.init({ selector:'textarea' });</script>
                ";
        return $script;
    }

}
