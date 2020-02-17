<?php

/**
 * Данное вью в разработке
 * В будущем будет отображать лайкнутые/дизлайкнутые посты и
 * будет позволять совершать над ними различные действия
 */

use app\models\db\Like;
use Yii;
use yii\bootstrap\Modal;
use yii\web\View;

$this->registerCss("
  .show_img{
    height: 100px; 
    border: 1px black solid; 
    margin: 10px;
  }

  .show_img:hover{
    cursor: pointer;
  border: 1px solid red;
  }
");

$this->registerJs("
$('.show_img').click(function(data){
  $('#pic-modal .modal-body').html('<img src='+data.target.src+'>');
  $('#pic-modal .modal-content').width($('#pic-modal .modal-body img')[0].width + 33);
  $('#pic-modal').modal('show');
});
 
",
View::POS_READY
);

Modal::begin([
  'header' => false,
  'footer' => false,
  'options' => [
    'id' => 'pic-modal'
  ],
  'size' => Modal::SIZE_DEFAULT
]);
echo 'test';
Modal::end();

$user_id = Yii::$app->user->identity->id;
$likes = Like::find()
             ->where("user_id = $user_id AND action = 1")
             ->all();

$posts = '';
foreach($likes as $like)
{
  echo "<img src='".(Yii::$app->picker->pick($like->post_id))['img']."' class='show_img'>";
}


?>