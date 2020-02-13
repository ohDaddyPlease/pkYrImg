<?php
namespace app\controllers;
use yii\web\Controller;
use Yii;
use app\models\db\Like;

class DashboardController extends Controller
{
    public function actionIndex()
    {
        $resp = Yii::$app->picker->pick();
        $img =  $resp['img'];
        $num = $resp['num'];
        $title = $resp['safe_title']??'Pick Your Image';

        return $this->render('index', ['img' => $img, 'title' => $title, 'num' => $num]);
    }

    public function actionTest()
    {
        $like = new Like;
        $like->user_id = Yii::$app->user->identity->id;
        $like->post_id = $_POST['num'];
        $like->action = $_POST['action'];
        $like->save();
    }
}