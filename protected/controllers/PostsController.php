<?php
class PostsController extends Controller{
    public function actionIndex(){
        $this->layout = 'web_main';
        $message = "Welcome to Post index page";
        return $this->render('/posts/index', ['message' => $message]);
    }

    public function actionCreate(){
        $this->layout = 'web_main';
        $message = "Welcome to Post create page.";
        return $this->render('/posts/create', ['message' => $message]);
    }

    public function actionView(){
        $this->layout = 'web_main';
        $message = "Welcome to Post View Page";
        return $this->render('/posts/view', ['message' => $message]);
    }

    public function actionEdit(){
        $this->layout = 'web_main';
        $message = "Welcome to Post Edit page";
        $this->render('/posts/edit', ['message' => $message]);
    }
}