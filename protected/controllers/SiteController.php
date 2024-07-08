<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$posts = Post::model()->findAll();
		$this->layout = 'web_main';
		$this->render('/posts/index', ['posts' => $posts]);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$this->layout = 'web_main';
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	public function actionSignup() {
		$user = new User;
		$this->layout = 'web_main';
		if (isset($_POST['User'])) {
		  $user->attributes = $_POST['User'];
		  $user->token = md5(uniqid(rand(), true));
		  $user->status = 1;
	
		  if ($user->save()) {
			// $this->sendVerificationEmail($user);
			Yii::app()->user->setFlash('success', 'Thank you for registering. Please check your email to verify your account.');
			$this->redirect(array('login'));
		  }
		}
		$this->render('signup', array('model' => $user));
	  }
	  
	  public function sendVerificationEmail($user) {

		$verificationUrl = $this->createAbsoluteUrl('site/verifyEmail', array('token' => $user->token));

		Yii::import('application.extensions.swiftMailer.SwiftMailer');

		$mailer = Yii::app()->mailer;
	
		$transport = Swift_SmtpTransport::newInstance('smtp.example.com', 25)
			->setUsername('your_username')
			->setPassword('your_password');

		$mailer = Swift_Mailer::newInstance($transport);

		$message = Swift_Message::newInstance('Email Verification')
			->setFrom(['from@example.com' => 'Your Application'])
			->setTo([$user->email => $user->name])
			->setBody("Please click the following link to verify your email address: $verificationUrl");

		$result = $mailer->send($message);

		if ($result) {
			echo "Verification email sent successfully!";
		} else {
			echo "Failed to send verification email.";
		}
	}

	//   public function actionUsername() {
	// 	$username = $_POST['username'];
	//   }
	public function actionLogin()
	{
		$this->layout = 'web_main';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			$this->redirect(Yii::app()->user->returnUrl);
		}

		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionCheckEmail() {
		$email = $_POST['email'];
		$exists = User::model()->exists('email=:email', array(':email' => $email));
		$response = [];
		if ($exists) {
			$response = ['status' => 200, 'message' => "This email address is already registered."];
		} else {
			$response = ['status' => 201, 'message' => "This email address is available."];
		}

		header('Content-Type: application/json');

		echo CJSON::encode($response);
	  }

	public function actionVerifyEmail($token)
	{
		$user = User::model()->findByToken($token);
		if ($user !== null) {
			$user->email_verified = 1;
			$user->token = null;
			$user->save(false);
			Yii::app()->user->setState('emailVerified', true);
			Yii::app()->user->setState('token', $user->token);
			Yii::app()->user->setFlash('success', 'Your email has been successfully verified.');
			return $this->redirect(['posts/index']);
		} else {
			Yii::app()->user->setFlash('danger', 'Invalid verification token.');
			return $this->redirect(['posts/index']);
		}
	}
}