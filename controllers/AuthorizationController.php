<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\db\User;

/**
 * Контроллер авторизации
 * Необходим для действий входа, выхода, регистрации
 */
class AuthorizationController extends Controller
{
  /**
   * Действие входа
   * Производит вход в систему
   *
   * @return void
   */
  public function actionLogin()
  {
    if(!Yii::$app->request->post())
      return $this->goHome();
      
    $request = Yii::$app->request->post('LoginForm');
    $identity = User::findOne(['login' => $request['login']]);
    if($identity  && Yii::$app->security->validatePassword($request['password'], $identity->password))
    {
      Yii::$app->user->login($identity);

      /**
       * Параметр '?&login=success' необходим для формы входа
       * Если success - авторизация прошла успешно
       */
      return $this->redirect(Yii::$app->request->referrer . '?&login=success');
    }
    else

      /**
       * Параметр '?&login=failed' необходим для формы входа
       * Если failed - авторизация не увенчалась успехом и будет открыта форма авторизации,
       * с указанием ошибки
       */
      return $this->redirect(Yii::$app->request->referrer . '?&login=failed');
    }

  /**
   * Действие регистрации
   * Производит занесение нового пользоователя в БД и производит вход от имени
   * нового пользователя
   *
   * @return void
   */
  public function actionRegistration()
  {
    if(!Yii::$app->request->post())
      return $this->goHome();

    $request = Yii::$app->request->post('RegisterForm');
    $user = new User();
    $user->login = $request['login'];
    $user->password = Yii::$app->security->generatePasswordHash($request['password']);
    $user->save();

    Yii::$app->user->login($user);
    return $this->redirect(Yii::$app->request->referrer);
  }

  /**
   * Действие выхода
   * Производит выход из системы и возвращает на главную страницу
   *
   * @return void
   */
  public function actionLogout()
  {
    Yii::$app->user->logout();
    return $this->goHome();
  }
}