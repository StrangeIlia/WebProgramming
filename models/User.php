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
    static $setCharacter = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

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
            [['accessToken'], 'unique']
        ];
    }

    /**
     * Возращает объект пользователя, по токену или логину
     * @param $data
     * @return User|null
     */
    public static function getUser($data)
    {
        // Если пользователь передал токен
        if(isset($data['authKey']) && isset($data['accessToken']))
        {
            $user = User::findByAccessToken($data['accessToken']);
            if($user !== null && $user->validateAuthKey($data['authKey']))
                return $user;
        }
        // Если пользователь передал логин
        else if(isset($data['login']) && isset($data['password'])){
            $user = User::findByLogin($data['login']);
            if ($user !== null && $user->validatePassword($data['password']))
                return $user;
        }
        return null;
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
     * Возращает список видео, которые были загружены пользователем
     * @return ActiveQuery
     */
    public function getLoadedVideos()
    {
        return $this->hasMany(Video::className(), ['author' => 'id']);
    }

    /**
     * Возращает список видео, которые понравились пользователю
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getFavoriteVideos()
    {
        return $this->hasMany(Rating::className(), ['userId' => 'id'])->
            viaTable(Video::className(), ['id' => 'videoId'])->
            where(['rating'] > 0);
    }

    /**
     * Генерирует рандомную строку заданнной длины по набору символов
     * @param $setCharacter
     * @param $strLength
     * @return string
     */
    private function generate_string($strLength)
    {
        $randomStr = '';
        $countCharacter = strlen(User::$setCharacter);
        for($i = 0; $i < $strLength; ++$i)
            $randomStr .= User::$setCharacter[mt_rand(0, $countCharacter - 1)];
        return $randomStr;
    }

    /**
     * Генерирует токен, возращает ключ авторизации и токен
     * @return array
     */
    public function createToken()
    {
        $this->authKey = $this->generate_string(32);
        $this->accessToken = $this->generate_string(32);
        return [
            'authKey' => $this->authKey,
            'accessToken' => $this->accessToken
        ];
    }

    /**
     * Очищает информацию по токену
     */
    public function removeToken()
    {
        $this->authKey = '';
        $this->accessToken = '';
    }

    /**
     * Поиск пользователя по токену
     * @param $token
     * @return static|null
     */
    public static function findByAccessToken($token)
    {
        if($token === '' ) return null;
        return User::findOne(['accessToken' => $token]);
    }

    /**
     * Валидация по ключю авторизации
     * @param $authKey
     * @return bool
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Поиск пользователя по логину
     * @param string login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        if($login === '') return null;
        return User::findOne(['login' => $login]);
    }

    /**
     * Валидация по паролю
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}