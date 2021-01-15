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
    <div class="series">
        <h1 class="text-center">Ionic and Angular features <br>for App Development</h1>

        <div class="articles">
            <div class="list-group">
                @foreach($articles as $index => $article)
                <a class="list-group-item list-group-item-action mb-3" href="/article/{{ $article->slug }}">
                    <span class="index">{{ $index + 1 }}</span>
                    <span class="title">{{ $article->shortTitle }}</span>

                    <small><i class="fas fa-clock"></i> {{ $article->read_time }}min read</small>
                </a>
                @endforeach
                <div class="list-group-item list-group-item-action">
                    <span class="index">{{ $index + 2 }}</span>
                    <span class="title">Custom Form Control</span>

                    <small>Coming soon</small>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
