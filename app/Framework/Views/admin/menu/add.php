<?php
use Framework\Models\User;
use Framework\Models\Category;
use Framework\Models\Navigation;
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

$categories = (new Category(new DB))->read();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate(new DB);
        $validation = $validate->check($_POST, array(
            'title' => array('required' => true),
            'parent' => array('is_int' => true),
            'position' => array('is_int' => true),
            'category' => array('is_int' => true),
            ));

        if ($validation->passed()) {
            unset($menu);
            $menu = (new Navigation(new DB))->create([
              'title' => Input::get('title'),
              'url' => Input::get('url'),
              'parent_id' => Input::get('parent'),
              'position' => Input::get('position'),
              'category_id' => Input::get('category'),
              ]);
            if (true === $menu) {
                Session::flash('success', '<p>Your changes have been saved.</p>');
                Redirect::to(ADMIN_ROOT . '/menu');
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
        <li class="active"><a href="<?php echo ADMIN_ROOT; ?>/menu_add">Add menu <span class="sr-only">(current)</span></a></li>
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
      <h1 class="page-header">Add Menu Entry</h1>
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
              <th>Title</th>
              <th>URL*</th>
              <th>Parent**</th>
              <th>Position</th>
              <th>Category</th>
              <th>Save</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <form action="" method="post">
              <td><input type="text" name="title"></td>
              <td><input type="text" name="url"></td>
              <td><input type="text" name="parent"></td>
              <td><input type="text" name="position"></td>
              <td>
                <select name="category">
                  <option selected disabled>-- Choose a category --</option>
                  <option value="0">No category</option>
                  <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category->id; ?>"><?php echo $category->name ?></option>
                  <?php } ?>
                </select>
              </td>
              <td>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                <input type="submit" value="Add entry">
              </td>
            </form>
            </tr>
          </tbody>
        </table>
        <div><b>*</b> If the URL is empty, the entry is a dropdown menu.</div>
        <div><b>*</b> The URL is relative to the root of the website e.g. www.yoursite.com/URL</div>
        <br>
        <div><b>**</b> If the entry is not a part of a dropdown menu set it to 0, otherwise set it to the id (#) of the parent.</div>
      </div>
    </div>
  </div>
</div>