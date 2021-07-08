<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // protected $table = 'users';

    public function imagePath(){
        // $path = '/storage/images/';
        $path = env('IMAGE_PATH', '/storage/images/');
        $imageFile = $this->image ?? 'default.png'; 
        // $imageFile = $this->image ?? 'default image';
        return $path.$imageFile;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}     
      