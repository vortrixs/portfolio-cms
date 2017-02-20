<?php

use Framework\Libs\Session;
use Framework\Libs\Redirect;
use Framework\Core\DB;
use Framework\Models\User;

(new User(new DB))->logout();

Session::flash('home', '<p>You have been logged out.</p>');
Redirect::to(DIRECTORY_ROOT . '/home');
