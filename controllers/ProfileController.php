<?php

namespace app\controllers;
use yii\web\Controller;
use app\models\db\User;
use Yii;

class ProfileController extends Controller
{
  public function actionIndex()
  {
    return $this->render('index.php');
  }
}