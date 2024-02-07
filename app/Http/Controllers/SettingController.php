<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    //

public function index(){

    $setting=Setting::pluck('value','key')->toArray();

    if(!$setting){
        return config('settings.default');
    }

    
 return $setting;
    
}

public function update(){


$setting=request()->validate([
    'app_name'=>['required','string'],
    'date_format'=>['required','string'],
    'pagination_limit'=>['required','int','min:5','max:100'],
]);


foreach($setting as $key=>$value){

  Setting::updateOrCreate(
    ['key'=>$key],
    ['value'=>$value]
    );

}


Cache::flush('settings');

return response()->json(['success'=>'Updated Successfully'],200);

}

}
