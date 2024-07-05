<?php
class Post extends CActiveRecord {
    public function rules() {
        return array(
          array('title, content', 'required'),
          array('is_public', 'boolean'),
        );
      }
    
      public static function model($className=__CLASS__) {
        return parent::model($className);
      }

      public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        );
    }
}