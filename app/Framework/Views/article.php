<?php

use Framework\Core\DB;
use Framework\Models\User;
use Framework\Models\Article;

$article = (new Article(new DB))->read($url[1]);
$image = (new DB)->get(['filename'], 'cms_images', [['article_id','=',$article->id]])->first();
$user = (new User(new DB, $article->user_id))->data();
?>

<!-- Page Header -->
<!-- Set your background image for this header on the line below. -->
<header class="intro-header" style="background-image: url('../assets/img/uploads/<?php echo $image->filename; ?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?php echo $article->headline; ?></h1>
                    <h2 class="subheading"><?php echo $article->sub_headline; ?></h2>
                    <span class="meta">Posted by <a><?php echo $user->name; ?></a> on <?php echo date('F d, Y', strtotime($article->created_at)); ?></span>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Post Content -->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
            <?php echo $article->content; ?>
            </div>
        </div>
    </div>
</article>