<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function userLogin(Request $request)
    {
        $usersCredentials = request(['email', 'password']);
        if (!$token = auth()->guard('users-api')->attempt($usersCredentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['message' => 'login successfully', 'accessToken' => $token]);
    }

    public function usersRegistration(Request $request){

        $newUser=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'phoneNumber'=>$request->phone,
            'address'=>$request->address,

        ]);
        if($newUser){
            return response()->json([$newUser,'status'=>true]);
        }else{
            return response()->json(['status'=>false]);
        }
    }
    public function userDetails(){
        return response()->json(auth()->guard('users-api' )->user());
    }
    public function usersLogout(){
        auth()->guard('users-api')->logout();
        return response()->json(['message'=>'Successfully logged out']);
    }




    //TODO:controller for managing all members that involve deactivate&activate membership
    //TODO:secure all controller&route with this user guard
}
