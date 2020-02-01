<?php

namespace app\models;
use yii\base\Model;

class LoginForm extends Model
{
    public $password;
    public $login;
    
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'password']
        ];
    }
}