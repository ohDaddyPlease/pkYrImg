<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;

class DashboardController extends Controller
{
    public function actionIndex()
    {
        $resp = Yii::$app->picker->pick();
        $img =  $resp['img'];
        $title = $resp['safe_title']??'Pick Your Image';

        return $this->render('index', ['img' => $img, 'title' => $title]);
    }
}