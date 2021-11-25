<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Ad;
use App\Models\Comment;
class CommentController extends Controller
{
  
        public function store(Request $request){
          $ad = Ad::where('id',$request->idAd)->first();
          if($ad){
               $user = User::where('email',$request->email)->first();
               if($user){
                 $commentRequest = $request -> all();
              $validator = Validator::make($commentRequest, [
                 'comment' => 'required',
              ]);
              if ($validator -> fails()) {
                  return response([
                      'error' => $validator -> errors(),
                      'Validation Error'
                  ]);
              }  
              $commentRequest['userId'] = $user->id;
              $commentRequest['lat'] = $user->lat;
              $commentRequest['lang'] = $user->lang;
              $commentRequest['city'] = $user->city;
              $commentRequest['adId'] = $ad->id;
                $comment = Comment::create($commentRequest);
                  return response()->json([
                   'data' => $comment,
                   'message' => 'success'
                  ]);
              }
              return response() -> json(['error' => 'user not exist'], 401);
            }
              else {
            return response() -> json(['error' => 'this ads not exist '], 401);
        }}
       public function show(Request $request){
          $filter = Ad::where('id',$request->id)->first();
            if($filter){
             $filter = Comment::where('adId',$request->id)->with('ads')->get();
                  return response()->json([
                   'data' => $filter,
                   'message' => 'success'
                  ]);
              } 
              else {
            return response() -> json(['error' => 'No Ads in this city'], 401);
        }}
}
