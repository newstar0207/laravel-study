<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'password',
        'title',
        'start_period',
        'end_period',
        'owner'
    ];

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function cost()
    {
        return $this->hasOne(Cost::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();;
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class)->oldest()->get();
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
