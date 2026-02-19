<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('dark/assets/images/LogoTifico.png') }}">
    <title>Dashboard IT</title>
    <!-- Simple bar CSS -->
    @include('layouts.style')
</head>

<body class="vertical  dark  ">

    @include('layouts.navbar')
    @include('layouts.sidebar')
    <main role="main" class="main-content">
        @include('layouts.script')
        @yield('content')
    </main> <!-- main -->
    </div> <!-- .wrapper -->
</body>

</html>
