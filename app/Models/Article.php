<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['short_title'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getShortTitleAttribute()
    {
        return explode(':', $this->title)[1];
    }
}
