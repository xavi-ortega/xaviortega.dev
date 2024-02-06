@extends('layouts.master')

@section('title', 'My projects')

@section('page-meta')
<meta name="description" content="I love programming and I improve my skills everyday. Welcome to my personal blog, where I will share everything I think its worth">

<meta property="og:type" content="website" />
<meta property="og:title" content="My projects" />
<meta property="og:url" content="https://xaviortega.dev" />
<meta property="og:image" content="https://xaviortega.dev/favicon.png" />
@endsection

@section('page-styles')
<link rel="stylesheet" href="{{ mix('css/projects.css') }}">
@endsection

@section('body')
<div class="wrapper">
    <section>
        <div class="banner programming">
            <h1>My projects</h1>
        </div>

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
                    <a class="action-btn" href="https://git-interactions.xaviortega.dev" target="_blank">GitInteractions</a>
                    <small>(2020)</small>
                </h3>
                <p>
                    GitInteractions is an analytical tool crafted to dig into git repositories. By producing comprehensive reports, it effectively visualizes the strengths and weaknesses of a team contributing to a Git repository. This allows for the identification of standout performers deserving of recognition, as well as individuals who might benefit from additional coaching to optimize their performance.
                </p>
            </div>

            <div class="challenges">
                <div class="title">
                    Challenges
                </div>

                <div class="body">
                    <ul>
                        <li>Real-time progress tracking</li>
                        <li>Real-time queue tracking (multi-user)</li>
                        <li>Git diff parse</li>
                        <li>GitHub API rate limiting</li>
                        <li>Long background async tasks</li>
                    </ul>
                </div>
            </div>
        </article>
        <article>
            <div class="project-brand">
                <figure>
                    <img src="/images/real-estate-analyzer.jpg" alt="Real Estate analyzer" />
                </figure>
                <div class="stack">
                    <img src="/images/tech-stacks/laravel.svg" alt=Laravel" title="Laravel" />
                    <img src="/images/tech-stacks/react.svg" alt="React" title="React" />
                    <img class="stack-png" src="/images/tech-stacks/rubix-ml.png" alt="Rubix ML" title="Rubix ML" />
                </div>
            </div>


            <div class="info">
                <h3>
                    <a class="action-btn" href="https://real-estate-analyzer.xaviortega.dev" target="_blank">Real Estate Analyzer</a>
                    <small>(2023)</small>
                </h3>
                <p>
                    Real Estate Analyzer is a cutting-edge Real Estate Assessor powered by Machine Learning. This innovative solution specializes in crawling Spanish websites to identify prime investment opportunities. By employing ML algorithms, it intelligently analyzes real estate data to pinpoint properties with significant potential for return on investment.
                </p>
            </div>

            <div class="challenges">
                <div class="title">
                    Challenges
                </div>

                <div class="body">
                    <ul>
                        <li>Machine learning regression model</li>
                        <li>Model fine-tuning</li>
                        <li>Web crawling</li>
                        <li>Feature cleaning</li>
                    </ul>
                </div>
            </div>
        </article>
    </section>
</div>
@endsection
