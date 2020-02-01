<?php

namespace app\components;

use yii\base\Component;

class Picker extends Component 
{
    public function pick(){
        $num = rand(1, 2260);
        $curl = curl_init("https://xkcd.com/{$num}/info.0.json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        return json_decode(curl_exec($curl), 1);
    }
    
}