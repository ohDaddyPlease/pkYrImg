<?php

/**
 * Данный лэйаут позволяет регистрироваться/входить/выходить на любых страницах
 * за счет настроенной системы авторизации в данном вью
 * Формы входа и регистрации расположены в модальных окнах,
 * при ошибках будут выдаваться соответствующие сообщения
 */

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

/**
 * Регистрирует JS скрипт
 * Сбрасывает стандартное действие кнопки типа Submit
 * При нажатии на кнопку "Войти" отправляет POST-запрос с сериализованными данными
 * Если вернулись данные типа True, перезагружает страницу,
 * в ином случае выдаёт ошибку входа
 * Note: работает без перезагрузки страницы
 */
$this->registerJs("
    $('#login-form').submit(function(e){
      e.preventDefault();

      $.ajax({
        url: '?r=authorization/login',
        method: 'POST',
        data: $('#login-form').serialize(),
        success: function(data){
          if(data){
          window.location.reload();
          }else{
            $($('#login-form .help-block')[0]).text('Возможно, неправильный логин!');
            $($('#login-form .help-block')[1]).text('Возможно, неправильный пароль!');
        
            if(!$($('#login-form .help-block')[0]).parent().hasClass('has-error') || !$($('#login-form .help-block')[1]).parent().hasClass('has-error'))
            {
              $($('#login-form .help-block')[0]).parent().addClass('has-error');
              $($('#login-form .help-block')[1]).parent().addClass('has-error');
            }
          }
        },
        error: function(){
          console.log('[Форма авторизации] Что-то пошло не так...')
        }
      });
    });

    $('#register-form').submit(function(e){
      e.preventDefault();

      $.ajax({
        url: '?r=authorization/registration',
        method: 'POST',
        data: $('#register-form').serialize(),
        success: function(data){
          if(data){
          window.location.reload();
          }else{
            $($('#register-form .help-block')[0]).text('Такой пользователь существует!');
            $($('#register-form .help-block')[1]).text('');
        
            if(!$($('#register-form .help-block')[0]).parent().hasClass('has-error') || !$($('#register-form .help-block')[1]).parent().hasClass('has-error'))
            {
              $($('#register-form .help-block')[0]).parent().addClass('has-error');
              $($('#register-form .help-block')[1]).parent().addClass('has-error');
            }
          }
        },
        error: function(){
          console.log('[Форма регистрации] Что-то пошло не так...')
        }
      });
    });
",
  View::POS_READY,
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

  /**
   * Работа с формой входа
   * Если в параметрах GET есть login=failed, будет произведена валидация для выдачи ошибки
   * (знаю, что корявый велосипед)
   */
  $loginFormModel = new LoginForm;
  if(Yii::$app->request->get('login') == 'failed') {
    $loginFormModel->validate('loginFailed');
  }

  Modal::begin([
    'header' => 'Вход в учётную запись',
    'options' => ['id' => 'login'],
  ]);
    $loginForm = ActiveForm::begin([
      'id' => 'login-form'
    ]);
    echo $loginForm->field($loginFormModel, 'login')->label('Имя пользователя (логин)');
    echo $loginForm->field($loginFormModel, 'password')->input('password')->label('Пароль');
    echo Html::submitButton('Войти');
    ActiveForm::end();
  Modal::end();

  /**
   * Работа с формой регистрации
   * Передает заполненные поля по роуту authorization/registration
   */
  $registerFormModel = new RegisterForm;
  Modal::begin([
    'header' => 'Регистрация учётной записи',
    'options' => ['id' => 'register'],
  ]);
    $registerForm = ActiveForm::begin([
      'id' => 'register-form'
    ]);
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
