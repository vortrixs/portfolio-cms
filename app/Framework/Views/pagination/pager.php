<?php

use Framework\Models\Pagination;
use Framework\Models\User;
use Framework\Core\DB;

$pager = new Pagination(new DB);

$pager->setter($_POST['page'], 4);

if (isset($_POST['url'])) {
	$category = (new DB)->get(['category_id'], 'cms_navigation', [['url','=',$_POST['url']]])->first();
}

if ($category->category_id > 0) {
	$results = $pager->pagination(['*'], 'cms_articles', [['category_id','=',$category->category_id]]);
} else {
	$results = $pager->pagination(['*'], 'cms_articles');
}

foreach ($results as $result) { ?>
<div class="post-preview">
	<a href="article/<?php echo $result->id; ?>">
		<h2 class="post-title">
			<?php echo $result->headline; ?>
		</h2>
		<h3 class="post-subtitle">
			<?php echo $result->sub_headline; ?>
		</h3>
	</a>
	<?php $user = new User(new DB, $result->user_id); ?>
	<p class="post-meta">Posted by <a><?php echo $user->data()->name ?></a> on <?php echo date('F d, Y', strtotime($result->created_at)); ?></p>
</div>
<hr>
<?php } ?>

<div id='loading-div'></div>

<div id="pager" align="center">
	<ul class="pager">
		<?php echo $pager->generateLinks(); ?>
	</ul>
</div>
