<?php


namespace app\modules\api\controllers;

use app\models\Video;
use yii\db\ActiveQuery;

class VideosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';
    public $defaultAction = 'default';

    /***
     * @param Video $video
     */
    public function addUrl($video)
    {
        if($video === null) return;
        $video->path = $this->getUrl() . $video->path;
        $video->preview = $this->getUrl() . $video->preview;
    }

    /***
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionDefault()
    {
        $videos = Video::find()->all();
        foreach ($videos as $video)
            $this->addUrl($video);
        return $videos;
    }

    /***
     * @param $id
     * @return Video|null
     */
    public function actionSelected_video($id)
    {
        $video = Video::findOne($id);
        $this->addUrl($video);
        return $video;
    }

    /***
     * @return array
     */
    public  function verbs()
    {
        return [
            'add_video'=>['POST','OPTIONS']
        ];
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
     * Получить списко видео, которые понравились пользователю
     * @return ActiveQuery
     */
    public function getFavoriteVideo()
    {
        $request = Yii::$app->request->post();
        $user = $this->getUser($request);
        if($user !== null)
            return $user->getPlaylists();
    }
}