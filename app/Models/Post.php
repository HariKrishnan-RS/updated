<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    public function tags()
{
    return $this->belongsToMany(Tag::class,'tagjoins');
}
    public function users()
    {
        return $this->belongsToMany(User::class, 'joins', 'post_id', 'user_id')->withTimestamps();
    }

}
