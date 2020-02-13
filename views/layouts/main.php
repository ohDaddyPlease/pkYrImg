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
use yii\web\View;

AppAsset::register($this);

$this->registerJs(
  "
  let params = window.location.search.split('?&')
  if(params[(params.length) - 1] == 'login=failed')
  {
    $('#login').modal('show');
    $($('#login-form .help-block')[0]).text('Возможно, неправильный пароль!');
    $($('#login-form .help-block')[1]).text('Возможно, неправильный логин!');

    if(!$($('#login-form .help-block')[0]).parent().hasClass('has-error') || !$($('#login-form .help-block')[1]).parent().hasClass('has-error'))
    {
      $($('#login-form .help-block')[0]).parent().addClass('has-error');
      $($('#login-form .help-block')[1]).parent().addClass('has-error');
    }
  }
    ",
  View::POS_LOAD,
  'loggin-script'
);

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

$postRequest = Yii::$app->request->post();

//Вход
  $loginFormModel = new LoginForm;
  if(Yii::$app->request->get('login') == 'failed') {
    $loginFormModel->validate('loginFailed');
  }

  Modal::begin([
    'header' => 'Вход в учётную запись',
    'options' => ['id' => 'login'],
  ]);
    $loginForm = ActiveForm::begin([
      'action' => '?r=authorization/login',
      'id' => 'login-form'
    ]);
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
    if(Yii::$app->user->isGuest)
      echo Nav::widget([
          'options' => ['class' => 'navbar-nav navbar-right'],
          'items' => [
              ['label' => 'Вход', 'url' => '#login', 'linkOptions' => ['data-toggle'=>'modal']],
              ['label' => 'Зарегистрироваться', 'url' => '#register', 'linkOptions' => ['data-toggle'=>'modal']]


          ],
      ]);
    else 
    echo Nav::widget([
      'options' => ['class' => 'navbar-nav navbar-right'],
      'items' => [
          ['label' => Yii::$app->user->identity->login, 'url' => '?r=profile'],
          ['label' => 'Выйти', 'url' => '?r=authorization/logout']


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
