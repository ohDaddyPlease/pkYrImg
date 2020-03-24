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
            ['login', 'unique']
        ];
    }

    public function fields()
    {
        return [
            'id',
            'login',
            'role'
        ];
    }

}