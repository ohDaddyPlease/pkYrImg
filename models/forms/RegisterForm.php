<?php
namespace app\models\forms;

use yii\base\Model;

/**
 * Модель для работы с формой регистрации
 * Аналогично модели формы имеет поле пароля и логина
 */
class RegisterForm extends Model
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