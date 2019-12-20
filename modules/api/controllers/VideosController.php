<?php


namespace app\modules\api\controllers;


use Yii;
use yii\filters\AccessControl;

class VideosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['bearerAuth']['except'] = ['index', 'view'];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'index'],
                    'allow' => true,
                    'roles' => ['@', '?'], //только авторизованные пользователи
                ],
            ],
        ];
        return $behaviors;
    }
}