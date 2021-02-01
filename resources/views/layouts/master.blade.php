<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @yield('page-meta')

    <link rel="canonical" href="https://xaviortega.dev" />
    <link rel="icon" type="image/png" href="/favicon.png">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/fontawesome.min.css" rel="stylesheet" />
    <link href="/css/solid.min.css" rel="stylesheet" />
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/prism.css" rel="stylesheet">
    @yield('page-styles')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T3Z1PNSV60"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-T3Z1PNSV60');
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a href="/" class="navbar-brand d-none d-md-flex align-items-center">
                <span class="mr-2">{</span>
                xaviortega.dev
                <span class="ml-2">}</span>
            </a>

            <a href="/" class="navbar-brand d-flex d-md-none align-items-center">
                <span class="mr-2">{</span>
                x
                <span class="ml-2">}</span>
            </a>

            <ul class="navbar-nav ml-auto mr-2 mr-md-0">
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="container">
        @yield('body')
    </div>

    <footer>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" target="_blank" href="https://github.com/xavi-ortega" title="Github" rel="noreferrer"><img class="img-fluid" src="/images/github.svg" alt="xavi-ortega"></a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.linkedin.com/in/xavi-ortega/" title="Linkedin" rel="noreferrer"><img class="img-fluid" src="/images/linkedin.svg" alt="xavi-ortega"></a></li>
                </ul>

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item text-center">Icons designed by <br class="d-block d-md-none"> <a href="https://www.flaticon.es/autores/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.es/" title="Flaticon">Flaticon</a></li>
                </ul>
            </div>

        </nav>
    </footer>

    <script src="/js/prism.js"></script>
    <script src="/js/app.js"></script>
    <script type="text/javascript" id="cookieinfo" src="//cookieinfoscript.com/js/cookieinfo.min.js"></script>

    @yield('page-scripts')
</body>

</html>
