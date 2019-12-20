<?php


namespace app\modules\api\controllers;


use Yii;
use yii\db\ActiveQuery;

class Base_playlistsController extends BaseActiveController
{
    public $modelClass = 'app\models\Playlist';

    /**
     * Возращает список плейлистов
     * @return array|ActiveQuery
     */
    public function getPlaylists()
    {

        $request = Yii::$app->request->post();
        $user = $this->getUser($request);
        if($user !== null)
            return $user->getPlaylists();
        else
            return [];
    }
}