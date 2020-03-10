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
");

$this->registerJs("
$('.show_img').click(function(){
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
      url: '?r=dashboard/like-dislike',
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
",
View::POS_READY
);

Modal::begin([
  'header' => false,
  'footer' => 
              Html::button('Нравится', ['class' => 'like_button', 'id' => 'like_button', 'data-action' => 1, 'style' => 'outline: none; width: calc(50% - 10px); margin-right: 10px; height: 100%; font-size: medium;']) . 
              Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button', 'data-action' => 0, 'style' => 'outline: none; width: 50%; height: 100%; font-size: medium;']),
  'options' => [
    'id' => 'pic-modal'
  ],
  'size' => Modal::SIZE_DEFAULT
]);
echo 'test';
Modal::end();

echo "<p class='text_center'><a href='?r=profile/likes' class='link'>Лайкнутые посты (" . Post::find()->where(['action' => 1, 'user_id' => Yii::$app->user->identity->id])->count() . ")</a> | <a href='?r=profile/dislikes' class='link'> Дизлайкнутые посты (" . Post::find()->where(['action' => 0, 'user_id' => Yii::$app->user->identity->id])->count() . ")</a> | <a href='?r=profile/favorites' class='link you_here'>Посты в избранном (" . Post::find()->where(['favorite' => 1, 'user_id' => Yii::$app->user->identity->id])->count() . ")</a></p>";

foreach ($models as $model) {
  echo "<img src='".(Html::encode($model->img) ?? 'https://www.bafe.org.uk/imgs/icons/x-mark-256x256-red.png')."' data-id='$model->post_id' data-favorite='".($model->favorite ?? 0)."' data-action='$model->action' class='show_img'>";
}

echo "<br>" . LinkPager::widget([
  'pagination' => $pages,
  'id' => 'pagination'
]);

?>