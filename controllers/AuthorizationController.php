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
      $identity = User::findOne(['login' => $request['login']]);
      Yii::$app->user->login($identity);
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
    $identity = User::findOne(['login' => $request['login']]);
    Yii::$app->user->login($identity);
    return $this->redirect(Yii::$app->request->referrer);
  }

  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->redirect(Yii::$app->request->referrer);
  }
}