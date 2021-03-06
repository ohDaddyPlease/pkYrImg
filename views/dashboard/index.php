<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * Регистрирует CSS-код
 */
$CSS = <<<CSS
    body {
      background: black;
    }

    h1 {
      color: white; 
      text-align: center;
    }

    img {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    
    #wrapper {
      position: relative;
    }

    #like_button {
      border: 2px solid dodgerblue;
      border-radius: 10px;
      background: white;
      color: dodgerblue;
    }

    #like_button:hover {
      background: powderblue;
      transition: 0.8s;
    }

    #dislike_button {
      border: 2px solid brown;
      border-radius: 10px;
      background: white;
      color: brown;
    }

    #dislike_button:hover {
      background: sandybrown;
      transition: 0.8s;
    }

    #favorite_button {
      border: 2px solid limegreen;
      border-radius: 10px;
      background: white;
      color: limegreen;
    }

    #favorite_button:hover {
      background: palegreen;
      transition: 0.8s;
    }

    .marked {
      font-weight: bold !important;
      color: black !important;
    }

    .auth_btn {
      border: 1px solid;
      border-radius: 10px;
      padding: 3px;
      text-decoration: none !important;
    }
    
    #loader {
      border-radius: 5px;
      width: 100%;
      height: calc(100% + 2px);
      position: absolute;
      background: antiquewhite;
      border: 10px solid;
      display: table;
    }
    
    #loader > p {
      display: table-cell;
      vertical-align: middle;
      text-align: center;
      font-size: large;
      font-weight: bolder;
    }
    
    #title {
      border-bottom: 2px solid white;
      margin-bottom: 20px;
    }
    
    #controls {
      display: block;
      margin-left: auto;
      margin-right: auto;
      max-width: 400px;
      height: 45px;
      padding-top: 15px;
    }
    
    #need_auth {
      color: red;
      text-align: center;
      margin-top: 10px;
      border-bottom: 1px solid red;
      border-top: 1px solid red;
      padding: 10px;
      display: none; 
    }
    
    #like_button,
    #dislike_button,
    #favorite_button {
      outline: none;
      width: 32%;
      height: 100%;
      font-size: medium;
    }
    
CSS;

$this->registerCss($CSS);

/**
 * Регистрирует код JS
 * Если пользователь залогинен, будет подключен скрипт для отправки действия лайка/дизлайка
 * В ином случае будет подключен скрипт для выдачи ошибки
 */

if (!Yii::$app->user->isGuest) {
    $JS = <<<JS
        let interval = setInterval(function(){
        if($('#img_id').prop('complete'))
        {
          $('#loader').css('display', 'none');
          clearInterval(interval);
        }
        });
        
        $('#like_button, ' +
        '#dislike_button').click(function(data){
        $('#loader').css('display', 'table');
        $.ajax({
          url: '/dashboard/like-dislike',
          type: 'POST',
          data: {
            num: $('#img_id').attr('data-num'),
            img: $('#img_id').attr('src'),
            action: data.target.dataset.action
          },
          success: function(e) {
            $('#favorite_button').text('В избранное').removeClass('marked');
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
            console.log('[Кнопки лайка/дизлайка] Что-то пошло не так...');
            console.error(e);
          }
        });
        });
        
        $('#favorite_button').click(function(){
          $.ajax({
            url: '/dashboard/add-to-favorite',
            type: 'POST',
            data: {
              num: $('#img_id').attr('data-num'),
              img: $('#img_id').attr('src'),
            },
            success: function(){
              if(!$('#favorite_button').hasClass('marked')){
                $('#favorite_button').text('В избранном').addClass('marked');
              }else{
                $('#favorite_button').text('В избранное').removeClass('marked');
              }
            },
            error: function(e){
              console.log('[Кнопка добавления в избранное] Что-то пошло не так...');
              console.error(e);
            }
          });
        });
JS;
} else {
    $JS = <<<JS
        let interval = setInterval(function(){
          if($('#img_id').prop('complete'))
          {
            $('#loader').css('display', 'none');
            clearInterval(interval);
          }
        });
    
        $('#like_button, ' +
          '#dislike_button, ' +
          '#favorite_button').click(function(){
        $('#need_auth').css('display', 'block');
        });
JS;
}

$this->registerJs(
    $JS,
    View::POS_READY
);

?>

<div id="wrapper">
  <div id="loader"><p> Пожалуйста, подождите :)</p></div>
  <h1 id="title"><?= Html::encode($title);?></h1>
  <?= Html::img(Html::encode($img), [
          'alt'      => Html::encode($title),
          'id'       => 'img_id',
          'data-num' => $num
      ]);
  ?>

  <div id="controls">
    <?= Html::button('Нравится', [
            'class'       => 'like_button',
            'id'          => 'like_button',
            'data-action' => 1
        ]);
    ?>
    <?= Html::button('Не нравится', [
            'class'       => 'dislike_button',
            'id'          => 'dislike_button',
            'data-action' => 0
        ]);
    ?>
    <?= Html::button('В избранное', [
            'class'       => 'favorite_button',
            'id'          => 'favorite_button',
            'data-action' => 0
        ]);
    ?>
    <p id="need_auth">Вы не авторизованы!<br><a  class='auth_btn' href='#login' data-toggle='modal'>Войдите</a> в аккаунт или <a class='auth_btn' href='#register' data-toggle='modal'>зарегистрируйте</a> новый.</p>
  </div>
</div>