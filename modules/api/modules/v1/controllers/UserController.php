<?php
namespace app\modules\api\modules\v1\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'app\modules\api\modules\v1\models\User';
}