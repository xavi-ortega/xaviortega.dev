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
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;700;900&display=swap" rel="stylesheet" crossorigin>

    <!-- RENDER-BLOCKING ASSETS -->
    <link rel="preload" href="/css/utilities.min.css" as="style">
    <link rel="preload" href="/css/solid.min.css" as="style">


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

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
    <nav class="navbar navbar-expand-lg navbar-light flex">
        <div class="container clearfix">
            <a href="/" class="navbar-brand float-left ml-0 d-none d-md-flex align-items-center">
                <span class="mr-2">{</span>
                xaviortega.dev
                <span class="ml-2">}</span>
            </a>

            <a href="/" class="navbar-brand float-left ml-0 d-flex d-md-none align-items-center">
                <span class="mr-2">{</span>
                x
                <span class="ml-2">}</span>
            </a>

            <ul class="navbar-nav fix right mr-0">
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/projects">Projects</a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="container">
        @yield('body')
    </div>

    <footer>
        <nav class="navbar navbar-expand-lg navbar-light flex">
            <div class="container">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" target="_blank" href="https://github.com/xavi-ortega" title="Github" rel="noreferrer"><img class="img-fluid" width="30" height="30" src="/images/github.svg" alt="xavi-ortega"></a></li>
                    <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.linkedin.com/in/xavi-ortega/" title="Linkedin" rel="noreferrer"><img class="img-fluid" width="30" height="30" src="/images/linkedin.svg" alt="xavi-ortega"></a></li>
                </ul>

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item text-center">&copy; Xavi Ortega, {{ now()->year }}</li>
                </ul>
            </div>

        </nav>
    </footer>

    <link href="/css/utilities.min.css" rel="stylesheet" />
    <link href="/css/solid.min.css" rel="stylesheet" />

    <script src="/js/prism.js" defer></script>
    <script src="{{ mix('js/manifest.js') }}" defer>
    </script>
    <script src="{{ mix('js/vendor.js') }}" defer></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="/js/cookieinfo.min.js" type="text/javascript" id="cookieinfo" defer></script>

    @yield('page-scripts')
</body>

</html>
