<?php

namespace app\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\Expression;

/**
 * This is the model class for table "Users".
 *
 * @property int $id Id
 * @property string $email email
 * @property string $login логин
 * @property string $password пароль
 * @property string $createdAt когда создан
 * @property string $updatedAt когда обновлен
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
            [['email', 'login', 'password', 'createdAt', 'updatedAt'], 'required'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['email', 'login', 'password'], 'string', 'max' => 30],
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
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPlaylist()
    {
        return $this->hasMany(Playlist::className(), ['author' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getRating()
    {
        return $this->hasMany(Rating::className(), ['userId' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getVideo()
    {
        return $this->hasMany(Video::className(), ['id' => 'videoId'])->viaTable('Rating', ['userId' => 'id']);
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
