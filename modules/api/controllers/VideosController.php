<?php


namespace app\modules\api\controllers;


use PHPUnit\Util\Log\JSON;
use Yii;
use app\models\Video;
use yii\filters\AccessControl;


class VideosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['bearerAuth']['except'] = ['index', 'view'];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'view'],
                    'allow' => true,
                    'roles' => ['@', '?'],
                ],
                [
                    'actions' => ['create'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
                [
                    'actions' => ['update', 'delete'],
                    'allow' => true,
                    'roles' => ['@'], //только авторизованные пользователи
                    'matchCallback' => function($rule, $action){
                        //Разрешить модификацию только авторам видео
                        $selectedVideo = Video::findOne(['id' => Yii::$app->request->get('id')]);
                        return $selectedVideo['author'] === Yii::$app->user->identity['id'];
                    }
                ]
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
    }

    public function actionCreate()
    {
        if(!isset($_FILES['video']) || !isset($_FILES['preview']))
            return ['status' => 'reject'];

        $video = new Video();
        $request = Yii::$app->request->post();
        $request['author'] = Yii::$app->user->identity->getId();
        $request['numberOfViews'] = 0;

        if($video->load($request, '')){
            $video->path = 'video';
            $video->preview = 'preview';
            if($video->save())
                return ['status' => 'success'];
        }
        return ['status' => 'reject'];
    }

    public function actionUpdate($id)
    {
        $video = Video::findOne($id);
        if ($video === null) return ['status' => 'reject'];
        $request = Yii::$app->request->getBodyParams();
        if($video->load($request, '')){
            if($video->save())
                return [
                    'status' => 'success',
                    'video' => $video,
                ];
        }
        return ['status' => 'reject'];
    }
}