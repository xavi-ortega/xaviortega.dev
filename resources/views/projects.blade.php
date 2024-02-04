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
<link rel="stylesheet" href="{{ mix('css/projects.css') }}">
@endsection

@section('body')
<div class="wrapper">
    <section>
        <article>
            <div class="project-brand">
                <figure>
                    <img src="/images/git-interactions.png" alt="Git Interactions" />
                </figure>
                <div class="stack">
                    <img src="/images/tech-stacks/laravel.svg" alt=Laravel" title="Laravel" />
                    <img src="/images/tech-stacks/vue.svg" alt="Vue" title="Vue" />
                    <img src="/images/tech-stacks/git.svg" alt="Git" title="Git" />
                    <img src="/images/tech-stacks/github.svg" alt="GitHub API" title="GitHub API" />
                </div>
            </div>


            <div class="info">
                <h3>
                    <a class="action-btn" href="https://git-interactions.xaviortega.dev" target="_blank">
                        GitInteractions
                    </a>
                </h3>
                <p>
                    GitInteractions is an analytical tool designed to scrutinize git repositories, extract relevant data, and generate insightful metrics aimed at enhancing a development team's performance and product quality. By producing comprehensive reports, it effectively visualizes the strengths and weaknesses of a team contributing to a Git repository. This allows for the identification of standout performers deserving of recognition, as well as individuals who might benefit from additional coaching to optimize their performance.
                </p>
            </div>

            <div class="challenges">
                <div class="title">
                    Challenges
                </div>

                <div class="body">
                    <ul>
                        <li>Websockets connection</li>
                        <li>Git diff parse</li>
                        <li>GitHub API rate limiting</li>
                        <li>Long background async tasks</li>
                    </ul>
                </div>
            </div>
        </article>
    </section>
</div>
@endsection
