<?php


namespace app\modules\api\controllers;

use app\models\User;
use app\models\Video;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Base_videosController extends BaseActiveController
{
    public $modelClass = 'app\models\Video';


    /**
     * @param $data
     * @return User|null
     */
    private static function getUser($data)
    {
        return User::findByUsername($data['username']);
    }

    /**
     * Получить список видео, которые понравились пользователю
     * @return array|ActiveQuery
     * @throws InvalidConfigException
     */
    public function getFavoriteVideo()
    {
        $request = Yii::$app->request->post();
        $user = static::getUser($request);
        if ($user !== null)
            return $user->getFavoriteVideos();
        else
            return [];
    }
}