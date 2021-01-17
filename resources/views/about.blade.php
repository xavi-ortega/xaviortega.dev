@extends('layouts.master')

@section('page-styles')
<link rel="stylesheet" href="/css/about.css">
@endsection

@section('title', 'About Xavi Ortega')

@section('body')
<div class="wrapper">
    <img class="cv-img my-5" src="/images/CV.jpeg" alt="CV">

    <h2 class="text-center mb-5">Hi! My name is Xavi Ortega</h2>
    <p class="text-center mb-5">
        I'm a <strong>Full-Stack Developer</strong>. My expertise is on <strong>Angular</strong> and <strong>Laravel</strong>. <br>
        I make <strong>PWAs</strong> and <strong>SPAs</strong> but I also can stick to vanilla Javascript and do a fast static site. <br>
        With every line of code, I try to make the best design and UX <br>
        because <strong>the customer is the king</strong>.
    </p>
</div>

@endsection
