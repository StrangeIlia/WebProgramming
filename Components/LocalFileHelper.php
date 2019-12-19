<?php


use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class LocalFileHelper
{
    /***
     * @param $file
     * @return string
     * @throws \yii\base\Exception
     */
    static public function createVideo($file)
    {
        return self::createFile($file, 'uploads/videos');
    }

    /***
     * @param $file
     * @return string
     * @throws \yii\base\Exception
     */
    static public function createPreview($file)
    {
        return self::createFile($file, 'uploads/previews');
    }

    /**
     * @param UploadedFile $file
     * @param $basepath
     * @return string
     * @throws \yii\base\Exception
     */
    static public function createFile($file, $basepath)
    {
        $date = date('Y/m/d');
        FileHelper::createDirectory($basepath . $date );
        return $basepath . $date . '/' . md5($file->name . time()) . '.' . $file->extension;
    }
}

