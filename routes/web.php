<?php

use App\Models\Article;
use App\Models\User;
use App\Notifications\NewArticle;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'NavController@index');
Route::get('/about', 'NavController@about');
Route::get('/article/{series}/{slug}', 'ArticlesController@show');

Route::get('/notification', function () {
    $article = Article::all()->last();

    $user = User::find(1);

    $user->notify(new NewArticle($article));

    return (new NewArticle($article))
        ->toMail(null);
});
