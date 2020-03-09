<?php

/**
 * Данное вью в разработке
 * В будущем будет отображать лайкнутые/дизлайкнутые посты и
 * будет позволять совершать над ними различные действия
 */

use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use yii\web\View;
use yii\bootstrap\Html;
use app\models\db\Post;

$this->registerCss("
.link{
  border: 1px solid;
  border-radius: 10px;
  padding: 3px;
  text-decoration: none !important;
}
");

$this->registerJs("",
View::POS_READY
);
?>

Пс-с-с, пользователь с логином <?= Yii::$app->user->identity->login; ?>, а ты знаешь, что у тебя <a href='?r=profile/likes' class='link'> лайкнутых</a> постов <?= Post::find()->where(['action' => 1])->count(); ?>, <a href='?r=profile/dislikes' class='link'> дизлайкнутых</a> <?= Post::find()->where(['action' => 0])->count(); ?> и постов <a href='?r=profile/favorites' class='link'>в избранном</a> <?= Post::find()->where(['favorite' => 1])->count(); ?> ?