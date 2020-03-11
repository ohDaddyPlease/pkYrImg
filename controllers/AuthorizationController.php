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
     * @return bool|\yii\web\Response
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        if (! $request->post()) {
            return $this->goHome();
        }

        /**
         * Получение данных из формы входа
         */
        $postRequest = $request->post('LoginForm');

        /**
         * Поиск пользователя в таблице БД
         */
        $user = User::findOne(['login' => $postRequest['login']]);
        $isPasswordValid = Yii::$app->security->validatePassword($postRequest['password'], $user->password);
        if ($user  && $isPasswordValid)
        {
            Yii::$app->user->login($user);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Действие регистрации
     * Производит занесение нового пользоователя в БД и производит вход от имени
     * нового пользователя
     *
     * @return bool|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionRegistration()
    {
        $request = Yii::$app->request;
        if (! $request->post()) {
            return $this->goHome();
        }

        /**
         * Получение данных из формы регистрации
         */
        $postRequest    = $request->post('RegisterForm');
        $user           = new User();
        $user->login    = $postRequest['login'];
        $user->password = Yii::$app->security->generatePasswordHash($postRequest['password']);
        if ($user->validate()) {
            $user->save();
            Yii::$app->user->login($user);
            return true;
        } else {
            return false;
        }

    }

    /**
     * Действие выхода
     * Производит выход из системы и возвращает на главную страницу
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

}