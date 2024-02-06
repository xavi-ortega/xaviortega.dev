@extends('layouts.master')

@section('title', $article->title)

@section('page-meta')
<meta name="description" content="{{ $article->description }}">

<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $article->title }}" />
<meta property="og:url" content="https://xaviortega.dev" />
<meta property="og:image" content="https://xaviortega.dev/favicon.png" />
@endsection

@section('page-styles')
<link href="/css/prism.css" rel="stylesheet">
<link href="{{ mix('/css/article.css') }}" rel="stylesheet">
@endsection

@section('body')
    <section>
        <small>{{ $article->created_at->format('D, d M Y') }}</small>
        <article>
            {!! $article->content !!}
        </article>
    </section>
@endsection
