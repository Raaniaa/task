<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

  protected $fillable = [
        'image',
        'title',
        'phone',
        'description',
        'userId',
    ]; 
      protected $hidden = [
        'created_at', 'updated_at',
    ];

public function user(){
    return $this->belongsTo(User::class ,'userId');
}
}
