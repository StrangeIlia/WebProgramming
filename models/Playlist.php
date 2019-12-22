<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "Playlists".
 *
 * @property int $id Id
 * @property string $name название плейлиста
 * @property int $author автор плейлиста
 * @property string|null $createdAt Когда создан
 * @property string|null $updatedAt Когда обновлен
 *
 * @property User $author0
 * @property VideoPlaylist[] $videoPlaylists
 */

class Playlist extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Playlists';
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
                'updatedAtAttribute' => 'updatedAt',
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
            [['name', 'author'], 'required'],
            [['author'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'author' => 'Author',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVideoPlaylist()
    {
        return $this->hasMany(VideoPlaylist::className(), ['playlistId' => 'id']);
    }
}
