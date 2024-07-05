<?php
class User extends CActiveRecord {
    public $password_repeat;
  
    public function rules() {
      return array(
        array('username, password, email', 'required'),
        array('email', 'email'),
        array('email', 'unique', 'message' => "This email address is already registered."),
        array('password', 'compare'),
        array('password_repeat', 'safe'),
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
  
    public static function model($className=__CLASS__) {
      return parent::model($className);
    }
    
  }