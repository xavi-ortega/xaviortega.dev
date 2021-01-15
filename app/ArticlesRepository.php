<?php

namespace App;

use App\Models\Article;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Database\Eloquent\Collection;

class ArticlesRepository
{
    /**
     * The filesystem implementation.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The cache implementation.
     *
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * Create a new Article instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  \Illuminate\Contracts\Cache\Repository  $cache
     * @return void
     */
    public function __construct(Filesystem $files, Cache $cache)
    {
        $this->files = $files;
        $this->cache = $cache;
    }

    /**
     * Get the given article.
     *
     * @param  string  $slug
     * @return App\Article|null
     */
    public function get(string $series, string $slug): Article
    {
        $full_slug = $series . '/' . $slug;

        $article = Article::where('slug', '=', $full_slug)->with('comments')->first();

        $path = base_path('resources/articles/' . $full_slug . '.md');

        if ($this->files->exists($path)) {
            $content = (new Parsedown)->text($this->files->get($path));

            $article->content = $content;

            $introduction = explode('Introduction', strip_tags($content))[1];

            $article->description = mb_substr($introduction, 0, 150) . '...';

            return $article;
        }

        return null;
    }

    /**
     * Get the publicly available articles
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableArticles(): Collection
    {
        return Article::all()->map(function ($article) {
            $path = base_path('resources/articles/' . $article->slug . '.md');

            if ($this->files->exists($path)) {
                $content = (new Parsedown)->text($this->files->get($path));

                $article->content = $content;

                $introduction = explode('Introduction', strip_tags($content))[1];

                $article->description = mb_substr($introduction, 0, 150) . '...';

                return $article;
            }
        });
    }
}
