<?php


namespace app\modules\api\controllers;


use Yii;
use app\models\LoginForm;

class Base_userController extends BaseActiveController
{
    public $modelClass = 'app\models\User';
}