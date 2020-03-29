<?php
namespace app\models\forms;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    public $imageFile;
    public $name;
    public $description;

    public function rules()
    {
        return [
            [
                'imageFile',
                'image',
                'extensions' => 'png, jpg',
                'maxSize'    => '1000000',
            ]
        ];
    }

    public function upload()
    {
        $uploadsPath = \Yii::getAlias('@app') . '/uploads/' . \Yii::$app->user->identity->login . '/';
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        $this->imageFile->saveAs($uploadsPath . $this->imageFile->baseName . '.' . $this->imageFile->extension);

        return !$this->imageFile->hasError;
    }
}