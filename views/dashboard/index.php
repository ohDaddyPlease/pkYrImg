<?php

use yii\helpers\Html;
use yii\web\View;
$user_identity = Yii::$app->user->identity ? Yii::$app->user->identity->login : null;

$this->registerCss("
    body {background: black;}
    h1 {color: white; text-align: center;}
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
");

$this->registerJs(
$user_identity ?
"$('#like_button, #dislike_button').click(function(data){
    $.ajax({
        url: '?r=dashboard/test',
        type: 'POST',
        data: {
          num: $num,
          action: data.target.dataset.action
        },
        error: function(jqXHR, errMsg) {
            alert(errMsg);
        }
     });
  });
  " : 
  "$('#like_button, #dislike_button').click(function(){
     $('#need_auth').css('display', 'block');
  });
  ",
  View::POS_READY
);

?>
<div>
  <h1><?= Html::encode($title);?></h1>
  <?= Html::img(Html::encode($img), ['alt' => Html::encode($title)]); ?>
  <div style="display: block; margin-left: auto; margin-right: auto; max-width: 260px; padding-top: 15px;">
    <?= Html::button('<<', ['id' => 'prev', 'style' => 'display: inline-block; padding-right: 10px; color: black; cursor: pointer; font-weight: bold;']); ?>
    <?= Html::button('Нравится', ['class' => 'like_button', 'id' => 'like_button', 'data-action' => 1]); ?>
    <?= Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button', 'data-action' => 0]); ?>
    <?= Html::button('>>', ['id' => 'next', 'style' => 'display: inline-block;  padding-left: 10px; color: black; cursor: pointer; font-weight: bold;']); ?>
    <p id="need_auth" style="color: red; text-align: center; margin-top: 10px; border: 1px solid red; padding: 10px; display: none;">Для оценки картинок необходимо авторизоваться!</p>
  </div>
</div>