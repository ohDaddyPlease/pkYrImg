<?php

namespace app\models\db;

use yii\db\ActiveRecord;

class Like extends ActiveRecord
{
  public static function tableName()
  {
    return 'like';
  }
}