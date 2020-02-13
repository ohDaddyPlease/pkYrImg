<?php

namespace app\models\forms;
use yii\base\Model;
use app\models\db\User;
use Yii;

class LoginForm extends Model
{
    public $password;
    public $login;
    
    public function rules()
    {
        return [
            [['login', 'password'], 'required', 'message' => 'Это обязательное поле!'],
            [['login', 'password',], 'loginFailed']
        ];
    }

    public function loginFailed()
    {
    }
}