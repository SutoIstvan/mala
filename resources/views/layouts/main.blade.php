<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
    <title>@yield('title', 'Mala.hu')</title>

    <link rel="shortcut icon" href="./assets/img/favicon.png">
    <link rel="stylesheet" href="./assets/css/plugins.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/colors/grape.css">
    <link rel="preload" href="./assets/css/fonts/space.css" as="style" onload="this.rel='stylesheet'">
    <meta property="og:title" content="Mala.hu - Főoldal">
    <meta property="og:description"
        content="Egyedi digitális megoldásokat kínálunk - Weboldal fejlesztés - Szoftverfejlesztés
     - Webshop Audit">
    <meta property="og:url" content="https://mala.hu/">
    <meta property="og:image" content="https://mala.hu/assets/img/og-image.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:type" content="website">
</head>

<body class="bg-soft-primary">
    <div class="content-wrapper">

        <!-- /.navbar -->

        @include('layouts.nav')

        <!-- /.navbar -->

        <!-- /.content -->

        @yield('content')

        <!-- /.content -->

    </div>

    <!-- /.content -->

    @include('layouts.footer')

    <!-- /.content -->


    <div class="pb-md-6"></div>
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <script src="./assets/js/plugins.js"></script>
    <script src="./assets/js/theme.js"></script>
</body>

</html>
