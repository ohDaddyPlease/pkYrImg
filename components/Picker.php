<?php
namespace app\components;

use phpDocumentor\Reflection\Types\Integer;
use yii\base\Component;

/**
 * Компонент Picker
 * Необходим для получения рандомного выпуска xkcd
 */
class Picker extends Component
{
    /**
     * Номер самого нового поста
     */
    const LATEST_POST = 2260;

    /**
     * Метод получения рандомного выпуска
     *
     * @param Integer|null $num номер выпуска
     * @return void
     */
    public function pick(Integer $num = null)
    {
        /**
         * Рандомная выдача числа от 1 до номера последнего выпуска
         */
        if (!$num) {
            $num = rand(1, self::LATEST_POST);
        }
        $curl = curl_init("https://xkcd.com/{$num}/info.0.json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        return json_decode(curl_exec($curl), 1);
    }
}
