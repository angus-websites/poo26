<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

{{--Meta--}}
<!--Angus was here 2026-->
<title>@yield('title', config('app.name'))</title>
<meta name="description"
      content="@yield('description', 'Poo is a lightweight URL shortener that lets you share links, messages, and code snippets instantly. Clean, fast, and free')"/>
<meta property="og:image" content="@yield('og-image', url('assets/images/core/ogimage.jpg'))">
<meta name="keywords" content="@yield('keywords', 'Poo, URL shortener, link shortener, shorten URL, short links, link management, URL management, custom short links, branded links, link tracking, analytics, QR codes, link redirection, URL shortening service')"/>

{{--Icons--}}
<link rel="icon" type="image/png" href="/assets/images/core/favicon-96x96.png" sizes="96x96"/>
<link rel="icon" type="image/svg+xml" href="/assets/images/core/favicon.svg"/>
<link rel="shortcut icon" href="/favicon.ico"/>
<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/core/apple-touch-icon.png"/>
<meta name="apple-mobile-web-app-title" content="Poo"/>
<link rel="manifest" href="/assets/images/core/site.webmanifest"/>

{{--Fonts--}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@stack('head')
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
