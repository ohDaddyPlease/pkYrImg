<?php
namespace app\controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actionAccessDenied()
    {
        return $this->render('access-denied');
    }
}