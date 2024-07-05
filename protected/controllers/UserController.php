<?php
class UserController extends Controller {
  public function actionSignup() {
    $model = new User;
    $this->layout = 'web_main';
    if (isset($_POST['User'])) {
      $model->attributes = $_POST['User'];
      $model->token = md5(uniqid(rand(), true));
      $model->status = 1;

      if ($model->save()) {
        $this->redirect(array('signin'));
      }
    }
    $this->render('signup', array('model' => $model));
  }

  public function actionSignin() {
    $this->layout = 'web_main';
    if (isset($_POST['User']['username']) && isset($_POST['User']['password'])) {
      $user = User::model()->findByAttributes(array('username' => $_POST['User']['username'], 'password' => md5($_POST['User']['password'])));
      if($user && $user->login())
				$this->redirect(Yii::app()->user->returnUrl);
      
      // if ($user) {
      //   Yii::app()->user->setId($user->id);
      //   $this->redirect(array('/posts/index'));
      // }
    }
    $this->render('signin', array('model' => new User));
  }

  public function actionVerify($token) {
    $user = User::model()->findByAttributes(array('token' => $token));
    if ($user) {
      $user->status = 1;
      $user->token = null;
      $user->save();
      $this->redirect(array('signin'));
    }
  }

  public function actionUsername() {
    $username = $_POST['username'];
  }
}
