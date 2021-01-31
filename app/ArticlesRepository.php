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
     * @return string
     */
    public function getContent(string $slug): string
    {
        return $this->cache->remember(
            'article.' . $slug,
            5,
            function () use ($slug) {
                $path = base_path('resources/articles/' . $slug . '.md');

                if ($this->files->exists($path)) {
                    $content = (new Parsedown)->text($this->files->get($path));

                    return $content;
                }

                return '';
            }
        );
    }
}
