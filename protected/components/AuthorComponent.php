<?php
class AuthorComponent extends CApplicationComponent
{
    public function getAuthors()
    {
        return User::model()->findAll();
    }
}