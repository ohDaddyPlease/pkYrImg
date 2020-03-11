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

    public function actionIndex()
    {
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts  = Post::find()->where([
            'user_id' => $user->identity->id,
            'action'  => self::LIKE
        ]);
        $pages  = new Pagination(['totalCount' => $posts->count()]);
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
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts  = Post::find()->where([
            'user_id' => $user->identity->id,
            'action'  => self::LIKE
        ]);
        $pages  = new Pagination(['totalCount' => $posts->count()]);
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
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts  = Post::find()->where([
            'user_id' => $user->identity->id,
            'action'  => self::DISLIKE
        ]);
        $pages  = new Pagination(['totalCount' => $posts->count()]);
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
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return $this->goHome();
        }

        /**
         * Получение всех лайкнутых постов и создание пагинации
         */
        $posts = Post::find()->where([
            'user_id'  => $user->identity->id,
            'favorite' => self::IS_FAVORITE
        ]);
        $pages  = new Pagination(['totalCount' => $posts->count()]);
        $models = $posts->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
        return $this->render('favorites', [
            'models' => $models,
            'pages'  => $pages
        ]);
    }
}