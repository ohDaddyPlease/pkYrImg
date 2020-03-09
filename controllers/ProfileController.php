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
  public function actionIndex()
  {
    if(Yii::$app->user->isGuest)
      return $this->goHome(); 

    $posts = Post::find()->where(['user_id' => Yii::$app->user->identity->id, 
                                  'action' => 1]);
    $pages = new Pagination(['totalCount' => $posts->count()]);
    $models = $posts->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();

    return $this->render('index.php', [
      'models' => $models, 
      'pages' => $pages
    ]);
  }

  public function actionLikes()
  {
    if(Yii::$app->user->isGuest)
      return $this->goHome();
    
      $posts = Post::find()->where(['user_id' => Yii::$app->user->identity->id, 
      'action' => 1]);
      $pages = new Pagination(['totalCount' => $posts->count()]);
      $models = $posts->offset($pages->offset)
      ->limit($pages->limit)
      ->all();

      return $this->render('likes.php', [
      'models' => $models, 
      'pages' => $pages
      ]);
  }

  public function actionDislikes()
  {
    if(Yii::$app->user->isGuest)
      return $this->goHome();
    
      $posts = Post::find()->where(['user_id' => Yii::$app->user->identity->id, 
      'action' => 0]);
      $pages = new Pagination(['totalCount' => $posts->count()]);
      $models = $posts->offset($pages->offset)
      ->limit($pages->limit)
      ->all();

      return $this->render('dislikes.php', [
      'models' => $models, 
      'pages' => $pages
      ]);
  }

  public function actionFavorites()
  {
    if(Yii::$app->user->isGuest)
      return $this->goHome();
    
      $posts = Post::find()->where(['user_id' => Yii::$app->user->identity->id, 
      'favorite' => 1]);
      $pages = new Pagination(['totalCount' => $posts->count()]);
      $models = $posts->offset($pages->offset)
      ->limit($pages->limit)
      ->all();

      return $this->render('favorites.php', [
      'models' => $models, 
      'pages' => $pages
      ]);
  }
}