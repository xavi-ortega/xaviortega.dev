<?php

namespace App\Models;

use App\ArticlesRepository;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['short_title', 'content', 'description'];

    private $articlesRepository;

    public function __construct()
    {
        $this->articlesRepository = app()->make(ArticlesRepository::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getShortTitleAttribute()
    {
        return explode(':', $this->title)[1];
    }

    public function getContentAttribute()
    {
        return $this->articlesRepository->getContent($this->slug);
    }

    public function getDescriptionAttribute()
    {
        $introduction = explode('Introduction', strip_tags($this->content))[1];

        return mb_substr($introduction, 0, 150) . '...';
    }
}
