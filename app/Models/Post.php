<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory; // traits

    // protected $table = 'users';

    public function imagePath()
    {
        // $path = '/storage/images/';
        $path = env('IMAGE_PATH', '/storage/images/');
        $imageFile = $this->image ?? 'default.png';
        // $imageFile = $this->image ?? 'default image';
        return $path . $imageFile;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewers()
    {
        return $this->belongsToMany(User::class);
        // return $this->belongsToMany(User::class , 'post_user', 'post_id', 'user_id', 'id', 'id', 'users'); //관례를 따랐기에 안써도 괜찮음
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
