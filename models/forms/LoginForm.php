<?php
namespace app\models\forms;

use yii\base\Model;

/**
 * Модель для работы с формой
 * Включает поле пароля и логина
 */
class LoginForm extends Model
{
    public $password;
    public $login;
  
    public function rules()
    {
        return [
            [
                ['login', 'password'],
                'required',
                'message' => 'Это обязательное поле!'
            ],
        ];
    }

}