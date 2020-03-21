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

/**
 * Не в избранном
 */
const NOT_IN_FAVORITE = 0;

$CSS = <<<CSS
  .show_img{
    height: 100px; 
    margin: 10px;
    border: 2px solid white;
  }

  .show_img:hover{
    cursor: pointer;
    border: 2px solid red;
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
  #favorite_button{
    border: 2px solid limegreen;
    border-radius: 10px;
    background: white;
    color: limegreen;
  }
  #favorite_button:hover{
    background: palegreen;
    transition: 0.8s;
  }

  .marked{
    font-weight: bold !important;
    color: black !important;
  }

  .text_center{
    width: 100%; 
    text-align: center;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .link{
    border: 1px solid;
    border-radius: 10px;
    padding: 3px;
    text-decoration: none !important;
  }

  .you_here{
    font-weight: bold;
  }

  #like_count, #dislike_count, #favorite_count{
    display: inline-block;
  }

  #like_button{
  outline: none; 
  width: calc(33% - 10px); 
  margin-right: 10px; 
  height: 100%; 
  font-size: medium;
  }

  #dislike_button{
  outline: none; 
  width: 33%; 
  height: 100%; 
  font-size: medium;
  }

  #favorite_button{
  outline: none; 
  width: calc(33% - 10px); 
  margin-left: 10px; 
  height: 100%; 
  font-size: medium;
  }
CSS;
$this->registerCss($CSS);

$JS = <<<JS
$('.show_img').click(function(){
  $('#favorite_button').text('В избранном').addClass('marked');
  if($(this).data('action') === 1){
    $('#dislike_button').removeClass('marked');
    $('#like_button').addClass('marked');
  }else if ($(this).data('action') === 0){
    $('#dislike_button').addClass('marked');
    $('#like_button').removeClass('marked');
  } else {
    $('#dislike_button').removeClass('marked');
    $('#like_button').removeClass('marked');
  }


  $('#pic-modal .modal-body').html('<img id=\'modal-img\' src=\''+$(this).attr('src')+ '\' data-id='+$(this).data('id')+'>');
  $('#pic-modal .modal-dialog').width($('#pic-modal .modal-body img')[0].width + 33).css('min-width', 425);
  $('#pic-modal').modal('show');
});

$('#dislike_button').click(function(data){
  $.ajax({
    url: '/dashboard/like-dislike',
    type: 'POST',
    data: {
      num: $('#modal-img').attr('data-id'),
      img: $('#modal-img').attr('src'),
      action: 0
    },
    success: function(e) {
      $('#dislike_button').addClass('marked');
      $('#like_button').removeClass('marked');
    },
    error: function(e) {
      console.log('[Кнопки лайка/дизлайка] Что-то пошло не так...');
      console.error(e);
    }
  });
  });

  $('#like_button').click(function(data){
    $.ajax({
      url: '/dashboard/like-dislike',
      type: 'POST',
      data: {
        num: $('#modal-img').attr('data-id'),
        img: $('#modal-img').attr('src'),
        action: 1
      },
      success: function(e) {
        $('#dislike_button').removeClass('marked');
        $('#like_button').addClass('marked');
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
          num: $('#modal-img').attr('data-id')
        },
        success: function(){
          $('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').remove();
          if($('#favorite_button').hasClass('marked')){
            $('#favorite_count').text(+$('#favorite_count').text() - 1);
            $('#favorite_button').text('В избранное').removeClass('marked');
          }
          else{
            $('#favorite_button').text('В избранном').addClass('marked');
            $('#favorite_count').text(+$('#favorite_count').text() + 1);
          }
        },
        error: function(e){
          console.log('[Кнопка добавления в избранное] Что-то пошло не так...');
          console.error(e);
        }
      });
    });
JS;
$this->registerJs($JS,
View::POS_READY
);

Modal::begin([
  'header' => false,
  'footer' => 
      Html::button('Нравится', [
          'class'       => 'like_button',
          'id'          => 'like_button',
          'data-action' => LIKE
      ]) .
      Html::button('Не нравится', [
          'class'       => 'dislike_button',
          'id'          => 'dislike_button',
          'data-action' => DISLIKE
      ]) .
      Html::button('В избранном', [
          'class'       => 'favorite_button marked',
          'id'          => 'favorite_button',
          'data-action' => IN_FAVORITE
      ]),
  'options' => [
      'id'    => 'pic-modal',
      'style' => [
          'text-align' => 'center'
      ]
  ],
  'size'    => Modal::SIZE_DEFAULT
]);
Modal::end();

$likesCount = Post::find()->where([
    'action'  => LIKE,
    'user_id' => Yii::$app->user->identity->id
])->count();

$dislikesCount = Post::find()->where([
    'action'  => DISLIKE,
    'user_id' => Yii::$app->user->identity->id
])->count();

$favoriteCount = Post::find()->where([
    'favorite' => IN_FAVORITE,
    'user_id'  => Yii::$app->user->identity->id
])->count();

echo "<div class='text_center'>
  <a href='/profile/likes' class='link'>Лайкнутые посты (<div id='like_count'>$likesCount</div>)</a> 

| <a href='/profile/dislikes' class='link'> Дизлайкнутые посты (<div id='dislike_count'>$dislikesCount</div>)</a> 

| <a href='/profile/favorites' class='link you_here'>Посты в избранном (<div id='favorite_count'>$favoriteCount</div>)</a></div>";

foreach ($models as $model) {
    echo "<img src='".(Html::encode($model->img) ?? 'https://www.bafe.org.uk/imgs/icons/x-mark-256x256-red.png')."' 
               data-id='$model->post_id' 
               data-favorite='".($model->favorite ?? NOT_IN_FAVORITE)."' 
               data-action='$model->action' 
               class='show_img'>";
}

echo "<br>" . LinkPager::widget([
    'pagination' => $pages,
    'id'         => 'pagination'
]);

?>