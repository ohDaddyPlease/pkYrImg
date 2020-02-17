<?php

namespace app\components;

use yii\base\Component;

/**
 * Компонент Picker
 * Необходим для получения рандомного выпуска xkcd
 */
class Picker extends Component
{
  /**
   * Метод получения рандомного выпуска
   *
   * @return void
   */
  public function pick($num = null)
  {
    /**
     * Рандомная выдача числа от 1 до номера последнего выпуска
     */
    $num ?? $num = rand(1, 2260);
    $curl = curl_init("https://xkcd.com/{$num}/info.0.json");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    return json_decode(curl_exec($curl), 1);
  }
}
