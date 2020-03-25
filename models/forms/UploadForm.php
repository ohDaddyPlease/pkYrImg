<?php
namespace app\models\forms;

use yii\base\Model;

class UploadForm extends Model
{
    public $imageFile;
    public $name;
    public $description;

    public function rules()
    {
        return [
            ['imageFile', 'image', 'extensions' => 'png, jpg']
        ];
    }
}