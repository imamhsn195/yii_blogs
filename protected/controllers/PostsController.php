<?php
class PostsController extends Controller{

      public function actionIndex() {
          $this->layout = 'web_main';
          $criteria = new CDbCriteria;
        
          if (isset($_GET['q'])) {
            $criteria->addSearchCondition('title', $_GET['q']);
          }
        
          if (isset($_GET['author'])) {
            $criteria->addCondition('user_id=:user_id');
            $criteria->params[':user_id'] = $_GET['author'];
          }
        
          $posts = Post::model()->findAll($criteria);
          $this->render('/posts/index', array('posts' => $posts));
      }
    
      public function actionCreate() {
        $this->layout = 'web_main';
        $model = new Post;
    
        if (isset($_POST['Post'])) {
          $model->attributes = $_POST['Post'];
          $model->author_id = Yii::app()->user->id;
          if ($model->save()) {
            $this->redirect(array('index'));
          }
        }
        $this->render('/posts/create', array('model' => $model));
      }
      
      public function actionView($id){
        $this->layout = 'web_main';
        $model = Post::model()->findByPk($id);
        if (!$model) {
            $this->redirect(array('index'));
        }

        if ($model->author_id != Yii::app()->user->id) {
          Yii::app()->user->setFlash('danger', 'You are not authorized to view this post.');
          $this->redirect(array('index'));
      }
  

        $this->render('/posts/view', array('post' => $model));
      }

      public function actionUpdate($id)
      {
          $this->layout = 'web_main';
          $model = Post::model()->findByPk($id);

          if (!$model) {
              $this->redirect(['index']);
          }

          if ($model->author_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', 'You are not authorized to perform this action.');
            $this->redirect(array('index'));
          }
      
          if (isset($_POST['Post'])) {
              $model->attributes = $_POST['Post'];
              if ($model->save()) {
                  $this->redirect(['index']);
              }
          }
      
          $this->render('/posts/update', ['model' => $model]);
      }
      
      public function actionDelete($id)
      {
          $this->layout = 'web_main';
          $model = Post::model()->findByPk($id);

          if (!$model) {
              $this->redirect(['index']);
          }
      
          if ($model->author_id != Yii::app()->user->id) {
            Yii::app()->user->setFlash('danger', 'You are not authorized to perform this action.');
            $this->redirect(array('index'));
          }
      
          $model->delete();
          Yii::app()->user->setFlash('success', 'Post deleted successfully.');
          $this->redirect(array('index'));
      }
      
}