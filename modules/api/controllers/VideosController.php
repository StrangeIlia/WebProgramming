<?php


namespace app\modules\api\controllers;

use Yii;
use app\models\User;
use app\models\Video;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;

class VideosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['get_all_video'],
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['get_all_video', 'selected_video'],
                    'roles' => ['?'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return array|ActiveRecord[]
     */
    public function actionGet_all_video()
    {
        return Video::find()->all();
    }

    /***
     * @param $id
     * @return Video|null
     */
    public function actionSelected_video($id)
    {
        return Video::findOne($id);
    }


    /***
     * @param Video $video
     * @return array
     */
    public function actionAdd_video($video)
    {
        if($video->save())
            return['status'=>'success'];
        else
            return['status'=>'reject'];
    }

    /**
     * @param $data
     * @return User|null
     */
    private static function getUser($data)
    {
        return User::findByUsername($data['username']);
    }

    /**
     * Получить списко видео, которые понравились пользователю
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getFavoriteVideo()
    {
        $request = Yii::$app->request->post();
        $user = static::getUser($request);
        if($user !== null)
            return $user->getFavoriteVideos();
    }
}