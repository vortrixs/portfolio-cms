<?php
use Framework\Models\User;
use Framework\Models\Navigation;
use Framework\Core\DB;
use Framework\Libs\Redirect;

$user = new User(new DB);

if ((!$user->isLoggedIn())) {
    Redirect::to('login');
}

$menu = new Navigation(new DB);
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-3 col-md-2 sidebar">
      <ul class="nav nav-sidebar">
        <li><a href="<?php echo ADMIN_ROOT; ?>/index">View articles</a></li>
        <li><a href="<?php echo ADMIN_ROOT; ?>/article_create">Create article</a></li>
      </ul>
      <ul class="nav nav-sidebar">
        <li class="active"><a href="<?php echo ADMIN_ROOT; ?>/menu">View menu <span class="sr-only">(current)</span></a></li>
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
      <h1 class="page-header">Menu</h1>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>URL</th>
              <th>Parent</th>
              <th>Position</th>
              <th>Category ID</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($menu->read() as $entry){ ?>
            <tr>
              <td><?php echo $entry->id; ?></td>
              <td><?php echo $entry->title; ?></td>
              <td><?php echo $entry->url; ?></td>
              <td><?php echo $entry->parent_id; ?></td>
              <td><?php echo $entry->position; ?></td>
              <td><?php echo $entry->category_id; ?></td>
              <td><a href="<?php echo ADMIN_ROOT; ?>/menu_edit/<?php echo $entry->id; ?>">Edit</a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <div><b>Note:</b> If the URL is empty, the entry is a dropdown menu.</div>
      </div>
    </div>
  </div>
</div>