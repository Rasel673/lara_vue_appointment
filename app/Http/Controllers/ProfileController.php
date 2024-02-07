<?php

namespace App\Http\Controllers;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //

    public function index(Request $request)
    {

        $user=$request->user()->only(['name','email','role','avatar']);

        return $user;
    }


    public function update(Request $request){

        $validated=$request->validate([
            'name'=>['required'],
            'email'=>['required','email',Rule::unique('users')->ignore($request->user()->id)],
        ]);


        $request->user()->update($validated);

        return response()->json(['success'=>true]);

    }


    public function updateProfilePicture(Request $request){
    if($request->hasFile('profile_picture')){

     $previousPath=$request->user()->getRawOriginal('avatar');

     $link=Storage::put('/photos',$request->file('profile_picture'));

     $request->user()->update(['avatar'=>$link]);

     Storage::delete($previousPath);


     return response()->json(['message'=>'Picture Uploaded  Successfully']);

    }
    }

}
