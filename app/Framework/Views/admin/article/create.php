<?php
use Framework\Models\User;
use Framework\Models\Article;
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

$categories = (new Category(new DB))->read();

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate(new DB);
        $validation = $validate->check($_POST, array(
            'headline' => array('required' => true),
            'sub_headline' => array('required' => true),
            'content' => array('required' => true),
            'end_at' => array('required' => true, 'valid_date' => true),
            'category' => array('required' => true),
            ));

        if ($validation->passed()) {
            unset($article);
            $article = (new Article(new DB))->create([
              'headline' => Input::get('headline'),
              'sub_headline' => Input::get('sub_headline'),
              'content' => Input::get('content'),
              'created_at' => date('Y-m-d'),
              'end_at' => Input::get('end_at'),
              'user_id' => $user->data()->id,
              'category_id' => Input::get('category'),
              ]);
            if (true === $article) {
                Session::flash('success', '<p>Your changes have been saved.</p>');
                Redirect::to(ADMIN_ROOT . '/admin/index');
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
        <li class="active"><a href="<?php echo ADMIN_ROOT; ?>/article_create">Create article <span class="sr-only">(current)</span></a></li>
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
      <h1 class="page-header">Create Article</h1>
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
      <div class="table-responsive">
      <form action="" method="post">
        <label for="headline">Title:
          <input id="headline" name="headline" type="text">
        </label>
        <br>
        <label for="sub_headline">Sub title:
          <input id="sub_headline" name="sub_headline" type="text">
        </label>
        <br>
        <label for="content">Content:
          <textarea name="content" id="content" cols="30" rows="10"></textarea>
        </label>
        <br>
        <label for="end_at">End date:
          <input id="end_at" name="end_at" type="date">
        </label>
        <br>
        <label for="category">Category:
          <select name="category">
            <option selected disabled>-- Choose a category --</option>
            <?php foreach($categories as $category) { ?>
              <option value="<?php echo $category->id ?>"><?php echo $category->name ?></option>
            <?php } ?>
          </select>
        </label>
        <br>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
        <input type="submit" value="Publish article">
      </form>
      </div>
    </div>
  </div>
</div>
<?php echo JSLoader::TinyMCE(); ?>
