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
            [['login', 'password'], 'required'],
            ['password', 'loginValidation']
        ];
    }

    public function loginValidation($attribute, $params)
    {
        die();
        // $this->validate();
        // $hash = User::find()->where('login = ' . $this->login);
        // if(Yii::$app->security->validatePassword($this->password, $hash->password));
        // else $this->addError($attribute, 'no!');
    }
}