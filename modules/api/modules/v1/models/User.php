<?php
namespace app\modules\api\modules\v1\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            ['login', 'unique'],
            [['login', 'password'], 'required']
        ];
    }

    public function load($data, $formName = null)
    {
        parent::load($data, $formName);
        $this->setAttribute('password', \Yii::$app->security->generatePasswordHash($this->password));
    }

    public function fields()
    {
        return [
            'id',
            'login',
            'role',
        ];
    }

}