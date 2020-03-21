<?php

/**
 * Данное вью в разработке
 * В будущем будет отображать лайкнутые/дизлайкнутые посты и
 * будет позволять совершать над ними различные действия
 */

use yii\web\View;
use app\models\db\Post;

/**
 * Лайк
 */
const LIKE = 1;

/**
 * Дизлайк
 */
const DISLIKE = 0;

/**
 * В избранном
 */
const IN_FAVORITE = 1;

$CSS = <<<CSS
.link{
  border: 1px solid;
  border-radius: 10px;
  padding: 3px;
  text-decoration: none !important;
}
CSS;
$this->registerCss($CSS);

$this->registerJs("",
View::POS_READY
);

/**
 * Имя пользователя
 */
$userLogin = Yii::$app->user->identity->login;

/**
 * Количество лайкнутых постов
 */
$likesCount = Post::find()->where(['action' => LIKE, 'user_id' => Yii::$app->user->identity->id])->count();

/**
 * Количество дизлайкнутых постов
 */
$dislikesCount = Post::find()->where(['action' => DISLIKE, 'user_id' => Yii::$app->user->identity->id])->count();

/**
 * Количество постов в избранном
 */
$favoriteCount = Post::find()->where(['favorite' => IN_FAVORITE, 'user_id' => Yii::$app->user->identity->id])->count();
?>

<p>Пс-с-с, пользователь с логином <?= $userLogin; ?>, а ты знаешь, что у тебя
    <a href='/profile/likes' class='link'> лайкнутых</a> постов <?= $likesCount; ?>,
    <a href='/profile/dislikes' class='link'> дизлайкнутых</a> <?= $dislikesCount; ?>
    и постов <a href='/profile/favorites' class='link'>в избранном</a> <?= $favoriteCount; ?> ? </p>