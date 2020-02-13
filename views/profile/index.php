<?php
 use yii\helpers\Html;
 use app\models\db\Like;
$user_id = Yii::$app->user->identity->id;
$likes =   Like::find()
                 ->where("user_id = $user_id")
                 ->all();

$posts = '';
foreach($likes as $like)
{
  $posts .= ' ' . $like->post_id;
}
?>

<p>Вы лайкнули следующие посты: </p>
<p><?= $posts ?></p>