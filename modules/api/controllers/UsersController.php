<?php


namespace app\modules\api\controllers;


use Yii;
use yii\filters\AccessControl;

class UsersController extends BaseActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }
}