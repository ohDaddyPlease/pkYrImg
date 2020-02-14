<?php

namespace app\models\db;

use yii\db\ActiveRecord;

/**
 * Модель для работы с таблицей БД Like
 */
class Like extends ActiveRecord
{
  public static function tableName()
  {
    return 'like';
  }
}