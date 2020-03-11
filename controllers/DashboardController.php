<?php
namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\db\Post;

/**
 * Контроллер главной страницы (дашборда)
 * Формирует страницу с картинкой и названием
 */
class DashboardController extends Controller
{
    /**
     * Находится ли пост в избарнном
     */
    const IS_FAVORITE = 1;

    /**
     * Добавить пост в избранное
     */
    const ADD_TO_FAVORITE = 1;

    /**
     * Удалить пост из избранного
     */
    const DELETE_FROM_FAVORITE = 0;

    /**
     * Альтернативный заголовок для поста (картинки)
     */
    const ALTERNATIVE_TITLE = 'Pick Your Image';

    public function actionIndex()
    {
        /**
         * Получение рандомной картинки с сайта xkcd
         */
        $img    = Yii::$app->picker->pick();
        $src    = $img['img'];
        $number = $img['num'];
        $title  = $img['safe_title'] ?? self::ALTERNATIVE_TITLE;
        return $this->render('index', [
            'img'   => $src,
            'title' => $title,
            'num'   => $number
        ]);
    }

    /**
     * Действие добавления в БД записи о лайке/дизлайке поста
     *
     * @return false|string
     */
    public function actionLikeDislike()
    {
        $request = Yii::$app->request;
        $user    = Yii::$app->user;

        if ($user->isGuest || (! $user->isGuest && ! $request->post())) {
            return false;
        }

        /**
         * Получение (поиск) данных о посте (картинке) в БД
         */
        $post = Post::findOne([
            'post_id' => $request->post('num'),
            'user_id' => $user->identity->id
        ]);
        if ($post !== null) {
            $post->action = $request->post('action');
            $post->save();
            return json_encode(Yii::$app->picker->pick());
        }
        $post = new Post;
        $post->user_id = $user->identity->id;
        $post->post_id = $request->post('num');
        $post->action  = $request->post('action');
        $post->img     = $request->post('img');
        $post->save();
        return json_encode(Yii::$app->picker->pick());
  }

    /**
     * Действие для добавления поста (картинки) в БД, с соотнесением id поста с id пользователя
     *
     * @return bool
     */
    public function actionAddToFavorite()
    {
        $request = Yii::$app->request;
        $user    = Yii::$app->user;
        if ($user->isGuest || (! $user->isGuest && ! $request->post())) {
            return false;
        }

        /**
         * Получение (поиск) данных о посте (картинке) в БД
         */
        $favorite = Post::findOne([
            'post_id' => $request->post('num'),
            'user_id' => $user->identity->id
        ]);

        /**
         * Если пост в избарнном, убрать его из избранного,
         * в ином случае добавить в избранное
         */
        if ($favorite !== null) {
            if ($favorite->favorite == self::IS_FAVORITE) {
                $favorite->favorite = self::DELETE_FROM_FAVORITE;
            } else {
                $favorite->favorite = self::ADD_TO_FAVORITE;
            }
            $favorite->save();
            return true;
        }
        $favorite = new Post;
        $favorite->user_id  = $user->identity->id;
        $favorite->post_id  = $request->post('num');
        $favorite->img      = $request->post('img');
        $favorite->favorite = self::ADD_TO_FAVORITE;
        $favorite->save();
  }
}