<!-- Post content-->
<ul class="list-group">
  <?php foreach($posts as $post) : ?>
  <li class="list-group-item">
    <article>
        <!-- Post header-->
        <header class="mb-4">
            <!-- Post title-->
            <h1 class="fw-bolder mb-1"><?=$post->title ?? "Post" ?></h1>
            <!-- Post meta content-->
            <div class="text-muted fst-italic mb-2">
                Posted on <?=date_format(new DateTime($post->created_at), 'F j, Y') ?> by <?= $post->author->username ?? "User"?>
                <?php if(Yii::app()->user->id == $post->author_id) : ?>
                    <a class="float-end btn btn-link  text-danger" style="text-decoration: none;" href="<?php echo $this->createUrl('posts/delete', array('id' => $post->id)); ?>">Delete</a>
                    <a class="float-end btn btn-link" style="text-decoration: none;" href="<?php echo $this->createUrl('posts/update', array('id' => $post->id)); ?>">Edit</a>
                <?php endif; ?>
            </div>
            <!-- Post categories-->
            <?php if ($post->is_public == 1): ?>
                <a class="badge bg-primary text-decoration-none" href="#!">Public</a>
            <?php else: ?>
                <a class="badge bg-secondary text-decoration-none link-light" href="#!">Private</a>
            <?php endif; ?>
        </header>
        <!-- Preview image figure-->
        <figure class="mb-4"><img class="img-fluid rounded" src="<?=$post->image_url ?? 'https://dummyimage.com/900x400/ced4da/6c757d.jpg'?>" alt="..." /></figure>
        <!-- Post content-->
        <section class="mb-5">
        <p>
            <?php
            $content = CHtml::encode($post->content);
            if (strlen($content) > 200) {
                $content = substr($content, 0, 200) . '...';
            }
            echo $content;
            ?>
        </p>
        <p>
            <a href="<?php echo Yii::app()->createUrl('/posts/view', array('id' => $post->id)); ?>">Read More</a>
        </p>
        </section>
        <!-- <span class="badge bg-primary text-decoration-none">Liked (<?=$post->likesCount?>)</span> -->
        <?php if (!Yii::app()->user->isGuest): ?>
            <?php
            $userLiked = PostLike::model()->exists('post_id=:post_id AND user_id=:user_id', array(':post_id'=>$post->id, ':user_id'=>Yii::app()->user->id));
            ?>
            <?php if ($userLiked): ?>
                <span class="badge bg-primary text-decoration-none">Liked (<?=$post->likesCount?>)</span>
            <?php else: ?>
                <?= CHtml::link('Like (' . $post->likesCount. ')', array('/posts/likePost', 'post_id'=>$post->id), array('class'=>'badge bg-primary text-decoration-none')) ?>
            <?php endif; ?>
        <?php endif; ?>  
    </article>
  </li>
  <?php endforeach; ?>
     <?php if(!$posts): ?>
        <li class="list-group-item">No Post found!</li>
    <?php endif; ?>
</ul>
