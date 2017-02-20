<?php
use Framework\Models\User;
use Framework\Models\Category;
use Framework\Models\Validate;
use Framework\Core\DB;
use Framework\Core\JSLoader;
use Framework\Libs\Token;
use Framework\Libs\Redirect;
use Framework\Libs\Input;
use Framework\Libs\Session;

$user = new User(new DB);

if ((!$user->isLoggedIn())) {
    Redirect::to('login');
}

$id = $url[2];

$category = (new Category(new DB))->read($id);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate(new DB);
        $validation = $validate->check($_POST, array(
            'name' => array('required' => true),
            ));

        if ($validation->passed()) {
            unset($menu);
            $menu = (new Category(new DB))->update($id,[
              'name' => Input::get('name'),
              ]);
            if (true === $menu) {
                Session::flash('success', '<p>Your changes have been saved.</p>');
                Redirect::to(ADMIN_ROOT . '/categories');
            } else {
                $failed = 'Sorry, the changes could not be saved. Try again.';
            }
        }
    }
}
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo ADMIN_ROOT; ?>/index">View articles</a></li>
        <li><a href="<?php echo ADMIN_ROOT; ?>/article_create">Create article</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo ADMIN_ROOT; ?>/menu">View menu</a></li>
        <li><a href="<?php echo ADMIN_ROOT; ?>/menu_add">Add menu</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo ADMIN_ROOT; ?>/categories">View categories</a></li>
        <li><a href="<?php echo ADMIN_ROOT; ?>/categories_create">Add category</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo ADMIN_ROOT; ?>/images">View images</a></li>
        <li><a href="<?php echo ADMIN_ROOT; ?>/images_upload">Upload image</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo ADMIN_ROOT; ?>/users">View users</a></li>
        <li><a href="<?php echo ADMIN_ROOT; ?>/users_permissions">Assign permissions</a></li>
      </ul>
    </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      <h1 class="page-header">Edit Category</h1>
      <div class="table-responsive">
        <?php
        if (Input::exists()) {
          echo $failed;
          if (!$validation->passed()) {
            foreach ($validation->errors() as $error) {
              echo $error;
            }
          }
        }
        ?>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Save</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <form action="" method="post">
              <td><?php echo $category->id; ?></td>
              <td><input type="text" name="name" value="<?php echo $category->name; ?>"></td>
              <td>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                <input type="submit" value="Save changes">
              </td>
            </form>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>