<?php


namespace app\modules\api\controllers;

use Yii;
use app\models\User;
use app\models\Video;
use yii\db\ActiveQuery;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;

class Auth_videosController extends ActiveAuthController
{
    public $modelClass = 'app\models\Video';

    /***
     * @param Video $video
     * @return array
     */
    public function actionAdd_video($video)
    {
        if ($video->save())
            return ['status' => 'success'];
        else
            return ['status' => 'reject'];
    }


}