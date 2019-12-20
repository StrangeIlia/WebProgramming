<?php


namespace app\modules\api\controllers;

use app\models\User;
use Yii;
use app\models\LoginForm;
use yii\filters\AccessControl;

class Auth_usersController extends ActiveAuthController
{
    public $modelClass = 'app\models\User';

    public function actionGet_username()
    {
        return ['username' => Yii::$app->user->identity['username']];
    }


}