<?php


namespace app\modules\api\controllers;

use Yii;
use app\models\LoginForm;
use yii\filters\AccessControl;

class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $bearer = $behaviors['bearerAuth'];
        unset($behaviors['bearerAuth']);
        $bearer['except'] = ['login'];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['logout', 'get_username'],
                    'allow' => true,
                    'roles' => ['@'], //только авторизованные пользователи
                ],
                [
                    'actions' => ['login'],
                    'allow' => true,
                    'roles' => ['?'], // любые пользователи
                ]
            ],
        ];
        $behaviors['bearerAuth'] = $bearer;

        return $behaviors;
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

    /**
     * Получить логин пользователя
     * @return array
     */
    public function actionGet_username()
    {
        return ['username' => Yii::$app->user->identity['username']];
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