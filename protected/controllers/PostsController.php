<?php
class PostsController extends Controller{

      public function actionIndex() {
        $this->layout = 'web_main';
        $criteria = new CDbCriteria;

        if (!Yii::app()->user->isGuest) {

            $userId = Yii::app()->user->id;
            $criteria->addCondition('is_public = 1');
            $criteria->addCondition('author_id = :userId AND is_public = 1', 'OR');
            $criteria->params[':userId'] = $userId;

        } else {

            $criteria->addCondition('is_public = 1');

        }

        if (isset($_GET['q']) && !empty($_GET['q'])) {

            $criteria->addSearchCondition('title', $_GET['q']);

        }

        if (isset($_GET['author']) && !empty($_GET['author'])) {

            $criteria->addCondition('author_id = :author_id');
            $criteria->params[':author_id'] = $_GET['author'];
            
        }

        $posts = Post::model()->findAll($criteria);

        $this->render('/posts/index', array('posts' => $posts));
    }

      public function actionCreate() {
        $this->layout = 'web_main';
        $model = new Post;
    
        if(!User::model()->findByPk(Yii::app()->user->id)->email_verified){
          Yii::app()->user->setFlash('danger', 'Your account\'s email id is not verified.');
          $this->redirect(array('index'));
        }

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
        if(!User::model()->findByPk(Yii::app()->user->id)->email_verified){
          Yii::app()->user->setFlash('danger', 'Your account\'s email id is not verified.');
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

          if(!User::model()->findByPk(Yii::app()->user->id)->email_verified){
            Yii::app()->user->setFlash('danger', 'Your account\'s email id is not verified.');
            $this->redirect(array('index'));
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
          
          if(!User::model()->findByPk(Yii::app()->user->id)->email_verified){
            Yii::app()->user->setFlash('danger', 'Your account\'s email id is not verified.');
            $this->redirect(array('index'));
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