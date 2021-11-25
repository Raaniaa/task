<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
      public function signUp(Request $request){
        $userRequest = $request -> all();
              $validator = Validator::make($userRequest, [
                'name' => 'required|min:2|max:200',
                 'email' => 'unique:users',
                 'password' => 'required|min:2|max:200|confirmed',
              ]);
              if ($validator -> fails()) {
                  return response([
                      'error' => $validator -> errors(),
                      'Validation Error'
                  ]);
              }
              $userRequest['password'] = bcrypt($request -> password);
              $userCreate = User::create($userRequest);
          //    $success['token'] = $userCreate -> createToken('MyApp') -> plainTextToken;
              $token = $userCreate->createToken('auth_token')->plainTextToken;
              if ($userCreate) {
                  return response() -> json([
                      'data' => $userCreate,
                      'message' => 'success',
                      'token' => $token
                  ]);
              }
      }
       public function login() {
        if (Auth::guard('users')->attempt([
            'email' => request('email'),
            'password' => request('password')
        ])) {
            $user = Auth::guard('users')->user();
            $accessToken =$user->createToken('auth_token')->plainTextToken;
            return response() -> json([
                'data' => $user,
                'message' => 'success',
                'token' => $accessToken,
            ]);
        } else {
            return response() -> json(['error' => 'Unauthorised'], 401);
        }
          }
          
                public function location(Request $request){
              $user = User::where('email',$request->email)->first();
              if($user){
              $userRequest = $request -> all();
              $validator = Validator::make($userRequest, [
                 'lat' => 'required|min:2|max:200',
                 'lang' => 'required|min:2|max:200',
                 'city' => 'required|min:2|max:200',
              ]);
              if ($validator -> fails()) {
                  return response([
                      'error' => $validator -> errors(),
                      'Validation Error'
                  ]);
              }
                  $edit = User::where('email',$user->email)->update($userRequest);
                  return response()->json([
                   'data' => $edit,
                   'message' => 'success'
                  ]);
              } 
              else {
            return response() -> json(['error' => 'user not exist'], 401);
        }}
}
