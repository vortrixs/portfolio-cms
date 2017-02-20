<?php

namespace Framework\Core;

use Framework\Core\View;

interface ControllerInterface {

    public function __construct(View $view);

    public function index();
}
