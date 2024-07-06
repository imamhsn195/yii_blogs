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
            <div class="text-muted fst-italic mb-2">Posted on <?=date_format(new DateTime($post->created_at), 'F j, Y') ?> by <?= $post->author->username ?? "User"?></div>
            <!-- Post categories-->
            <a class="badge bg-secondary text-decoration-none link-light" href="#!">Web Design</a>
            <a class="badge bg-secondary text-decoration-none link-light" href="#!">Freebies</a>
        </header>
        <!-- Preview image figure-->
        <figure class="mb-4"><img class="img-fluid rounded" src="https://dummyimage.com/900x400/ced4da/6c757d.jpg" alt="..." /></figure>
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
    </article>
  </li>
  <?php endforeach; ?>
     <?php if(!$posts): ?>
        <li class="list-group-item">No Post found!</li>
    <?php endif; ?>
</ul>
