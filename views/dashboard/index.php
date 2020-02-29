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
  #like_button{
    border: 2px solid dodgerblue;
    border-radius: 10px;
    background: white;
    color: dodgerblue;
  }
  #like_button:hover{
    background: powderblue;
    transition: 0.8s;
  }
  #dislike_button{
    border: 2px solid brown;
    border-radius: 10px;
    background: white;
    color: brown;
  }
  #dislike_button:hover{
    background: sandybrown;
    transition: 0.8s;
  }
");

/**
 * Регистрирует код JS
 * Если пользователь залогинен, будет подключен скрипт для отправки действия лайка/дизлайка
 * В ином случае будет подключен скрипт для выдачи ошибки
 */
$this->registerJs(
  !Yii::$app->user->isGuest ?
  "
  let interval = setInterval(function(){
    if($('#img_id').prop('complete'))
    {
      $('#loader').css('display', 'none');
      clearInterval(interval);
    }
  });

  $('#like_button, #dislike_button').click(function(data){
    $('#loader').css('display', 'table');
    $.ajax({
      url: '?r=dashboard/like-dislike',
      type: 'POST',
      data: {
        num: $('#img_id').attr('data-num'),
        img: $('#img_id').attr('src'),
        action: data.target.dataset.action
      },
      success: function(e) {
        e = JSON.parse(e);
        $('#img_id').attr('src', e['img']);
        $('#img_id').attr('alt', e['safe_title']);
        $('#img_id').attr('data-num', e['num']);
        $('#title').text(e['safe_title']);
        let interval = setInterval(function(){
          if($('#img_id').prop('complete')){
            $('#loader').css('display', 'none');
            clearInterval(interval);
          }
        }, 300);
        
        
      },
      error: function(e) {
        console.log('[Форма лайков/дизлайков] Что-то пошло не так...');
        console.error(e);
      }
    });
    });
    " : 
    "
    let interval = setInterval(function(){
      if($('#img_id').prop('complete'))
      {
        $('#loader').css('display', 'none');
        clearInterval(interval);
      }
    });

    $('#like_button, #dislike_button').click(function(){
    $('#need_auth').css('display', 'block');
    });",
  View::POS_READY
);

?>

<div style="position: relative;">
  <div id="loader" style="border-radius: 5px; width: 100%; height: calc(100% + 2px); position: absolute; background: antiquewhite; border: 10px solid; display: table;"><p style="display: table-cell; vertical-align: middle; text-align: center; font-size: large; font-weight: bolder;"> Пожалуйста, подождите :)</p></div>
  <h1 style="border-bottom: 2px solid white; margin-bottom: 20px;" id="title"><?= Html::encode($title);?></h1>
  <?= Html::img(Html::encode($img), ['alt' => Html::encode($title), 'id' => 'img_id', 'data-num' => $num]); ?>
  <div style="display: block; margin-left: auto; margin-right: auto; max-width: 350px; height: 45px; padding-top: 15px;">
  <?= Html::button('Нравится', ['class' => 'like_button', 'id' => 'like_button', 'data-action' => 1, 'style' => 'outline: none; width: 49%; height: 100%; font-size: medium;']); ?>
  <?= Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button', 'data-action' => 0, 'style' => 'outline: none; width: 49%; height: 100%; font-size: medium;']); ?>
  <p id="need_auth" style="color: red; text-align: center; margin-top: 10px; border: 1px solid red; padding: 10px; display: none;">Для оценки картинок необходимо авторизоваться!</p>
  </div>
</div>