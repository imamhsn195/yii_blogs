
<!-- Post content-->
<article>
    <!-- Post header-->
    <header class="mb-4">
            <!-- Post title-->
            <h1 class="fw-bolder mb-1">
                <?=$post->title ?? "Post" ?> 
                <a class="float-end btn btn-link  text-danger" style="text-decoration: none;" href="<?php echo $this->createUrl('posts/delete', array('id' => $post->id)); ?>">Delete</a>
                <a class="float-end btn btn-link" style="text-decoration: none;" href="<?php echo $this->createUrl('posts/update', array('id' => $post->id)); ?>">Edit</a>
            </h1>
            <!-- Post meta content-->
            <div class="text-muted fst-italic mb-2">Posted on <?=date_format(new DateTime($post->created_at), 'F j, Y') ?> by <?= $post->author->username ?? "User"?></div>
            <!-- Post categories-->
            <a class="badge bg-secondary text-decoration-none link-light" href="#!">Web Design</a>
            <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a>
    </header>
    <!-- Preview image figure-->
    <figure class="mb-4"><img class="img-fluid rounded" src="<?=$post->image_url ?? 'https://dummyimage.com/900x400/ced4da/6c757d.jpg'?>" alt="..." /></figure>
    <section class="mb-5">
        <?php $post->content ?? "No content found!" ?>
    </section>
    <!-- Post content-->
    <?php if (!Yii::app()->user->isGuest): ?>
        <?php
        $userLiked = PostLike::model()->exists('post_id=:post_id AND user_id=:user_id', array(':post_id'=>$post->id, ':user_id'=>Yii::app()->user->id));
        ?>
        <?php if ($userLiked): ?>
            <span class="btn btn-primary btn-sm">Liked (<?=$post->likesCount?>)</span>
        <?php else: ?>
            <?= CHtml::link('Like (' . $post->likesCount. ')', array('/posts/likePost', 'post_id'=>$post->id), array('class'=>'btn btn-sm btn-primary')) ?>
        <?php endif; ?>
    <?php endif; ?>
</article>
<!-- Comments section-->
<section class="mb-5 mt-2">
    <div class="card bg-light">
        <div class="card-body">
            <!-- Comment form-->
            <form class="mb-4"><textarea class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea></form>
            <!-- Comment with nested comments-->
            <div class="d-flex mb-4">
                <!-- Parent comment-->
                <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                <div class="ms-3">
                    <div class="fw-bold">Commenter Name</div>
                    If you're going to lead a space frontier, it has to be government; it'll never be private enterprise. Because the space frontier is dangerous, and it's expensive, and it has unquantified risks.
                    <!-- Child comment 1-->
                    <div class="d-flex mt-4">
                        <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                        <div class="ms-3">
                            <div class="fw-bold">Commenter Name</div>
                            And under those conditions, you cannot establish a capital-market evaluation of that enterprise. You can't get investors.
                        </div>
                    </div>
                    <!-- Child comment 2-->
                    <div class="d-flex mt-4">
                        <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                        <div class="ms-3">
                            <div class="fw-bold">Commenter Name</div>
                            When you put money directly to a problem, it makes a good headline.
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single comment-->
            <div class="d-flex">
                <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                <div class="ms-3">
                    <div class="fw-bold">Commenter Name</div>
                    When I look at the universe and all the ways the universe wants to kill us, I find it hard to reconcile that with statements of beneficence.
                </div>
            </div>
        </div>
    </div>
</section>