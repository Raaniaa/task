<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
      public function signUp(Request $request){
        $userRequest = $request -> all();
              $validator = Validator::make($userRequest, [
                 'email' => 'unique:users',
                 'password' => 'requierd|min:2|max:200',
                 'name' => 'requierd|min:2|max:200',
                'password_confirmation' => 'requierd|min:2|max:200|confirm',
              ]);
              if ($validator -> fails()) {
                  return response([
                      'error' => $validator -> errors(),
                      'Validation Error'
                  ]);
              }
              $userRequest['password'] = bcrypt($request -> password);
              $userCreate = User::create($userRequest);
              $success['token'] = $userCreate -> createToken('MyApp') -> accessToken;
              if ($userCreate) {
                  return response() -> json([
                      'data' => $userCreate,
                      'message' => 'success',
                      'token' => $success['token']
                  ]);
              }
      }
}
