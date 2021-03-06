<?php

namespace app\models;

use app\components\LocalFileHelper;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Videos".
 *
 * @property int $id Id
 * @property string $name Название видео
 * @property string $path Путь к файлу
 * @property int $author Создатель видео
 * @property string|null $description Описание видео
 * @property string $preview Путь к изображению превью
 * @property int $numberOfViews Количество просмотров
 * @property string|null $createdAt Когда видео создано
 * @property string|null $updatedAt Когда обновлена информация
 *
 * @property Rating[] $ratings
 * @property User[] $users
 * @property VideoPlaylist[] $videoPlaylists
 * @property Video $author0
 * @property Video[] $videos
 */
class Video extends ActiveRecord
{
    public static function tableName()
    {
        return 'Videos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'author', 'preview', 'numberOfViews'], 'required'],
            [['author', 'numberOfViews'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['path', 'preview'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 50],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'path' => 'Path',
            'author' => 'Author',
            'description' => 'Description',
            'preview' => 'Preview',
            'numberOfViews' => 'Number Of Views',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getRating()
    {
        return $this->hasMany(Rating::className(), ['videoId' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getUser()
    {
        return $this->hasMany(User::className(), ['id' => 'userId'])->viaTable('Rating', ['videoId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVideoPlaylist()
    {
        return $this->hasMany(VideoPlaylist::className(), ['playlistId' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(Video::className(), ['id' => 'author']);
    }

    /**
     * @return ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['author' => 'id']);
    }


    /**
     * @param bool $insert
     * @return bool
     * @throws Exception
     */
    public function beforeSave($insert)
    {
        if(!parent::beforeSave($insert))
            return false;

        if(isset($_FILES['video']))
        {
            if(!$insert) LocalFileHelper::deleteFile($this->path);
            $this->uploadVideo();
        }
        if(isset($_FILES['preview']))
        {
            if(!$insert) LocalFileHelper::deleteFile($this->preview);
            $this->uploadPreview();
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function uploadVideo()
    {
        $file = UploadedFile::getInstancesByName('video')[0];
        if($file===null) return;
        $this->path = LocalFileHelper::createVideo($file);
        $file->saveAs($this->path);
    }

    /**
     * @throws Exception
     */
    public function uploadPreview()
    {
        $file = UploadedFile::getInstancesByName('preview')[0];
        if($file===null) return;
        $this->preview = LocalFileHelper::createPreview($file);
        $file->saveAs($this->preview);
    }

    public function beforeDelete()
    {
        if(!parent::beforeDelete())
            return false;
        LocalFileHelper::deleteFile($this['path']);
        LocalFileHelper::deleteFile($this['preview']);
        return true;
    }



    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);
        $data['author'] = User::findIdentity($data['author'])['username'];
        $data['path'] = Yii::$app->urlManager->hostInfo . '/' . $data['path'];
        $data['preview'] = Yii::$app->urlManager->hostInfo . '/' . $data['preview'];
        return $data;
    }
}
