<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Ad;
use App\Models\Comment;
class AdsController extends Controller
{   
    public function upload(Request $request) {
            $hospitalRequest = $request -> file;
            $image = $request -> file('image');
            $input = $hospitalRequest = time().'.'.$image -> getClientOriginalExtension();
    
            $destinationPath = public_path('uploads/');
            $image -> move($destinationPath, $input);
            return response() -> json([
                'data' => asset('uploads/'.$input),
                'status' => true,
                'message' => 'success Message'
            ]);
            }
    public function store(Request $request){
              $user = User::where('email',$request->email)->first();
              if($user){
              $adRequest = $request -> all();
              $validator = Validator::make($adRequest, [
                 'image' => 'required|min:2|max:200',
                 'title' => 'required|min:2|max:200',
                 'phone' => 'required|min:2|max:200',
                 'description' => 'required|min:2|max:200',
              ]);
              if ($validator -> fails()) {
                  return response([
                      'error' => $validator -> errors(),
                      'Validation Error'
                  ]);
              }
              $adRequest['userId'] = $user->id;
                  $edit = Ad::create($adRequest);
                  return response()->json([
                   'data' => $edit,
                   'message' => 'success'
                  ]);
              } 
              else {
            return response() -> json(['error' => 'user not exist'], 401);
        }}
         public function show(Request $request){
          $city = $request->city;
          $filter = Ad::with('user')->whereHas('user', function($query) use ($city){
        $query->where('city', $city);
    })->count();
              if($filter){
                  $filter = Ad::with('user')->whereHas('user', function($query) use ($city){
                        $query->where('city', $city);
                    })->get();
                      return response()->json([
                   'data' => $filter,
                   'message' => 'success'
                  ]);
              } 
              else {
            return response() -> json(['error' => 'No Ads in this city'], 401);
        }}
}
