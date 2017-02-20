<?php

use Framework\Libs\Input;
use Framework\Libs\Token;
use Framework\Libs\Session;
use Framework\Libs\Redirect;
use Framework\Models\User;
use Framework\Models\Validate;
use Framework\Core\DB;

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate(new DB);
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
            ));

        if ($validation->passed()) {
            $user = new User(new DB);
            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if ($login) {
                Session::flash('home', '<p>You have logged in successfully.</p>');
                Redirect::to('admin/index');
            } else {
                echo 'Sorry, logging in failed.';
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error;
            }
        }
    }
}
?>

<div class="container">
    <form class="form-signin" action="" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputUsername" class="sr-only">Username</label>
        <input type="text" value="admin" name="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" value="admin" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div> <!-- /container -->