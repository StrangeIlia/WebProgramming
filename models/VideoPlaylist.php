<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "VideoPlaylist".
 *
 * @property int $playlistId id плейлиста
 * @property int $videoId id видео
 * @property string $createdAt когда создана
 *
 * @property Video $playlist
 * @property Playlist $playlist0
 */
class VideoPlaylist extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'VideoPlaylist';
    }

    /**
     * Добавляем инициализацию времени
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'value' => new Expression('now()')
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['playlistId', 'videoId', 'createdAt'], 'required'],
            [['playlistId', 'videoId'], 'integer'],
            [['createdAt'], 'safe'],
            [['playlistId', 'videoId'], 'unique', 'targetAttribute' => ['playlistId', 'videoId']],
            [['playlistId'], 'exist', 'skipOnError' => true, 'targetClass' => Video::className(), 'targetAttribute' => ['playlistId' => 'id']],
            [['playlistId'], 'exist', 'skipOnError' => true, 'targetClass' => Playlist::className(), 'targetAttribute' => ['playlistId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'playlistId' => 'Playlist ID',
            'videoId' => 'Video ID',
            'createdAt' => 'Created At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPlaylist()
    {
        return $this->hasOne(Video::className(), ['id' => 'playlistId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlaylist0()
    {
        return $this->hasOne(Playlist::className(), ['id' => 'playlistId']);
    }
}
