<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUpload extends Model
{
    public ?UploadedFile $image = null;

    public function rules(): array
    {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg,jpeg,png'],
        ];
    }

    public function uploadFile( UploadedFile $file, $currentImage): ?string
    {
        $this->image = $file;

        if ($this->validate()){
            $this->deleteCurrentImage($currentImage);
            return $this->saveImage();
        }
        return null;
    }

    private function getFolder(): string
    {
        //var_dump(Yii::getAlias('@frontend') . '/web/uploads/');die;
        return Yii::getAlias('@frontend') . '/web/uploads/';
    }

    private function generateFileName(): string
    {
        return strtolower(md5(uniqid($this->image->baseName)) . '.' . $this->image->extension);
    }

    public function deleteCurrentImage($currentImage)
    {
        if($this->fileExist($currentImage))
        {
            unlink($this->getFolder() . $currentImage);
        }
    }

    public function fileExist($currentImage): bool
    {
        if (!empty($currentImage) && $currentImage != null)
        {
            return file_exists($this->getFolder() . $currentImage);
        }
        return false;
    }

    public function saveImage(): string
    {
        $filename = $this->generateFileName();
        //var_dump($this->getFolder());die;
        $this->image->saveAs($this->getFolder() . $filename);
        return $filename;
    }


}