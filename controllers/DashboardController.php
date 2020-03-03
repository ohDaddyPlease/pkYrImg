<?php
namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\db\Like;
use app\models\db\Favorite;

/**
 * Контроллер главной страницы (дашборда)
 * Формирует страницу с картинкой и названием
 */
class DashboardController extends Controller
{
  public function actionIndex()
  {
    $resp = Yii::$app->picker->pick();
    $img =  $resp['img'];
    $num = $resp['num'];
    $title = $resp['safe_title']??'Pick Your Image';
    return $this->render('index', [
        'img' => $img, 
        'title' => $title, 
        'num' => $num
    ]);
  }

  /**
   * Действие добавления в БД записи о лайке/дизлайке поста
   *
   * @return void
   */
  public function actionLikeDislike()
  {
    if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && !Yii::$app->request->post())) return;
    
    $like = new Like;
    $like->user_id = Yii::$app->user->identity->id;
    $like->post_id = Yii::$app->request->post('num');
    $like->action = Yii::$app->request->post('action');
    $like->img = Yii::$app->request->post('img');
    $like->save();

    return json_encode(Yii::$app->picker->pick());
  }

  /**
   * Действие для добавления поста (картинки) в БД, с соотнесением id поста с id пользователя
   *
   * @return void
   */
  public function actionAddToFavorite()
  {
    if(Yii::$app->user->isGuest || (!Yii::$app->user->isGuest && !Yii::$app->request->post())) return;

    $favorite = new Favorite;
    $favorite->user = Yii::$app->user->identity->id;
    $favorite->post = Yii::$app->request->post('num');
    $favorite->save();
  }
}