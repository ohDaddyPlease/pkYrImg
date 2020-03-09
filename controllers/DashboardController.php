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

    if(($post = Post::findOne([
        'post_id' => Yii::$app->request->post('num'),
        'user_id' => Yii::$app->user->identity->id
    ])) !== null)
    {
      $post->action = Yii::$app->request->post('action');
      $post->save();

      return json_encode(Yii::$app->picker->pick());
    }

    $post = new Post;
    $post->user_id = Yii::$app->user->identity->id;
    $post->post_id = Yii::$app->request->post('num');
    $post->action = Yii::$app->request->post('action');
    $post->img = Yii::$app->request->post('img');
    $post->save();
    
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

    if(($favorite = Post::findOne([
        'post_id' => Yii::$app->request->post('num'),
        'user_id' => Yii::$app->user->identity->id]
    )) !== null)
    {
      if($favorite->favorite == 0)
        $favorite->favorite = 1;
      else
        $favorite->favorite = 0;
    $favorite->save();
    return;
    }

    $favorite = new Post;
    $favorite->user_id = Yii::$app->user->identity->id;
    $favorite->post_id = Yii::$app->request->post('num');
    $favorite->img = Yii::$app->request->post('img');
    $favorite->favorite = 1;
    $favorite->save();
  }
}