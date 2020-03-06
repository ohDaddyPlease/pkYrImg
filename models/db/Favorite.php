<?php

namespace app\models\db;

use yii\db\ActiveRecord;

class Favorite extends ActiveRecord
{
  public static function tableName()
  {
    return 'favorite';
  }

  /**
   * Задание primary key
   * Необходимо для метода delete()
   *
   * @return void
   */
  public static function primaryKey()
  {
    return ['post'];
  }
}