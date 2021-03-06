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
$JS = <<<JS
    $('#login-submit').click(function(e){
      e.preventDefault();
      $.ajax({
        url: '/login',
        method: 'POST',
        data: $('#login-form').serialize(),
        success: function(data){
          if(data){
              window.location.reload();
          }else{
            $($('#login-form .help-block')[0]).text('Возможно, неправильный логин!');
            $($('#login-form .help-block')[1]).text('Возможно, неправильный пароль!');
            if(!$($('#login-form .help-block')[0]).parent().hasClass('has-error') 
              || !$($('#login-form .help-block')[1]).parent().hasClass('has-error'))
            {
              $($('#login-form .help-block')[0]).parent().addClass('has-error');
              $($('#login-form .help-block')[1]).parent().addClass('has-error');
            }
          }
        },
        error: function(e){
          console.log('[Форма авторизации] Что-то пошло не так...');
          console.error(e);
        }
      });
    });

    $('#register-submit').click(function(e){
      e.preventDefault();
      $.ajax({
        url: '/registration',
        method: 'POST',
        data: $('#register-form').serialize(),
        success: function(data){
          if(data){
          window.location.reload();
          }else{
            $($('#register-form .help-block')[0]).text('Такой пользователь существует!');
            $($('#register-form .help-block')[1]).text('');
            if(!$($('#register-form .help-block')[0]).parent().hasClass('has-error') 
              || !$($('#register-form .help-block')[1]).parent().hasClass('has-error'))
            {
              $($('#register-form .help-block')[0]).parent().addClass('has-error');
              $($('#register-form .help-block')[1]).parent().addClass('has-error');
            }
          }
        },
        error: function(e){
          console.log('[Форма регистрации] Что-то пошло не так...');
          console.error(e);
        }
      });
    });
JS;

$this->registerJs(
    $JS,
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
<?php $this->beginBody(); ?>

<?php
    $postRequest = Yii::$app->request->post();

    /**
     * Работа с формой входа
     * Передает заполненные поля по роуту authorization/login
     */
    $loginFormModel = new LoginForm;
    Modal::begin([
        'header'  => 'Вход в учётную запись',
        'options' => [
            'id' => 'login'
        ],
    ]);
        $loginForm = ActiveForm::begin([
            'id' => 'login-form'
        ]);
            echo $loginForm->field($loginFormModel, 'login')
                           ->label('Имя пользователя (логин)');
            echo $loginForm->field($loginFormModel, 'password')
                           ->input('password')
                           ->label('Пароль');
            echo Html::submitButton('Войти', [
                'id'=>'login-submit'
            ]);
        ActiveForm::end();
    Modal::end();

    /**
     * Работа с формой регистрации
     * Передает заполненные поля по роуту authorization/registration
     */
    $registerFormModel = new RegisterForm;
    Modal::begin([
        'header'  => 'Регистрация учётной записи',
        'options' => [
            'id' => 'register'
        ],
    ]);
        $registerForm = ActiveForm::begin([
            'id' => 'register-form'
        ]);
            echo $registerForm->field($registerFormModel, 'login')
                              ->label('Имя пользователя (логин)');
            echo $registerForm->field($registerFormModel, 'password')
                              ->input('password')
                              ->label('Пароль');
            echo Html::submitButton('Зарегистрироваться', [
                'id'=>'register-submit'
            ]);
        ActiveForm::end();
    Modal::end();
?>

<div class="wrap">
<?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl'   => Yii::$app->homeUrl,
        'options'    => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        echo Nav::widget([
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ],
            'items'   => [
                [
                    'label'       => 'Вход',
                    'url'         => '#login',
                    'linkOptions' => [
                        'data-toggle'=>'modal'
                    ]
                ],
                [
                    'label'       => 'Зарегистрироваться',
                    'url'         => '#register',
                    'linkOptions' => [
                        'data-toggle'=>'modal'
                    ]
                ]
            ],
        ]);
    } else {
        echo Nav::widget([
            'options' => [
                'class' => 'navbar-nav navbar-right'
            ],
            'items'   => [
                [
                    'label' => 'Загрузить мемчик',
                    'url'   => '/upload'
                ],
                [
                    'label' => Yii::$app->user->identity->login,
                    'url'   => '/profile'
                ],
                [
                    'label' => 'Выйти',
                    'url'   => '/logout'
                ]
            ],
        ]);
    }
    NavBar::end();
?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]);
        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
