<?php


namespace app\modules\api\controllers;


use yii\filters\AccessControl;

class VideosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        //$bearer = $behaviors['bearerAuth'];
        //unset($behaviors['bearerAuth']);
        //$bearer['except'] = ['index', 'view'];
        $behaviors['bearerAuth']['except'] = ['index', 'view'];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['@', '?'], //только авторизованные пользователи
                ]
            ],
        ];
        //$behaviors['bearerAuth'] = $bearer;

        return $behaviors;
    }
}