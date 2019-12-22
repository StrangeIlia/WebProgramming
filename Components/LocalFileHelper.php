<?php

namespace app\components;

use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class LocalFileHelper
{
    /***
     * @param $file
     * @return string
     * @throws Exception
     */
    static public function createVideo($file)
    {
        return self::createFile($file, 'uploads/videos');
    }

    /***
     * @param $file
     * @return string
     * @throws Exception
     */
    static public function createPreview($file)
    {
        return self::createFile($file, 'uploads/previews');
    }

    /**
     * @param UploadedFile $file
     * @param $basepath
     * @return string
     * @throws Exception
     */
    static public function createFile($file, $basepath)
    {
        $date = date('Y/m/d');
        $dir = $basepath  . '/'  . $date;
        FileHelper::createDirectory( $dir );
        return $dir. '/' . md5($file->baseName . time()) . '.' . $file->extension;
    }
}

