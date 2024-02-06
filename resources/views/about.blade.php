@extends('layouts.master')

@section('title', 'About Xavi Ortega')

@section('page-meta')
<meta name="description" content="Hi! My name is Xavi Ortega. I'm a Software Engineer. My expertise is on Angular and Laravel">

<meta property="og:type" content="website" />
<meta property="og:title" content="About Xavi Ortega" />
<meta property="og:url" content="https://xaviortega.dev" />
<meta property="og:image" content="https://xaviortega.dev/favicon.png" />
@endsection

@section('page-styles')
<link rel="stylesheet" href="{{ mix('css/about.css') }}">
@endsection

@section('body')
<section class="wrapper">
    <figure>
        <img class="cv-img my-5" src="/images/CV.jpeg" alt="CV">
        <figcaption>Hi! My name is Xavi Ortega</figcaption>
    </figure>

    <main>
        <p class="text-center">
            I'm a <strong>Software engineer</strong> with B.S. in computer science and 5+ years of experience in web technologies.
        </p>
        <p class="text-center">
            Starting as a full-stack developer, I crafted a large variety of web-based products,<br> like <strong>static sites</strong>, <strong>SPAs</strong>, <strong>ecommerce</strong>, <strong>hybrid mobile apps</strong> and <strong>SaaS solutions</strong>.
        </p>
        <p class="text-center">
            Currently, I'm specialised in <strong>front-end technologies</strong>, and focused in delivering <strong>quality</strong>, <strong>tested</strong> and <strong>well-designed</strong> software.
        </p>
        <p class="text-center">
            I’ve been passionate about programming since I was in high school, <br> using spare time to be up-to-date with the <strong>latest technologies</strong>, <strong>patterns</strong> and <strong>trends</strong>.
        </p>
    </main>
</section>
@endsection
