<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;

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
    return $this->render('index.php');
  }
}