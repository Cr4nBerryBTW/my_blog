<?php

namespace common\models;

use phpDocumentor\Reflection\File;
use yii\base\Model;

class ImageUpload extends Model
{
    public ?File $image = null;
}