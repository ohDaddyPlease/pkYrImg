<?php

namespace app\models\forms;
use yii\base\Model;

class LoginForm extends Model
{
    public $password;
    public $login;
    
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
        ];
    }
}