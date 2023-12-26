<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
        'onestar',
        'twostar',
        'threestar',
        'fourstar',
        'fivestar',
    ];

    // Define relationship with the Post model
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
