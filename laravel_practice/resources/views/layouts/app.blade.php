<html lang="en">
    <head>
        @include('layouts.header')
        <style>
            .active{
                color : red;
            }
            a {
                text-decoration:none;
            }
        </style>
    </head>
    <body>
        @yield('content')

        <footer>
            @include('layouts.footer')
        </footer>
    </body>

</html>
