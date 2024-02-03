<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavController extends Controller
{
    private $articlesController;

    public function __construct(ArticlesController $articlesController)
    {
        $this->articlesController = $articlesController;
    }

    public function index()
    {
        $articles = $this->articlesController->list();

        return view('welcome', [
            'articles' => $articles
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function projects()
    {
        return view('projects');
    }
}
