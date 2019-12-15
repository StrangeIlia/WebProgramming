<?php

namespace app\modules\api\controllers;

use yii\web\Response;

class BaseActiveController extends \yii\rest\ActiveController
{
    public  function  behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
                'verbFilter' => [
                    'class' => \yii\filters\VerbFilter::className(),
                    'actions' => $this->verbs(),
                ],
                'rateLimiter' => [
                    'class' => \yii\filters\RateLimiter::className(),
                ],
                'cors' => [
                    'class' => \yii\filters\Cors::className(),
                ]
            ]
        ];
    }
}