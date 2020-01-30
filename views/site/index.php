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

<h1><?= Html::encode($title);?></h1>
<?= Html::img(Html::encode($img), ['alt' => Html::encode($title)]); ?>
<?= Html::button('Нравится', ['class' => 'like_button', 'id' => 'like_button']); ?>
<?= Html::button('Не нравится', ['class' => 'dislike_button', 'id' => 'dislike_button']); ?>
