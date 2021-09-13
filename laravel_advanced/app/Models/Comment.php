<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'image', 'user_id'
    ];

    // protected $guard = [ // 안되는것만 적어둠

    // ];

    public function writer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getImagePathAttribute()
    {
        // dd('storage/images/' . $this->image);
        return 'storage/images/' . $this->image;
    }
}
