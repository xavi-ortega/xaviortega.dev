@extends('layouts.master')

@section('title', 'xaviortega.dev • Always learning')

@section('page-meta')
<meta name="description" content="I love programming and I improve my skills everyday. Welcome to my personal blog, where I will share everything I think its worth">
@endsection

@section('page-styles')
<link rel="stylesheet" href="/css/welcome.css">
@endsection

@section('body')
<section>
    <div class="banner mb-5">

        <div class="text">
            <h1 class="text-center mb-5">Ionic and Angular features <br>for App Development</h1>

            <p class="text-center">In this series you will learn how to take profit of all Angular features that makes app development easier.</p>
        </div>

    </div>

    <div class="articles">

        @foreach($articles as $index => $article)
        <a href="/article/{{ $article->slug }}">
            <div class="index">
                <span>{{ $index + 1 }}</span>
                <small><i class="fas fa-clock"></i> {{ $article->read_time }}min read</small>
            </div>
            <div class="info">
                <h3>{{ $article->shortTitle }}</h3>
                <p>{{ $article->description }}</p>
            </div>


        </a>
        @endforeach
        <div class="coming-soon">
            <div class="index">
                <span>{{ $index + 2 }}</span>
                <small><i class="fas fa-clock"></i> Coming soon</small>
            </div>
            <div class="info">
                <h3>Services Pattern</h3>
                <p></p>
            </div>
        </div>

    </div>
</section>
@endsection
