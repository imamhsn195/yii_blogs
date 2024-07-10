<?php
class User extends CActiveRecord {
    public $password_repeat;
  
    public function rules() {
      return array(
        array('username, password, email', 'required'),
        array('username', 'unique', 'message' => "This username is already registered."),
        array('email', 'email'),
        array('email', 'unique', 'message' => "This email address is already registered."),
        array('password', 'compare'),
        array('password_repeat', 'safe'),
        array('token', 'length', 'max'=>255),
        array('email_verified', 'boolean'),
      );
    }
  
    public function beforeSave() {
      if (parent::beforeSave()) {
        if ($this->isNewRecord) {
          $this->password = md5($this->password);
        }
        return true;
      } else {
        return false;
      }
    }
  
    public static function findByToken($token) {
      return self::model()->findByAttributes(array('token' => $token));
    }
    
    public static function model($className=__CLASS__) {
      return parent::model($className);
    }

    public function relations() {
      return array(
          'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
      );
    }
    
  }