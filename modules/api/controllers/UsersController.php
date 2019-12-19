<?php


namespace app\modules\api\controllers;

use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

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
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        $request = Yii::$app->request->post();
        if ($model->load($request) && $model->login())
            return['status'=>'success'];


        else return $request;//return['status'=>'reject'];
    }

    /**
     *
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
    }

    public function actionGet_load_video()
    {
        Yii::$app->user->logout();

    }
}