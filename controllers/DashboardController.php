<?php
namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use app\models\db\Post;
use app\models\forms\UploadForm;

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

    /**
     * @var \yii\web\Request переменная для хранения объекта request
     */
    public $request;

    /**
     * @var User переменная для хранения объекта user
     */
    public $systemUser;

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
        $this->request      = Yii::$app->request;
        $this->systemUser   = Yii::$app->user;
        $this->isUserGuest  = Yii::$app->user->isGuest;
        $this->systemUserId = Yii::$app->user->id;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['upload'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
                'denyCallback' => function() {
                    return $this->redirect('access-denied');
                }
            ]
        ];
    }

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
        if ($this->isUserGuest
            || (!$this->isUserGuest && !$this->request->post())
        ) {
            return false;
        }

        /**
         * Получение (поиск) данных о посте (картинке) из БД
         */
        $post = Post::findOne([
            'post_id' => $this->request->post('num'),
            'user_id' => $this->systemUserId
        ]);
        if ($post !== null) {
            $post->action = $this->request->post('action');
            $post->save();
            return json_encode(Yii::$app->picker->pick());
        }

        /**
         * Созздание нового поста, если таковой не был найден
         */
        $post          = new Post;
        $post->user_id = $this->systemUserId;
        $post->post_id = $this->request->post('num');
        $post->action  = $this->request->post('action');
        $post->img     = $this->request->post('img');
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
        if ($this->isUserGuest
            || (!$this->isUserGuest && !$this->request->post())
        ) {
            return false;
        }

        /**
         * Получение (поиск) данных о посте (картинке) в БД
         */
        $favorite = Post::findOne([
            'post_id' => $this->request->post('num'),
            'user_id' => $this->systemUserId
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

        /**
         * Созздание нового поста, если таковой не был найден
         */
        $favorite           = new Post;
        $favorite->user_id  = $this->systemUserId;
        $favorite->post_id  = $this->request->post('num');
        $favorite->img      = $this->request->post('img');
        $favorite->favorite = self::ADD_TO_FAVORITE;
        $favorite->save();
  }

  public function actionUpload()
  {
      $model = new UploadForm;
      return $this->render('upload', [
          'model' => $model
      ]);
  }
}