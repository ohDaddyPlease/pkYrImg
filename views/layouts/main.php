<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Modal;
use app\models\forms\LoginForm;
use yii\widgets\ActiveForm;
use app\models\forms\RegisterForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody();

$request = Yii::$app->request->post();

//Вход
  $loginFormModel = new LoginForm;
  Modal::begin([
    'header' => 'Вход в учётную запись',
    'options' => ['id' => 'login'],
  ]);
    $loginForm = ActiveForm::begin();
    $loginForm->action = '?r=authorization/login';
    echo $loginForm->field($loginFormModel, 'login')->label('Имя пользователя (логин)');
    echo $loginForm->field($loginFormModel, 'password')->input('password')->label('Пароль');
    echo Html::submitButton('Войти');
    ActiveForm::end();
  Modal::end();

  //Регистрация
  $registerFormModel = new RegisterForm;
  Modal::begin([
    'header' => 'Регистрация учётной записи',
    'options' => ['id' => 'register'],
  ]);
    $registerForm = ActiveForm::begin();
    $registerForm->action = '?r=authorization/registration';
    echo $registerForm->field($registerFormModel, 'login')->label('Имя пользователя (логин)');
    echo $registerForm->field($registerFormModel, 'password')->input('password')->label('Пароль');
    echo Html::submitButton('Зарегистрироваться');
    ActiveForm::end();
  Modal::end();


?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Войти', 'url' => '#login', 'linkOptions' => ['data-toggle'=>'modal']],
            ['label' => 'Зарегистрироваться', 'url' => '#register', 'linkOptions' => ['data-toggle'=>'modal']]


        ],
    ]);
    NavBar::end();
    
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
