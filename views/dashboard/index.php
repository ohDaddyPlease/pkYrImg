<?php

use yii\helpers\Html;
$this->title = $title;

$this->registerCss("
    body {background: black;}
    h1 {color: white; text-align: center;}
    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
");
?>

<div>
  <h1><?= Html::encode($title);?></h1>
  <?= Html::img(Html::encode($img), ['alt' => Html::encode($title)]); ?>
  <div style="display: block; margin-left: auto; margin-right: auto; max-width: 260px; padding-top: 15px;">
    <?= Html::button('<<', ['id' => 'prev', 'style' => 'display: inline-block; padding-right: 10px; color: black; cursor: pointer; font-weight: bold;']); ?>
    <?= Html::button('Нравится', ['class' => 'like_button', 'id' => 'like_button']); ?>
    <?= Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button']); ?>
    <?= Html::button('>>', ['id' => 'next', 'style' => 'display: inline-block;  padding-left: 10px; color: black; cursor: pointer; font-weight: bold;']); ?>
  </div>
</div>