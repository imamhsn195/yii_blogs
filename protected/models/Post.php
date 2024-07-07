<?php
class Post extends CActiveRecord {
    public function rules() {
        return array(
          array('title, content', 'required'),
          array('is_public', 'boolean'),
          array('image_url', 'safe'), 
        );
      }
    
      public static function model($className=__CLASS__) {
        return parent::model($className);
      }

      public function relations() {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'likes' => array(self::HAS_MANY, 'PostLike', 'post_id'),
            'likesCount' => array(self::STAT, 'PostLike', 'post_id'),
        );
    }
}