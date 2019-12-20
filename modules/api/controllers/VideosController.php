<?php


namespace app\modules\api\controllers;

use Yii;
use app\models\User;
use app\models\Video;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

class VideosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';

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