<?php

namespace app\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "Users".
 *
 * @property int $id Id
 * @property string $email email
 * @property string $login логин
 * @property string $password пароль
 * @property string $createdAt когда создан
 * @property string $updatedAt когда обновлен
 * @property string $authKey ключ авторизации
 * @property string $accessToken токен
 *
 * @property Playlist[] $playlists
 * @property Rating[] $ratings
 * @property Video[] $videos
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'login', 'password', 'createdAt', 'updatedAt', 'authKey', 'accessToken'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['email', 'login', 'password'], 'string', 'max' => 30],
            [['authKey', 'accessToken'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'login' => 'Login',
            'password' => 'Password',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlist::className(), ['author' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['userId' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['id' => 'videoId'])->viaTable('Ratings', ['userId' => 'id']);
    }
}