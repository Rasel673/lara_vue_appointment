<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //


    public function users(){

        $users=User::latest()->paginate(setting('pagination_limit'));
        return  $users;

    }


    public function createUsrs(Request $request){

        $request->validate([
            "name"=>"required",
            "email"=> 'required|unique:users,email',
            "password"=>"required",
        ]);


        $user=User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),

        ]);


        return $user;

    }

    public function updateUsrs(Request $request,$id){
           
        $request->validate([
            "name"=>"required",
            "email"=>'required|unique:users,email,'.$id,
        ]);

        

        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        if($request->password){
        $user->password=Hash::make($request->password);
        }
        $user->update();
        
        return $user;

    }


    public function deleteUsrs($id){

      
        $user=User::find($id);
        $user->delete();

        return response()->noContent();
    }


    public function bulkDelete(){
       $user=User::whereIn('id',request('ids'))->delete();
       return response()->json(['message'=>'User Deleted Successfully !']);
    }



    public function changeRole(Request $request){



        $userId=$request->user_id;
        $user=User::find($userId);
        $user->role=$request->role;
        $user->update();
        return response()->json(['success'=>true]);
        
    }



    public function search(){
     
    $query=request('query');
     $users=User::where('name','like',"%{$query}%")->paginate(5);
     return response()->json($users);
    }
}
