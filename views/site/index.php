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
<img src=<?= Html::encode($img); ?>>