<?php

class PostLike extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'post_likes';
    }

    public function rules()
    {
        return array(
            array('post_id, user_id', 'required'),
            array('post_id, user_id', 'numerical', 'integerOnly' => true),
            array('post_id, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'likes' => array(self::HAS_MANY, 'PostLike', 'post_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }
}
