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

$this->registerCss("
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

  .favorite{
    border: 2px solid gold;
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
");

$this->registerJs("
$('.show_img').click(function(){
  if($(this).data('favorite')){
    $('#favorite_button').text('В избранном').addClass('marked');
  }else{
    $('#favorite_button').text('В избранное').removeClass('marked');
    $('#dislike_button').removeClass('marked');
  }

  $('#pic-modal .modal-body').html('<img id=\'modal-img\' src=\''+$(this).attr('src')+ '\' data-id='+$(this).data('id')+'>');
  $('#pic-modal .modal-dialog').width($('#pic-modal .modal-body img')[0].width + 33);
  $('#pic-modal').modal('show');
});

$('#dislike_button').click(function(data){
  $.ajax({
    url: '?r=dashboard/like-dislike',
    type: 'POST',
    data: {
      num: $('#modal-img').attr('data-id'),
      img: $('#modal-img').attr('src'),
      action: 0
    },
    success: function(e) {
      $('#dislike_button').addClass('marked');
      $('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').remove()
    },
    error: function(e) {
      console.log('[Кнопки лайка/дизлайка] Что-то пошло не так...');
      console.error(e);
    }
  });
  });

  $('#favorite_button').click(function(){
    $.ajax({
      url: '?r=dashboard/add-to-favorite',
      type: 'POST',
      data: {
        num: $('#modal-img').attr('data-id'),
      },
      success: function(){
        if($('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').data('favorite') == 1)
          $('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').data('favorite', 0);
        else
        $('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').data('favorite', 1);

        if(!$('#favorite_button').hasClass('marked')){
          $('#favorite_button').text('В избранном').addClass('marked');
          $('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').addClass('favorite');
        }else{
          $('#favorite_button').text('В избранное').removeClass('marked');
          $('[class*=show_img][data-id=\"'+$('#modal-img').attr('data-id')+'\"]').removeClass('favorite');
        }
      },
      error: function(e){
        console.log('[Кнопка добавления в избранное] Что-то пошло не так...');
        console.error(e);
      }
    });
  });
",
View::POS_READY
);

Modal::begin([
  'header' => false,
  'footer' => 
              Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button', 'data-action' => 0, 'style' => 'outline: none; width: 50%; height: 100%; font-size: medium;']) . 
              Html::button('В избранное', ['class' => 'favorite_button', 'id' => 'favorite_button', 'data-action' => 0, 'style' => 'outline: none; width: calc(50% - 10px); margin-left: 10px; height: 100%; font-size: medium;']),
  'options' => [
    'id' => 'pic-modal'
  ],
  'size' => Modal::SIZE_DEFAULT
]);
echo 'test';
Modal::end();

echo "<p class='text_center'><a href='?r=profile/likes' class='link'>Лайкнутые посты</a> | <a href='?r=profile/dislikes' class='link you_here'> Дизлайкнутые посты</a> | <a href='?r=profile/favorites' class='link'>Посты в избранном</a></p>";

foreach ($models as $model) {
  echo "<img src='".(Html::encode($model->img) ?? 'https://www.bafe.org.uk/imgs/icons/x-mark-256x256-red.png')."' data-id='$model->post_id' data-favorite='".($model->favorite ?? 0)."' class='show_img ".($model->favorite ?'favorite' : '')."'>";
}

echo "<br>" . LinkPager::widget([
  'pagination' => $pages,
  'id' => 'pagination'
]);

?>