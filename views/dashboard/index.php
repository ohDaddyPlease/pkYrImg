<?php

use yii\helpers\Html;
use yii\web\View;

$this->registerCss("
  body {background: black;}
  h1 {color: white; text-align: center;}
  img {
    display: block;
    margin-left: auto;
    margin-right: auto;
    }
");

/**
 * Регистрирует код JS
 * Если пользователь залогинен, будет подключен скрипт для отправки действия лайка/дизлайка
 * В ином случае будет подключен скрипт для выдачи ошибки
 */
$this->registerJs(
  !Yii::$app->user->isGuest ?
  "$('#like_button, #dislike_button').click(function(data){
    $.ajax({
      url: '?r=dashboard/like-dislike',
      type: 'POST',
      data: {
        num: $num,
        img: '$img',
        action: data.target.dataset.action
      },
      success: function() {
        location.reload();
      },
      error: function(jqXHR, errMsg) {
        alert(errMsg);
      }
    });
    });
    " : 
    "$('#like_button, #dislike_button').click(function(){
    $('#need_auth').css('display', 'block');
    });",
  View::POS_READY
);

?>

<div>
  <h1><?= Html::encode($title);?></h1>
  <?= Html::img(Html::encode($img), ['alt' => Html::encode($title)]); ?>
  <div style="display: block; margin-left: auto; margin-right: auto; max-width: 260px; padding-top: 15px;">
  <?= Html::button('Нравится', ['class' => 'like_button', 'id' => 'like_button', 'data-action' => 1, 'style' => 'width: 49%;']); ?>
  <?= Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button', 'data-action' => 0, 'style' => 'width: 49%;']); ?>
  <p id="need_auth" style="color: red; text-align: center; margin-top: 10px; border: 1px solid red; padding: 10px; display: none;">Для оценки картинок необходимо авторизоваться!</p>
  </div>
</div>