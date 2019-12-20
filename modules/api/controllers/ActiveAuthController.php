<?php

namespace app\modules\api\controllers;

use app\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\RateLimiter;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;

/**
 * Class ActiveAuthController.
 * Контроллер для авторизованных запросов.
 */
class ActiveAuthController extends ActiveController
{
	public function behaviors()
	{
		return [
			'contentNegotiator' => [
				'class' => ContentNegotiator::className(),
				'formats' => [
					'application/json' => Response::FORMAT_JSON,
					'application/xml' => Response::FORMAT_XML,
				],

			],
			'verbFilter' => [
				'class' => VerbFilter::className(),
				'actions' => $this->verbs(),

			],
			'rateLimiter' => [
				'class' => RateLimiter::className(),
			],
			'cors' => [
				'class' => Cors::class
			],
			'bearerAuth' => [
				'class' => HttpBearerAuth::className(),
			],
		];
	}
}