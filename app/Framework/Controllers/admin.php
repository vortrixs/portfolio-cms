<?php

namespace Framework\Controllers;

use Framework\Core\ControllerInterface;
use Framework\Core\View;

class Admin implements ControllerInterface {

    private $_view;

    public function __construct(View $view) {
        $this->_view = $view;
    }

    public function index() {
        $this->_view->customRender('admin/index', true, false);
    }

    public function article_create() {
        $this->_view->customRender('admin/article/create', true, false);
    }

    public function article_edit() {
        $this->_view->customRender('admin/article/edit', true, false);
    }

    public function menu() {
        $this->_view->customRender('admin/menu/index', true, false);
    }

    public function menu_add() {
        $this->_view->customRender('admin/menu/add', true, false);
    }

    public function menu_edit() {
        $this->_view->customRender('admin/menu/edit', true, false);
    }

    public function categories() {
        $this->_view->customRender('admin/categories/index', true, false);
    }

    public function categories_create() {
        $this->_view->customRender('admin/categories/create', true, false);
    }

    public function categories_edit() {
        $this->_view->customRender('admin/categories/edit', true, false);
    }

    public function images() {
        $this->_view->customRender('admin/images/index', true, false);
    }

    public function images_upload() {
        $this->_view->customRender('admin/images/upload', true, false);
    }

    public function users() {
        $this->_view->customRender('admin/users/index', true, false);
    }

    public function users_permissions() {
        $this->_view->customRender('admin/users/permissions', true, false);
    }

}
