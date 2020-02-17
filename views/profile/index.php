<?php

/**
 * Данное вью в разработке
 * В будущем будет отображать лайкнутые/дизлайкнутые посты и
 * будет позволять совершать над ними различные действия
 */

use app\models\db\Like;
use Yii;

$user_id = Yii::$app->user->identity->id;
$likes = Like::find()
             ->where("user_id = $user_id AND action = 1")
             ->all();

$posts = '';
foreach($likes as $like)
{
  echo "<img src='".(Yii::$app->picker->pick($like->post_id))['img']."' style='height: 100px; border: 1px black solid; margin: 10px;'>";
}


?>