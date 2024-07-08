<?php
class PostsController extends Controller{
      public function filters()
      {
          return array(
              'accessControl',
          );
      }

      public function accessRules()
      {
          return array(
              array('allow',
                  'actions' => array('index', 'view'),
                  'users' => array('?'),
              ),
              array('allow',
                  'actions' => array('LikePost'),
                  'users' => array('@'),
              ),
              array('allow',
                  'actions' => array('create', 'update', 'delete'),
                  'users' => array('@'),
                  'expression' => '$user->getState("emailVerified") === true',
            )
          );
      }
      public function checkAccess($user)
      {
          if ($user->getState('emailVerified') !== true) {
              Yii::app()->user->setFlash('warning', 'Your email is not verified. Please verify your email to perform this action.');
              return false;
          }
          return true;
      }

      public function actionIndex() {
        $this->layout = 'web_main';
        $isGuest = Yii::app()->user->isGuest;
        $author_id =  (isset($_GET['author_id']) && !empty($_GET['author_id'])) ? $_GET['author_id'] : null;
        $like_search = (isset($_GET['like_search']) && !empty($_GET['like_search'])) ? $_GET['like_search'] : null;
        $date_search = (isset($_GET['date_search']) && !empty($_GET['date_search'])) ? $_GET['date_search'] : null;

        $criteria = new CDbCriteria;

        if($isGuest){
          $criteria->addCondition('is_public = 1');
        }
        if($author_id && $author_id != 'All'){
          $criteria->addCondition('author_id = :author_id');
          $criteria->params[':author_id'] = $author_id;
        }
        if($like_search){
          $criteria->addSearchCondition('title', $like_search);
          $criteria->addSearchCondition('content', $like_search);      
        }
        if($date_search){
          $criteria->addCondition('DATE(created_at)  = :date_search');
          $criteria->params[':date_search'] = $date_search;
        }
        $criteria->with = array('likesCount');

         // Log criteria parameters and condition
        Yii::log('Criteria Params: ' . CVarDumper::dumpAsString($criteria->params), CLogger::LEVEL_INFO);
        Yii::log('Criteria Condition: ' . $criteria->condition, CLogger::LEVEL_INFO);

        try {
          $authors = User::model()->findAll();
          $posts = Post::model()->findAll($criteria);
          $this->render('/posts/index', array('posts' => $posts, 'authors' => $authors));
        } catch (Exception $e) {
            // Log any errors
            Yii::log('Error: ' . $e->getMessage(), CLogger::LEVEL_ERROR);
        }
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
        $model = Post::model()->with('likesCount', 'author')->findByPk($id);
        if (!$model) {
            Yii::app()->user->setFlash('danger', "Post is not found.");
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

      public function actionLikePost($post_id)
      {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setFlash('error', 'Please login to like posts.');
            $this->redirect(Yii::app()->user->loginUrl);
        }

        $post = Post::model()->findByPk($post_id);

        if (!$post) {
            throw new CHttpException(404, 'Post not found.');
        }

        $userId = Yii::app()->user->id;

        $existingLike = PostLike::model()->find('post_id=:post_id AND user_id=:user_id', array(':post_id'=>$post_id, ':user_id'=>$userId));

        if ($existingLike) {
            Yii::app()->user->setFlash('error', 'You have already liked this post.');
        } else {
            $like = new PostLike;
            $like->post_id = $post_id;
            $like->user_id = $userId;

            if ($like->save()) {
                Yii::app()->user->setFlash('success', 'Post liked successfully.');
            } else {
                Yii::app()->user->setFlash('error', 'Failed to like the post.');
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer ?: Yii::app()->homeUrl);
      }
      
}