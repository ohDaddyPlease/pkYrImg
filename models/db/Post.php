<?php
namespace app\models\db;

use yii\db\ActiveRecord;

/**
 * Модель для работы с таблицей БД post
 */
class Post extends ActiveRecord
{
    public static function tableName()
    {
        return 'post';
    }
}