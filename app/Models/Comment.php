<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
      protected $fillable = [
        'comment',
        'userId',
        'adId',
        'lat',
        'lang',
        'city',
    ]; 
      protected $hidden = [
        'created_at', 'updated_at',
    ];
   public function users(){
    return $this->belongsToMany(User::class);
}
   public function ads(){
    return $this->belongsTo(Ad::class,'adId');
}
}
