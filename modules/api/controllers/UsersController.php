<?php


namespace app\modules\api\controllers;

use app\models\User;
use Yii;
use app\models\LoginForm;
use yii\filters\AccessControl;

class UsersController extends BaseActiveController
{
    public $modelClass = 'app\models\User';

    public function verbs()
    {
        return [
            'login'=>['POST','OPTIONS'],
            'logout'=>['POST','OPTIONS']
        ];
    }

    /**
     * Ввод в аккаунт
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $request = Yii::$app->request->post();
        if ($model->load($request, '') && $model->login()) {
            return [
                'status' => 'success',
                'token' => $model->getUser()['accessToken'],
            ];
        }

        return ['status', 'reject'];
    }

    public function actionGet_username()
    {
        return ['username' => Yii::$app->user->identity->username];
    }

    /**
     * Выход
     */
    public function actionLogout()
    {
        if(Yii::$app->user->logout())
            return ['status' => 'success'];
        else
            return ['status' => 'reject'];
    }
}