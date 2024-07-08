<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Post</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= Yii::app()->createUrl('/posts/index')?>">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= Yii::app()->createUrl('/posts/index')?>">All Posts</a></li>
                    <?php if (Yii::app()->user->isGuest) : ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Yii::app()->createUrl('/site/login')?>">Log In</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= Yii::app()->createUrl('/site/signup')?>">SignUp</a></li>
                    <?php else : ?>
                        <li class="nav-item"><a class="nav-link" href="<?= Yii::app()->createUrl('/posts/create')?>">Add Post</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= Yii::app()->createUrl('/site/logout')?>">Logout <?='('.Yii::app()->user->name.')'?></a></li>
                    <?php  endif; ?>
                </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    <?php if(isset($this->breadcrumbs)):?>
                        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links'=>$this->breadcrumbs,
                        )); ?><!-- breadcrumbs -->
                    <?php endif?>
                    <?php if(!Yii::app()->user->isGuest && Yii::app()->user->getState('emailVerified') == false): ?>
                        <?php if (!Yii::app()->user->getState('emailVerified')): ?>
                            <div class="alert alert-warning fade show" role="alert">
                                Your email is not verified. Please click<a href="<?php echo $this->createAbsoluteUrl('site/verifyEmail', array('token' => Yii::app()->user->token))?>" style="text-decoration:none"> here </a>to verify your email to unlock full access.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php             
                $flashes = Yii::app()->user->getFlashes();
                foreach ($flashes as $key => $message) {
                    echo '<div class="alert alert-' . $key . ' alert-dismissible fade show" role="alert">' . $message . '</div>';
                }
                ?> 
                <?= $content ?>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Search</div>
                        <div class="card-body">
                        <form action="<?=Yii::app()->createUrl('/posts/index')?>" method="get">
                            <div class="input-group mb-2">
                                <select class="form-control" name="author_id">
                                    <option selected>All</option>
                                    <?php foreach(Yii::app()->authorComponent->getAuthors() as $author): ?>
                                        <option value="<?=$author->id?>" <?= isset($_GET['author_id']) && $_GET['author_id'] == $author->id ? 'selected' : '' ?>><?=$author->username?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="input-group mb-2">
                                <input class="form-control" name="date_search" type="date" id="date" value="<?= isset($_GET['date_search']) ? htmlspecialchars($_GET['date_search']) : '' ?>">
                            </div>
                            <div class="input-group mb-2">
                                <input class="form-control" name="like_search" type="text" placeholder="Enter title or content..." aria-label="Enter title or content..." aria-describedby="button-search" value="<?= isset($_GET['like_search']) ? htmlspecialchars($_GET['like_search']) : '' ?>">
                            </div>
                            <button class="btn btn-primary float-end" id="button-search" type="submit">Search!</button>
                        </form>

                        </div>
                    </div>
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">Web Design</a></li>
                                        <li><a href="#!">HTML</a></li>
                                        <li><a href="#!">Freebies</a></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">JavaScript</a></li>
                                        <li><a href="#!">CSS</a></li>
                                        <li><a href="#!">Tutorials</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Side Widget</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/scripts.js"></script>
    </body>
</html>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var alerts = document.querySelectorAll('.alert.alert-dismissible');
    alerts.forEach(function(alert) {
        var seconds = 5;
        var countdown = setInterval(function() {
            seconds--;
            if (seconds <= 0) {
                clearInterval(countdown);
                alert.classList.remove('show');
                alert.classList.add('hide');
                alert.remove();
            }
        }, 1000);
    });
});
</script>
