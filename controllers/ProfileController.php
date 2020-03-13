<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\db\Post;
use yii\data\Pagination;

/**
 * Контроллер пользователя
 * Формирует страницу пользовательского профиля
 */
class ProfileController extends Controller
{
    /**
     * Пост дизлайкнут
     */
    const DISLIKE = 0;

    /**
     * Пост лайкнут
     */
    const LIKE = 1;

    /**
     * Пост в избранном
     */
    const IS_FAVORITE = 1;

    /**
     * @var Bool переменная для хранения состояния (bool) посетителя (гость/пользователь)
     */
    public $isUserGuest;

    /**
     * @var Integer переменная для хранения ID пользователя
     */
    public $systemUserId;

    /**
     * Инициализация объекта (донастройка/конфигурирование)
     */
    public function init()
    {
        $this->isUserGuest  = Yii::$app->user->isGuest;
        $this->systemUserId = Yii::$app->user->identity->id;
    }

    public function actionIndex()
    {
        if ($this->isUserGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts  = Post::find()->where([
            'user_id' => $this->systemUserId,
            'action'  => self::LIKE
        ]);

        /**
         * Создание объекта пагинации
         */
        $pages  = new Pagination(['totalCount' => $posts->count()]);

        /**
         * Выдача записей из БД с учетом смещения и лимита пагинации
         */
        $models = $posts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        return $this->render('index', [
            'models' => $models,
            'pages'  => $pages
        ]);
  }

    public function actionLikes()
    {
        if ($this->isUserGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts  = Post::find()->where([
            'user_id' => $this->systemUserId,
            'action'  => self::LIKE
        ]);

        /**
         * Создание объекта пагинации
         */
        $pages  = new Pagination(['totalCount' => $posts->count()]);

        /**
         * Выдача записей из БД с учетом смещения и лимита пагинации
         */
        $models = $posts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        return $this->render('likes', [
            'models' => $models,
            'pages'  => $pages
        ]);
    }

    public function actionDislikes()
    {
        if ($this->isUserGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts  = Post::find()->where([
            'user_id' => $this->systemUserId,
            'action'  => self::DISLIKE
        ]);

        /**
         * Создание объекта пагинации
         */
        $pages  = new Pagination(['totalCount' => $posts->count()]);

        /**
         * Выдача записей из БД с учетом смещения и лимита пагинации
         */
        $models = $posts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        return $this->render('dislikes', [
            'models' => $models,
            'pages'  => $pages
        ]);
    }

    public function actionFavorites()
    {
        if ($this->isUserGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts = Post::find()->where([
            'user_id'  => $this->systemUserId,
            'favorite' => self::IS_FAVORITE
        ]);

        /**
         * Создание объекта пагинации
         */
        $pages  = new Pagination(['totalCount' => $posts->count()]);

        /**
         * Выдача записей из БД с учетом смещения и лимита пагинации
         */
        $models = $posts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        return $this->render('favorites', [
            'models' => $models,
            'pages'  => $pages
        ]);
    }
}