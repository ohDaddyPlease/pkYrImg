<?php

/**
 * Данное вью в разработке
 * В будущем будет отображать лайкнутые/дизлайкнутые посты и
 * будет позволять совершать над ними различные действия
 */

use app\models\db\Like;

$user_id = Yii::$app->user->identity->id;
$likes = Like::find()
             ->where("user_id = $user_id AND action = 1")
             ->all();

$posts = '';
foreach($likes as $like)
{
  $posts .= ' ' . $like->post_id;
}
?>

<p>Вы лайкнули следующие посты: </p>
<p><?= $posts ?></p>