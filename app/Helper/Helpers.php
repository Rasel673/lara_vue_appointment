<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

 function setting($key){


    $setting=Cache::rememberForever('settings',function(){
        Setting::pluck('value','key')->all();
    });

    if(!$setting){

        $setting=config('settings.default');
    }

    return $setting[$key] ?? false;

}