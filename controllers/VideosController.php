<?php


namespace app\controllers;


use app\models\Video;
use yii\web\Controller;

class VideosController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $models = Video::find()->all();

        return $this->render('index',['models'=>$models]);
    }
}