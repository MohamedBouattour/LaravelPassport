<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\api\BaseController as BaseController;
use App\User;
use Validator;


class RegisterController extends BaseController
{
    public function register (Request $request){
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email|max:255|unique:users',
            'name'=> 'required|unique:users',
            'password'=> 'required',
            'c_password'=> 'required|same:password'
        ]);

        if ($validator -> fails() ) {
            return $this->sendError('error validation', $validator->errors());
        }

        $input=$request->all();
        $input['password'] = bcrypt($input['password']);
        $input['mykey'] = bcrypt($input['email']);
        $user = User::Create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name']= $user->name;

        return $this->sendResponse($success , 'User created succesfully');
        
    }
}
