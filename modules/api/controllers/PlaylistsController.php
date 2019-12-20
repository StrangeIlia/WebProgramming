<?php

namespace app\modules\api\controllers;

use app\models\User;
use Yii;
use yii\db\ActiveQuery;

class PlaylistsController extends ActiveAuthController
{
    public $modelClass = 'app\models\Playlist';

    /**
     * Возращает список плейлистов
     * @return array|ActiveQuery
     */
    public function getPlaylists()
    {
    	/** @var $user User */
    	$user = Yii::$app->user->identity;

        return $user->getPlaylists()->all();
    }
}