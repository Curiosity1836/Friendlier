<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Steam Friends</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        @include('inc.navbar')
        @include('inc.message')
        @yield('content')
    </body>
    <footer id="footer" class="text-center"> 
        This site is not affiliated with Valve Corp</p>
    </footer>
</html>
