<?php


namespace app\modules\api\controllers;

use Yii;
use app\models\User;

class UsersController extends BaseActiveController
{
    public $modelClass = 'app\models\User';

    public  function verbs()
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
        $request = Yii::$app->request->post();
        $user = User::getUser($request);
        if($user === null)
            return ['status'=>'reject'];
        else {
            $user->createToken();
            return [
                'status' => 'success',
                'authKey' => $user['authKey'],
                'accessToken' => $user['accessToken'],
            ];
        }
    }

    /**
     * Выход
     */
    public function actionLogout()
    {
        $request = Yii::$app->request->post();
        $user = User::getUser($request);
        if($user !== null)
            $user->removeToken();
    }
}