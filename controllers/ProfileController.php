<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\db\User;
use Yii;

class ProfileController extends Controller
{
  public function actionIndex()
  {
    if(Yii::$app->user->isGuest) return $this->goHome(); 
    return $this->render('index.php');
  }
}