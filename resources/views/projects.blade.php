@extends('layouts.master')

@section('title', 'About Xavi Ortega')

@section('page-meta')
<meta name="description" content="Hi! My name is Xavi Ortega. I'm a Full-Stack Developer. My expertise is on Angular and Laravel">

<meta property="og:type" content="website" />
<meta property="og:title" content="About Xavi Ortega" />
<meta property="og:url" content="https://xaviortega.dev" />
<meta property="og:image" content="https://xaviortega.dev/favicon.png" />
@endsection

@section('page-styles')
<link rel="stylesheet" href="{{ mix('css/about.css') }}">
@endsection

@section('body')
<div class="wrapper">
    <section>
        <article class="article">
            <div class="index">
                LOGO
            </div>
            <div class="info">
                <h3>GitInteractions</h3>
                <p>
                    GitInteractions is an analytical tool designed to scrutinize git repositories, extract relevant data, and generate insightful metrics aimed at enhancing a development team's performance and product quality. By producing comprehensive reports, it effectively visualizes the strengths and weaknesses of a team contributing to a Git repository. This allows for the identification of standout performers deserving of recognition, as well as individuals who might benefit from additional coaching to optimize their performance.
                </p>
            </div>
        </article>
    </section>
</div>
@endsection
