<?php

namespace App\Http\Controllers;

use App\ArticlesRepository;
use App\Models\Article;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class ArticlesController extends Controller
{
    /**
     * The articles repository.
     *
     * @var \App\ArticlesRepository
     */
    protected $articles;

    /**
     * Create a new controller instance.
     *
     * @param  \App\ArticlesRepository $articles
     * @return void
     */
    public function __construct(ArticlesRepository $articles)
    {
        $this->articles = $articles;
    }

    /**
     * Show an article.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(string $series, string $slug)
    {

        $article = $this->articles->get($series, $slug);

        return view('article', [
            'article' => $article
        ]);
    }

    public function comment(Article $article)
    {
        $comment = request()->only('author', 'body', 'pleased');

        $comment['hidden'] = false;

        try {
            $article->comments()->create($comment);

            if ($comment['pleased']) {
                $article->likes++;
            } else {
                $article->dislikes++;
            }

            $article->save();

            return response()->json([
                'success' => true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function feedback(Article $article)
    {
        try {
            if (request()->get('pleased')) {
                $article->likes++;
                $article->save();

                return response()->json([
                    'success' => true
                ]);
            } else if (request()->has('dislike')) {
                $article->dislikes++;
                $article->save();

                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'error' => 'No feedback'
                ], 300);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lists available articles.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function list(): Collection
    {
        return $this->articles->getAvailableArticles();
    }
}
