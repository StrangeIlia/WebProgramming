<?php

namespace app\modules\api;

use yii\base\Module;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;

class ApiModule extends Module
{
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'controllers' => ['api/site', 'api/videos'],
                    ],
                ]
            ]
        ];
    }*/
}