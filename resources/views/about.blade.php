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
    <img class="cv-img my-5" src="/images/CV.jpeg" alt="CV">

    <h2 class="text-center mb-5">Hi! My name is Xavi Ortega</h2>
    <p class="text-center mb-5">
        I'm a <strong>Full-Stack Developer</strong>. My expertise is in <strong>Angular</strong> and <strong>Laravel</strong>. <br>
        I develop <strong>PWAs</strong> and <strong>SPAs</strong> but I also can stick to vanilla Javascript and do a fast static site. <br>
        With every line of code, I try to make the best design and UX <br>
        because <strong>the customer is always in charge</strong>.
    </p>
</div>
@endsection
