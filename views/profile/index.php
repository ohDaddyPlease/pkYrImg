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
    border: 1px black solid; 
    margin: 10px;
  }

  .show_img:hover{
    cursor: pointer;
  border: 1px solid red;
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
");

$this->registerJs("
$('.show_img').click(function(data){
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
        $('#favorite_button').text('В избранном').addClass('marked');
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

foreach ($models as $model) {
  echo "<img src='".($model->img ?? 'https://www.bafe.org.uk/imgs/icons/x-mark-256x256-red.png')."' data-id='$model->post_id' class='show_img'>";
}

echo "<br>" . LinkPager::widget([
  'pagination' => $pages,
  'id' => 'pagination'
]);

?>