<?php


namespace app\controllers;


use app\models\News;
use yii\web\Controller;

class VideoController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $models = News::find()
            ->orderBy(['createdAt'=> SORT_DESC])
            ->all();

        return $this->render('index',['models'=>$models]);
    }
}