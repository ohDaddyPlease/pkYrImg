<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\db\Like;
use yii\data\Pagination;

/**
 * Контроллер пользователя
 * Формирует страницу пользовательского профиля
 */
class ProfileController extends Controller
{
  public function actionIndex()
  {
    if(Yii::$app->user->isGuest)
      return $this->goHome(); 

    $likes = Like::find()->where(['user_id' => Yii::$app->user->identity->id, 
                                  'action' => 1]);
    $pages = new Pagination(['totalCount' => $likes->count()]);
    $models = $likes->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();

    return $this->render('index.php', [
      'models' => $models, 
      'pages' => $pages
    ]);
  }
}