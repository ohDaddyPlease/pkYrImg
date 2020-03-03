<?php

namespace app\models\db;

use yii\db\ActiveRecord;

class Favorite extends ActiveRecord
{
  public static function tableName()
  {
    return 'favorite';
  }
}