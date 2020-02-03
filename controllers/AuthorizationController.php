<?php

namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\db\User;

class AuthorizationController extends Controller
{
  public function actionLogin()
  {
    if(!Yii::$app->request->post())
      return $this->goHome();
      $request = Yii::$app->request->post('LoginForm');
      return $this->redirect(Yii::$app->request->referrer);
  }

  public function actionRegistration()
  {
    if(!Yii::$app->request->post())
    return $this->goHome();
    $request = Yii::$app->request->post('RegisterForm');
    $user = new User();
    $user->login = $request['login'];
    $user->password = Yii::$app->security->generatePasswordHash($request['password']);
    $user->save();
    return $this->redirect(Yii::$app->request->referrer);
  }

  public function actionLogout()
  {
    if(!Yii::$app->request->post())
    return $this->goHome();
  }
}