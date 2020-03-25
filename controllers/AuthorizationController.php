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
     * @var \yii\web\Request переменная для хранения объекта request
     */
    public $request;

    /**
     * @var User переменная для хранения объекта user
     */
    public $systemUser;

    /**
     * Инициализация объекта (донастройка/конфигурирование)
     */
    public function init()
    {
        $this->request    = Yii::$app->request;
        $this->systemUser = Yii::$app->user;
    }

    /**
     * Действие входа
     * Производит вход в систему
     *
     * @return bool|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!$this->request->post()) {
            return $this->goHome();
        }

        /**
         * Получение данных из формы входа
         */
        $postRequest = $this->request->post('LoginForm');

        /**
         * Поиск пользователя в таблице БД
         */
        $user            = User::findOne(['login' => $postRequest['login']]);
        if (!$user) {
            return false;
        }
        $isPasswordValid = Yii::$app->security->validatePassword(
            $postRequest['password'],
            $user->password
        );
        if ($isPasswordValid)
        {
            $this->systemUser->login($user);
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
        if (!$this->request->post()) {
            return $this->goHome();
        }

        /**
         * Получение данных из формы регистрации
         */
        $postRequest    = $this->request->post('RegisterForm');

        /**
         * Создание экземпляра объекта для занесения новой  записи о пользователе в БД
         */
        $user           = new User();
        $user->login    = $postRequest['login'];
        $user->password = Yii::$app->security->generatePasswordHash($postRequest['password']);
        if ($user->validate()) {
            $user->save();
            $this->systemUser->login($user);
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
        $this->systemUser->logout();
        return $this->goHome();
    }

}