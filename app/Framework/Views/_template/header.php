	<?php

use Framework\Libs\Config;
use Framework\Libs\Session;
use Framework\Libs\Cookie;
use Framework\Models\User;
use Framework\Core\DB;
use Framework\Core\HTMLCore;
use Framework\Libs\NavGenerator;

$url = (!empty($_GET['url'])) ? explode('/', $_GET['url']) : array('home');

$db = new DB;

if (Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = $db->get(array('*'), 'oop_users_session', array(array('hash', '=', $hash)));

	if ($hashCheck->count()) {
		$user = new User($db, $hashCheck->first()->user_id);
		$user->login();
	}
}
$user = !empty($user) ? $user : new User($db);

if ($url[0] != 'login' && $url[0] != 'admin') {
	$navgen = new NavGenerator($db->get(['*'], 'cms_navigation', null, ['ORDER BY' => 'parent_id,position,id'])->results());
	$navgen->base_url = DIRECTORY_ROOT;
}
?>
<html>
<head>
	<?php echo HTMLCore::head($url); ?>
</head>

<body>
	<?php if ($url[0] != 'login' && $url[0] != 'admin') { ?>
	<div class="bs-example">
		<nav class="navbar navbar-default navbar-custom navbar-fixed-top">

			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header page-scroll">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<span class="navbar-brand">Meltdown News</span>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<?php echo HTMLCore::nav($navgen->run(), $user) ?>
					</ul>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container -->

		</nav>
	</div>
	<?php } elseif($url[0] === 'admin') { ?>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo ADMIN_ROOT; ?>/index">CMS Dashboard</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="<?php echo DIRECTORY_ROOT ?>/home">Website</a></li>
					<li><a href="<?php echo DIRECTORY_ROOT ?>/logout">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<?php } ?>