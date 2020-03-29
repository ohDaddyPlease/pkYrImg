<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$uploadForm = ActiveForm::begin();
    echo $uploadForm->field($model, 'imageFile')->fileInput()->label('Выберите мемчик');
    echo Html::submitButton('Загрузить');
ActiveForm::end();
