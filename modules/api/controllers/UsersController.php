<?php


namespace app\modules\api\controllers;


use app\models\User;
use Yii;
use yii\filters\AccessControl;

class UsersController extends BaseActiveController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Вроде бы так правильней
        // Сначала настраиваем права доступа
        // Затем настраиваем права для аутнефикации ($behaviors['bearerAuth'] = $bearer)
        $bearer = $behaviors['bearerAuth'];
        unset($behaviors['bearerAuth']);
        $bearer['except'] = ['create'];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@', '?'], //любые пользователи
                ],
                [
                    'actions' => ['update', 'delete'],
                    'allow' => true,
                    'roles' => ['@'], //только авторизованные пользователи
                    'matchCallback' => function($rule, $action){
                        // Разрешаем обновление/удаление только если id совпадает с id пользователя
                        return Yii::$app->user->identity['id'] === Yii::$app->request->post()['id'];
                    }
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                    'matchCallback' => function($rule, $action){
                        //Доступ к методам index и view запрещен для всех
                        return false;
                    }
                ]
            ],
        ];

        $behaviors['bearerAuth'] = $bearer;

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $user = new User();
        if($user->load(Yii::$app->request->post(), ''))
        {
            if($user->save()){
                return [
                    'status' => 'success',
                    'token' => $user->accessToken
                ];
            }
            elseif(User::findOne(['username' => $user->username])) {
                return [
                    'status' => 'reject',
                    'error' => 'Пользователь с таким логином уже существует'
                ];
            }
            elseif(User::findOne(['email' => $user->email])) {
                return [
                    'status' => 'reject',
                    'error' => 'Данная электронная почта уже привязана к другому аккаунту'
                ];
            }
            else {
                return [
                    'status' => 'reject',
                    'error' => 'Неизвестная ошибка'
                ];
            }
        }

        return [
            'status' => 'reject',
            'error' => 'Неверная форма отправки данных'
        ];
    }
}